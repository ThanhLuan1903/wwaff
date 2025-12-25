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
    $data = $this->input->post();
    $errors = '';
    unset($data['action']);

    $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean|callback_check_email');     
    $this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|callback_check_username');       
    $this->form_validation->set_rules('social_network', 'Skype ID/Linkedin', 'trim|required|max_length[255]|xss_clean');
    $this->form_validation->set_rules("website", 'Website', 'required|regex_match[/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/]');
    $this->form_validation->set_rules('phone', 'Phone', 'required|trim|regex_match[/^(\+)?[0-9]{9,12}$/]|xss_clean');

    if (!$this->form_validation->run()) {
      if(form_error('email')) $errors .= form_error('email').'<br/>';
      if(form_error('username')) $errors .= form_error('username').'<br/>';
      if(form_error('social_network')) $errors .= form_error('social_network').'<br/>';
      if(form_error('website')) $errors .= form_error('website').'<br/>';
      if(form_error('phone')) $errors .= form_error('phone').'<br/>';

      echo $errors;
      return;
    }

    $this->Advertiser_model->update_profile($data);
    echo 'Update Profile Successfully';
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