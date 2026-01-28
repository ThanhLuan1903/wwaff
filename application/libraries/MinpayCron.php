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
    // Helper nhỏ cho escape
    $e = function ($str) {
        return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
    };

    $username  = isset($d['username']) ? $e($d['username']) : 'Publisher';
    $available = isset($d['available']) ? number_format((float)$d['available'], 2) : '0.00';

    $html = '<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Minpay Notification</title>
</head>
<body style="margin:0;padding:0;background:#f5f6f8;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f6f8;padding:20px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:6px;overflow:hidden;">
                
                <!-- Header -->
                <tr>
                    <td style="background:#2c7be5;color:#ffffff;padding:20px;">
                        <h2 style="margin:0;font-size:20px;">Worldwide Affiliate</h2>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:24px;color:#333333;">
                        <p style="margin-top:0;font-size:14px;">Hi <strong>' . $username . '</strong>,</p>

                        <p style="font-size:14px;line-height:1.6;">
                            Chúc mừng bạn đã <strong>đạt ngưỡng thanh toán</strong>.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" style="margin:16px 0;">
                            <tr>
                                <td style="background:#f0f4ff;padding:14px;border-radius:4px;">
                                    <strong>Số dư hiện tại:</strong>
                                    <span style="color:#2c7be5;font-size:16px;">
                                        $' . $available . '
                                    </span>
                                </td>
                            </tr>
                        </table>';

    // Approved offers
    if (!empty($d['approved_offers']) && is_array($d['approved_offers'])) {
        $html .= '
                        <h3 style="font-size:15px;margin-top:24px;">Approved offers</h3>
                        <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse;font-size:13px;">
                            <tr style="background:#f1f1f1;">
                                <th align="left" style="border:1px solid #ddd;">Offer</th>
                                <th align="center" style="border:1px solid #ddd;">Conversions</th>
                                <th align="right" style="border:1px solid #ddd;">Amount</th>
                            </tr>';

        foreach ($d['approved_offers'] as $o) {
            $html .= '
                            <tr>
                                <td style="border:1px solid #ddd;">' . $e($o['offer_name']) . '</td>
                                <td align="center" style="border:1px solid #ddd;">' . (int)$o['conversion_count'] . '</td>
                                <td align="right" style="border:1px solid #ddd;">$' . number_format((float)$o['total_amount'], 2) . '</td>
                            </tr>';
        }

        $html .= '
                        </table>';
    }

    // Manager
    if (!empty($d['manager']) && isset($d['manager']->username)) {
        $html .= '
                        <p style="margin-top:20px;font-size:13px;">
                            <strong>Manager:</strong> ' . $e($d['manager']->username) . '
                        </p>';
    }

    $html .= '
                        <p style="margin-top:20px;font-size:14px;">
                            Vui lòng đăng nhập hệ thống để thực hiện <strong>yêu cầu rút tiền</strong>.
                        </p>

                        <p style="margin-top:30px;font-size:13px;color:#666;">
                            — Worldwide Affiliate Team
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#fafafa;padding:14px;text-align:center;font-size:12px;color:#999;">
                        This is an automated email. Please do not reply.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>';

    return $html;
}




}

