<?php
require_once APPPATH . 'libraries/modules/module.php';

class Placements extends CI_Controller
{
  public $route;
  public $master_view;

  public function __construct()
  {
    parent::__construct();
    $this->route = new Module();
    $this->load->model('Home_model');

    if ($this->session->userdata('role') == 2) {
      $this->master_view = 'advertiser/default/vindex';
    } else {
      $this->master_view = 'default/vindex';

      if ($this->session->userdata('logedin')) {
        $this->member = $this->Home_model->get_one('users', array('id' => $this->session->userdata('userid')));
        $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
      }
    }
  }

  public function index()
  {
    return $this->route->placements();
  }

  public function send_request()
  {
    return $this->route->send_request();
  }

  public function update()
  {
    return $this->route->update_placements();
  }

  /**
   * Share View for Adv and Pub
   */
  public function show($id)
  {
    $additional = "";

    // If Logged session is publisher, Placements should be displayed by that Publisher
    if ($this->session->userdata('role') == 1) {
      $additional = " AND cpalead_placements.publisher_id = {$this->member->id}";
    }

    $query = "SELECT cpalead_placements.*, cpalead_offer.title,  cpalead_users.username, cpalead_offer.id as offer_id, cpalead_request.traffic_source
    FROM cpalead_placements
    INNER JOIN cpalead_offer on cpalead_placements.offer_id = cpalead_offer.id
    INNER JOIN cpalead_users on cpalead_placements.publisher_id = cpalead_users.id
    INNER JOIN cpalead_request on cpalead_request.id = cpalead_placements.request_id
    WHERE cpalead_placements.id = ? $additional
    ";

    $placement = $this->db->query($query, [$id, $additional])->row();
    $placement_details = $this->Home_model->get_data('placement_details', ['placement_id' => $id], null, ['id', 'desc']);

    if (!$placement) {
      echo "You don't have permissions";
      return;
    }

    $content = $this->load->view('placements/placement_detail', compact('placement', 'placement_details'), true);
    $this->load->view($this->master_view, compact('content'));
  }
}
