<?php
require_once APPPATH . 'libraries/observer/classes/notification_request_offer.php';

trait Advertiser_Management_Trait
{

  public function my_publishers()
  {
    list($my_publishers, $total) = $this->Advertiser_model->list_my_publishers();
    $left_title = $this->Home_model->get_data('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_LEFT]);
    $right_title = $this->Home_model->get_data('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_RIGHT]);
    list($left_banners, $right_banners) = $this->get_banners();
    $content = $this->load->view('advertiser/publishers/my_publishers', compact('my_publishers', 'left_title', 'right_title', 'left_banners', 'right_banners'), true);
    $this->load->view('advertiser/default/vindex', compact('content', 'advertiser'));
  }

  public function invited_publishers()
  {
    list($invited_publishers, $total) = $this->Advertiser_model->list_invited_publishers();
    $left_title = $this->Home_model->get_data('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_LEFT]);
    $right_title = $this->Home_model->get_data('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_RIGHT]);
    list($left_banners, $right_banners) = $this->get_banners();
    $content = $this->load->view('advertiser/publishers/invited_publishers', compact('invited_publishers', 'left_title', 'right_title', 'left_banners', 'right_banners'), true);
    $this->load->view('advertiser/default/vindex', compact('content', 'advertiser'));

  }

  public function update_my_publisher()
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    if (!$this->input->is_ajax_request() || !$is_post_method) {
      throw new Error("Method is not allowed");
    }

    $data = $this->input->post();
    unset($data['request_id']);
    $request_id = $this->input->post('request_id');
    $this->db->where(['id' => $request_id]);
    $this->db->update('cpalead_request', $data);
    $request = $this->Admin_model->get_one('cpalead_request', ['id' => $request_id]);

    if (is_numeric($this->input->post('show'))) {
      $is_show = $this->input->post('show');
      $offer = $this->Admin_model->get_one('offer', ['id' => $request->offerid]);

      if ($is_show == 0) {
        $dis_offer = $this->Admin_model->get_one('cpalead_disoffer', ['offerid' => $request->offerid, 'usersid' => $request->userid]);

        if ($dis_offer) return;

        $this->db->insert('cpalead_disoffer', ['offerid' => $request->offerid, 'usersid' => $request->userid, 'offername' => $offer->title, 'email' => $request->userid]);
        return;
      } else {
        $this->db->delete('cpalead_disoffer', ['offerid' => $request->offerid, 'usersid' => $request->userid]);
      }
    }

    /** Send notification when changing apply request status */
    $status = $this->input->post('status');
    if ($status) {
      if ($status == 'Approved') {
        (new Notification_Request_Offer($request->userid, $request->offerid))->notify_adv_accept();
      } elseif ($status == 'Deny') {
        (new Notification_Request_Offer($request->userid, $request->offerid))->notify_adv_denied();
      } elseif ($status == 'Pending') {
        (new Notification_Request_Offer($request->userid, $request->offerid))->notify_adv_pending();
      }
    }

    return $this->db->affected_rows() > 0;
  }
}
