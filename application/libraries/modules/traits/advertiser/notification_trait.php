<?php

trait Advertiser_Notifications_Trait
{
  public function notification_center()
  {
    $left_title = $this->Home_model->get_data('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_LEFT]);
    $right_title = $this->Home_model->get_data('custom_features', ['type' => ThemeService::TITLE_PUBLISHER_RIGHT]);
    list($left_banners, $right_banners) = $this->get_banners();
    $notifications = $this->Home_model->get_data('notifications', [
      'receiver' => $this->session->userdata('user')->id,
      'is_adv' => 1,
    ], null, ['id', 'desc']);

    $content = $this->load->view('notifications/advertiser/index', compact('left_title', 'right_title', 'left_banners', 'right_banners', 'notifications'), true);
    $this->load->view('advertiser/default/vindex', compact('content'));
  }

  public function mark_as_read()
  {
    $id = $this->input->post('id');

    $this->db->where('id', $id);
    $this->db->update('notifications', ['mark_as_read' => 1]);
    echo $this->db->affected_rows();
  }
}
