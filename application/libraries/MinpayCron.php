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
log_message('info', "MINPAY_SEND_MAIL userid={$userid} to={$email_payload['to']}");

            // gửi
            $message = $this->CI->load->view('members/email_template/minpay_threshold_email', $email_payload['data'], true);

            $result = $this->CI->mailjet->send_email(
                $email_payload['to'],
                $email_payload['subject'],
                $message,
                'support@wwaff.com',
                'Worldwide Affiliate'
            );

            log_message('info', 'MINPAY_MAILJET_RAW_RESULT ' . var_export($result, true));


            $ok = ($result === true || $result === 1);

            if ($ok) {
                // gửi ok -> remove job khỏi redis
                $redis->multi()
                    ->zRem('minpay:due', $job_key)
                    ->del($job_key)
                    ->exec();
                $redis->unwatch();

                log_message('info', "✓ [MINPAY] Email sent userid={$userid} to={$email_payload['to']}");
                $this->out("SENT userid={$userid}");
            } else {
                // fail -> không remove, để cron sau retry
                $redis->unwatch();
                log_message('error', "✗ [MINPAY] Email failed userid={$userid} to={$email_payload['to']}");
                $this->out("FAIL userid={$userid}");
            }
        }

        $this->out("JOB_END " . gmdate('c'));
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

    protected function out($s) { echo $s . PHP_EOL; }
}
