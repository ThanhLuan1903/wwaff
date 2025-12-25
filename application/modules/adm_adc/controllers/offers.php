<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Offers extends CI_Controller
{
    private $page_load = ''; 
    private $databk = ''; 
    private $base_url_trang = '';
    private $total_rows = 100;
    private $per_page = 30;
    private $pagina_uri_seg = 4;
    public $pub_config = '';
    private $base_key = '';

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
    }

    function search()
    {
        if ($_POST) {
            $key = $this->input->post('key');
            $arrdata = $this->input->post('data');
            $idnet = $this->input->post('idnet');
            $osearch = $this->session->userdata('osearch'); 

            if ($key) {
                $osearch['key'] = $key;
            } else {
                unset($osearch['key']);
            }
            if ($arrdata) {
                $osearch['offercat'] = $arrdata;
            } else {
                unset($osearch['offercat']);
            }
            if ($idnet && $idnet != 'all') {
                $osearch['idnet'] = (int)$idnet;
            } else {
                unset($osearch['idnet']);
            }
            if ($osearch) {
                $this->session->set_userdata('osearch', $osearch);
            } else {
                $this->session->unset_userdata('osearch');
            }
            if ($idnet || $idnet == 'all') {
            } else {
                redirect($this->uri->segment(1) . '/offers/listoffer');
            }
        }
    }

    function smartlinks($offset = 0)
    {
        $this->session->unset_userdata('osearch');
        $this->session->set_userdata('smtype', 3);
        $this->loffers($offset);
    }

    function smartoffers($offset = 0)
    {
        $this->session->unset_userdata('osearch');
        $this->session->set_userdata('smtype', 2);
        $this->loffers($offset);
    }

    function listoffer($offset = 0)
    {
        $this->session->set_userdata('smtype', 1);
        $this->loffers($offset);
    }

    function loffers($offset = 0)
    {
        if ($this->session->userdata('table12') != 'offer') {
            $this->session->set_userdata('table12', 'offer');
        }

        $dk = 1;
        $where = $key = $wsearch = $idnet = '';
        $sm = $this->uri->segment(3);
        
        if ($sm == 'smartoffers') {
            $smtype = 2;
        } elseif ($sm == 'smartlinks') {
            $smtype = 3;
        } else {
            $smtype = 1;
            $osearch = $this->session->userdata('osearch'); 
            if (!empty($osearch['key'])) $key = $osearch['key'];
            if (!empty($osearch['offercat'])) $wsearch = $osearch['offercat'];
            if (!empty($osearch['idnet'])) $idnet = $osearch['idnet'];
        }

        $where = " WHERE smtype= $smtype ";
        
        if ($idnet) {
            if ($where) {
                $where .= " AND cpalead_offer.idnet = $idnet ";
            } else {
                $where .= " WHERE cpalead_offer.idnet = $idnet ";
            }
        }

        if ($key) {
            if ($where) {
                $temp = " AND  ";
            } else {
                $temp = " WHERE ";
            }
            if (is_numeric($key)) {
                $where .= " $temp cpalead_offer.id=$key"; 
            } else { 
                $key = mysql_real_escape_string($key);
                $where .= " $temp cpalead_offer.title LIKE '%$key%' ";      
            }
        }

        if ($wsearch) {
            $t = 0;
            if ($where) {
                $temp = " AND  ";
            } else {
                $temp = " WHERE ";
            }
            foreach ($wsearch as $wsearch) {
                $t++;
                if ($t == 1) {
                    $where .= ' ' . $temp . ' ( cpalead_offer.offercat LIKE "%o' . $wsearch . 'o%" ';
                } else {
                    $where .= ' OR cpalead_offer.offercat LIKE "%o' . $wsearch . 'o%" ';
                }
            }
            $where .= ') ';
        }

        $qr = "
            SELECT cpalead_offer.* ,cpalead_network.title as nettitle
            FROM cpalead_offer
            LEFT JOIN cpalead_network ON cpalead_offer.idnet = cpalead_network.id
            $where AND is_adv is null
            ORDER BY `id` DESC 
            LIMIT $offset,$this->per_page
        ";
        $dt = $this->db->query($qr)->result();
        $qr = "
            SELECT COUNT(*) as total
            FROM cpalead_offer
            $where            
        ";
        $net = $this->Home_model->get_data('cpalead_network');
        $this->total_rows = $this->db->query($qr)->row()->total;
        $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/');
        $this->phantrang();
        if ($smtype == 2) {
            $page = "offers/smartoff_list.php";
        } elseif ($smtype == 3) {
            $page = "offers/smartlink_list.php";
        } else {
            $page = 'offers/offer_list.php';
        }
        $content = $this->load->view($page, array('dulieu' => $dt, 'net' => $net), true);
        $this->load->view('admin/index', array('content' => $content));
    }

    function load_thuvien()
    {
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model("Admin_model");
    }

    function phantrang()
    {
        $this->load->library('pagination'); 
        $config['base_url'] = $this->base_url_trang;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->pagina_uri_seg;
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
        //-----
        $this->pagination->initialize($config);
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */