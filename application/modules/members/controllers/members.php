<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/modules/adm_adc/services/classes/CustomSaleReward.php';
require_once APPPATH . 'libraries/modules/module.php';


class Members extends CI_Controller
{

    private $per_page = 30;
    public $total_rows = 6;
    public $pub_config = '';
    /** @var object $member */
    public $member = '';
    public $member_info = '';
    public $is_adv = 0;

    function  __construct()
    {
        parent::__construct();
        $this->load->model('Offer_model');
        $this->load->model('Custom_model');
        $this->load->model('Partner_model');
        $this->route = new Module();
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));

        if ($this->session->userdata('role') == 1) {
            $table = 'users';
        } else if ($this->session->userdata('role') == 2) {
            $table = 'advertiser';
            $this->is_adv = 1;
        }
        if ($this->session->userdata('logedin')) {
            $this->db->select($table . '.*,cpalead_api_key.api_key');
            $this->db->from($table);
            $this->db->join('api_key', 'api_key.user_id =' . $table . '.id AND cpalead_api_key.is_adv = ' . $this->is_adv, 'left');
            $this->db->where(array($table . '.id' => $this->session->userdata('userid')));
            $this->member = $this->db->get()->row();
            $this->member_info = !empty($this->member->mailling) ? unserialize($this->member->mailling) : [];
        }
    }

    function index()
    {
        echo '<h2>404 Page Not Found</h2> <br/> The page you requested was not found.';
    }

    function dashboard()
    {
        return $this->route->dashboard();
    }

    function publisher()
    {
        return $this->route->publisher();
    }

    function invite_publishers()
    {
        return $this->route->invite_publishers();
    }

    function rating_publishers()
    {
        return $this->route->rating_publishers();
    }

    function ajax_search_publisher()
    {
        return $this->route->ajax_search_publisher();
    }

    function add_product()
    {
        return $this->route->add_product();
    }

    function update_product($id)
    {
        return $this->route->update_product($id);
    }

    function post_payment()
    {
        return $this->route->post_payment();
    }

    function profile()
    {
        return $this->route->profile();
    }

    function ajax_test_postback()
    {
        if ($_POST) {
            $url = $this->input->post('url');
            if (strpos($url, '{sum}')) {
                //
                $url = str_replace('{sum}', $this->input->post('payout'), $url);
            } else {
                $url .= '&payout=' . $this->input->post('payout');
            }
            if (strpos($url, '{offerid}')) {
                //
                $url = str_replace('{offerid}', $this->input->post('offerid'), $url);
            } else {
                $url .= '&offerid=' . $this->input->post('v');
            }
            if (strpos($url, '{sub1}')) {
                //
                $url = str_replace('{sub1}', $this->input->post('sub1'), $url);
            } else {
                $url .= '&sub1=' . $this->input->post('sub1');
            }


            $result = $this->curl_senpost($url);
            echo json_encode(array('url' => $url, 'result' => $result));
        }
    }

    function curl_senpost($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch); 
        curl_close($ch);
        return $result;
    }

    function referrals()
    {
        return $this->route->referrals();
    }

    function account()
    {
        return $this->route->account();
    }

    function payments()
    {
        return $this->route->payments();
    }
  
    function w9()
    {
        if ($_POST) {
            $this->form_validation->set_rules('tax_name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('entity_type', 'Type of Entity', 'trim|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'Sity', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zipcode', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tin_type', 'Tax Identification Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('signature', 'Signature of U.S. person', 'trim|required|xss_clean');

            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST);         
                $this->db->where(array('userid' => $this->member->id, 'type' => 'w9'));
                $this->db->update('tax', array('content' => serialize($data), 'type' => 'w9'));
                if ($this->db->affected_rows()) {
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                } else {
                    $this->db->insert('tax', array('content' => serialize($data), 'userid' => $this->member->id, 'type' => 'w9'));
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }
            } else {
                $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
            }
        }
        $this->db->where(array('userid' => $this->member->id, 'type' => 'w9'));
        $dt = $this->db->get('tax')->row();
        if ($dt) {
            $dt =  unserialize($dt->content);
        }
        $this->load->view('default/w9', array('content' => $dt));
    }

    function w8()
    {
        if ($_POST) {
            $this->form_validation->set_rules('tax_name', 'Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('bus_country', 'Country of citizenship', 'trim|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('city', 'City', 'trim|required|xss_clean');
            $this->form_validation->set_rules('state', 'Sity', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zip', 'Zipcode', 'trim|required|xss_clean');
            $this->form_validation->set_rules('tin_type', 'Tax Identification Number', 'trim|required|xss_clean');
            $this->form_validation->set_rules('signature', 'Signature of U.S. person', 'trim|required|xss_clean');

            if ($this->form_validation->run() == TRUE) {
                $data = $this->security->xss_clean($_POST);     
                $this->db->where(array('userid' => $this->member->id, 'type' => 'w8'));
                $this->db->update('tax', array('content' => serialize($data), 'type' => 'w8'));
                if ($this->db->affected_rows()) {
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully.</p></div>');
                } else {
                    $this->db->insert('tax', array('content' => serialize($data), 'userid' => $this->member->id, 'type' => 'w8'));
                    $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Account Details have been updated successfully!.</p></div>');
                }
            } else {
                $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
            }
        }
        $this->db->where(array('userid' => $this->member->id, 'type' => 'w8'));
        $dt = $this->db->get('tax')->row();
        if ($dt) {
            $dt =  unserialize($dt->content);
        }
        $this->load->view('default/w8', array('content' => $dt));
    }

    function save_chat_sound()
    {
        $member_info = $this->member_info;

        if ($this->input->post('chat_sound_enabled') == 'true') {
            $member_info['chat_sound'] = 1;
        } else {
            $member_info['chat_sound'] = 0;
        }
        if ($this->input->post('chat_showspam') == 'true') {
            $member_info['chat_showspam'] = 1;
        } else {
            $member_info['chat_showspam'] = 0;
        }
        $this->db->where('id', $this->member->id);
        $this->db->update('users', array('mailling' => serialize($member_info)));
    }

    function resetApi()
    {
        $key = substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30);
        $where = array('user_id' => $this->member->id, 'is_adv' => $this->is_adv);
        $getApi = $this->Home_model->get_one('api_key', $where);
        if ($getApi) {
            $this->db->where($where)->update('api_key', array('api_key' => $key));
        } else {
            $where['api_key'] = $key;
            $this->db->insert('api_key', $where);
        }
        echo $key;
    }

    function terms()
    {
        $this->content =  $this->pub_config['termsinfo'];
        $this->hienthi();
    }

    function activate($key = '')
    {
        $log = $this->Home_model->get_one('users', array('key_active' => $key));
        if (!empty($log)) {
            if (!$log->activated) {
                if ($log->key_active != $key) {
                    echo 'your activation code is not right, please correct them';
                } else {
                    $this->db->where('key_active', $key);
                    $this->db->update('users', array('activated' => 1));
                    echo 'Thanks for interested with ' . $this->pub_config['sitename'] . '. Your application is completed and will be process within 3-5 business days'; //noi dugn thong bao sau khi kich hoat mail
                }
            } else {
                echo 'activated!';
            }
        }
    }

    function logout()
    {
        return $this->auth_plugin->logout();
    }

    function my_publishers()
    {
        return $this->route->my_publishers();
    }

    function invited_publishers()
    {
        return $this->route->invited_publishers();
    }

    function update_my_publisher()
    {
        return $this->route->update_my_publisher();
    }
}