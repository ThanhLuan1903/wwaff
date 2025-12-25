<?php

abstract class BaseService extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Admin_model');
    $this->load->model('Custom_model');
  }

  abstract function update($type, $content);
  abstract function delete($type);
}