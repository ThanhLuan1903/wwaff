<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'controllers/postback.php';
class Api_adv extends Postback
{
    private $base_url_trang = '';
    private $total_rows = '';
    private $per_page = 50;
    private $urigeg = 2;
    public $member = '';

    function  __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logedin')) {
            $table = 'advertiser';
            $this->is_adv = 1;
            $this->db->select($table . '.*,cpalead_api_key.api_key');
            $this->db->from($table);
            $this->db->join('api_key', 'api_key.user_id =' . $table . '.id AND cpalead_api_key.is_adv = ' . $this->is_adv, 'left');
            $this->db->where(array($table . '.id' => $this->session->userdata('userid')));
            $this->member = $this->db->get()->row();
            $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
        }
    }

    function index()
    {
        $content = $this->load->view('apikey.php', [], true);
        $this->load->view('members/default/vindex.php', array('content' => $content));
    }

    private function offers_cats()
    {
        $this->db->select('id,offercat as offercats');
        $this->db->where('show', 1);
        $ocat = $this->db->get('offercat')->result();
        if ($ocat) {
            echo json_encode($ocat);
        } else {
            echo '0';
        }
    }

    private function offers_types()
    {
        $this->db->select('id,type as offertypes');
        $this->db->where('show', 1);
        $ocat = $this->db->get('offertype')->result();
        if ($ocat) {
            echo json_encode($ocat);
        } else {
            echo '0';
        }
    }

    function generatorUrl($data)
    {
        $tempArray = [];
        $arr = ['subid', 'commission', 'sale_amount', 'pub_id'];
        if ($data) {
            $data = unserialize($data);
            foreach ($arr as $key) {
                $tempArray[] = ($data[$key][0] . "=" . $data[$key][1]);
            }
        }
        return implode('&', $tempArray);
    }

    private function offers()
    {
        $Guser_id = $this->input->get('user_id');
        $where = $like = array();
        $where = 'cpalead_offer.show = 1 ';
        $Gkeyword = $this->input->get('keyword');
        $Gcat = (int)$this->input->get('cat');
        $Gid = (int)$this->input->get('id');
        $Gtype = (int)$this->input->get('type');
        $Gcountry = $this->input->get('country');
        $arrCountry = array();

        if ($Gid) {
            $where .= " AND cpalead_offer.id = $Gid ";
        }

        if ($Gkeyword) {
            $like['title'] = trim($Gkeyword);
        }

        if ($Gcat) {
            $like['offercat'] = trim($Gcat);
        }
        if ($Gtype) {
            $like['type'] = trim($Gtype);
        }

        $ct = $this->Home_model->get_data('country', array());
        $ct_id = $ct_keycode = array();
        if ($ct) {
            foreach ($ct as $ct) {
                $ct_id[$ct->id] =  $ct->keycode;
                $ct_keycode[$ct->keycode] =  $ct->id;
            }
        }

        $oc = $this->Home_model->get_data('offercat', array());
        $oc_arr =  array();
        if ($oc) {
            foreach ($oc as $oc) {
                $oc_arr[$oc->id] =  $oc;
            }
        }
        if ($Gcountry) {
            if (!empty($ct_keycode[trim($Gcountry)])) {
                $like['country'] = $ct_keycode[trim($Gcountry)];
            }
        }
        $ct_Like = '';
        if ($like) {
            $count = 0;
            foreach ($like as $key => $value) {
                $count++;
                if ($count == 1) {
                    $ct_Like .= "$key LIKE \'%o'.$value.'o%\'";
                } else {
                    $ct_Like .= " AND $key LIKE \'%o'.$value.'o%\'";
                }
            }
            $cat_Like = " AND (" . $cat_Like . ") ";
        }
        $burl = base_url("click?pid=$Guser_id&offer_id=");

        $qr = "SELECT cpalead_offer.* , 'Approved' as status
        FROM cpalead_offer
        WHERE $where $cat_Like AND apion =1
        ORDER BY `id` DESC                 
        ";
        $offer = $this->db->query($qr)->result();
        $mdata = array();
        if ($offer) {
            foreach ($offer as $offer) {
                $dt = array();
                $dt['offerid'] = $offer->id;
                $dt['title'] = $offer->title;

                $point_geo = unserialize($offer->point_geos);
                $point = '';
                if ($point_geo) {
                    $dem = 0;
                    foreach ($point_geo as $key => $value) {

                        if ($value > 0) {
                            $dem++;
                            if ($dem == 1) {
                                $phay = '';
                            } else {
                                $phay = ', ';
                            }
                            $point .= $phay . $key . ': $' . $value;
                        }
                    }
                }
                $dt['payout'] = $point;
                $dt['track'] = $burl . $offer->id;

                $mIdCountry = explode('o', substr($offer->country, 1, -1));
                $flagIcon = '';
                if ($mIdCountry) {
                    foreach ($mIdCountry as $mIdCountry) {
                        if ($mIdCountry == 'all') {
                            $flagIcon = 'All Countries';
                        } else {
                            @$flagIcon .= $ct_id[$mIdCountry] . ', ';
                        }
                    }
                }
                @$dt['Geo'] = substr($flagIcon, 0, -2);

                $cat = explode('o', substr($offer->offercat, 1, -1));
                $ccc = '';
                if ($cat) {
                    foreach ($cat as $cat) {
                        @$ccc .= $oc_arr[$cat]->offercat . ', ';
                    }
                }
                @$dt['category'] = substr($ccc, 0, -2);

                $dt['description'] = $offer->description;
                $dt['convert_on'] = $offer->convert_on;
                $dt['traffic_source'] = $offer->traffic_source;
                $dt['restriced_traffics'] = $offer->restriced_traffics;
                $mdata[] = $dt;
            }
        }
        if ($mdata) {
            echo json_encode($mdata);
        } else {
            echo 0;
        }
    }

    public function document()
    {
        $content = $this->load->view('adv_document.php', [], true);
        $this->load->view('members/default/vindex.php', array('content' => $content));
    }

    function statistics()
    {
        $from = $this->input->post('from');
        $to = $this->input->post('to') ? $this->input->post('to') : date('Y-m-d');
        if ($from) {
            $this->session->set_userdata('from', $from);
            $this->session->set_userdata('to', $to);
        }
        $data = [];
        echo json_encode(['status' => 'success', 'data' => $data]);
    }

    function conversions()
    {
        header('Content-type: application/json');
        $apiKey = $this->input->get_post('apikey');
        $click_id = $this->input->post('click_id');
        $commission = $this->input->post('commission');
        $sale_amount = $this->input->post('sale_amount');

        $apiData = $this->Home_model->get_one('api_key', ['api_key' => $apiKey, 'is_adv' => 1]);
        if ($apiData) {
            $this->apiPostback($click_id, $commission, $sale_amount);
            echo json_encode([
                'status' => 'success',
                "message" => "Conversion recorded successfully"
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                "message" => "Your api Key does not exist!"
            ]);
        }
    }

    function phantrang()
    {
        $this->load->library('pagination');
        $config['base_url'] = $this->base_url_trang;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = $this->urigeg;
        $config['num_links'] = 13;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_pag">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = '>>';
        $config['last_tag_open'] = '<li class="last_pag">';
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
        $config['cur_tag_open'] = '<li class="activep">';
        $config['cur_tag_close'] = '</li>';
        //--so 
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        //-----
        $this->pagination->initialize($config);
    }
}
