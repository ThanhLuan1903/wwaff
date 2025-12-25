<?php
if (!class_exists('CustomSaleReward')) {
  require_once(APPPATH . '/modules/adm_adc/services/classes/CustomSaleReward.php');
}

class Custom_model extends CI_Model
{
  public $table = 'custom_features';

  public function __construct()
  {
    parent::__construct();
  }

  public function get_list_ranking()
  {
    return $this->db->like('type', CustomSaleReward::REWARD_RANKING, 'after')->order_by('type ASC')->get($this->table)->result();
  }

  public function get_list_by_type($type)
  {
    return $this->db->like('type', $type, 'after')->get($this->table)->result();
  }

  public function find_by_id($id)
  {
    return $this->db->where('id', $id)->get($this->table)->row();
  }

  public function find_by_type($type)
  {
    return $this->db->where('type', $type)->get($this->table)->row();
  }

  public function update($type, $content)
  {
    $this->db->set('content', $content);
    $this->db->where('type', $type);
    return $this->db->update($this->table);
  }

  public function delete($type)
  {
    $this->db->where('type', $type);
    return $this->db->delete($this->table);
  }

  public function delete_by_id($id)
  {
    $this->db->where(compact('id'));
    return $this->db->delete($this->table);
  }

  public function get_banners_by_role($is_adv = 0)
  {
    $this->db->where('is_adv', $is_adv);
    $query = $this->db->get('banners');

    return $query ? $query->result() : null;
  }
}