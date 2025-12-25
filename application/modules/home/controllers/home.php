<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    private $per_page = 50;
    
    function __construct()
    {
        parent::__construct();
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
    }
    
    function test()
    {
        echo $_SERVER['REMOTE_ADDR'];
        echo '<br/>hh';
    }

    public function index()
    {
        $paymterm = $this->Home_model->get_data('paymterm', array('show' => 1));
        $marrpaymterm = array();
        if ($paymterm) {
            foreach ($paymterm as $paymterm) {
                $marrpaymterm[$paymterm->id] = $paymterm->payment_term;
            }
        }
        
        $offertype = $this->Home_model->get_data('offertype', array('show' => 1));
        $marroffertype = array();
        if ($offertype) {
            foreach ($offertype as $offertype) {
                $marroffertype[$offertype->id] = $offertype->type;
            }
        }
     
        $country = $this->Home_model->get_data('country', array('show' => 1));
        $mCountryKeycode = array();
        if ($country) {
            foreach ($country as $country) {
                $mCountryKeycode[$country->id] = strtolower($country->keycode);
            }
        }
       
        $this->db->select('offercat as catname,id');
        $cpalead_offercat = $this->Home_model->get_data('cpalead_offercat', array('show' => 1));
        $mcat_off = array();
        if ($cpalead_offercat) {
            foreach ($cpalead_offercat as $cpalead_offercat) {
                //get offer bay cateygor
                $this->db->limit(20);
                $this->db->like('offercat', 'o' . $cpalead_offercat->id . 'o');
                $off = $this->Home_model->get_data('offer', array('show' => 1, 'home' => 1));
                if ($off) {
                    $mcat_off[$cpalead_offercat->id]['offer'] = $off;
                    $mcat_off[$cpalead_offercat->id]['cat'] = $cpalead_offercat->catname;
                }
            }
        }
        $data['mcat_off'] = $mcat_off;

        $data['marrpaymterm'] = $marrpaymterm;
        $data['marroffertype'] = $marroffertype;
        $data['mCountryKeycode'] = $mCountryKeycode;
        $data['newoffer'] = $this->Home_model->get_data('offer', array('show' => 1, 'new' => 1), array(20), array('id', 'DESC'));
        $data['topoffer'] = $this->Home_model->get_data('offer', array('show' => 1, 'top' => 1), array(20));
        $this->load->view('vindex', $data);
    }


    function ip()
    {
        echo '<pre>';
        print_r($_SERVER);
    }

    function phantrang()
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/';
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 3;
        $config['num_links'] = 6;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_pag">'; //div cho chu <<
        $config['first_tag_close'] = '</li>'; //div cho chu <<
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<li class="last_pag">';
        $config['last_tag_close'] = '</li>';
        //-------next-
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        //------------preview
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        // ------------------cu?npage
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';
        //--so 
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */