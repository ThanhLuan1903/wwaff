<?php


class Partner_model extends CI_Model
{

  public $type_table = 'partner_types';
  public $partner_table = 'partners';

  public function __construct()
  {
    parent::__construct();
  }

  public function count_list_type()
  {
    return $this->db->get($this->type_table)->num_rows();
  }

  public function count_list_partner()
  {
    return $this->db->get($this->partner_table)->num_rows();
  }

  public function get_all_partner_type()
  {
    $results = $this->db->get($this->type_table);
    return $results ? $results->result() : null;
  }

  public function get_list_partner($page = 1, $per_page)
  {
    $results = $this->db->join('partner_types', 'partner_types.id = partners.partner_type_id', 'left')
    ->select('partners.*, partner_types.title as partner_type')
    ->limit($per_page)->offset(($page - 1) * $per_page)
    ->get($this->partner_table);

    return $results ? $results->result() : null;
  }
  
  public function get_list_type($page = 1, $per_page)
  {
    $results =  $this->db->limit($per_page)->offset(($page - 1) * $per_page)->get($this->type_table);
    return $results ? $results->result() : null;
  }

  public function find_type_by_id($id)
  {
    $result = $this->db->where(compact('id'))->get($this->type_table);
    return $result ? $result->row() : null;
  }

  public function find_partner_by_id($id)
  {
    $result = $this->db->where(compact('id'))->get($this->partner_table);
    return $result ? $result->row() : null;
  }

  public function find_partner_by_type($partner_type_id)
  {
    $results = $this->db->where(compact('partner_type_id'))->get($this->partner_table);
    return $results ? $results->result() : null;
  }

  public function insert_partner_type($data)
  {
    return $this->db->insert($this->type_table, $data);
  }

  public function update_partner_type($id, $data)
  {
    return $this->db->update($this->type_table, $data, compact('id'));
  }

  public function insert_partner($data)
  {
    // var_dump($data);die;
    return $this->db->insert($this->partner_table, $data);
  }

  public function update_partner($id, $data)
  {
    return $this->db->update($this->partner_table, $data, compact('id'));
  }

  public function delete_type($id)
  {
    $this->db->where(compact('id'));
    return $this->db->delete($this->type_table);
  }

  public function delete_partner($id)
  {
    $this->db->where(compact('id'));
    return $this->db->delete($this->partner_table);
  }
}
