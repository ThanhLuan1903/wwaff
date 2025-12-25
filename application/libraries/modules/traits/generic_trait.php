<?php

trait GenericTrait
{
  public function get_account_fields()
  {
    if ($this->table == 'users') {
      return 'id, email, username, status, balance, manager';
    }
    return 'id, email, username, status, avatar_url, manager';
  }

  public function get_user_by_email($email)
  {
    $this->db->select($this->get_account_fields() . ', password');
    $this->db->where('email', $email);
    $query = $this->db->get($this->table);
    return $query ? $query->row() : false;
  }

  public function login($username, $password)
  {
    $user = $this->get_user_by_email($username);
    if (!$user) {
      return ['error' => 'not_found'];
    }
    if ($user->password !== $password) {
      return ['error' => 'wrong_password'];
    }
    unset($user->password);
    return ['user' => $user];
  }

  public function get_user($user_id)
  {
    $this->db->select($this->get_account_fields());
    $this->db->where('id', $user_id);
    $query = $this->db->get($this->table);
    return $query ? $query->row() : false;
  }
}
