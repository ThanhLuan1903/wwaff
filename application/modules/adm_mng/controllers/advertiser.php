<?php if (!defined('BASEPATH'))
  exit('No direct script access allowed');

require_once APPPATH . 'libraries/observer/classes/notification_payment.php';

class Advertiser extends CI_Controller
{
  public $pub_config = '';
  private $base_url_trang = '#';
  private $total_rows = 0;
  private $per_page = 10;
  private $uri_segment = 5;
  private $from = 0;

  function __construct()
  {
    parent::__construct();
    $this->authenticated();
    $this->load->model('Home_model');
    $this->load->model('Advertiser_model');
    $this->load->model('Request_Product_model');
    $this->load->helper(array('date_helper'));
    $this->load->model('Builder_model');
    $this->load->model('Adv_invoice_model');
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

  private function handlePagnination()
  {
    $this->load->library('pagination');
    if ($this->base_url_trang == '#') {
      $config['base_url'] = base_url() . $this->config->item('manager') . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/?';
    } else {
      $config['base_url'] = $this->base_url_trang;
    }

    $config['total_rows'] = $this->total_rows;
    $config['per_page'] = $this->per_page;
    $config['uri_segment'] = $this->uri_segment - 1;
    $config['num_links'] = 7;
    $config['first_link'] = '<<';
    $config['first_tag_open'] = '<li class="firt_page">';
    $config['first_tag_close'] = '</li>';
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
    $config['query_string_segment'] = 'page';

    //-----
    $this->pagination->initialize($config);
  }

  function pagination_with_path()
  {
    $this->load->library('pagination');

    $config['base_url'] = base_url() . $this->config->item('manager') . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/';
    $config['total_rows'] = $this->total_rows;
    $config['per_page'] = $this->per_page;
    $config['uri_segment'] = $this->uri_segment - 1;
    $config['num_links'] = 7;
    $config['first_link'] = '<<';
    $config['first_tag_open'] = '<li class="firt_page">';
    $config['first_tag_close'] = '</li>';
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
    $config['use_page_numbers'] = true;

    //-----
    $this->pagination->initialize($config);
  }

  function list_account($offset = 0)
  {
    $orders = ['balance', 'available', 'holding'];
    $where = '';
    if (!in_array($this->session->userdata('sort'), $orders)) {
      $this->session->set_userdata('sort', 'cpalead_advertiser.id');
      $this->session->set_userdata('order', 'DESC');
    }

    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';

    if ($is_post_method) {
      $this->session->set_userdata('sort', $this->input->post('sort'));
      $this->session->set_userdata('order', $this->input->post('order'));
      $this->session->set_userdata('keycode', $this->input->post('keycode'));
    }

    if ($this->session->userdata('keycode')) {
      $keycode = $this->session->userdata('keycode');
      if (is_numeric($keycode)) {
        $where = "WHERE cpalead_advertiser.id = $keycode ";
      } else {
        $where = "WHERE cpalead_advertiser.email like '%$keycode%' ";
      }
    }

    list($result, $total) = $this->Builder_model
      ->select("SELECT cpalead_advertiser.*, 
          cpalead_advertiser_dashboard.available, cpalead_advertiser_dashboard.holding as hold, cpalead_advertiser_dashboard.balance, cpalead_advertiser_dashboard.pending,
          cpalead_advertiser_dashboard.updated_at as updated_at
      ")
      ->query_from("
        FROM cpalead_advertiser 
        LEFT JOIN cpalead_advertiser_dashboard on cpalead_advertiser_dashboard.advertiser_id = cpalead_advertiser.id
        INNER JOIN cpalead_manager on cpalead_manager.id = cpalead_advertiser.manager
        $where
      ")
      ->pagination($offset, $this->per_page);

    $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/');
    $this->total_rows = $total;
    $this->handlePagnination();
    $home_link = base_url($this->uri->segment(1));
    $breadcrumb = '<li><a href="' . $home_link . '">Home</a></li><li><a href="javascript:void(0)">List Advertiser</a></li>';
    $from = $this->total_rows ? $this->per_page + $offset : 0;
    $to = $this->per_page * $offset > $this->total_rows ? $this->total_rows : $from + $this->per_page;
    $content = $this->load->view("advertiser_management/list.php", array('data' => $result, 'from' => $from, 'to' => $to), true);
    return $this->load->view('manager/index', array('content' => $content, 'breadcrumb' => $breadcrumb));
  }

  function update_status()
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';

    if ($is_post_method && $_POST) {
      $id = $this->input->post('id');
      $status = $this->input->post('status');
      if (!$this->Advertiser_model->update_status($id, $status))
        throw new Exception('Can not update user status');

      echo $status;
    }
  }

  function list_payments($page = 1)
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    $status = $this->input->post('status');
    $date = $this->input->post('date');
    $adv_id = $this->input->post('keycode');

    $start_offset = ($page - 1) * $this->per_page;
    list($payments, $total) = $this->Advertiser_model->get_payments(compact('status', 'date', 'adv_id'), $start_offset, $this->per_page);
    $this->total_rows = $total;
    $from = $this->total_rows ? $this->per_page * ($start_offset) : 0;
    $to = ($this->per_page * $start_offset >= $this->total_rows) || $page == 1 ? $this->total_rows : $this->per_page * $start_offset;
    $this->pagination_with_path();

    $content = $this->load->view('advertiser_management/payments.php', compact('payments', 'from', 'to'), true);
    $this->load->view('manager/index', array('content' => $content));
  }

  function list_request_products($offset = 1)
  {
    $result = $this->Request_Product_model->getAllAdvProduct($this->per_page, $offset);
    $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/');
    $this->total_rows = $result['total_rows'];
    $this->handlePagnination();
    $home_link = base_url($this->uri->segment(1));
    $breadcrumb = '<li><a href="' . $home_link . '">Home</a></li><li><a href="javascript:void(0)">Request Product</a></li>';
    $from = $this->total_rows ? $this->per_page * ($offset - 1) + 1 : 0;
    $to = $this->per_page * $offset > $this->total_rows ? $this->total_rows : $this->per_page * $offset;
    $content = $this->load->view("advertiser_management/list_request.php", array('data' => $result['data'], 'from' => $from, 'to' => $to), true);
    return $this->load->view('manager/index', array('content' => $content, 'breadcrumb' => $breadcrumb));
  }

  function update_request_product($id)
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';

    if ($is_post_method) {
      $this->Request_Product_model->update_request_product($id, $this->input->post());
      return redirect($_SERVER['HTTP_REFERER']);
    }

    $request_product = $this->Home_model->get_one('request_product', ['id' => $id]);
    echo $this->load->view("advertiser_management/list_request_form.php", compact('request_product'), true);
  }

  function delete_request_product($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('request_product');

    if ($this->db->affected_rows() > 0) {
      $this->session->set_flashdata('success', 'Deleted successfully');
    } else {
      $this->session->set_flashdata('error', 'Failed Delete Request Product');
    }

    return redirect($_SERVER['HTTP_REFERER']);
  }

  function update_status_payment()
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';

    if (!$is_post_method)
      throw new Exception("The method does not supported");

    $id = $this->input->post('id');
    $status = $this->input->post('status');

    if ($this->input->post('is_delete')) {
      echo $this->Advertiser_model->delete_payment($id);
    }

    if ($status == 'Complete') {
      (new Notification_Payment(''))->notify_payment_complete($id);
    }
    $this->db->trans_start(); 

    $this->handleInvoice();
    $result = $this->Advertiser_model->update_status_payment($id, $status);

    $this->db->trans_complete(); 
    if ($this->db->trans_status() === FALSE) {
      echo 0;
    } else {
      echo 1;
    }
  }

  function handleInvoice()
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    if ($is_post_method) {
      $id = $this->input->post('id');
      $status = $this->input->post('status');
      $dt = $this->Adv_invoice_model->getApprovedTracklink($id);
      if ($status == 'Complete') {
        if ($this->load->controller('proxy_report/updateData', [$dt, 'pay'])) {
          $this->Adv_invoice_model->updateTracklinkStatus($id, 3);
        }
      }
      if ($this->input->post('is_delete')) {
        $this->Adv_invoice_model->removeAdvpayTracklink($id);
      }

      if ($status == 'Reverse') {
        if (!empty($dt)) {
          if ($this->load->controller('proxy_report/updateData', [$dt, 'declined'])) {
            $this->Adv_invoice_model->updateTracklinkStatus($id, 2);
          }
        }
      }
    }
  }

  function list_products($page = 1)
  {
    $this->session->set_userdata('table12', 'offer');
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';

    $where = '';
    if ($is_post_method) {
      $key = $this->input->post('key');
      $cats = $this->input->post('offercats');

      if ($cats) {
        $where .= "AND offercat = 'o" . join('o', $cats) . "o'";
      }

      if ($key) {
        $where .= " AND (cpalead_offer.id = '$key' OR cpalead_offer.title like '%$key%')";
      }
    }

    $per_page = 10;
    $start_offset = ($page - 1) * $per_page;
    $offercats = $this->Home_model->get_data('offercat', '`show` = 1');
    list($products, $total) = $this->Advertiser_model->get_products($start_offset, $per_page, $where);

    $this->total_rows = $total;
    $from = $this->total_rows ? $this->per_page * ($start_offset) : 0;
    $to = ($this->per_page * $start_offset >= $this->total_rows) || $page == 1 ? $this->total_rows : $this->per_page * $start_offset;
    $this->pagination_with_path();

    $content = $this->load->view('advertiser_management/products.php', compact('products', 'offercats'), true);
    $this->load->view('manager/index', array('content' => $content));
  }

  public function show_advertiser($id)
  {
    $advertiser = $this->Home_model->get_one('advertiser', ['id' => $id]);
    $this->load->view('advertiser_management/advertiser_info', compact('advertiser'));
  }

  public function add_new_advertiser()
  {
    $is_get_method = $this->input->server('REQUEST_METHOD') === 'GET';

    if ($is_get_method) {
      $content = $this->load->view('advertiser_management/form_adv', [], true);
      $this->load->view('manager/index', array('content' => $content));
      return;
    }

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_check_email');

    if ($this->form_validation->run() && $this->Advertiser_model->add_new_advertiser($this->input->post())) {
      $this->session->set_flashdata('success', 'Inserted successfully');
    } else {
      $this->session->set_flashdata('error', 'Failed Insert');
    }
    return redirect(base_url(config_item('manager') . '/advertiser/list_account'));
  }

  public function update_advertiser($id)
  {
    $is_get_method = $this->input->server('REQUEST_METHOD') === 'GET';

    if ($is_get_method) {
      $advertiser = $this->Admin_model->get_one('advertiser', ['id' => $id]);
      $content = $this->load->view('advertiser_management/form_adv.php', compact('advertiser'), true);
      $this->load->view('manager/index', array('content' => $content));
      return;
    }

    if ($this->Advertiser_model->update_advertiser($id, $this->input->post())) {
      $this->session->set_flashdata('success', 'Updated successfully');
    } else {
      $this->session->set_flashdata('error', 'Failed Update');
    }

    return redirect(base_url(config_item('manager') . '/advertiser/list_account'));
  }

  function check_email($email)
  {
    if ($this->Home_model->get_one('advertiser', array('email' => $email))) {
      $this->form_validation->set_message('check_email', 'Email already exists!');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function update_status_product()
  {
    if (!($this->input->server('REQUEST_METHOD') === 'POST') || !$this->input->is_ajax_request()) {
      throw new Exception('Method does not supported');
    }

    $offer_id = $this->input->post('offer_id');
    $status = $this->input->post('action');
    $editor = $this->input->post('role');

    $isExists = $this->db->get_where('advertiser_offer_status', ['offer_id' => $offer_id]);

    if ($isExists->num_rows() > 0) {
      $this->db->where('offer_id', $offer_id);
      $this->db->update('advertiser_offer_status', ['status' => $status, 'editor' => $editor]);
    } else {
      $this->db->insert('advertiser_offer_status', ['offer_id' => $offer_id, 'status' => $status, 'editor' => $editor]);
    }

    echo $this->db->affected_rows() > 0;
  }

  public function invoice($adv_id)
  {
    $invoices = $this->Home_model->get_data('advertiser_payment', ['adv_id' => $adv_id]);
    $this->load->view('advertiser_management/invoice', compact('invoices'));
  }

  public function get_invoice_details()
  {
    $invoiceId = $this->input->get('id');

    $invoice = $this->db->get_where('advertiser_payment', ['id' => $invoiceId])->row();

    $this->db->select('offerid, oname, SUM(amount3) as total_amount');
    $this->db->where('adv_pay', $invoiceId);
    $this->db->group_by('offerid');
    $clicks = $this->db->get('cpalead_tracklink')->result();

    $html = '<h4>Invoice Information</h4>';
    $html .= '<p><strong>ID:</strong> ' . $invoice->id . '</p>';
    $html .= '<p><strong>Amount:</strong> ' . $invoice->amount . '</p>';
    $html .= '<p><strong>Method:</strong> ' . $invoice->method . '</p>';
    $html .= '<p><strong>Date:</strong> ' . $invoice->date . '</p>';
    if (!empty($invoice->image_path)) {
      $html .= '<p><strong>Payment Proof:</strong><br><img src="' . base_url($invoice->image_path) . '" alt="Payment Proof" style="max-width: 100%;"></p>';
    }

    $html .= '<h4>Offers Details</h4>';
    $html .= '<table class="table table-bordered">';
    $html .= '<thead><tr><th>Offer ID</th><th>Offer Name</th><th>Amount</th></tr></thead>';
    $html .= '<tbody>';
    foreach ($clicks as $click) {
      $html .= '<tr>';
      $html .= '<td>' . $click->offerid . '</td>';
      $html .= '<td>' . $click->oname . '</td>';
      $html .= '<td>' . $click->total_amount . '</td>';
      $html .= '</tr>';
    }
    $html .= '</tbody></table>';

    echo $html;
  }
}
