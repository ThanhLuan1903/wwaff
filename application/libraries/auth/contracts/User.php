<?php

interface UserInterface
{
  public function login($username, $password);
}

abstract class User extends CI_Controller implements UserInterface
{
  protected $name;
  protected $email;
  protected $role;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model');
    $this->load->model('Home_model');
    $this->load->model('Admin_model');
  }

  /**
   * Check method of HTTP Request
   *
   * @return boolean
   */
  protected function is_method_post()
  {
    return $this->input->server('REQUEST_METHOD') === 'POST';
  }
}
