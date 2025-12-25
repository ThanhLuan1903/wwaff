<?php

require_once APPPATH . 'libraries/modules/publisher.php';
require_once APPPATH . 'libraries/modules/advertiser.php';

class Auth_plugin
{
  const PUBLISHER_ROLE = 1;
  const ADVERTISER_ROLE = 2;

  public $user;
  protected $CI;

  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->library('session');
  }

  /**
   * Get the authenticated user
   * 
   * @return mixed $user
   */
  public function get_user()
  {
    return $this->user;
  }

  public function set_user()
  {
    $this->user = $this->user_factory($this->CI->session->userdata('role'));
    $this->CI->session->set_userdata('user',  $this->user->get_user($this->CI->session->userdata('user')->id));
  }


  /**
   * authenticate
   *
   * @return mixed
   */
  public function authenticate($username, $password, $role)
  {
    $userFactory = $this->user_factory($role);
    $result = $userFactory->login($username, sha1(md5($password)));

    if (isset($result['error'])) {
      return $result;
    }

    $user = $result['user'];
    $this->user = $user;
    $this->CI->session->set_userdata('logedin', 1);
    $this->CI->session->set_userdata('user', $user);
    $this->CI->session->set_userdata('role', $role);
    $this->CI->session->set_userdata('userid', $user->id);

    return $result;
  }

  public function logout()
  {
    $this->CI->session->unset_userdata('logedin');
    $this->CI->session->unset_userdata('userid');
    $this->CI->session->unset_userdata('user');
    $this->CI->session->unset_userdata('role');
    redirect(base_url());
  }

  public function user_factory($role)
  {
    switch ($role) {
      case self::PUBLISHER_ROLE:
        return new Publisher();
      case self::ADVERTISER_ROLE:
        return new Advertiser();
      default:
        throw new Exception('Role not supported');
    }
  }
}
