<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Network extends CI_Controller
{
    private $page_load = ''; 
    private $databk = '';
    private $base_url_trang = '';
    private $total_rows = 100;
    private $per_page = 30;
    private $pagina_uri_seg = 4;
    public $pub_config = '';
    private $base_key = '';
    private $queryString = '';

    function __construct()
    {
        parent::__construct();
        $this->load_thuvien();
        $this->base_key = $this->config->item('base_key');
        if (!$this->session->userdata('adlogedin')) {
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        } else {
            $this->session->set_userdata('upanh', 1);
        }
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->queryString = $this->input->server('QUERY_STRING');
    }

    function listNetwork($offset = 0)
    {
        $this->db->select('cpalead_network.*,advertiser.first_name,advertiser.last_name');
        $this->db->where('adv_id >', 0);
        $this->db->join('advertiser', 'advertiser.id =network.adv_id', 'left');
        $this->db->order_by('id', 'desc');
        $net = $this->Home_model->get_data('cpalead_network');
        $where = ' WHERE adv_id >0';
        $qr = "  SELECT COUNT(*) as total FROM cpalead_network  $where";
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->phantrang();
        $content = $this->load->view('network/network_list', array('dulieu' => $net, 'queryString' => $this->queryString), true);
        $this->load->view('admin/index', array('content' => $content));
    }

    function edit($id = 0)
    {
        $data = $this->db->where('id', $id)->get('cpalead_network')->row();
        $content = $this->load->view('network/network_edit', array('dulieu' => $data), true);
        $this->load->view('admin/index', array('content' => $content));
    }

    function delete($id = 0)
    {
        if ($id)  $this->db->where('id', $id)->delete('network');
        redirect($this->config->item('admin') . '/network/listNetwork');
    }

    function create()
    {
        $data['advList'] = $this->db->get('cpalead_advertiser')->result();
        $content = $this->load->view('network/network_add', $data, true);
        $this->load->view('admin/index', array('content' => $content));
    }

    function generatorUrl($data)
    {
        $tempArray = [];
        $arr = ['clickid', 'commission', 'sale_amount', 'pub_id'];
        if ($data) {
            $data = unserialize($data);
            foreach ($arr as $key) {
                $tempArray[] = ($data[$key][0] . "=" . $data[$key][1]);
            }
        }
        return implode('&', $tempArray);
    }

    function store()
    {
        $data = $this->input->post();
        $id  = $data['id'];
        $pass =  $data['pb_pass'];
        $queryString = $this->generatorUrl(serialize($data['pb_value']));
        $pbUrl = base_url("/advpostback/banner/{$id}/{$pass}?{$queryString}");
        $data['linkadd'] = $pbUrl;
        $nwdt = $this->db->where('id', $data['id'])->get('cpalead_network')->row();
        $pb_value = unserialize($nwdt->pb_value);
        
        if ($data['pb_value']) {
            foreach ($data['pb_value'] as $key => $value) {
                $pb_value[$key] = $value;
            }
        }

        $data['pb_value'] = serialize($pb_value);

        if ($id)  $this->db->where('id', $data['id'])->update('network', $data);
        else $this->db->insert('network', $data);
        redirect($this->config->item('admin') . '/network/listNetwork');
    }

    function search() {}

    function load_thuvien()
    {
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model("Admin_model");
    }
    
    function phantrang()
    {
        $this->load->library('pagination'); // da load ben tren
        $config['base_url'] = $this->base_url_trang;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->pagina_uri_seg;
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
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */