<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller
{
  public $pub_config = '';
  private $base_url_trang = '#';
  private $total_rows = 0;
  private $per_page = 10;
  private $uri_segment = 5;

  function __construct()
  {
    parent::__construct();

    $this->authenticated();

    $this->load->model('Home_model');
    $this->load->model('Admin_model');
    $this->load->model("Request_Product_model");
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

  private function phantrang()
  {
    $this->load->library('pagination'); // da load ben tren
    if ($this->base_url_trang == '#') {
      $config['base_url'] = base_url() . $this->config->item('admin') . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/?';
    } else {
      $config['base_url'] = $this->base_url_trang;
    }

    $config['total_rows'] = $this->total_rows;
    $config['per_page'] = $this->per_page;
    $config['uri_segment'] = $this->uri_segment;
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
    $config['page_query_string'] = true;
    //-----
    $this->pagination->initialize($config);
  }

  public function view($view, $id = null)
  {
    switch ($view) {
      case 'add':
        return $this->load->view('admin/content/product/categories_add', null, true);
      case 'edit';
        $data = $this->Admin_model->get_one('offer_categories', array('id' => $id), null, []);
        return $this->load->view('admin/content/product/categories_edit', ['data' => $data], true);
      case 'delete':
        $this->Admin_model->xoa('offer_categories',  ['id' => $id]);
        $this->session->set_flashdata('success', 'Category deleted successfully');
      default:
        $data = $this->Admin_model->get_data('offer_categories', [], [], [$this->per_page, $_GET['per_page'] ?: 0]);
        return $this->load->view('admin/content/product/categories_list', ['data' => $data], true);
    }
  }

  private function edit()
  {
    if ($this->input->post()) {
      $id = isset($_POST['id']) ? $_POST['id'] : null;
      $check = $this->Admin_model->get_one('offer_categories', array('id' => $id));
      if (!empty($check)) {
        unset($_POST['id']);
        $this->Admin_model->update('offer_categories', $_POST, array('id' => $id));
        $this->session->set_flashdata('success', 'Category updated successfully');
      } else {
        if (!isset($_POST['title']) || empty($_POST['title'])) {
          $this->session->set_flashdata('error', 'Title must not be null');
          return;
        }

        $this->db->insert('offer_categories', $_POST);
        $this->session->set_flashdata('success', 'Category created successfully');
      }
    }
  }

  public function categories($action = null, $number = null)
  {
    $this->edit();
    $this->total_rows = $this->Home_model->get_number('offer_categories');
    $this->phantrang();
    $view = $this->view($action, $number);
    $this->load->view('admin/index', array('content' => $view));
  }

  function list_request($offset = 1)
  {
    $result = $this->Request_Product_model->getAllProduct($this->per_page, $offset);
    $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/');
    $this->total_rows = $result['total_rows'];
    $this->phantrang();
    $home_link = base_url($this->uri->segment(1));
    $breadcrumb = '<li><a href="' . $home_link . '">Home</a></li><li><a href="javascript:void(0)">Request Product</a></li>';
    $from = $this->total_rows ? $this->per_page * ($offset - 1) + 1 : 0;
    $to = $this->per_page * $offset > $this->total_rows ? $this->total_rows : $this->per_page * $offset;
    $content = $this->load->view("request_product/list.php", array('data' => $result['data'], 'from' => $from, 'to' => $to), true);
    return $this->load->view('admin/index', array('content' => $content, 'breadcrumb' => $breadcrumb));
  }

  function change_status_request($id)
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    if ($is_post_method) {
      $data = $this->security->xss_clean($_POST);
      if (in_array($data['status'], ["1", "2", "3"])) {
        $this->Request_Product_model->updateStatusRequest($id, $data['status']);
        echo json_encode(array('error' => false, 'data' => null));
        return;
      } else {
        $errors = array(
          "status" => 'value input is invalid',
        );

        echo json_encode(array('error' => true, 'data' => $errors));
        return;
      }
    } else {
      echo "Method not allow";
    }
  }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */