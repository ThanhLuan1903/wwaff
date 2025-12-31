<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'modules/adm_adc/services/classes/ThemeService.php';

class Auth extends CI_Controller
{
    public $total_rows = 6;
    public $pub_config = '';
    public $data_sitekey = '6Lc-NLsZAAAAAAt3usWbXBkPdVsbjFqKtaGYcXkY';

    private $pindex = '';

    function  __construct()
    {   
	   
error_log("before constructor");	   
 parent::__construct();
	    error_log( "sau controller contrutctor");
	    
        $this->load->model('Custom_model');
        $this->load->library('auth/auth_plugin');
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
    }

    function index()
    {
        echo 'hello';
    }

    function regm($managerid = 0)
    {
        if ($managerid) {
            $this->session->set_userdata('managerid', $managerid);
        }
        redirect(base_url('v2/sign/up'));
    }

    function logout()
    {
        $this->session->unset_userdata('logedin');
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('userdata');
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('role');
        redirect(base_url('v2/sign/in'));
    }

    function resetpass()
    {
        if ($_POST) {
            $err = 1;
            $dt = '';
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            if ($this->form_validation->run() == TRUE) {
                $email = $this->security->xss_clean($_POST['email']);
                $user = $this->Home_model->get_one('users', array('email' => $email));
                if ($user) {
                    $user = unserialize($user->mailling);
                    $this->load->helper('string');
                    $pass = random_string('alnum', 8);
                    $password = sha1(md5($pass));
                    $this->db->where('email', $email);
                    $this->db->update('users', array('password' => $password));
                    $sitename = $this->pub_config['sitename'];
                    $tieude = ' Your new password for ' . $sitename;
                    $name =   $user['firstname'] . $user['lastname'];
                    $noidung = "
                        <b>Dear $name ,</b><p>
                        As you requested, your password has now been reset. Your new details are as follows:
                        Email: $email 
                        Password: $pass
                        
                        Regards,<br/>
                        Affiliate Application Team.                    
                        ";

                    $this->guimail($email, $tieude, $noidung);
                    $err = 0;
                    $dt .= 'Reset Instructions Sent. Please check your email.';
                } else {
                    $dt .= 'Specified email does not exist<br/>';
                }
            } else {
                $dt = form_error('email');
            }

            echo json_encode(array('error' => $err, 'data' => $dt));
            return;
        }

        $this->load->view('members/auth/losspass', '');
    }

    function generateRandomToken($email)
    {
        $tk = substr(sha1(md5($email)), 0, 25);
        return $tk;
    }

    function login()
    {
        $action = $this->input->get_post('action', TRUE);
        $dem = 0;
        if (isset($_COOKIE['attempts'])) {
            $dem = $_COOKIE['attempts'];
        }
        if ($dem) {
            setcookie("attempts", $dem + 1, time() + 300);
        } else {
            setcookie("attempts", 1, time() + 300);
        }

        if ($_POST) {
            $err = 1;
            $dt = '';
            $act = $this->security->xss_clean($_POST['login']);
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('pwd', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('role', 'Role', 'in_list[1,2]|required|xss_clean');

            if ($this->form_validation->run() == TRUE) {
                $email = $this->security->xss_clean($_POST['email']);
                $password = $_POST['pwd'];
                $role = $_POST['role'];
                $this->session->set_userdata('role', (int)$role);

                $result = $this->auth_plugin->authenticate($email, $password, $role);

                if (isset($result['error'])) {
                    if ($result['error'] === 'wrong_password') {
                        $dt = 'Incorrect password';
                    } else {
                        $dt = 'The user does not exist!';
                    }
                } elseif (isset($result['user'])) {
                    $log = $result['user'];

                    if ($log->status == 0) {
                        $dt = $this->pub_config['acc_pendding'];
                    } elseif ($log->status == 3) {
                        $dt = $this->pub_config['acc_banned'];
                    } elseif ($log->status == 2) {
                        $dt = $this->pub_config['acc_pause'];
                    } elseif ($log->status == 1) {
                        $this->db->where('id', $log->id);
                        $ref_token = $this->generateRandomToken($log->email);

                        if (!isset($log->ref_pub_token)) {
                            $this->db->update($this->session->userdata('role') == 1 ? 'users' : 'advertiser', array('ip_login' => $this->input->ip_address(), 'ref_pub_token' => $ref_token));
                        } else {
                            $this->db->update($this->session->userdata('role') == 1 ? 'users' : 'advertiser', array('ip_login' => $this->input->ip_address()));
                        }

                        $email_refs = [];
                        if (isset($log->ref_pub_token)) {
                            $refs = $this->db->where([
                                'using_ref_token' => $log->ref_pub_token
                            ])->select('using_ref_token, id, email')->get($this->session->userdata('role') == 1 ? 'users' : 'advertiser')->result();

                            foreach ($refs as $row) {
                                array_push($email_refs, $row->email);
                            }
                        }

                        $this->session->set_userdata('logedin', 1);
                        $this->session->set_userdata('userid', $log->id);
                        $this->session->set_userdata('userdata', array('id' => $log->id, 'chatuser' => $log->chatuser, 'balance' => $log->balance, 'email' => $log->email));
                        $this->session->set_userdata('refs', $email_refs);
                        $err = 0;
                        $dt = 'Login successfully';
                    }
                }
            } else {
                $dt = form_error('email') . ' ' . form_error('pwd');
            }

            echo json_encode(array('error' => $err, 'data' => $dt));
            return;
        }

        $loginBackground = $this->Home_model->get_one('custom_features', ['type' => ThemeService::BG_LOGIN]);
        $this->load->view('members/auth/login', compact('loginBackground'));
    }

    function approved($name = '', $toemail = '')
    {
        $tieude = 'Welcome to ' . $this->pub_config['sitename'] . '- Approved';
        $noidung = "
            Dear <b>$name</b>,<p>
            Congratulation, your application has been approved. In the meantime, please take a look at our current offers which listed in the offer page. If you have any other request then contact your affiliate manager for further information. 
            <br/>
            We are looking forward to lead you to the success in Affiliate Marketing.
            <br/>
            Contact skype if you have any question: live:.cid.dc3f3f4d372582ea  ( Bi Phan|Wedebeek ).
            <p>
            Regards,<br/>
            Affiliate Application Team                            
            
        ";
        if (!$this->guimail($toemail, $tieude, $noidung)) {
            $this->guimail($toemail, $tieude, $noidung);
        }
    }

    function register($ref = 0)
    {
        $managerid = 0;
        $err = 1;
        $dt = '';
        $ref = (int)$this->input->get_post('ref');
        $data = $this->security->xss_clean($_POST);
        $is_company = $this->input->post('flexRadioDefault') == 'Company' ? 1 : 0;
        if ($data) {
            $this->set_validation_register($this->input->post('flexRadioDefault'));
            $this->mailling = $data['mailling'];
            $loi = '';

            if (empty($data['mailling']['username'])) {
                $loi .= 'Please enter a valid <strong>Username</strong><br/>';
            }

            if (empty($data['mailling']['firstname'])) {
                $loi .= 'Please enter a valid <strong>Firstname</strong><br/>';
            }

            if (empty($data['mailling']['lastname'])) {
                $loi .= 'Please enter a valid <strong>Lastname</strong><br/>';
            }

            if (empty($data['mailling']['im_service'])) {
                $loi .= 'Please enter a valid <strong>IM Name.</strong><br/>';
            }

            $data['mailling']['aff_type'] = isset($data['aff_type']) ? join(',', (array)$data['aff_type']) : '';
            if (($this->form_validation->run() == FALSE)) {
                if ($loi && $data) {
                    $dt = $loi;
                }
                if (form_error('email')) $dt .= form_error('email') . '<br/>';
                if (form_error('password')) $dt .=  form_error('password') . '<br/>';
                if (form_error('phone')) $dt .=  form_error('phone') . '<br/>';
                if (form_error('mailling[website]')) $dt .=  form_error('mailling[website]') . '<br/>';
                if (form_error('avatar_url')) $dt .= form_error('avatar_url') . '<br/>';
                if (form_error('product_category')) $dt .=  form_error('product_category') . '<br/>';
                if (form_error('product_geo')) $dt .=  form_error('product_geo') . '<br/>';
                if (form_error('mailling[hear_about]')) $dt .=  form_error('mailling[hear_about]') . '<br/>';
                if (form_error('conversion_flow')) $dt .=  form_error('conversion_flow') . '<br/>';
                if (form_error('mailling[volume]')) $dt .=  form_error('mailling[volume]') . '<br/>';
                if (form_error('traffic_device')) $dt .=  form_error('traffic_device') . '<br/>';
                if (form_error('mailling[ad]')) $dt .=  form_error('mailling[ad]') . '<br/>';
                if (form_error('mailling[username]')) $dt .=  form_error('mailling[username]') . '<br/>';
                if (empty($data['mailling']['terms'])) {
                    $dt .= 'You must agree and accept the <strong>Terms and Conditions.</strong><br/>';
                }
            } else {
                $managerid = 1;

                if ($this->session->userdata('managerid')) {
                    $managerid = $this->session->userdata('managerid');
                } else {
                    $qr = "UPDATE cpalead_manager SET id = @id := id, pub_count=pub_count+1
                            WHERE id >1 AND parrent = 0
                            ORDER BY pub_count ASC
                            LIMIT 1";
                    $this->db->query($qr);

                    $qr = 'SELECT @id as id';
                    $dt = $this->db->query($qr)->row();

                    if ($dt && $dt->id && $dt->id > 0) {
                        $managerid = $dt->id;
                    }
                }

                $firstname = $data['mailling']['firstname'];
                $lastname = $data['mailling']['lastname'];

                $this->load->helper('string');
                $mangaunhien = random_string('alnum', 16);
                $data['mailling']['avartar'] =
                    isset($this->mailling['avartar'])
                        ? $this->mailling['avartar']
                        : (isset($data['mailling']['avartar']) ? $data['mailling']['avartar'] : '');
                $idata['mailling'] = serialize($data['mailling']);
                $idata['manager'] = $managerid;
                $idata['phone'] = $data['phone'];
                $idata['password'] = sha1(md5($data['password']));
                $idata['email'] = $data['email'];
                $idata['status'] = 0;
                $idata['ip'] = $this->input->ip_address();
                $idata['key_active'] = $mangaunhien;
                $idata['ref'] = $ref;
                $idata['rate'] = 1;
                $idata['ref_pub_token'] = $this->generateRandomToken($data['email']);
                $idata['using_ref_token'] = $data['ref_pub_token'];
                $idata['product_geos'] = implode(',', $data['product_geo']);
                $idata['product_categories'] = implode(',', $data['product_category']);
                $idata['conversion_flow'] = implode(',', $data['conversion_flow']);
                $idata['traffic_device'] = $data['traffic_device'];
                $idata['username'] = $data['mailling']['username'];
                $idata['is_company'] = $is_company;

                $sitename = $this->pub_config['sitename'];

                if ($this->pub_config['activate']) {
                    $idata['activated'] = 0;
                    $noidung = "
                            <b>Dear $firstname $lastname,</b><p>
                            Thanks for interested with $sitename. Your application is completed and will be process within 3-5 business days.
                            </p>
                            <p>
                            In the meantime, please active your account by the following link:
                            <a href=" . base_url() . "confirmation/$mangaunhien>Active</a>
                            </p>
                            If the active does not work well with your end then please copy and paste the url below for activate your account
                            " . base_url() . "confirmation/$mangaunhien
                            <br/>                                 
                            Regards,<br/>
                            Affiliate Application Team.                    
                            ";
                } else {
                    $idata['activated'] = 1;
                    $noidung = "
                        <b>Dear $firstname $lastname,</b><p>
                        Thanks for interested with $sitename. Your application is completed and will be process within 3-5 business days.
                        </p>
                        <br/>                                 
                        Regards,<br/>
                        Affiliate Application Team.                    
                        ";
                }

                $this->db->insert('users', $idata);
                $err = 0;
                $dt .= "You have successfully registered!. please active your email address.If you don't see the verification email in your inbox, please check your Junk or Spam folders.";

                $toemail = $data['email'];
                $tieude = $sitename . ' Please verify your email address.';

                @$this->guimail($toemail, $tieude, $noidung);
            }

            echo json_encode(array('error' => $err, 'data' => $dt));
            return;
        }

        $categories = $this->Home_model->get_data('offercat', ['show' => 1]);
        $countries = $this->Home_model->get_data('country', ['show' => 1]);
        $offer_types = $this->Home_model->get_data('offertype', ['show' => 1]);
        $trafficTypes = $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE);
        $this->load->view('auth/signup', array('pubconfig' => $this->pub_config['termsinfo'], 'trafficTypes' => $trafficTypes, 'categories' => $categories, 'countries' => $countries, 'offer_types' => $offer_types));
    }

    function check_email($email)
    {
        if ($this->Home_model->get_one('users', array('email' => $email))) {
            $this->form_validation->set_message('check_email', 'Email already exists!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_username($username)
    {
        if ($this->Home_model->get_one('users', array('username' => $username))) {
            $this->form_validation->set_message('check_username', 'Username already exists!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    private function guimail($toemail = '', $tieude = '', $noidung = '')
    {
        $domain = 'noreply3.wedebeek.com';
        $api = '738d80a2f18a41c0c4d6a9e67696516c-31eedc68-b5347e9d';
        $from = $this->pub_config['sitename'] . '<' . $this->pub_config['emailadmin'] . '>';
        $txt = strip_tags($noidung);
        $curl_post_data = array(
            'from'    => $from,
            'to'      => $toemail,
            'subject' => $tieude,
            'html' => $noidung,
            'text'    => $txt
        );

        $service_url = 'https://api.mailgun.net/v3/' . $domain . '/messages';
        $curl = curl_init($service_url);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "api:$api");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curl_response = curl_exec($curl);
        $response = json_decode($curl_response);
        curl_close($curl);
        if ($response->message == 'Queued. Thank you.') return 1;
        else return 0;
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
                    $mailling = unserialize($log->mailling);
                    $name = $mailling['firstname'] . ' ' . $mailling['lastname'];
                }
            } else {
                echo 'activated!';
            }
        } else {
            echo 'Your Activation key is experied !';
        }
    }

    function hienthi()
    {
        $this->load->view('default/index' . $this->pindex, array('content' => $this->content));
    }

    private function set_validation_register($registerType)
    {
        $this->form_validation->set_rules('mailling[username]', 'Username', 'trim|required|xss_clean|callback_check_username');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_check_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[8]|max_length[30]|matches[confirm_pass]|callback_valid_password');
        $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim|regex_match[/^(\+)?[0-9]{9,12}$/]|xss_clean');
        $this->form_validation->set_rules('product_category', 'Product Category', 'required');
        $this->form_validation->set_rules('product_geo', 'Product Geo', 'required');
        // $this->form_validation->set_rules('mailling[avartar]', 'Avatar', 'required');
        $this->form_validation->set_rules('mailling[hear_about]', 'About your business', 'required');
        $this->form_validation->set_rules('conversion_flow', 'Product Type', 'required');
        $this->form_validation->set_rules('mailling[volume]', 'Volume', 'required');
        $this->form_validation->set_rules('traffic_device', 'Traffic Device', 'required');
        $this->form_validation->set_rules('mailling[ad]', 'Address', 'required');
        $this->form_validation->set_rules('avatar_url', 'Avatar', 'callback__validate_and_upload_avatar');

        // if (!empty($this->input->post('mailling')['avartar'])) {
        //     $this->form_validation->set_rules('mailling[avartar]', 'Avatar', 'regex_match[/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/]');
        // }

        if ($registerType == 'Company') {
            $this->form_validation->set_rules("mailling[website]", 'Website', 'required|regex_match[/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/]');
        }
    }

    public function _validate_and_upload_avatar()
{
    // Nếu không có file
    if (empty($_FILES['avatar_url']) || empty($_FILES['avatar_url']['name'])) {
        $this->form_validation->set_message('_validate_and_upload_avatar', 'Please upload an <strong>Avatar</strong>.');
        return false;
    }

    // Ensure folder exists: /upload/files/avatars
    $uploadDir = FCPATH . 'upload/files/avatars/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0755, true);
    }

    $config = [];
    $config['upload_path']   = $uploadDir;
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size']      = 2048; // KB = 2MB
    $config['encrypt_name']  = true;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('avatar_url')) {
        $this->form_validation->set_message('_validate_and_upload_avatar', $this->upload->display_errors('', ''));
        return false;
    }

    $up = $this->upload->data();

    // Lưu đường dẫn relative để dùng base_url() render
    $relativePath = 'upload/files/avatars/' . $up['file_name'];

    // IMPORTANT: đưa vào mailling để register() serialize xuống DB
    if (!isset($this->mailling) || !is_array($this->mailling)) {
        $this->mailling = [];
    }
    $this->mailling['avartar'] = $relativePath;

    // Đồng bộ vào POST data để phía dưới bạn serialize($data['mailling']) ra đúng
    $_POST['mailling']['avartar'] = $relativePath;

    return true;
}


    public function valid_password($password)
    {
        $password = trim($password);

        /* $regex_lowercase = '/[a-z]/'; */
        $regex_uppercase = '/[A-Z]/';
        /* $regex_number = '/[0-9]/'; */
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

        if (empty($password)) {
            $this->form_validation->set_message('valid_password', 'The password field is required.');
            return FALSE;
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The password field must be at least one uppercase letter.');
            return FALSE;
        }

        if (preg_match_all($regex_special, $password) < 1) {
            $this->form_validation->set_message('valid_password', 'The password field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
            return FALSE;
        }

        if (strlen($password) < 8) {
            $this->form_validation->set_message('valid_password', 'The password field must be at least 8 characters in length.');
            return FALSE;
        }

        if (strlen($password) > 30) {
            $this->form_validation->set_message('valid_password', 'The password field cannot exceed 32 characters in length.');
            return FALSE;
        }

        return TRUE;
    }
}
