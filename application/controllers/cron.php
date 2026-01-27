<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function minpay_emails()
    {
        if (method_exists($this->input, 'is_cli_request') && !$this->input->is_cli_request()) {
            show_404(); return;
        }
        $this->load->library('MinpayCron');
        $this->minpaycron->run();
    }
}
