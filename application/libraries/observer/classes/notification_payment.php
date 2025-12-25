<?php

require_once APPPATH . 'libraries/observer/contracts/notification.php';


class Notification_Payment extends BaseNotification
{

    protected $title = 'Payment Notification';

    protected $category = 'Payment';

    protected $advertiser_id;

    public function __construct($advertiser_id)
    {
        parent::__construct();
        $this->CI->load->model('Advertiser_model');
        $this->advertiser_id = $advertiser_id;
    }

    public function notify_payment_near_expired($offer_id, $offer_name)
    {
        $this->set_sender(1);
        $this->set_receiever($this->advertiser_id);
        $this->set_is_adv(1);
        $this->set_is_manager(1);
        $this->set_link(base_url(). 'v2/payments');
        $this->set_short_description("<span style='color:#d7a100'>Reminder ! Only 5 days left until payment due for $offer_id $offer_name. Please make confirmation for publishers to avoid your product being temporarily locked.<span>");
        $this->notify();
    }

    public function notify_payment_pending($offer_id, $offer_name)
    {
        $this->set_sender(1);
        $this->set_receiever($this->advertiser_id);
        $this->set_is_adv(1);
        $this->set_is_manager(1);
        $this->set_link(base_url(). 'v2/payments');
        $this->set_short_description("<span style='color:red'>Delayed ! Your payment for $offer_id $offer_name has been delayed! Your product has been locked. Please go to make payment to continue promote your product!<span>");
        $this->notify();
    }

    public function notify_payment_expired()
    {
        $this->set_sender(1);
        $this->set_receiever($this->advertiser_id);
        $this->set_is_adv(1);
        $this->set_is_manager(1);
        $this->set_link(base_url(). 'v2/payments');
        $this->set_short_description("<span style='color:#d7a100'>Warning ! Please go to the payment center to make the payment. Your product will be locked after 5 days of waiting!</span");
        $this->notify();
    }

    public function notify_payment_complete($payment_id)
    {
        $payment = $this->CI->db->get_where('advertiser_payment', ['id' => $payment_id])->row();
        
        $this->set_sender(1);
        $this->set_receiever($payment->adv_id);
        $this->set_is_adv(1);
        $this->set_is_manager(1);
        $this->set_link(base_url(). 'v2/payments');
        $this->set_short_description("<span style='color:#087b00'>Thanks for your payment and great cooperation. Product will continue promote traffic.</span>");
        $this->notify();
    }
}
