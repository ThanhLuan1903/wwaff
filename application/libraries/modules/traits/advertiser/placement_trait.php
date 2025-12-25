<?php
require_once APPPATH . 'libraries/observer/classes/notification_request_offer.php';

trait Advertiser_Placement_Trait
{

  public function placements()
  {
    $placements = $this->db->query("
    SELECT cpalead_offer.*, 
      cpalead_request.id as request_id, 
      cpalead_request.offerid as offer_id,
      cpalead_request.userid,
      cpalead_request.status, 
      cpalead_request.ip, 
      cpalead_request.date,
      cpalead_request.updated_at as request_updated_at,
      cpalead_request.show as request_show,
      cpalead_request.traffic_source,
      cpalead_users.username,
      cpalead_users.mailling,
      cpalead_users_dashboard.*
    FROM cpalead_offer
    INNER JOIN cpalead_request ON cpalead_request.offerid = cpalead_offer.id
    INNER JOIN cpalead_users on cpalead_users.id = cpalead_request.userid
    LEFT JOIN cpalead_users_dashboard on cpalead_users_dashboard.user_id = cpalead_users.id
    WHERE cpalead_request.status = 'Approved' AND cpalead_offer.is_adv = {$this->session->userdata('user')->id}
    ORDER BY cpalead_request.updated_at DESC
  ")->result();

    $content = $this->load->view('placements/advertiser/index', compact('placements'), true);
    $this->load->view('advertiser/default/vindex', compact('content'));
  }

  public function send_request()
  {
    $publisher_id = $this->input->post('publisher_id');
    $advertiser_id = $this->session->userdata('user')->id;
    $request_id = $this->input->post('request_id');
    $offer_id = $this->input->post('offer_id');
    $placement_id = $this->input->post('placement_id');
    $re_request = $this->input->post('re_request');

    if ($placement_id) {
      $this->db->where('id', $placement_id);
      $this->db->update('placements', ['status' => 'Requested']);
    } else {
      $this->db->trans_start();
      $this->db->insert('placements', compact('publisher_id','advertiser_id','request_id','offer_id'));
      $placement_id = $this->db->insert_id();
      if (!$placement_id) {
        $this->db->trans_rollback();
        return;
      }
      $this->db->trans_complete();
    }
    if ($re_request) {
      (new Notification_Request_Offer($publisher_id, $offer_id))->notify_adv_request_placement_again($placement_id);
    } else {
      (new Notification_Request_Offer($publisher_id, $offer_id))->notify_adv_request_placement($placement_id);
    }
    echo 'Notification have been sent';
  }

  /** With Advertiser Role that has only one status is Checked */
  public function update_placements()
  {
    $id = $this->input->post('id');
    $status = 'Checked';
    $this->db->where('id', $id);
    $this->db->update('placements', compact('status', 'note'));

    echo $this->db->affected_rows();
  }
}
