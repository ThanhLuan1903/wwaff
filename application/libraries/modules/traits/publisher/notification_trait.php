<?php

trait Publisher_Notification_Trait
{
  public function notification_center()
  {

    $left_title = $this->Custom_model->find_by_type(ThemeService::TITLE_BANNER_LEFT);
    $right_title = $this->Custom_model->find_by_type(ThemeService::TITLE_BANNER_RIGHT);
    $banners = $this->get_banners();
    $left_banners = $banners['left'];
    $right_banners = $banners['right'];
    $notifications = $this->Home_model->get_data('notifications', [
      'receiver' => $this->member->id,
      'is_adv' => 0,
    ], null, ['id','desc']);

    $content = $this->load->view('notifications/publisher/index', compact('left_title', 'right_title', 'left_banners', 'right_banners', 'notifications'), true);
    $this->load->view('default/vindex', compact('content'));
  }

  public function mark_as_read()
  {
    $id = $this->input->post('id');

    $this->db->where('id', $id);
    $this->db->update('notifications', ['mark_as_read' => 1]);
    echo $this->db->affected_rows();
  }
}
