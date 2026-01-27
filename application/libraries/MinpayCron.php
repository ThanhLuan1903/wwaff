<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MinpayCron
 * - Quét các file job: application/cache/minpay_*.json
 * - Đến giờ thì gửi email qua Mailjet
 * - Thành công => xoá file job
 * - Thất bại => retry có giới hạn (mặc định 5 lần), lưu tries vào chính file json
 *
 * Job format (ví dụ):
 * {
 *   "send_at": 1769429292,
 *   "to": "email@gmail.com",
 *   "subject": "...",
 *   "data": {...},
 *   "tries": 0,
 *   "created_at": 1769429232
 * }
 */
class MinpayCron
{
    /** @var CI_Controller */
    protected $CI;

    /** @var int */
    protected $MAX_TRIES = 5;

    /** @var int lock timeout seconds (để tránh kẹt lock nếu process chết) */
    protected $LOCK_TTL = 300; // 5 phút

    /** @var string */
    protected $LOCK_FILE;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->LOCK_FILE = sys_get_temp_dir() . '/minpay_cron.lock';
    }

    /**
     * Entry point
     */
    public function run()
    {
        $this->out("JOB_START " . date('c'));

        // lock để tránh cron chạy song song (trùng mail)
        if (!$this->acquire_lock()) {
            $this->out("LOCKED (another process is running)");
            return;
        }

        try {
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

            // load mailer
            $this->CI->load->library('Mailjet');

            foreach ($files as $file) {
                $this->process_file($file, $now);
            }

        } finally {
            $this->release_lock();
            $this->out("JOB_END " . date('c'));
        }
    }

    /**
     * Process one job file
     */
    protected function process_file($file, $now)
    {
        $raw = @file_get_contents($file);
        if ($raw === false || $raw === '') {
            @unlink($file);
            $this->out("BAD_FILE {$file} (deleted)");
            return;
        }

        $job = json_decode($raw, true);
        if (!is_array($job) || empty($job['send_at']) || empty($job['to'])) {
            @unlink($file);
            $this->out("INVALID_JOB {$file} (deleted)");
            return;
        }

        // normalize
        $job['tries'] = isset($job['tries']) ? (int)$job['tries'] : 0;

        // quá số lần retry -> drop
        if ($job['tries'] >= $this->MAX_TRIES) {
            log_message('error', "✗ [MINPAY] Dropped after {$this->MAX_TRIES} tries: {$job['to']} file={$file}");
            @unlink($file);
            $this->out("DROP {$job['to']} after {$this->MAX_TRIES} tries (deleted)");
            return;
        }

        // chưa tới giờ
        if ((int)$job['send_at'] > $now) {
            $this->out("WAIT {$job['to']} send_at={$job['send_at']} now={$now}");
            return;
        }

        // build email content
        $email_data = isset($job['data']) && is_array($job['data']) ? $job['data'] : array();
        $message = $this->CI->load->view('members/email_template/minpay_threshold_email', $email_data, true);

        // send
        $result = $this->CI->mailjet->send_email(
            $job['to'],
            isset($job['subject']) ? $job['subject'] : 'Payment Threshold Reached',
            $message,
            'support@wwaff.com',
            'Worldwide Affiliate'
        );

        // debug (đừng để error level, nhìn log đỏ mệt)
        log_message('debug', '[MINPAY][MAILJET_RETURN] ' . print_r($result, true));

        $ok = $this->is_mailjet_success($result);

        if ($ok) {
            log_message('info', "✓ [MINPAY] Email sent to {$job['to']}");
            $this->out("SENT {$job['to']}");
            @unlink($file); // ✅ quan trọng: thành công thì xoá job
            return;
        }

        // fail -> tăng tries và lưu lại để retry
        $job['tries'] = $job['tries'] + 1;
        $job['last_try_at'] = time();

        // lưu lại file job (atomic write)
        $this->write_json_atomic($file, $job);

        log_message('error', "✗ [MINPAY] Email failed to {$job['to']} (will retry) tries={$job['tries']} file={$file}");
        $this->out("FAIL {$job['to']} (will retry) tries={$job['tries']}");
    }

    /**
     * Detect success from Mailjet library result
     * Your actual result example:
     * Array(
     *   [success] => 1
     *   [http_code] => 200
     *   [response] => {"Messages":[{"Status":"success", ...}]}
     * )
     */
    protected function is_mailjet_success($result)
    {
        // boolean / int style
        if ($result === true || $result === 1) return true;

        // string style
        if (is_string($result)) {
            if (stripos($result, 'success') !== false) return true;
            if (stripos($result, 'ok') !== false) return true;
            return false;
        }

        // array style (your case)
        if (is_array($result)) {
            if (!empty($result['success']) && (int)$result['success'] === 1) return true;
            if (!empty($result['http_code']) && in_array((int)$result['http_code'], array(200, 201, 202), true)) return true;

            if (!empty($result['response'])) {
                $r = json_decode($result['response'], true);
                if (is_array($r) && !empty($r['Messages'][0]['Status']) && $r['Messages'][0]['Status'] === 'success') {
                    return true;
                }
            }
            return false;
        }

        // object style
        if (is_object($result)) {
            if (isset($result->success) && (int)$result->success === 1) return true;
            if (isset($result->http_code) && in_array((int)$result->http_code, array(200, 201, 202), true)) return true;

            if (isset($result->response)) {
                $r = json_decode($result->response, true);
                if (is_array($r) && !empty($r['Messages'][0]['Status']) && $r['Messages'][0]['Status'] === 'success') {
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    /**
     * Atomic write JSON file to avoid half-written job
     */
    protected function write_json_atomic($path, array $data)
    {
        $tmp = $path . '.tmp';
        @file_put_contents($tmp, json_encode($data));
        @rename($tmp, $path);
    }

    /**
     * Simple stdout
     */
    protected function out($s)
    {
        echo $s . PHP_EOL;
    }

    /**
     * Lock helpers
     */
    protected function acquire_lock()
    {
        // nếu lock tồn tại và còn hạn -> không chạy
        if (file_exists($this->LOCK_FILE)) {
            $mtime = @filemtime($this->LOCK_FILE);
            if ($mtime && (time() - $mtime) < $this->LOCK_TTL) {
                return false;
            }
            // lock cũ (process chết) -> xoá
            @unlink($this->LOCK_FILE);
        }

        // tạo lock
        return @file_put_contents($this->LOCK_FILE, (string)getmypid()) !== false;
    }

    protected function release_lock()
    {
        @unlink($this->LOCK_FILE);
    }
}
