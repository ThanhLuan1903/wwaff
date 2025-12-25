<?php

require_once APPPATH . 'libraries/observer/contracts/notification.php';

class Notification_Request_Offer extends BaseNotification
{

    protected $title = 'Request Offer Notification';
    protected $category = 'request_offer';

    protected $is_manager = 0;

    protected $request_offer;

    public function __construct($user_id, $offer_id)
    {
        parent::__construct();
        $this->request_offer = $this->get_request_offer($user_id, $offer_id);
    }

    private function get_request_offer($user_id, $offer_id)
    {
        $query = 'SELECT 
            cpalead_request.userid, 
            cpalead_request.offerid, 
            cpalead_offer.is_adv, 
            cpalead_offer.title, 
            cpalead_users.username, 
            cpalead_advertiser.username as advertiser_username
        FROM cpalead_request
        INNER JOIN cpalead_offer ON cpalead_offer.id = cpalead_request.offerid
        LEFT JOIN cpalead_users ON cpalead_users.id = cpalead_request.userid
        LEFT JOIN cpalead_advertiser ON cpalead_advertiser.id = cpalead_offer.is_adv
        WHERE cpalead_request.userid = ? AND cpalead_request.offerid = ? AND is_adv is not null';
        return $this->CI->db->query($query, [$user_id, $offer_id])->row();
    }

// Publisher Request ADV
    public function notify_apply()
    {
        $this->set_category("Request");
        $this->set_title('Request Notification');
        $this->set_sender($this->request_offer->userid);
        $this->set_receiever($this->request_offer->is_adv);
        $this->set_is_adv(1);
        $this->set_link(base_url() . 'v2/publishers/my-publishers');
        $this->set_short_description("Request product! {$this->request_offer->userid} {$this->request_offer->username} has sent requested to {$this->request_offer->offerid} {$this->request_offer->title}");
        $this->notify();
    }

    public function notify_re_apply()
    {
        $this->set_category("Request");
        $this->set_title('Request Notification');
        $this->set_sender($this->request_offer->userid);
        $this->set_receiever($this->request_offer->is_adv);
        $this->set_is_adv(1);
        $this->set_link(base_url() . 'v2/publishers/my-publishers');
        $this->set_short_description("Request product! {$this->request_offer->userid} {$this->request_offer->username} has sent requested to {$this->request_offer->offerid} {$this->request_offer->title}");
        $this->notify();
    }

    public function notify_adv_accept()
    {
        $this->set_category("Request");
        $this->set_title('Request Notification');
        $this->set_sender($this->request_offer->is_adv);
        $this->set_receiever($this->request_offer->userid);
        $this->set_is_adv(0);
        $this->set_short_description("Congrats! {$this->request_offer->is_adv} {$this->request_offer->advertiser_username} has accepted your request to run {$this->request_offer->offerid} {$this->request_offer->title}.");
        $this->set_link(base_url(). 'v2/offers/available');
        $this->notify();
    }

    public function notify_pub_pending()
    {
        $this->set_category("Request");
        $this->set_title('Request Notification');
        $this->set_sender($this->request_offer->userid);
        $this->set_receiever($this->request_offer->is_adv);
        $this->set_is_adv(1);
        $this->set_short_description('Publisher ' . $this->request_offer->userid . ' pending your offer has ID: ' . $this->request_offer->offerid);
        $this->set_link(base_url(). 'v2/publishers/invited-publishers');
        $this->notify();
    }

    public function notify_adv_denied()
    {
        $this->set_category("Request");
        $this->set_title('Request Notification');
        $this->set_sender($this->request_offer->is_adv);
        $this->set_receiever($this->request_offer->userid);
        $this->set_is_adv(0);
        $this->set_short_description("Your applied offer {$this->request_offer->offerid} has been rejected.");
        $this->set_link(base_url(). 'v2/offers/available');
        $this->notify();
    }

    public function notify_adv_pending()
    {
        $this->set_category("Request");
        $this->set_title('Request Notification');
        $this->set_sender($this->request_offer->is_adv);
        $this->set_receiever($this->request_offer->userid);
        $this->set_is_adv(0);
        $this->set_short_description('Your applied offer ' . $this->request_offer->offerid . ' have been pended.');
        $this->set_link(base_url(). 'v2/offers/available');
        $this->notify();
    }

// ADV INVITE PUBLISHER

    public function notify_adv_invite() {
        $this->set_category("Intive");
        $this->set_title('Intive Notification');
        $this->set_sender($this->request_offer->is_adv);
        $this->set_receiever($this->request_offer->userid);
        $this->set_is_adv(0);
        $this->set_short_description("Invite, {$this->request_offer->advertiser_username} has sent you an invitation to run their product {$this->request_offer->offerid} {$this->request_offer->title}.");
        $this->set_link(base_url(). 'v2/offers/invites');
        $this->notify();
    }

    public function notify_pub_agreed()
    {
        $this->set_category("Intive");
        $this->set_title('Intive Notification');
        $this->set_sender($this->request_offer->userid);
        $this->set_receiever($this->request_offer->is_adv);
        $this->set_is_adv(1);
        $this->set_short_description("Congrats! Publisher {$this->request_offer->userid} {$this->request_offer->username} accepted your invitation has ID: {$this->request_offer->offerid} {$this->request_offer->title}.");
        $this->set_link(base_url(). 'v2/publishers/invited-publishers');
        $this->notify();
    }

    public function notify_pub_denied()
    {
        $this->set_category("Intive");
        $this->set_title('Intive Notification');
        $this->set_sender($this->request_offer->userid);
        $this->set_receiever($this->request_offer->is_adv);
        $this->set_is_adv(1);
        $this->set_short_description("New! {$this->request_offer->userid} {$this->request_offer->username} has rejected your invitation to run {$this->request_offer->offerid} {$this->request_offer->title}.");
        $this->set_link(base_url(). 'v2/publishers/invited-publishers');
        $this->notify();
    }





// PLACEMENT IN HERE   
    
    public function notify_adv_request_placement($placement_id) {
        $this->set_category("Placement");
        $this->set_title('Placement Notification');
        $this->set_sender($this->request_offer->is_adv);
        $this->set_receiever($this->request_offer->userid);
        $this->set_is_adv(0);
        $this->set_short_description("Dear {$this->request_offer->userid} {$this->request_offer->username}! Advertiser need you provide traffic placement for {$this->request_offer->offerid} {$this->request_offer->title}. To avoid product suspension, please provide ASAP.");
//        $this->set_short_description("{$this->request_offer->is_adv} {$this->request_offer->advertiser_username} has send placement for {$this->request_offer->offerid} {$this->request_offer->title}.");
        $this->set_link(base_url() . 'v2/placements/'.$placement_id);
        $this->notify();
    }

    public function notify_adv_request_placement_again($placement_id) {
        $this->set_category("Placement");
        $this->set_title('Placement Notification');
        $this->set_sender($this->request_offer->is_adv);
        $this->set_receiever($this->request_offer->userid);
        $this->set_is_adv(0);
        $this->set_short_description("Dear {$this->request_offer->userid} {$this->request_offer->username}! Advertiser need you provide traffic placement for {$this->request_offer->offerid} {$this->request_offer->title}. It seems like what you provided before was not clear enough. Please help make it better and clearer!");
//        $this->set_short_description("{$this->request_offer->is_adv} {$this->request_offer->advertiser_username} has send placement for {$this->request_offer->offerid} {$this->request_offer->title}.");
        $this->set_link(base_url() . 'v2/placements/'.$placement_id);
        $this->notify();
    }

    public function notify_pub_submitted_placement($placement_id) {
        $this->set_category("Placement");
        $this->set_title('Placement Notification');
        $this->set_sender($this->request_offer->userid);
        $this->set_receiever($this->request_offer->is_adv);
        $this->set_is_adv(1);
        $this->set_short_description("Good! {$this->request_offer->userid} {$this->request_offer->username} has just update placment for {$this->request_offer->offerid} {$this->request_offer->title}.");
        $this->set_link(base_url() . 'v2/placements/'.$placement_id);
        $this->notify();
    }
}
