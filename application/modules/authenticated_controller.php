<?php

require APPPATH . 'libraries/auth/auth_plugin.php';


abstract class AuthenticatedController extends CI_Controller
{
  public $viewer;
  public $auth_plugin;
  public $member;
  public $route;

  public function __construct()
  {
    parent::__construct();
    $this->auth();
    $this->auth_plugin = new Auth_plugin();
    $this->load->library('parser');
  }

  protected function auth()
  {
    if (!$this->session->userdata('user'))
    {
      return redirect(base_url() . 'v2/sign/in');
    }
  }
}
