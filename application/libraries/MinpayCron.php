<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MinpayCron
{

    public function __construct() {
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
        $this->load->library('Mailjet');

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
            $message = $this->load->view('members/email_template/minpay_threshold_email', $email_data, TRUE);

            $result = $this->mailjet->send_email(
                $job['to'],
                $job['subject'],
                $message,
                'support@wwaff.com',
                'Worldwide Affiliate'
            );

            if ($result === 1) {
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
