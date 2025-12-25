<?php

require_once APPPATH . 'libraries/observer/contracts/notification.php';


class Notification_Support extends BaseNotification
{
    protected $title = 'Help and Support Notification';

    protected $category = 'help_and_support';

    public function __construct($sender_id, $receiver_id, $short_description, $content, $is_adv, $parent_id)
    {
        parent::__construct();
        $this->set_sender($sender_id);
        $this->set_receiever($receiver_id);
        $this->set_short_description($short_description);
        $this->set_link(base_url() . 'v2/help_and_support/detail/'.$parent_id);
        $this->set_content($content);
        $this->set_is_adv($is_adv);
    }
}
