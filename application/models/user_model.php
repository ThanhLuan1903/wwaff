<?php

class User_model extends CI_Model
{
  public function findUserById($table, $id) {
    $this->db->where('id', $id);
    $query = $this->db->get($table);
    return $query ? $query->row() : [];
  }
}
