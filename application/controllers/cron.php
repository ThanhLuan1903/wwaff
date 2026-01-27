<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function minpay_emails()
    {
        if (method_exists($this->input, 'is_cli_request') && !$this->input->is_cli_request()) {
            show_404(); return;
        }

        // tránh notice do dự án đang dùng HTTP_HOST/REMOTE_ADDR trong CLI
        if (empty($_SERVER['HTTP_HOST'])) $_SERVER['HTTP_HOST'] = 'localhost';
        if (empty($_SERVER['REMOTE_ADDR'])) $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

        echo "CRON_START " . date('c') . PHP_EOL;

        $this->load->library('MinpayCron');
        $this->minpaycron->run();

        echo "CRON_END " . date('c') . PHP_EOL;
    }
}
