<?php
require_once(APPPATH . '/modules/adm_adc/services/classes/ThemeService.php');

trait Advertiser_ProfileTrait {
  
  public function profile()
  {
    $profile = $this->db->get_where('advertiser', ['id' => $this->session->userdata('user')->id])->row();
    $trafficTypes = $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE);
    $countries = $this->Home_model->get_data('country', ['show' => 1]);
    $offer_cats = $this->Home_model->get_data('offercat', ['show' => 1]);

    if ($this->input->is_ajax_request()) {
      $action = $this->input->post('action');
      switch ($action) {
        case "Update Password":
          $this->change_password();
          break;
        case "update_info":
          $this->update_profile();
          break;
      }
      return;
    }

    $content = $this->load->view('advertiser/profile/profile', compact('profile', 'trafficTypes', 'countries', 'offer_cats'), true);
    return $this->load->view('advertiser/default/vindex', compact('content'));
  }

  private function change_password() {
    $old_password = $this->input->post('oldpassword');
    $new_password = $this->input->post('newpassword');
    $isSuccess = $this->Advertiser_model->change_password($old_password, $new_password);

    if ($isSuccess) {
      echo 'Change password Successfully';
    } else {
      echo show_error('Incorrect Password');
    }
  }
private function update_profile() {
  $errors = '';

  $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean|callback_check_email');
  $this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|callback_check_username');
  $this->form_validation->set_rules('social_network', 'Skype ID/Linkedin', 'trim|required|max_length[255]|xss_clean');
  $this->form_validation->set_rules("website", 'Website', 'required|regex_match[/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/]');
  $this->form_validation->set_rules('phone', 'Phone', 'required|trim|regex_match[/^(\+)?[0-9]{9,12}$/]|xss_clean');
  $this->form_validation->set_rules('avatar_file', 'Avatar', 'callback__validate_and_upload_avatar_profile');

  if (!$this->form_validation->run()) {
    if(form_error('email')) $errors .= form_error('email').'<br/>';
    if(form_error('username')) $errors .= form_error('username').'<br/>';
    if(form_error('social_network')) $errors .= form_error('social_network').'<br/>';
    if(form_error('website')) $errors .= form_error('website').'<br/>';
    if(form_error('phone')) $errors .= form_error('phone').'<br/>';
    if(form_error('avatar_file')) $errors .= form_error('avatar_file').'<br/>';
    echo $errors;
    return;
  }

    $data = $this->input->post();
    unset($data['action']);

    $ok = $this->Advertiser_model->update_profile($data);

    // update session
    $user = $this->session->userdata('user');
    if ($user && !empty($data['avatar_url'])) {
      $user->avatar_url = $data['avatar_url'];
      $this->session->set_userdata('user', $user);
    }

  echo $ok ? 'Update Profile Successfully' : 'Update Profile Failed';
}

  
  function _validate_and_upload_avatar_profile()
    {
      if (empty($_FILES['avatar_file']) || empty($_FILES['avatar_file']['name'])) {
        return true;
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

      if (!$this->upload->do_upload('avatar_file')) {
        $this->form_validation->set_message('_validate_and_upload_avatar_profile', $this->upload->display_errors('', ''));
        return false;
      }

      $up = $this->upload->data();
      $relativePath = 'upload/files/avatars/' . $up['file_name'];

      $_POST['avatar_url'] = $relativePath;

      return true;
    }


  function check_email($email ){
    if ($this->session->userdata('user')->email == $email) {
      return TRUE;
    }

    $is_exists = $this->db->query("SELECT * FROM cpalead_advertiser WHERE id <> {$this->session->userdata('user')->id} AND email = '$email'")->row();

    if($is_exists){
      $this->form_validation->set_message('check_email', 'Email already exists!');            
      return FALSE;
    } else {
      return TRUE;  
    }
  }

  function check_username($username) {
    if ($this->session->userdata('user')->username == $username) {
      return TRUE;
    }

    $is_exists = $this->db->query("SELECT * FROM cpalead_advertiser WHERE id <> {$this->session->userdata('user')->id} AND username = '$username'")->row();

    if($is_exists){
      $this->form_validation->set_message('check_username', 'Username already exists!');            
      return FALSE;
    } else {
      return TRUE;  
    }
  }
}