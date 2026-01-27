<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MinpayCron
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();   // lấy CodeIgniter super object
    }

    public function run()
    {
        $this->out("JOB_START " . date('c'));

        $cache_dir = APPPATH . 'cache/';
        if (!is_dir($cache_dir)) {
            $this->out("NO_CACHE_DIR {$cache_dir}");
            return;
        }

        $files = glob($cache_dir . 'minpay_*.json');
        if (!$files) {
            $this->out("NO_JOBS");
            return;
        }

        $now = time();

        $this->CI->load->library('Mailjet'); // ✅ dùng CI
        // thường library tên Mailjet sẽ tạo $this->mailjet
        // nên ở đây dùng $this->CI->mailjet

        foreach ($files as $file) {
            $raw = @file_get_contents($file);
            if (!$raw) { @unlink($file); $this->out("BAD_FILE {$file}"); continue; }

            $job = json_decode($raw, true);
            if (!is_array($job) || empty($job['send_at']) || empty($job['to'])) {
                @unlink($file);
                $this->out("INVALID_JOB {$file}");
                continue;
            }

            if ((int)$job['send_at'] > $now) {
                $this->out("WAIT {$job['to']} send_at={$job['send_at']} now={$now}");
                continue;
            }

            $email_data = isset($job['data']) ? $job['data'] : array();
            $message = $this->CI->load->view('members/email_template/minpay_threshold_email', $email_data, TRUE);

            $result = $this->CI->mailjet->send_email(
                $job['to'],
                $job['subject'],
                $message,
                'support@wwaff.com',
                'Worldwide Affiliate'
            );

            // mặc định fail
            $ok = false;

            // case 1: lib trả boolean
            if ($result === true) $ok = true;

            // case 2: lib trả int 1
            if ($result === 1) $ok = true;

            // case 3: lib trả string "OK"
            if (is_string($result) && stripos($result, 'ok') !== false) $ok = true;

            // case 4: lib trả array/object có status code (tuỳ lib bạn)
            if (is_array($result) && isset($result['status']) && in_array((int)$result['status'], [200,201,202])) $ok = true;
            if (is_object($result) && isset($result->status) && in_array((int)$result->status, [200,201,202])) $ok = true;

            // debug tạm để biết nó trả gì
            log_message('error', '[MINPAY][MAILJET_RETURN] ' . print_r($result, true));

            if ($ok) {
                log_message('info', "✓ Minpay email sent to {$job['to']}");
                $this->out("SENT {$job['to']}");
                @unlink($file);
            } else {
                log_message('error', "✗ Minpay email failed to {$job['to']} (will retry)");
                $this->out("FAIL {$job['to']} (will retry)");
            }
        }

        $this->out("JOB_END " . date('c'));
    }

    private function out($s)
    {
        echo $s . PHP_EOL;
    }
}
