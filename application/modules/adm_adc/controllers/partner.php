<?php

class Partner extends CI_Controller
{

  private $base_url = '/admin/partner/type?';
  private $total_rows = 100;
  private $per_page = 10;
  private $pagina_uri_seg = 4;

  public function __construct()
  {
    parent::__construct();
    $this->authenticated();
    $this->load->model('Partner_model');
    $this->load->library('Pagination');
    $this->load->library('form_validation');
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

  private function handlePagination()
  {
    $config['base_url'] = $this->base_url;
    $config['total_rows'] = $this->total_rows;
    $config['per_page'] = $this->per_page;
    $config['uri_segment'] = $this->pagina_uri_seg;
    $config['page_query_string'] = TRUE;
    $config['use_page_numbers'] = TRUE;
    $config['query_string_segment'] = 'page';
    $config['num_links'] = 7;
    $config['first_link'] = '<<';
    $config['first_tag_open'] = '<li class="firt_page">'; //div cho chu <<
    $config['first_tag_close'] = '</li>'; //div cho chu <<
    $config['last_link'] = '>>';
    $config['last_tag_open'] = '<li class="last_page">';
    $config['last_tag_close'] = '</li>';
    //-------next-
    $config['next_link'] = 'next &gt;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    //------------preview
    $config['prev_link'] = '&lt; prev';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    // ------------------cu?npage
    $config['cur_tag_open'] = '<li class="active"><a href=#>';
    $config['cur_tag_close'] = '</a></li>';
    //--so 
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    //-----
    $this->pagination->initialize($config);
  }

  public function index()
  {
    $data = [
      'partners' => $this->Partner_model->get_list_partner($this->input->get('page') ?: 1, $this->per_page)
    ];
    $this->total_rows = $this->Partner_model->count_list_partner();
    $this->base_url = base_url() . '/admin/partner/?';
    $this->handlePagination();
    $content = $this->load->view('partner/index', $data, true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function store($id = null)
  {
    $this->update_partner($id);
    $this->insert_partner();

    $data = [
      'partner_types' => $this->Partner_model->get_all_partner_type(),
      'partner' => $this->Partner_model->find_partner_by_id($id)
    ];
    $content = $this->load->view('partner/form', $data, true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function type()
  {
    $data = [
      'types' => $this->Partner_model->get_list_type($this->input->get('page') ?: 1, $this->per_page)
    ];
    $this->total_rows = $this->Partner_model->count_list_type();
    $this->base_url = base_url() . '/admin/partner/type?';
    $this->handlePagination();
    $content = $this->load->view('partner/type/index', $data, true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function edit_type($id = null)
  {
    $this->update_partner_type($id);
    $this->insert_partner_type();
    $type = $this->Partner_model->find_type_by_id($id);
    $content = $this->load->view('partner/type/form', compact('type'), true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function delete($model, $id)
  {
    if ($model == 'type') {
      $this->Partner_model->delete_type($id);
    } else {
      $this->Partner_model->delete_partner($id);
    }

    $this->session->set_flashdata('success', 'Deleted successfully');
    return redirect($_SERVER['HTTP_REFERER']);
  }

  private function insert_partner_type()
  {
    if (!$this->input->post())
      return;

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('status', 'Show', 'required|boolean');

    if ($this->form_validation->run()) {
      $this->Partner_model->insert_partner_type($this->input->post());
      $this->session->set_flashdata('success', 'Created successfully');
    } else {
      $this->session->set_flashdata('error', validation_errors());
    }

    return redirect('admin/partner/type');
  }

  private function update_partner_type($id)
  {
    if ($this->input->server('REQUEST_METHOD') !== 'POST' || empty($id))
      return;

    if ($this->Partner_model->update_partner_type($id, $this->input->post())) {
      $this->session->set_flashdata('success', 'Updated successfully');
    } else {
      $this->session->set_flashdata('error', 'Update Errors');
    }

    return redirect('admin/partner/type');
  }

  private function insert_partner()
  {
    if (!$this->input->post())
      return;

    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('logo', 'Logo', 'required');
    $this->form_validation->set_rules('partner_type_id', 'Partner Type', 'required');
    $this->form_validation->set_rules('link_profile', 'Website', 'required');
    $this->form_validation->set_rules('show', 'Show', 'required|boolean');

    if ($this->form_validation->run()) {
      $this->Partner_model->insert_partner($this->input->post()); 
      $this->session->set_flashdata('success', 'Created successfully');
    } else {
      $this->session->set_flashdata('error', validation_errors());
    }
    return redirect('admin/partner');
  }

  private function update_partner($id)
  {
    if ($this->input->server('REQUEST_METHOD') !== 'POST' || empty($id))
      return;

    if ($this->Partner_model->update_partner($id, $this->input->post())) {
      $this->session->set_flashdata('success', 'Updated successfully');
    } else {
      $this->session->set_flashdata('error', 'Update Errors');
    }

    return redirect('admin/partner');
  }
}
