<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'modules/adm_adc/services/classes/ThemeService.php';

class Auth extends CI_Controller
{
    public $data_sitekey = '6Lc-NLsZAAAAAAt3usWbXBkPdVsbjFqKtaGYcXkY'; //sử dụng recaptcha
    function  __construct()
    {
        parent::__construct();
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model('Home_model');
        $this->load->model('Custom_model');
        $this->load->model('Advertiser_model');
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        if ($this->session->userdata('logedin') && $this->uri->segment(2) != 'logout') {
            redirect('v2/advertiser/sign-in');
        }
    }

    function sign_up()
    {
        $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
        if ($is_post_method) {

            $type_account = $this->input->get_post('type_account');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_check_email');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|callback_check_username');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[30]|xss_clean|callback_valid_password');
            $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'trim|required|matches[password]|xss_clean');
            $this->form_validation->set_rules('phone', 'Phone', 'required|trim|regex_match[/^(\+)?[0-9]{9,12}$/]|xss_clean');
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('address', 'Address', 'trim|required|xss_clean');
            $this->form_validation->set_rules('how_to_get_traffic', 'Link Avatar', 'trim|max_length[500]|xss_clean');
            $this->form_validation->set_rules('product_geo_ids', 'Product geo', 'required|xss_clean');
            $this->form_validation->set_rules('user_setting[has_affiliate_program]', 'I already have an affiliate program', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_setting[agree_with_term_1]', 'Please agree with term', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_setting[agree_with_term_2]', 'Please agree with term 2', 'trim|required|xss_clean');
            $this->form_validation->set_rules('avatar_url', 'Avatar', 'callback__validate_and_upload_avatar');
            $this->form_validation->set_rules('how_to_get_traffic', 'About your business', 'trim|required|xss_clean');
            $this->form_validation->set_rules('product_categories', 'Product Categories', 'required');
            $data = $this->security->xss_clean($_POST);

            if ($type_account == 'Company') {
                $this->form_validation->set_rules('social_network', 'Skype ID/Linkedin', 'trim|required|max_length[255]|xss_clean');
                $this->form_validation->set_rules("website", 'Website', 'required|regex_match[/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/]');
            }

            if (($this->form_validation->run() == FALSE)) {
                $errors = '';
                if (form_error('email')) $errors .= form_error('email') . '<br/>';
                if (form_error('username')) $errors .= form_error('username') . '<br/>';
                if (form_error('password')) $errors .=  form_error('password') . '<br/>';
                if (form_error('confirm_pass')) $errors .=  form_error('confirm_pass') . '<br/>';
                if (form_error('phone')) $errors .=  form_error('phone') . '<br/>';
                if (form_error('first_name')) $errors .= form_error('first_name') . '<br/>';
                if (form_error('last_name')) $errors .=  form_error('last_name') . '<br/>';
                if (form_error('address')) $errors .=  form_error('address') . '<br/>';
                if (form_error('social_network')) $errors .=  form_error('social_network') . '<br/>';
                if (form_error('website')) $errors .=  form_error('website') . '<br/>';
                if (form_error('avatar_url')) $errors .=  form_error('avatar_url') . '<br/>';
                if (form_error('is_company')) $errors .=  form_error('is_company') . '<br/>';
                if (form_error('product_geo_ids')) $errors .=  form_error('product_geo_ids') . '<br/>';
                if (form_error('how_to_get_traffic')) $errors .=  form_error('how_to_get_traffic') . '<br/>';
                if (form_error('product_categories')) $errors .=  form_error('product_categories') . '<br/>';
                if (form_error('user_setting[has_affiliate_program]')) $errors .=  form_error('user_setting[has_affiliate_program]') . '<br/>';
                if (form_error('user_setting[agree_with_term_1]')) $errors .=  'Please agree with term' . '<br/>';
                if (form_error('user_setting[agree_with_term_2]')) $errors .=  'Please agree with term 2' . '<br/>';

                echo json_encode(array('error' => true, 'data' => $errors));
                return;
            } else {
                $avatar_url = $this->input->post('avatar_url', true); 
                $data['avatar_url'] = $avatar_url;
                $is_company = $type_account == 'Company' ? 1 : 0;
                $password = sha1(md5($_POST['password']));
                $user_setting = serialize($_POST['user_setting']);
                $product_geo_ids = serialize($_POST['product_geo_ids']);
                $data['has_affiliate_program'] = $this->input->post('user_setting')['has_affiliate_program'];
                $data['password'] = $password;
                $data['user_setting'] = $user_setting;
                $data['is_company'] = $is_company;
                $data['product_geo_ids'] = $product_geo_ids;
                $data['ref_pub_token'] = substr(sha1(md5($data['email'])), 0, 25);
                $data['using_ref_token'] = $this->input->post('ref_pub_token');
                $this->Advertiser_model->add($data);

                echo json_encode(array('success' => true));
                return;
            }
        }
        $countries = $this->Advertiser_model->get_list_country();
        $p_categories = $this->Advertiser_model->get_list_p_categories();
        $traffic_types = $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE);

        $this->load->view('auth/signup', array('pubconfig' => $this->pub_config['termsinfo'], 'traffic_types' => $traffic_types, 'countries' => $countries, 'p_categories' => $p_categories));
    }

    function _validate_and_upload_avatar()
    {
        if (empty($_FILES['avatar_url']) || empty($_FILES['avatar_url']['name'])) {
            $this->form_validation->set_message('_validate_and_upload_avatar', 'Please upload an Avatar.');
            return false;
        }

        $uploadDir = FCPATH . 'upload/files/avatars/';
        if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0755, true); }

        $config = [
            'upload_path'   => $uploadDir,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => true,
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('avatar_url')) {
            $this->form_validation->set_message('_validate_and_upload_avatar', $this->upload->display_errors('', ''));
            return false;
        }

        $up = $this->upload->data();
        $relativePath = 'upload/files/avatars/' . $up['file_name'];

        $_POST['avatar_url'] = $relativePath;

        return true;
    }

    function check_email($email)
    {
        if ($this->Home_model->get_one('advertiser', array('email' => $email))) {
            $this->form_validation->set_message('check_email', 'Email already exists!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function check_username($username)
    {
        if ($this->Home_model->get_one('advertiser', array('username' => $username))) {
            $this->form_validation->set_message('check_username', 'Username already exists!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function valid_password($password)
    {
        $password = trim($password);
        $regex_uppercase = '/[A-Z]/';
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