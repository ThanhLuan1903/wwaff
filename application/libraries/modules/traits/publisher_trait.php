<?php


trait PublisherTrait
{
  public $per_page = 15;

  function get_offers()
  {
    $uid = $this->member->id;
    $ct = $this->session->userdata('oCountry');
    $cat = $this->session->userdata('oCat');
    $opaymterm = $this->session->userdata('opaymterm');
    $oName = $this->session->userdata('oName');
    $where = '';
    if ($opaymterm) {
      $t = 0;
      $mp = '(';
      foreach ($opaymterm as $opaymterm) {
        $t++;
        if ($t == 1) {
          $mp .= $opaymterm;
        } else {
          $mp .= ',' . $opaymterm;
        }
      }
      $mp .= ')';
      $where .= " AND paymterm in $mp ";
    }

    $oName_Like = '';
    if ($oName) {
      $oName_Like .= " AND title LIKE '%$oName%' ";
    }
    $ct_Like = '';
    if ($ct) {
      $count = 0;
      foreach ($ct as $ct) {
        $count++;
        if ($count == 1) {
          $ct_Like .= 'country LIKE \'%o' . $ct . 'o%\'';
        } else {
          $ct_Like .= ' OR country LIKE \'%o' . $ct . 'o%\'';
        }
      }

      $ct_Like = "AND (" . $ct_Like . ")";
    }

    $cat_Like = '';
    if ($cat) {
      $count = 0;
      foreach ($cat as $cat) {
        $count++;
        if ($count == 1) {
          $cat_Like .= 'offercat LIKE \'%o' . $cat . 'o%\'';
        } else {
          $cat_Like .= ' OR offercat LIKE \'%o' . $cat . 'o%\'';
        }
      }

      $cat_Like = "AND (" . $cat_Like . ")";
    }

    $disoff = " AND id not in (SELECT distinct  offerid FROM cpalead_disoffer WHERE usersid = $uid) ";

    $activities = $this->get_activity_products($uid, $ct_Like, $cat_Like, $oName_Like, $where, $disoff);
    $newoffers = $this->get_new_offers($uid, $ct_Like, $cat_Like, $oName_Like, $where, $disoff);

    return compact('activities', 'newoffers');
  }

  function get_new_offers($uid, $ct_Like, $cat_Like, $oName_Like, $where, $disoff)
  {
    $qr = "SELECT cpalead_offer.*,
    CASE cpalead_offer.request 
        WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid limit 1)
        ELSE 'Approved'
        END AS status,
        (
            SELECT tmp_ranking.ranking FROM (
                                        SELECT
                                            (@cnt := @cnt + 1) AS ranking,
                                            t.id, t.`lead`
                                        FROM cpalead_offer AS t
                                                CROSS JOIN (SELECT @cnt := 0) AS dummy
                                        ORDER BY `lead` DESC
                                        LIMIT 20
                                    ) as tmp_ranking
            WHERE tmp_ranking.id = cpalead_offer.id
        ) as ranking
    FROM (`cpalead_offer`) 
    WHERE `show`='1' $where $ct_Like $cat_Like $oName_Like $disoff AND smartoff =0 AND smartlink=0  
    ORDER BY `id` DESC 
    LIMIT 0,20
    ";
    return $this->db->query($qr) ? $this->db->query($qr)->result() : null;
  }

  function sum_rewards($data, $field)
  {
    $sum = 0;
    foreach ($data as $each) {
      $sum += $each->$field;
    }

    return $sum;
  }

  function get_top_10_sale_awards()
  {
    $query = "SELECT cpalead_users.email, sum(cpalead_tracklink.amount2) as finance
    FROM cpalead_tracklink
    CROSS JOIN (SELECT @cnt := 0) AS dummy
    INNER JOIN cpalead_users on cpalead_users.id = cpalead_tracklink.userid
    WHERE cpalead_tracklink.flead = 1 AND (date >= ADDDATE(LAST_DAY(SUBDATE(CURRENT_DATE(), INTERVAL 1 MONTH)), 1) AND date <= LAST_DAY(CURRENT_DATE())) AND amount2 <> 0
    GROUP BY cpalead_users.email
    ORDER BY finance DESC
    LIMIT 10";

    $records = $this->db->query($query) ? $this->db->query($query)->result() : null;
    $refers = $this->Home_model->get_data('custom_sale_rewards', ['type' => 2], [],  ['0' => 'amount', '1' => 'DESC']);
    $amounts = [];

    foreach ($records as $record) {
      array_push($amounts, $record->finance);
    }

    $sorted = 0;
    foreach ($refers as $refer) {
      $temp = [];
      foreach ($amounts as $amount) {
        if ($amount - $refer->amount >= 0) {
          array_push($temp, $amount - $refer->amount);
        }
      }
      $index = !empty($temp) ? array_keys($temp, max($temp)) : 0;
      if (isset($index[0])) {
        $refer->username = $records[$index[0] + $sorted]->email;
        $refer->amount = $records[$index[0] + $sorted]->finance;
        unset($records[$index[0]], $amounts[$index[0]]);
        $sorted++;
      }
    }

    return $refers;
  }

  function get_custom_top_10_sale_rewards()
  {
    return $this->Home_model->get_data('custom_sale_rewards', ['type' => 1], [], ['0' => 'amount', '1' => 'DESC']);
  }

  function get_activity_products($uid, $ct_Like, $cat_Like, $oName_Like, $where, $disoff)
  {
    $qr = "SELECT cpalead_offer.* , 'Approved' as status,
                (
                    SELECT tmp_ranking.ranking FROM (
                                                SELECT
                                                    (@cnt := @cnt + 1) AS ranking,
                                                    t.id, t.`lead`
                                                FROM cpalead_offer AS t
                                                        CROSS JOIN (SELECT @cnt := 0) AS dummy
                                                ORDER BY `lead` DESC
                                                LIMIT 20
                                            ) as tmp_ranking
                    WHERE tmp_ranking.id = cpalead_offer.id
                ) as ranking
            FROM cpalead_offer
            WHERE `show` = 1 AND smartoff =0 AND smartlink=0 AND request = 1 $ct_Like $cat_Like $oName_Like $where  $disoff AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid) ELSE 'Approved' END)='Approved'
            ORDER BY `id` DESC 
            LIMIT 0,20
            ";
    return $this->db->query($qr) ? $this->db->query($qr)->result() : null;
  }

  function deletePostBack()
  {
    if ($_POST) {
      $id = (int)$this->input->post('pbid');
      if ($this->Home_model->get_one('postback', array('id' => $id, 'affid' => $this->member->id))) {
        $this->db->where('id', $id);
        $this->db->delete('postback');
        echo 1;
      } else {
        echo 0;
      }
    }
  }

  function addPostback()
  {
    if ($_POST) {
      $this->form_validation->set_rules('url', 'Postback URL', 'trim|required');
      if ($this->form_validation->run() == TRUE) {

        $url = $this->input->post('url');
        $this->db->insert('postback', array('affid' => $this->member->id, 'postback' => $url, 'enable' => 1, 'ip' => $this->input->ip_address()));
        return 1;
      } else {
        return 0;
      }
    }
  }

  private function changepass()
  {
    if ($_POST) {
      $this->form_validation->set_rules('oldpassword', 'Current password', 'trim|required|xss_clean|min_length[6]');
      $this->form_validation->set_rules('newpassword', 'New password', 'trim|required|matches[confirmpassword]|xss_clean|min_length[6]|max_length[18]');
      $this->form_validation->set_rules('confirmpassword', 'Confirm New password', 'trim|required|xss_clean|min_length[6]');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST); 
        $password = sha1(md5($data['oldpassword']));
        if ($this->Home_model->get_number('users', array('id' => $this->member->id, 'password' => $password)) == 1) {
          $this->db->where('id', $this->member->id);
          $this->db->update('users', array('password' => sha1(md5($data['password']))));
          return '<strong>SUCCESS: </strong>Your password has been updated successfully.';
        } else {
          return '<strong>FAILURE: </strong>"Current password" does not match account';
        }
      } else {
        return '<strong>FAILURE: </strong>' . validation_errors();
      }
    }
  }

  function update_info()
  { 
    if ($_POST) {
      $this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|callback_check_username');
      $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean|callback_check_email');
      $this->form_validation->set_rules('im_service', 'Skype ID/Telegram', 'trim|xss_clean');
      $this->form_validation->set_rules('firstname', 'First Name', 'trim|xss_clean');
      $this->form_validation->set_rules('lastname', 'Last Name', 'trim|xss_clean');
      $this->form_validation->set_rules('ad', 'Address Line 1', 'trim|required|xss_clean');
      $this->form_validation->set_rules('phone', 'Phone', 'required|trim|regex_match[/^(\+)?[0-9]{9,12}$/]|xss_clean');
      $this->form_validation->set_rules('hear_about', 'How did you find us?', 'trim|xss_clean');
      $this->form_validation->set_rules('volume', 'Volumne', 'greater_than[0]|xss_clean');
      $this->form_validation->set_rules('website', 'Website', 'trim|required|regex_match[/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/]|xss_clean');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST); 

        $member_info = $this->member_info;
        $member_info['im_service'] = trim($data['im_service']);
        $member_info['avartar'] = trim($data['avartar']);
        $member_info['username'] = trim($data['username']);
        $member_info['firstname'] = trim($data['firstname']);
        $member_info['lastname'] = trim($data['lastname']);
        $member_info['ad'] = trim($data['ad']);
        $member_info['hear_about'] = trim($data['hear_about']);
        $member_info['volume'] = trim($data['volume']);
        $member_info['website'] = trim($data['website']);
        $member_info['aff_type'] = join(',', $data['aff_type']);

        $this->db->where('id', $this->session->userdata('userid'));
        $this->db->update('users', [
          'mailling' => serialize($member_info),
          'phone' => trim($data['phone']),
          'product_categories' => join(',', $data['product_categories']),
          'conversion_flow' => join(',', $data['conversion_flow']),
          'traffic_device' => $data['traffic_device'],
          'product_geos' => join(',', $data['product_geos']),
          'username' => trim($data['username'])
        ]);

        if ($this->db->affected_rows() > 0) {
          return '<strong>SUCCESS: </strong> Successfully edited profile.';
        } else {
          return '<strong>FAILURE: </strong>Update error!';
        }
      } else {
        return '<strong>FAILURE: </strong>' . validation_errors();
      }
    }
  }

  private function savewire()
  {
    if ($_POST) {
      $this->form_validation->set_rules('payment_wire_bankname', ' Bank Name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('payment_wire_purpose', 'Purpose of Payment', 'trim|required|xss_clean');
      $this->form_validation->set_rules('payment_wire_bankaddress', 'Bank Address', 'trim|required|xss_clean');
      $this->form_validation->set_rules('payment_wire_accountnum', 'Account', 'trim|required|xss_clean');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST); 
        $member_info = $this->member_info;
        $member_info['payment_wire_bankname'] = trim($data['payment_wire_bankname']);
        $member_info['payment_wire_purpose'] = trim($data['payment_wire_purpose']);
        $member_info['payment_wire_bankaddress'] = trim($data['payment_wire_bankaddress']);
        $member_info['payment_wire_accountnum'] = trim($data['payment_wire_accountnum']);
        $member_info['payment_wire_country'] = trim($data['payment_wire_country']);
        $member_info['payment_method'] = 'wire';

        $this->db->where('id', $this->member->id);

        if ($this->db->update('users', array('mailling' => serialize($member_info)))) {
          return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
        } else {
          return '<strong>FAILURE: </strong>Update error!';
        }
      } else {
        return '<strong>FAILURE: </strong>' . validation_errors();
      }
    }
  }

  private function savepaypal()
  {
    if ($_POST) {
      $this->form_validation->set_rules('payment_paypal_email', 'Paypal Email', 'trim|required|valid_email|xss_clean');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST);          
        $member_info = $this->member_info;
        $member_info['payment_method'] = 'paypal';
        $member_info['payment_paypal_email'] = trim($data['payment_paypal_email']);
        $this->db->where('id', $this->session->userdata('userid'));
        if ($this->db->update('users', array('mailling' => serialize($member_info)))) {
          return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
        } else {
          return '<strong>FAILURE: </strong>Update error!';
        }
      } else {
        return '<strong>FAILURE: </strong>' . validation_errors();
      }
    }
  }

  private function savepayoneer()
  {
    if ($_POST) {
      $this->form_validation->set_rules('payment_payoneer_email', 'payoneer Email', 'trim|required|valid_email|xss_clean');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST);       
        $member_info = $this->member_info;
        $member_info['payment_method'] = 'payoneer';
        $member_info['payment_payoneer_email'] = trim($data['payment_payoneer_email']);
        $this->db->where('id', $this->session->userdata('userid'));
        if ($this->db->update('users', array('mailling' => serialize($member_info)))) {
          return '<strong>SUCCESS: </strong>Your Payment Details have been updated successfully.';
        } else {
          return '<strong>FAILURE: </strong>Update error!';
        }
      } else {
        return '<strong>FAILURE: </strong>' . validation_errors();
      }
    }
  }

  private function changemess()
  {
    if ($_POST) {
      $this->form_validation->set_rules('im_name', 'IM Name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('im_service', 'Im Service', 'trim|required|xss_clean');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST); 

        $member_info = $this->member_info;
        $member_info['im_service'] = trim($data['im_service']);
        $member_info['im_info'] = trim($data['im_name']);
        $this->db->where('id', $this->session->userdata('userid'));
        if ($this->db->update('users', array('mailling' => serialize($member_info)))) {
          $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your Instant Messenger Settings have been updated successfully.</p></div>');
        } else {
          $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Update error!</p></div>');
        }
      } else {
        $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
      }
    }
  }

  private function save_settings()
  {
    if ($_POST) {
      $this->form_validation->set_rules('chat_enabled', 'chat_enabled', 'trim|xss_clean');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST);              
        $member_info = $this->member_info;
        if (empty($data['chat_enabled'])) {
          $data['chat_enabled'] = 0;
        }
        if (empty($data['chat_sound'])) {
          $data['chat_sound'] = 0;
        }
        if (empty($data['earn_sound'])) {
          $data['earn_sound'] = 0;
        }
        if (empty($data['referral_sound'])) {
          $data['referral_sound'] = 0;
        }

        $member_info['chat_enabled'] = trim($data['chat_enabled']);
        $member_info['chat_sound'] = trim($data['chat_sound']);
        $member_info['earn_sound'] = trim($data['earn_sound']);
        $member_info['referral_sound'] = trim($data['referral_sound']);
        $this->db->where('id', $this->session->userdata('userid'));
        if ($this->db->update('users', array('mailling' => serialize($member_info)))) {
          $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"> <p><strong>SUCCESS: </strong>Your User Experience Settings have been updated successfully.</p></div>');
        } else {
          $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Update error!</p></div>');
        }
      } else {
        $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
      }
    }
  }

  private function chathandle()
  {
    if ($_POST) {
      $this->form_validation->set_rules('chathandle', 'Chat Handle', 'trim|required|xss_clean');
      if ($this->form_validation->run() == TRUE) {
        $data = $this->security->xss_clean($_POST); 
        $chatuser = trim($data['chathandle']);
        $this->db->where('chatuser', $chatuser);
        if ($this->db->get('users')->row()) {
          $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>The Chan Handle already exists, please choose another one.!</p></div>');
        } else {
          $this->db->where('id', $this->session->userdata('userid'));
          if ($this->db->update('users', array('chatuser' => $chatuser))) {
            $this->session->set_userdata('warn', '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Your ChatHandle have been updated successfully.</p></div>');
          }
        }
      } else {
        $this->session->set_userdata('warn', '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>' . validation_errors() . '</p></div>');
      }
    }
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

  function ajax_search_offer()
  {
    $name = $this->input->post('name');
    $gt = $this->input->post('gt');
    if ($name) {
      $this->session->set_userdata($name, $gt);
    }
    echo 1;
  }

  function check_email($email)
  {
    if ($this->session->userdata('email')->email == $email) {
      return TRUE;
    }

    $is_exists = $this->db->query("SELECT * FROM cpalead_users WHERE id <> {$this->session->userdata('user')->id} AND email = '$email'")->row();

    if ($is_exists) {
      $this->form_validation->set_message('check_email', 'Email already exists!');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function check_username($username)
  {
    if ($this->session->userdata('username')->username == $username) {
      return TRUE;
    }

    $is_exists = $this->db->query("SELECT * FROM cpalead_users WHERE id <> {$this->session->userdata('user')->id} AND username = '$username'")->row();

    if ($is_exists) {
      $this->form_validation->set_message('check_username', 'Username already exists!');
      return FALSE;
    } else {
      return TRUE;
    }
  }
}