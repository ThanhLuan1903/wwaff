<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function minpay_emails()
    {
        $this->load->library('MinpayCron');
        $this->minpaycron->run();
    }
}
