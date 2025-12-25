<?php

require_once APPPATH . 'libraries/observer/notification_observer.php';

abstract class BaseNotification implements Notification_Observer
{
    /**
     * message
     *
     * @var string
     */
    protected $title = 'System Notification';

    /**
     * short_description
     *
     * @var string
     */
    protected $short_description = 'A message from default of system';

    /**
     * content
     *
     * @var string
     */
    protected $content = '';

    /**
     * category
     *
     * @var string
     */
    protected $category = 'system';

    /**
     * sender
     *
     * @var mixed
     */
    protected $sender;

    /**
     * receiver
     *
     * @var mixed
     */
    protected $receiver;

    /**
     * is_manager
     *
     * @var int
     */
    protected $is_manager = 1;

        
    /**
     * is_adv
     *
     * @var mixed
     */
    protected $is_adv;

    /**
     * link
     *
     * @var string
     */
    protected $link = '';

    /**
     * CI
     *
     * @var CI_Controller
     */
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Builder_model');
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function set_short_description($description)
    {
        $this->short_description = $description;
    }

    public function set_content($content)
    {
        $this->content = $content;
    }

    public function set_category($category)
    {
        $this->category = $category;
    }

    public function set_sender($sender_id)
    {
        $this->sender = $sender_id;
    }

    public function set_receiever($recevier_id)
    {
        $this->receiver = $recevier_id;
    }

    public function set_is_manager($is_manager)
    {
        $this->is_manager = $is_manager;
    }

    public function set_is_adv($is_adv) {
        $this->is_adv = $is_adv;
    }

    public function set_link($link)
    {
        $this->link = $link;
    }

    public function notify()
    {
        $this->CI->db->insert('notifications', [
            'category' => $this->category,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'is_manager' => $this->is_manager,
            'is_adv' => $this->is_adv,
            'link' => $this->link,
        ]);
    }
}
