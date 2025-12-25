<?php
require_once APPPATH . 'libraries/observer/contracts/notification.php';

class Notification_Publisher_Update_Info extends BaseNotification
{
    protected $category = 'Information';

    private $publisher_id;

    public function __construct($publisher_id)
    {
        parent::__construct();
        $this->publisher_id = $publisher_id;
        $this->set_sender(1);
        $this->set_is_manager(1);
        $this->set_receiever($this->publisher_id);
        $this->set_is_adv(0);
    }

    public function notify_level_up($level)
    {
        $this->set_title('Information Notification');
        $this->set_short_description("Excellent! You have reached the publisher level $level.");
        $this->notify();
    }

    public function notify_receive_rating($advertiser)
    {
        $this->set_title('Rating Notification');
        $this->set_short_description("Rating! You have just received a review from the manufacturer of {$advertiser->username}.");
        $this->notify();
    }

    public function notify_ranking($range) {
        $message = "Power! Congratulations on being in the top 10 highest earning publishers";
        $this->set_title('Information Notification');
        $this->set_short_description($message);
        $this->notify();
    }
}
