<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Help_and_support extends CI_Controller {
    private $content=''; 
    //pagination
    private $base_url_trang = '';
    private $per_page = 30;
    private $pagina_uri_seg = 4;
    private $is_adv = 0;
    ///

    function  __construct() {
        parent::__construct();
        $this->load_helpers();
        $this->pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        if($this->session->userdata('logedin')){
            $this->member = $this->Home_model->get_one('users',array('id'=>$this->session->userdata('userid')));
           $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
            $this->is_adv = $this->session->userdata('role') == 2 ? 1 : 0;
        }elseif($this->uri->segment(3)!='in'&&$this->uri->segment(3)!='up'){
            redirect('v2/sign/in');            
        }
    }

    function load_helpers(){
        $this->load->helper(array( 'alias_helper','text','form', 'date_helper'));
        $this->load->model("Help_And_Support_model");        
    }

    private function handlePagination($total){
        $this->load->library('pagination');
        $config['base_url'] =$this->base_url_trang;
        $config['total_rows'] = $total;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->pagina_uri_seg;
        $config['num_links'] = 7;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_page">';//div cho chu <<
        $config['first_tag_close'] = '</li>';//div cho chu <<
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

        $this->pagination->initialize($config);
    
    }

    function index($offset = 1) {
        $user = $this->session->userdata('user');
        $result = $this ->Help_And_Support_model->getListConversation($this->per_page, $offset, $this->session->userdata('userid'), $this->is_adv);
        $this->base_url_trang = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'); 
        $this->handlePagination($result['total_rows']);
        $content =  $this->load->view('help&support/list', array('data'=> $result['data'], 'pagination' => [
            'page' => $offset,
            'total_page' => ceil($result['total_rows'] / $this->per_page),
            'next_link' => $this->base_url_trang.'/'.($offset + 1),
            'prev_link' => $this->base_url_trang.'/'.($offset - 1),
            'base_link' => $this->base_url_trang,
        ], 'user' => $user), true); 
        $this->load->view('default/vindex.php', ['content' => $content]); 
    }

    function add() {
        $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST'; 
        if($is_post_method) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[100]|xss_clean'); 
            $this->form_validation->set_rules('title', 'Title', 'trim|required|max_length[255]|xss_clean'); 
            $this->form_validation->set_rules('content', 'Content', 'trim|required|max_length[2000]|xss_clean');
            $data =$this->security->xss_clean($_POST); 
            if($this->form_validation->run() == TRUE) {
                $this ->Help_And_Support_model->add([
                    "name" => $data['name'], 
                    "email" => $data['email'],
                    "title" => $data['title'],
                    "content" => $data['content'],
                    "user_id" => $this->session->userdata('userid'),
                    'is_adv' => $this->is_adv,
                    "created_at" => date('Y-m-d H:i:s',time()),
                    "updated_at" => date('Y-m-d H:i:s',time()),
                ]);
                echo json_encode(array('error'=> false,'data'=> null));
                return;
            } else {
                $errors = array( 
                    "name" => form_error('name'), 
                    "email" => form_error('email'),
                    "title" => form_error('title'),
                    "content" => form_error('content'),
                ); 
                
                echo json_encode(array('error'=> true,'data'=> $errors));
                return;
            }
        } else {
            echo "Method not allow";
        }
    }

    function show($id) {
        $user = $this->session->userdata('user');
        $info = $this ->Help_And_Support_model->getConversation($id);
        $commment  = $this ->Help_And_Support_model->getListComment($this->per_page, 1, $id);
        $content = $this->load->view('help&support/detail', array('data'=> $info, 'comments' => $commment['data'], 'totalComment' => $info->total_comment, 'perPage' => $this->per_page, 'currentUser' => $user->email), true); 
        $this->load->view('default/vindex.php', ['content' => $content]); 
    }

    function getListComment($id, $offset = 2) {
        $result = $this ->Help_And_Support_model->getListComment($this->per_page, $offset, $id);
        $total_page = ceil($result['total_rows'] / $this->per_page);
        echo json_encode(array('comments'=> $result['data'], 'can_next' => $offset < $total_page ));
        return;
    }

    function reply($id) {
        $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST'; 
        if($is_post_method) {
            $user = $this->session->userdata('user');
            $this->form_validation->set_rules('content', 'Comment', 'trim|required|max_length[2000]|xss_clean'); 
            $data =$this->security->xss_clean($_POST); 
            if($this->form_validation->run() == TRUE) {
                $this ->Help_And_Support_model->add([
                    "email" => $user->email,
                    "content" => $data['content'],
                    "user_id" => $this->session->userdata('userid'),
                    "parent_id" => $id,
                    'is_adv' => $this->is_adv,
                    "created_at" => date('Y-m-d H:i:s',time()),
                    "updated_at" => date('Y-m-d H:i:s',time()),
                ]);
                echo json_encode(array('error'=> false,'data'=> null));
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