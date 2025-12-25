<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'libraries/observer/classes/notification_support.php';

class Help_And_Support extends CI_Controller
{
    public $pub_config = '';
    //phan trang
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
      $this->load->model("Help_And_Support_model");
      $this->load->helper(array('date_helper'));
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

    function list_request_publisher($offset = 1) {
        $result = $this ->Help_And_Support_model->getListConversation($this->per_page, $offset, null, 0);
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'); 
        $this->total_rows = $result['total_rows'];
        $this->handlePagnination();
        $home_link = base_url($this->uri->segment(1));
        $breadcrumb = '<li><a href="'.$home_link.'">Home</a></li><li><a href="javascript:void(0)">Help & Support</a></li>';
        $from = $this->total_rows ? $this->per_page * ($offset - 1) + 1 : 0;
        $to = $this->per_page * $offset > $this->total_rows ? $this->total_rows : $this->per_page * $offset;
        $content= $this->load->view("help_and_support/list.php", array('data' => $result['data'], 'from' => $from, 'to' => $to, 'is_adv' => 0), true);   
        return $this->load->view('admin/index', array('content' => $content, 'breadcrumb' => $breadcrumb));  
    }

    function list_request_advertiser($offset = 1) {
        $result = $this ->Help_And_Support_model->getListConversation($this->per_page, $offset, null, 1);
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'); 
        $this->total_rows = $result['total_rows'];
        $this->handlePagnination();
        $home_link = base_url($this->uri->segment(1));
        $breadcrumb = '<li><a href="'.$home_link.'">Home</a></li><li><a href="javascript:void(0)">Help & Support</a></li>';
        $from = $this->total_rows ? $this->per_page * ($offset - 1) + 1 : 0;
        $to = $this->per_page * $offset > $this->total_rows ? $this->total_rows : $this->per_page * $offset;
        $content= $this->load->view("help_and_support/list.php", array('data' => $result['data'], 'from' => $from, 'to' => $to, 'is_adv' => 1), true);   
        return $this->load->view('admin/index', array('content' => $content, 'breadcrumb' => $breadcrumb));  
    }

    function detail($id) {
        $info = $this ->Help_And_Support_model->getConversation($id);
        $commment  = $this ->Help_And_Support_model->getListComment($this->per_page, 1, $id);
        $home_link = base_url($this->uri->segment(1));
        $list_link = $home_link.'/help_and_support/list_request';
        $breadcrumb = '<li><a href="'.$home_link.'">Home</a></li><li><a href="'.$list_link.'">Help & Support</a></li><li><a href="javascript:void(0)">Detail</a></li>';
        $content = $this->load->view('help_and_support/detail.php', array('data'=> $info, 'comments' => $commment['data'], 'totalComment' => $info->total_comment, 'perPage' => $this->per_page, 'email' => $this->session->userdata('ademail')), true); 
        return $this->load->view('admin/index', array('content' => $content, 'breadcrumb' => $breadcrumb));  
    }

    function reply($id) {
        $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST'; 
        if($is_post_method) {
            $this->form_validation->set_rules('content', 'Comment', 'trim|required|max_length[2000]|xss_clean'); 
            $data =$this->security->xss_clean($_POST); 
            if($this->form_validation->run() == TRUE) {
                $parent = $this->Help_And_Support_model->getParent($id);

                $this->Help_And_Support_model->add([
                    "email" => $this->session->userdata('ademail'),
                    "content" => $data['content'],
                    "manager_id" => $this->session->userdata('aduserid'),
                    "parent_id" => $id,
                    "created_at" => date('Y-m-d H:i:s',time()),
                    "updated_at" => date('Y-m-d H:i:s',time()),
                ]);
                $this->Help_And_Support_model->updateTotalComment($id);
                echo json_encode(array('error'=> false,'data'=> null));

                /** Notificaiton when replying */
                $short_description = "Dear {$parent->name} you got a new mesenger from manager.";
                (new Notification_Support($this->session->userdata('aduserid'), $parent->user_id, $short_description, $data['content'], $parent->is_adv, $id))->notify();
                return;
            } else {
                $errors = array( 
                    "content" => form_error('content'),
                ); 
       
                echo json_encode(array('error'=> true,'data'=> $errors));
                return;
            }
        } else {
            echo "Method not allow";
        }
    }
}

?>