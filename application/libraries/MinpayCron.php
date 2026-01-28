<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MinpayCron
{
    protected $CI;

    protected $MAX_PER_RUN = 50; // tránh gửi quá nhiều 1 lượt

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function run()
    {
        log_message('info', 'MINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_STARTMINPAY_CRON_START');

        $this->out("JOB_START " . gmdate('c'));

        $redis = new Redis();
        if (!$redis->connect('redis', 6379)) {
            log_message('error', 'MINPAY_REDIS_CONNECT_FAILMINPAY_REDIS_CONNECT_FAILMINPAY_REDIS_CONNECT_FAILMINPAY_REDIS_CONNECT_FAILMINPAY_REDIS_CONNECT_FAILMINPAY_REDIS_CONNECT_FAIL ');
            $this->out("REDIS_CONNECT_FAIL");
            return;
        }

        log_message('info', 'MINPAY_REDIS_CONNECTED MINPAY_REDIS_CONNECTEDMINPAY_REDIS_CONNECTED');


        $now = (int)gmdate('U');

        // lấy các job_key đã tới hạn
        $job_keys = $redis->zRangeByScore('minpay:due', 0, $now, array('limit' => array(0, $this->MAX_PER_RUN)));
        if (empty($job_keys)) {
            $this->out("NO_DUE_JOBS now={$now}");
            return;
        }


        log_message('info', 'MINPAY_DUE_JOBS_COUNT=' . count($job_keys) . ' now=' . $now);


        $this->CI->load->library('Mailjet');

        foreach ($job_keys as $job_key) {


    log_message('info', "MINPAY_JOB_START job_key={$job_key}");

            // chống race: dùng WATCH/MULTI nhẹ
            $redis->watch($job_key);
            $job = $redis->hGetAll($job_key);
log_message('info', 'MINPAY_JOB_REDIS_PAYLOAD ' . json_encode($job));

            if (empty($job) || empty($job['userid'])) {
                // job hỏng -> remove khỏi zset
                $redis->multi()
                    ->zRem('minpay:due', $job_key)
                    ->del($job_key)
                    ->exec();
                $redis->unwatch();
                $this->out("BAD_JOB {$job_key} removed");
                continue;
            }

            $userid = (int)$job['userid'];
            $due_at = isset($job['due_at']) ? (int)$job['due_at'] : 0;

            if ($due_at > $now) {
                $redis->unwatch();
                continue;
            }
log_message('info', "MINPAY_BUILD_PAYLOAD userid={$userid}");

            // >>> LẤY DATA MỚI NHẤT TỪ DB (fresh) <<<
            $email_payload = $this->build_fresh_email_payload($userid);
            if (!$email_payload) {
                // user không tồn tại/không email -> drop job
                    log_message('error', "MINPAY_DROP_NO_PAYLOAD userid={$userid}");

                $redis->multi()
                    ->zRem('minpay:due', $job_key)
                    ->del($job_key)
                    ->exec();
                $redis->unwatch();
                $this->out("DROP userid={$userid} no payload");
                continue;
            }
            
log_message('info', "MINPAY_SEND_MAIL userid={$userid} to={$email_payload['to']} subject=" . $email_payload['subject']);

log_message(
    'info',
    "MINPAY_EMAIL_DATA\n" . print_r($email_payload['data'], true)
);



// $viewPath = APPPATH . 'modules/members/views/email_template/minpay_threshold_email.php';

// $message = $this->CI->load->view(
//     $viewPath,
//     $email_payload['data'],
//     true
// );


$message = $this->render_minpay_email($email_payload['data']);
log_message('info', 'MINPAY_TEMPLATE_LEN len=' . strlen($message));


// $message = $this->CI->load->view('members/email_template/minpay_threshold_email', $email_payload['data'], true);
log_message('info', "MINPAY_TEMPLATE_LEN userid={$userid} len=" . strlen($message));

$ok = $this->guimail(
    $email_payload['to'],
    $email_payload['subject'],
    $message,
    'support@wwaff.com',
    'Worldwide Affiliate'
);

log_message('info', "MINPAY_GUIMAIL_OK userid={$userid} ok=" . (int)$ok);

if ($ok) {
    $tx = $redis->multi()
        ->zRem('minpay:due', $job_key)
        ->del($job_key)
        ->exec();
    $redis->unwatch();

    log_message('info', "MINPAY_REMOVED userid={$userid} job_key={$job_key} tx=" . json_encode($tx));
    $this->out("SENT userid={$userid}");
} else {
    $redis->unwatch();
    log_message('error', "MINPAY_FAIL userid={$userid} job_key={$job_key}");
    $this->out("FAIL userid={$userid}");
}

        }

        $this->out("JOB_END " . gmdate('c'));
    }

private function guimail($toemail = '', $tieude = '', $noidung = '', $fromEmail = '', $fromName = '')
{
    log_message('info', "MINPAY_GUIMAIL_ENTER to={$toemail}");

    if (!$toemail || !filter_var($toemail, FILTER_VALIDATE_EMAIL)) {
        log_message('error', "MINPAY_GUIMAIL_BAD_EMAIL to={$toemail}");
        return 0;
    }

    if (!$fromEmail) $fromEmail = 'support@wwaff.com';
    if (!$fromName)  $fromName  = 'Worldwide Affiliate';

    $this->CI->load->library('Mailjet');

    try {
        $rs = $this->CI->mailjet->send_email($toemail, $tieude, $noidung, $fromEmail, $fromName);
        // rs của bạn là array: ['success'=>bool,'http_code'=>int,'response'=>string]
        log_message('info', 'MINPAY_GUIMAIL_RAW ' . json_encode($rs));
    } catch (Throwable $e) {
        log_message('error', 'MINPAY_GUIMAIL_EXCEPTION ' . $e->getMessage());
        return 0;
    }

    // ✅ check đúng theo cấu trúc lib Mailjet hiện tại
    if (is_array($rs)) {
        $ok = !empty($rs['success']);
        if (!$ok) {
            $http = isset($rs['http_code']) ? $rs['http_code'] : 'NA';
            $resp = isset($rs['response']) && is_string($rs['response']) ? substr($rs['response'], 0, 300) : '';
            log_message('error', "MINPAY_GUIMAIL_FAIL http={$http} resp={$resp}");
        }
        return $ok ? 1 : 0;
    }

    // fallback nếu lib trả kiểu khác
    return ($rs === true || $rs === 1) ? 1 : 0;
}


    private function build_fresh_email_payload($userid)
    {
        $user = $this->CI->db->select('id, available, email, mailling, manager')
            ->where('id', (int)$userid)
            ->get('users')
            ->row();

        if (!$user || empty($user->email)) return false;

        // ⚠️ Option: chỉ gửi nếu hiện tại vẫn >= MIN_PAY (nếu rút mất rồi thì thôi)
        // Nếu bạn muốn "đã kích hoạt thì gửi" bỏ check này.
        $min_pay = 200;
        if ((float)$user->available < $min_pay) {
            // không còn đủ điều kiện rút -> skip & drop job
            return false;
        }

        $mailling_data = @unserialize($user->mailling);
        $firstname = isset($mailling_data['firstname']) ? $mailling_data['firstname'] : '';
        $lastname  = isset($mailling_data['lastname'])  ? $mailling_data['lastname']  : '';
        $full_name = trim($firstname . ' ' . $lastname);
        if ($full_name === '') $full_name = $user->email;

        // conversions mới nhất (bạn muốn "fresh")
        $approved_offers_query = "
            SELECT t.offerid, t.oname as offer_name,
                COUNT(t.id) as conversion_count,
                SUM(t.amount2) as total_amount
            FROM cpalead_tracklink t
            WHERE t.userid = ?
            AND t.status = 3
            AND t.flead = 1
            GROUP BY t.offerid, t.oname
            ORDER BY total_amount DESC
        ";
        $rows = $this->CI->db->query($approved_offers_query, array((int)$userid))->result_array();

        $total_conversions = 0;
        if ($rows) foreach ($rows as $r) $total_conversions += (int)$r['conversion_count'];

        $manager = null;
        if (!empty($user->manager)) {
            $manager = $this->CI->db->select('username, aim, skype')
                ->where('id', (int)$user->manager)
                ->get('manager')
                ->row();
        }

        return array(
            'to'      => $user->email,
            'subject' => 'Payment Threshold Reached - Withdrawal Now Available',
            'data'    => array(
                'username'          => $full_name,
                'available'         => (float)$user->available,
                'approved_offers'   => $rows ? $rows : array(),
                'total_conversions' => $total_conversions,
                'manager'           => $manager
            )
        );
    }

protected function out($s)
{
    // chỉ log, không echo để tránh headers already sent
    log_message('info', '[MINPAY_OUT] ' . $s);
}







private function render_minpay_email(array $d)
{
    // Escape helper (PHP 5.6 compatible)
    $esc = function ($v) {
        return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
    };

    // ===== Map data từ $d (giữ đúng dữ liệu, chỉ chuẩn hoá để render) =====
    $username  = isset($d['username']) ? $d['username'] : '';
    $available = isset($d['available']) ? (float)$d['available'] : 0.0;

    $approved_offers = (!empty($d['approved_offers']) && is_array($d['approved_offers']))
        ? $d['approved_offers']
        : array();

    $manager = !empty($d['manager']) ? $d['manager'] : null;

    // Tổng conversions để show footer table (đúng theo data đang có)
    $total_conversions = 0;
    if (!empty($approved_offers)) {
        foreach ($approved_offers as $offer) {
            $total_conversions += (int)(isset($offer['conversion_count']) ? $offer['conversion_count'] : 0);
        }
    }

    // Threshold hiển thị trong nội dung (file mẫu ghi cứng 200.00)
    // Nếu bạn có key threshold trong $d thì ưu tiên lấy, còn không fallback 200.00
    $threshold = isset($d['threshold']) ? (float)$d['threshold'] : 200.0;

    // Base URL: nếu đang chạy trong CI2 thì dùng base_url(), không thì fallback '/'
    $base_url = '/';
    if (function_exists('base_url')) {
        $base_url = base_url();
    } elseif (isset($d['base_url']) && $d['base_url']) {
        $base_url = (string)$d['base_url'];
    }

    // ===== Render template giữ nguyên style/layout =====
    ob_start();
    ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.6;
            font-size: 15px;
            color: #353c46;
            margin: 0;
            padding: 0;
            background-color: #F8FAFC;
        }

        .email-container {
            max-width: 700px;
            margin: 30px auto;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #f5f5f5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #5bef91 0%, #2d82d6 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
        }

        .header-logo {
            width: 200px;
            max-height: 50px;
        }

        .header-logo img {
            height: 45px;
            vertical-align: middle;
        }

        .header-icon {
            font-size: 40px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .content {
            padding: 20px 40px;
        }

        .greeting p {
            margin: 0;
        }

        .main-text {
            line-height: 1.7;
            margin: 10px 0;
        }

        .report-table-container {
            margin: 25px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        .report-table thead {
            background: linear-gradient(135deg, #5bef91 0%, #2d82d6 100%);
            color: #ffffff;
        }

        .report-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 2px solid #22c55e;
        }

        .report-table th:last-child,
        .report-table td:last-child {
            text-align: right;
        }

        .report-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .report-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .report-table td {
            padding: 12px;
            font-size: 14px;
            color: #475569;
        }

        .report-table tfoot {
            background-color: #f8fafc;
            border-top: 2px solid #22c55e;
        }

        .report-table tfoot td {
            padding: 14px 12px;
            font-weight: bold;
            font-size: 15px;
            color: #1e293b;
        }

        .amount-cell {
            color: #22c55e;
            font-weight: 600;
        }

        .total-amount {
            color: #16a34a;
            font-size: 18px;
        }

        .signature {
            margin-top: 25px;
            line-height: 1.7;
        }

        .footer {
            padding: 30px 35px;
            border-top: 1px solid #e2e8f0;
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }

        .footer-note {
            font-weight: 600;
            color: #475569;
            margin-bottom: 12px;
        }

        .footer-contact {
            margin: 12px 0;
        }

        .footer-divider {
            height: 1px;
            margin: 20px 0;
        }

        .footer-copyright {
            text-align: center;
            color: #53718f;
            margin-bottom: 8px;
        }

        .footer-address {
            text-align: center;
            color: #53718f;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .offer-id {
            color: #64748b;
            font-size: 13px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <div class="header-logo">
                <a href="<?php echo $esc($base_url); ?>">
                    <!-- sửa .pngg -> .png để ảnh hiển thị đúng -->
                    <img src="https://i.postimg.cc/5yXKJx1Q/logo.png" alt="Wwaff Logo">
                </a>
            </div>
            <h1 class="header-title">Payment Threshold Notification</h1>
        </div>

        <div class="content">
            <div class="greeting">
                <p>Dear <strong><?php echo $esc($username); ?></strong>,</p>
            </div>

            <p class="main-text">
                We would like to inform you that, according to the latest financial report, your
                account balance has successfully reached the minimum payment threshold of
                <strong>$<?php echo number_format($threshold, 2); ?></strong>.
            </p>

            <div class="report-table-container">
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Offer Name</th>
                            <th style="text-align: center;">Conversions</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($approved_offers)): ?>
                            <?php foreach ($approved_offers as $offer): ?>
                                <?php
                                    $offerid = isset($offer['offerid']) ? $offer['offerid'] : '';
                                    $offer_name = isset($offer['offer_name']) ? $offer['offer_name'] : '';
                                    $conv = isset($offer['conversion_count']) ? (int)$offer['conversion_count'] : 0;
                                    $amt  = isset($offer['total_amount']) ? (float)$offer['total_amount'] : 0.0;
                                ?>
                                <tr>
                                    <td class="offer-id">#<?php echo $esc($offerid); ?></td>
                                    <td><?php echo $esc($offer_name); ?></td>
                                    <td style="text-align: center;"><?php echo number_format($conv); ?></td>
                                    <td class="amount-cell">$<?php echo number_format($amt, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 20px; color: #94a3b8;">
                                    No approved conversions found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total</td>
                            <td style="text-align: center;"><?php echo number_format((int)$total_conversions); ?></td>
                            <td class="total-amount">$<?php echo number_format((float)$available, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <p class="main-text">
                With the current balance, your account is now eligible for withdrawal in accordance
                with our payment policy. Please log in to your account and submit a withdrawal request by following the
                provided instructions.
            </p>

            <p class="main-text">
                If you have any questions regarding your financial report or the withdrawal process,
                please feel free to contact us for further assistance.
            </p>

            <div class="signature">
                <p>Thank you for your continued partnership.</p>
                <p><strong>Best regards,</strong><br>
                    Worldwide Affiliate</p>
            </div>
        </div>

        <div class="footer">
            <p class="footer-note">Note: This is an automated notification email. Please do not reply directly to this message.</p>

            <?php if (!empty($manager)): ?>
                <?php
                    $m_username = is_array($manager) ? (isset($manager['username']) ? $manager['username'] : '') : (isset($manager->username) ? $manager->username : '');
                    $m_aim      = is_array($manager) ? (isset($manager['aim']) ? $manager['aim'] : '')           : (isset($manager->aim) ? $manager->aim : '');
                    $m_skype    = is_array($manager) ? (isset($manager['skype']) ? $manager['skype'] : '')       : (isset($manager->skype) ? $manager->skype : '');

                    $parts = array();
                    if ($m_aim !== '')   $parts[] = 'Teams ' . $esc($m_aim);
                    if ($m_skype !== '') $parts[] = 'Skype ' . $esc($m_skype);
                ?>

                <p class="footer-contact">
                    For assistance, contact your personal manager<?php echo $m_username ? ' (' . $esc($m_username) . ')' : ''; ?>:
                    <?php echo $parts ? implode(' or ', $parts) : 'please contact support.'; ?>
                </p>
            <?php endif; ?>

            <div class="footer-divider"></div>

            <p class="footer-copyright">
                © <?php echo date('Y'); ?> Wedebeek Technology Limited. All rights reserved.
            </p>
            <p class="footer-address">41 Khue My Dong 7, Khue My, Ngu Hanh Son, Da Nang, Viet Nam, 50511</p>
        </div>
    </div>
</body>
</html>
    <?php

    return ob_get_clean();
}



}

