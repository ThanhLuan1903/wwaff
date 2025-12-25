<?php

 if (!defined('BASEPATH')) exit('No direct script access allowed');

class Custom_sale_rewards extends CI_Controller
{
  //admin
  public $pub_config = '';

  function __construct()
  {
    parent::__construct();

    $this->authenticated();

    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->model('Home_model');
    $this->load->model('Admin_model');
    $this->load->model('Custom_model');
  }

  private function authenticated()
  {
    $this->base_key = $this->config->item('base_key');

    if (!$this->session->userdata('adlogedin')) {
      redirect('ad_user');
      $this->inic->sysm();
      exit();
    } else {
      $this->session->set_userdata('upanh', 1);
    }
    $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
    $this->db->trans_strict(FALSE);
  }

  private function set_validation_rules($isUpdate) {
    if ($isUpdate) {
      $this->form_validation->set_rules('username', 'Email', 'required');
      $this->form_validation->set_rules('amount', 'Amount', 'required');
    } else {
      $this->form_validation->set_rules('username', 'Email', 'required|is_unique[custom_sale_rewards.username]');
      $this->form_validation->set_rules('amount', 'Amount', 'required');
    }
  }

  public function view()
  {
    $users = $this->Admin_model->get_data('custom_sale_rewards', ['type' => 1], ['0' => 'amount', '1' => 'ASC']);
    $rewards = $this->Admin_model->get_data('custom_sale_rewards', ['type' => 2], ['0' => 'amount', '1' => 'ASC']);
    $content = $this->load->view('admin/content/sale_rewards/view', compact('users', 'rewards'), true);
    $this->load->view('admin/index', compact('content'));
  }

  /** 
   * Method: GET
   * Return html form
   */
  public function edit($id = null)
  {
    $type = 1;
    $user = $this->Admin_model->get_one('custom_sale_rewards', compact('id'));
    $content = $this->load->view('admin/content/sale_rewards/form', compact('user', 'type'), true);
    $this->load->view('admin/index', compact('content'));
  }

  public function reward($id = null)
  {
    $type = 2;
    $user = $this->Admin_model->get_one('custom_sale_rewards', compact('id'));
    $content = $this->load->view('admin/content/sale_rewards/form', compact('user', 'type'), true);
    return $this->load->view('admin/index', compact('content'));
  }
  
  /** 
   * Method: POST 
   * Update records
   * 
  */
  public function update($id = null)
  {
    if (!$this->input->post())
      throw new Exception('Method is not allowed');

    $this->set_validation_rules(!empty($id));
      
    if (!$this->form_validation->run()) 
      return $this->view();
    
    if ($id && $this->db->update('custom_sale_rewards', $_POST, ['id' => $id]))
      $this->session->set_flashdata('success', 'Updated successfully');
    
    /** Default is insert */
    if ($this->db->insert('custom_sale_rewards', $_POST))
      $this->session->set_flashdata('success', 'Category created successfully');
    
    return redirect(base_url(). 'admin/custom_sale_rewards/view');
  }

  public function delete($id)
  {
    $this->Admin_model->xoa('custom_sale_rewards', compact('id'));
    $this->session->set_flashdata('success', 'Deleted successfully');
    return redirect(base_url(). 'admin/custom_sale_rewards/view');
  }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */