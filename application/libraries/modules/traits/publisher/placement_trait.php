<?php

require_once APPPATH . 'libraries/observer/classes/notification_request_offer.php';

trait Publisher_Placement_Trait
{
  public function placements()
  {
    $content = $this->load->view('placements/publisher/index', [], true);
    $this->load->view('default/vindex', compact('content'));
  }

  public function send_request() { throw new Exception('You dont have permissions'); }

  /** With Publisher Role that has only one status is Submitted */
  public function update_placements()
  {
    $id = $this->input->post('id');
    $status = 'Submitted';
    $note = $this->input->post('note');

    $this->db->trans_start();

    $this->db->where('id', $id);
    $this->db->update('placements', compact('status'));
    $this->db->insert('placement_details', ['placement_id' => $id, 'note' => $note]);

    if (!($this->db->affected_rows() >= 1)) {
      $this->db->trans_rollback();
      return;
    }

    $this->db->trans_complete();

    $placement = $this->Home_model->get_one('placements', ['id' => $id]);
    (new Notification_Request_Offer($placement->publisher_id, $placement->offer_id))->notify_pub_submitted_placement($id);

    echo $this->db->affected_rows();
  }
}
