<?php


class Builder_model extends CI_Model
{
  public $order_string = '';
  public $select_string = '';
      public $skip_order = false;  // Thêm dòng này
  public $query_frame = "{{select_builder}} {{query_builder}} {{order_builder}}";

  public function __construct()
  {
    parent::__construct();
  }

  private function reset_frame()
  {
    $this->query_frame = "{{select_builder}} {{query_builder}} {{order_builder}}";
  }

  private function count()
  {
    $this->order();
    $count_query = str_replace("{{select_builder}}", 'SELECT COUNT(*) as count', $this->query_frame);
    return $this->db->query($count_query)->row()->count;
  }

  /**
   * The function builds Order By String automatically
   */
  public function order()
  {

    if ($this->skip_order) {
            $this->query_frame = str_replace('{{order_builder}}', $this->order_string, $this->query_frame);
            return $this;
        }
        
    if (empty($this->session->userdata('order'))) {
      $this->session->unset_userdata('sort');
      $this->session->unset_userdata('order');
    }

    if ($this->session->userdata('sort')) {
      $sort = $this->session->userdata('sort');
      $order = $this->session->userdata('order');
      $this->order_string = "ORDER BY $sort $order";
    }

    $this->query_frame = str_replace('{{order_builder}}', $this->order_string, $this->query_frame);
    return $this;
  }

  public function select($select_raw = '*')
  {
    $this->select_string = $select_raw;
    return $this;
  }

  public function query_from($raw_query)
  {
    $this->query_frame = str_replace('{{query_builder}}', $raw_query, $this->query_frame);
    return $this;
  }

  /**
   * pagination
   *
   * @param  int $limit
   * @param  int $offset
   * @return void
   */
  public function pagination($offset, $limit)
  {
    $total = $this->count();
    $this->query_frame .= "\n LIMIT $offset, $limit";
    $query_frame = str_replace("{{select_builder}}", $this->select_string, $this->query_frame);
    $this->order();
    $result = $this->db->query($query_frame)->result();
    $this->reset_frame();
    return [$result, $total];
  }

  public function get_one()
  {
    $this->order();
    $query_frame = str_replace("{{select_builder}}", $this->select_string, $this->query_frame);
    $this->reset_frame();
    return $this->db->query($query_frame)->row();
  }

  public function all()
  {
    $this->order();
    $query_frame = str_replace("{{select_builder}}", $this->select_string, $this->query_frame);
    $this->reset_frame();
    return $this->db->query($query_frame)->result();
  }
}
