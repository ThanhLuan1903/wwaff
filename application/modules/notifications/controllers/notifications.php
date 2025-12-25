<?php
require_once APPPATH . 'libraries/modules/module.php';

class Notifications extends CI_Controller
{

  public $route;

  public function __construct()
  {
    parent::__construct();
    $this->route = new Module();
  }

  public function index()
  {
    return $this->route->notification_center();
  }

  public function mark_as_read()
  {
    if ($this->input->server('REQUEST_METHOD') !== 'POST') {
      throw new Exception('Method is not supported');
    }

    return $this->route->mark_as_read();
  }
}
