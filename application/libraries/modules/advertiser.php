<?php

require_once APPPATH . 'libraries/modules/traits/advertiser_trait.php';
require_once APPPATH . 'libraries/modules/traits/advertiser/payment_trait.php';
require_once APPPATH . 'libraries/modules/traits/advertiser/product_trait.php';
require_once APPPATH . 'libraries/modules/traits/advertiser/profile_trait.php';
require_once APPPATH . 'libraries/modules/traits/advertiser/management_trait.php';
require_once APPPATH . 'libraries/modules/traits/advertiser/notification_trait.php';
require_once APPPATH . 'libraries/modules/traits/advertiser/placement_trait.php';
require_once APPPATH . 'libraries/modules/traits/advertiser/stastic_trait.php';
require_once APPPATH . 'libraries/observer/classes/notification_request_offer.php';

class Advertiser extends User
{
  use GenericTrait,
    AdvertiserTrait,
    Advertiser_PaymentTrait,
    Advertiser_ProductTrait,
    Advertiser_ProfileTrait,
    Advertiser_Management_Trait,
    Advertiser_Notifications_Trait,
    Advertiser_Placement_Trait,
    Advertiser_Statistic_Trait;
  protected $per_page = 30;
  private $table = 'advertiser';
  private $is_adv = 0;

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Partner_model');
    $this->load->model('Advertiser_model');
    $this->load->model('Custom_model');
    $this->load->model('Request_Product_model');
    $this->load->model('Calculator_model');
    $this->load->model('Admin_model');
    $this->load->helper(array('alias_helper', 'text', 'form'));
    if ($this->session->userdata('role') == 1) {
      $table = 'users';
    } else if ($this->session->userdata('role') == 2) {
      $table = 'advertiser';
      $this->is_adv = 1;
    }
    if ($this->session->userdata('logedin')) {
      $this->db->select($table . '.*,cpalead_api_key.api_key');
      $this->db->from($table);
      $this->db->join('api_key', 'api_key.user_id =' . $table . '.id AND cpalead_api_key.is_adv = ' . $this->is_adv, 'left');
      $this->db->where(array($table . '.id' => $this->session->userdata('userid')));
      $this->member = $this->db->get()->row();
      $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
    }
  }

  public function dashboard()
  {
    $advId = $this->session->userdata('userid');
    $this->calc_advertiser($advId);
    $data = $this->get_data_dashboard();

    $partner_types = $this->Partner_model->get_all_partner_type();
    foreach ($partner_types as $type) {
      $type->partners = $this->Partner_model->find_partner_by_type($type->id);
    }
    $data['partner_types'] = $partner_types;

    $content = $this->load->view('advertiser/dashboard/vdashboard', $data, true);
    $this->load->view('advertiser/default/vindex', compact('content', 'advertiser'));
  }
  
  public function calc_advertiser($advertiser_id, $return = true)
  {

    list($balance, $holding, $available, $pending, $declined, $paid, $invoice) = $this->Calculator_model->advertiser_info($advertiser_id);
    $this->db->where('advertiser_id', $advertiser_id);
    $isExists = $this->db->get('advertiser_dashboard')->num_rows() > 0;

    if ($isExists) {
      $updated_at = date('Y-m-d H:i:m');
      $this->db->where('advertiser_id', $advertiser_id);
      $this->db->update('advertiser_dashboard', compact('balance', 'holding', 'available', 'pending', 'declined', 'paid', 'invoice', 'updated_at'));
      if ($return) echo $this->db->affected_rows() > 0;
    } else {
      $this->db->insert('advertiser_dashboard', compact('advertiser_id', 'balance', 'holding', 'available', 'pending', 'declined', 'paid', 'invoice'));
      if ($return) echo $this->db->affected_rows() > 0;
    }
  }

  public function list_publisher()
  {
    $limit_page = 24;
    $page = $this->input->get('page') ? (int)$this->input->get('page') : 0;

    if ($this->is_method_post()) {
      $this->session->set_userdata('search_input', $this->input->post('oName'));
    }

    $filters = [
      'offercat' => $this->session->userdata('offercat'),
      'search_input' => $this->session->userdata('search_input'),
      'offer_type' => $this->session->userdata('offer_types'),
      'countries' => $this->session->userdata('countries'),
      'sort-by-id' => $this->session->userdata('sort-by-id'),
      'sort-by-rating' => $this->session->userdata('sort-by-rating'),
      'sort-by-level' => $this->session->userdata('sort-by-level'),
      'sort-by-epc' => $this->session->userdata('sort-by-epc'),
      'sort-by-cr' => $this->session->userdata('sort-by-cr'),
    ];

    list($publishers, $total) = $this->get_publishers($page, $limit_page, $filters);
    $final_page = floor($total / $limit_page) == $page;


    if ($this->input->is_ajax_request()) {
      if (!empty($publishers)) {
        echo $this->load->view('advertiser/publishers/modal_offer', compact('publishers', 'final_page'), true);
      }
      return;
    }

    $offcats = $this->Home_model->get_data('cpalead_offercat', ['show' => 1]);
    $countries = $this->Home_model->get_data('country', ['show' => 1]);
    $offer_types = $this->Home_model->get_data('offertype', ['show' => 1]);
    $left_title = $this->Home_model->get_one('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_LEFT]);
    $right_title = $this->Home_model->get_one('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_RIGHT]);
    list($left_banners, $right_banners) = $this->get_banners();

    $content = $this->load->view('advertiser/publishers/list', compact('publishers', 'advertiser', 'final_page', 'offcats', 'countries', 'offer_types', 'left_banners', 'right_banners', 'left_title', 'right_title'), true);
    return $this->load->view('advertiser/default/vindex', compact('content', 'advertiser'));
  }

  public function ajax_search_publisher()
  {
    if (!$this->input->is_ajax_request())
      throw new Exception('Method does not supported');

    $name = $this->input->get('name');
    $value = $this->input->get('value');

    $sorting_by = [
      'sort-by-id',
      'sort-by-rating',
      'sort-by-level',
      'sort-by-epc',
      'sort-by-cr',
    ];

    foreach ($sorting_by as $sort) {
      $this->session->unset_userdata($sort);
    }

    if ($name == 'offer_types' && !is_array($value) && $value) {
      $value = [$value];
    }

    $this->session->set_userdata($name, $value);
  }

  public function invite_publishers()
  {
    $publisher_id = $this->input->post('publisher_id');
    $products = $this->input->post('products');
    $invitation_message = $this->input->post('invitation_message');

    foreach ($products as $product) {
      $this->Advertiser_model->invite_publisher($product, $this->session->userdata('user')->id, $publisher_id, $invitation_message);
      /** Send notification when inviting publisher */
      (new Notification_Request_Offer($publisher_id, $product))->notify_adv_invite();
    }
    return redirect($_SERVER['HTTP_REFERER']);
  }

  public function rating_publishers()
  {
    if ($this->is_method_post() && $this->input->is_ajax_request()) {
      $publisher_id = $this->input->post('publisher_id');
      $advertiser_id = $this->session->userdata('user')->id;
      $rating = $this->input->post('rating');
      echo $this->Advertiser_model->rating_publisher($rating, $advertiser_id, $publisher_id);
      return;
    }

    throw new Exception('Method does not support');
  }
}
