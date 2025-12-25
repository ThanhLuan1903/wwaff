<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'libraries/modules/module.php';

class Payments extends CI_Controller
{

    private $mensenger = '';
    private $per_page = 30;
    public $total_rows = 6;
    public $pub_config = '';
    /** @var Member */
    public $member = '';
    public $member_info = '';
    private $pagina_uri_seg = 3;
    private $pagina_baseurl = 's';
    public $route;

    function  __construct()
    {
        parent::__construct();
        $this->pagina_baseurl =  base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/';
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        if ($this->session->userdata('logedin')) {
            $this->member = $this->Home_model->get_one('users', array('id' => $this->session->userdata('userid')));
            $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
        } elseif ($this->uri->segment(3) != 'in' && $this->uri->segment(3) != 'up') {
            redirect('v2/sign/in');
        }

        $this->route = new Module();
    }

    function index()
    {
        echo 1234;
    }

    function payment_list()
    {
        return $this->route->payment_list();
    }
    
    function request_payouts()
    {
        return $this->route->request_payouts();
    }
}
