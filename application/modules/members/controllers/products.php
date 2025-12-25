<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'libraries/modules/module.php';
class Products extends CI_Controller
{
    private $content = '';
    private $base_url_trang = '';
    private $per_page = 30;
    private $pagina_uri_seg = 4;
    public $route;
   
    function  __construct()
    {
        parent::__construct();
        $this->load_helpers();
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        if ($this->session->userdata('logedin')) {
            $this->member = $this->Home_model->get_one('users', array('id' => $this->session->userdata('userid')));
            $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
        } elseif ($this->uri->segment(3) != 'in' && $this->uri->segment(3) != 'up') {
            redirect('v2/sign/in');
        }

        $this->route = new Module();
    }

    function index($offset = 1)
    {
        return $this->route->request_product($offset);
    }

    function checkFileSize($field_name)
    {
        $config['upload_path'] = './upload/images/request_products';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size']     = '2048';
        $this->load->library('upload', $config);
        $this->upload->do_upload($field_name);
        $error = $this->upload->display_errors('', '');
        if (!empty($error)) {
            return [
                'status' => false,
                'error' => $error
            ];
        } else {
            $path = 'upload/images/request_products/' . $this->upload->data()['file_name'];
            return [
                'status' => true,
                'path' => $path,
            ];
        }
    }

    function add()
    {
        return $this->route->add_request_product();
    }

    function load_helpers()
    {
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model("Request_Product_model");
    }
}
