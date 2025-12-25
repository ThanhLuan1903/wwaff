<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller
{
    private $allchild = array();
    private $per_page = 5;
    private $total_rows = 6;
    
    function  __construct()
    {
        parent::__construct();
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
    }

    function terms()
    {
        $data['article'] = $this->pub_config['termsinfo'];
        $content = $this->load->view('term.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    function index($article_id = 0)
    {
        echo 123;
    }

    function news_list()
    {
        $data['article'] = $this->Home_model->get_data('cpalead_content', array('id >' => 3));
        $content = $this->load->view('listnews.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    function views($id = 0)
    {
        $data['article'] = $this->Home_model->get_one('cpalead_content', array('id' => $id));
        $content = $this->load->view('detail.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }
    
    function phantrang()
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/';
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 1;
        $config['num_links'] = 12;
        $this->pagination->initialize($config);
    }
}
