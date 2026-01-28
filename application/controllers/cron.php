<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function minpay_emails()
    {
log_message('info', 'CRON_START ' . date('c'));

$this->load->library('MinpayCron');
$this->minpaycron->run();

log_message('info', 'CRON_END ' . date('c'));

    }
}
