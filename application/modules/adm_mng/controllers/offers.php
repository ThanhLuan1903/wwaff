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
        $this->managerid = $this->session->userdata('aduserid');
        $this->users = $this->Admin_model->get_one('cpalead_manager', array('id' => $this->session->userdata('aduserid')));
    }

    function search()
    {
        if ($_POST) {
            // Reset filter
            if ($this->input->post('reset_filter')) {
                $this->session->unset_userdata('osearch');
                redirect($this->uri->segment(1) . '/offers/listoffer');
                return;
            }

            $osearch = array();

            // Offer ID
            $id = $this->input->post('id');
            if ($id) {
                $osearch['id'] = $id;
            }

            // Offer Name
            $title = $this->input->post('title');
            if ($title) {
                $osearch['title'] = $title;
            }

            // Offer Category
            $arrdata = $this->input->post('data');
            if ($arrdata && is_array($arrdata)) {
                $osearch['offercat'] = $arrdata;
            }

            // Network (multi)
            $idnet = $this->input->post('idnet');
            if ($idnet && is_array($idnet)) {
                $osearch['idnet'] = array_map('intval', $idnet);
            }

            if (!empty($osearch)) {
                $this->session->set_userdata('osearch', $osearch);
            } else {
                $this->session->unset_userdata('osearch');
            }

            redirect($this->uri->segment(1) . '/offers/listoffer');
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

        $where = '';
        $sm = $this->uri->segment(3);

        if ($sm == 'smartoffers') {
            $smtype = 2;
        } elseif ($sm == 'smartlinks') {
            $smtype = 3;
        } else {
            $smtype = 1;
        }

        $where = " WHERE smtype = $smtype ";

        // Chỉ lấy filter khi là listoffer
        if ($smtype == 1) {
            $osearch = $this->session->userdata('osearch');

            // Filter by ID
            if (!empty($osearch['id'])) {
                $id = (int)$osearch['id'];
                $where .= " AND cpalead_offer.id = $id ";
            }

            // Filter by Title
            if (!empty($osearch['title'])) {
                $title = $this->db->escape_like_str($osearch['title']);
                $where .= " AND cpalead_offer.title LIKE '%$title%' ";
            }

            // Filter by Offercat
            if (!empty($osearch['offercat']) && is_array($osearch['offercat'])) {
                $cond = [];
                foreach ($osearch['offercat'] as $cat) {
                    $cond[] = "cpalead_offer.offercat LIKE '%o" . (int)$cat . "o%'";
                }
                $where .= " AND (" . implode(" OR ", $cond) . ") ";
            }

            // Filter by Network (multi)
            if (!empty($osearch['idnet']) && is_array($osearch['idnet'])) {
                $nets = implode(',', array_map('intval', $osearch['idnet']));
                $where .= " AND cpalead_offer.idnet IN ($nets) ";
            }
        }

        $qr = "
            SELECT cpalead_offer.*, cpalead_network.title as nettitle
            FROM cpalead_offer
            LEFT JOIN cpalead_network ON cpalead_offer.idnet = cpalead_network.id
            $where
            ORDER BY `id` DESC 
            LIMIT $offset, $this->per_page
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

        if ($this->users->parrent > 0) {
            if ($smtype == 2) {
                $page = "offers/sub_smartoff_list.php";
            } elseif ($smtype == 3) {
                $page = "offers/sub_smartlink_list.php";
            } else {
                $page = 'offers/sub_offer_list.php';
            }
        } else {
            if ($smtype == 2) {
                $page = "offers/smartoff_list.php";
            } elseif ($smtype == 3) {
                $page = "offers/smartlink_list.php";
            } else {
                $page = 'offers/offer_list.php';
            }
        }

        $content = $this->load->view($page, array('dulieu' => $dt, 'net' => $net), true);
        $this->load->view('manager/index', array('content' => $content));
    }

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