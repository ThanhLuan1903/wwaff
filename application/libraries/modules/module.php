<?php

require_once APPPATH . 'libraries/modules/module_interface.php';
require_once APPPATH . 'libraries/modules/traits/session_trait.php';
require_once APPPATH . 'libraries/modules/traits/generic_trait.php';
require_once APPPATH . '/modules/authenticated_controller.php';
require_once APPPATH . 'libraries/modules/notification_modules.php';
require_once APPPATH . 'libraries/modules/placement_modules.php';

class Module extends AuthenticatedController implements ModuleInterface
{
  use SessionTrait, NotificationModules, PlacementModules;

  public $user;
  public $auth;

  public function __construct()
  {
    parent::__construct();
    $this->auth_plugin->set_user();
    $this->user = $this->auth_plugin->get_user();
    $this->load->model('Custom_model');
  }

  public function dashboard()
  {
    $this->clear_filter_session();
    return $this->user->dashboard();
  }

  public function publisher()
  {
    return $this->user->list_publisher();
  }

  public function invite_publishers()
  {
    return $this->user->invite_publishers();
  }

  public function rating_publishers()
  {
    return $this->user->rating_publishers();
  }

  public function ajax_search_publisher()
  {
    return $this->user->ajax_search_publisher();
  }

  public function add_product()
  {
    return $this->user->add_product();
  }

  public function update_product($id)
  {
    return $this->user->update_product_form($id);
  }

  public function profile()
  {
    return $this->user->profile();
  }

  public function referrals()
  {
    return $this->user->referrals();
  }

  public function payment()
  {
    return $this->user->payments();
  }

  public function payment_list()
  {
    return $this->user->payment_list();
  }

  public function request_payouts()
  {
    return $this->user->request_payouts();
  }

  public function my_product($page = 0)
  {
    return $this->user->my_product($page);
  }

  public function update_status()
  {
    return $this->user->update_status();
  }

  public function request_product($offset = 1)
  {
    return $this->user->request_product($offset);
  }

  public function add_request_product()
  {
    return $this->user->add_request_product();
  }

  public function my_publishers()
  {
    return $this->user->my_publishers();
  }

  public function invited_publishers() {
    return $this->user->invited_publishers();
  }

  public function update_my_publisher()
  {
    return $this->user->update_my_publisher();
  }

  public function conversion()
  {
    return $this->user->stastic_conversion();
  }
  public function clicks()
  {
    return $this->user->stastic_clicks();
  }

  public function approve_tracklinks()
  {
    return $this->user->approve_tracklinks();
  }

  public function mark_as_read()
  {
    return $this->user->mark_as_read();
  }
}
