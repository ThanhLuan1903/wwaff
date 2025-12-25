<?php

require_once APPPATH . 'libraries/auth/contracts/User.php';
require_once APPPATH . 'libraries/modules/traits/generic_trait.php';
require_once APPPATH . 'libraries/modules/traits/publisher_trait.php';
require_once APPPATH . 'libraries/modules/traits/publisher/payment_trait.php';
require_once APPPATH . 'libraries/modules/traits/publisher/product_trait.php';
require_once APPPATH . 'libraries/modules/traits/publisher/notification_trait.php';
require_once APPPATH . 'libraries/modules/traits/publisher/placement_trait.php';
require_once APPPATH . 'libraries/modules/traits/publisher/stastic_trait.php';

class Publisher extends User
{
  use GenericTrait, PublisherTrait, Publisher_PaymentTrait, Publisher_ProductTrait, Publisher_Notification_Trait, Publisher_Placement_Trait, Publisher_Statistic_Trait;

  private $table = 'users';
  private $is_adv = 0;
  public function __construct()
  {
    parent::__construct();
    $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
    $this->load->model('Home_model');
    $this->load->model('Partner_model');
    $this->load->model('Offer_model');
    $this->load->model("Request_Product_model");
    if($this->session->userdata('role')==1){
      $table = 'users';
    }else if($this->session->userdata('role')==2){
        $table = 'advertiser';
        $this->is_adv =1;
    }
    if($this->session->userdata('logedin')){
      $this->db->select($table.'.*,cpalead_api_key.api_key');
        $this->db->from($table);
        $this->db->join('api_key', 'api_key.user_id ='.$table.'.id AND cpalead_api_key.is_adv = '.$this->is_adv, 'left');
        $this->db->where(array($table.'.id'=>$this->session->userdata('userid')));
        $this->member = $this->db->get()->row();
       $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];           
    }
  }

  public function dashboard()
  {
    $data = array();
    $data = $this->get_offers();
    $data['top_10_rewards'] = $this->Home_model->get_data('publisher_top_10_month_rewards', [], null, ['0' => 'ranking', 'ASC']);
    $data['balance_users'] = $this->Admin_model->get_top_10_balance_month();
    $data['custom_sale_rewards'] = $this->get_custom_top_10_sale_rewards();
    $data['sum_sale_rewards'] = $this->sum_rewards($data['top_10_rewards'], 'reward');
    $data['sum_custom_sale_rewards'] = $this->sum_rewards($data['custom_sale_rewards'], 'reward');
    $data['news'] = $this->Home_model->get_data('content', array('show' => 1), array(9), array('id', 'DESC'));
    $data['manager'] = $this->Home_model->get_one('manager', array('id' => $this->member->manager));
    $qr = "SELECT count(id) as click,
     SUM(CASE WHEN (date < '2025-11-01' OR (date >= '2025-11-01' AND amount3 > 0)) AND flead=1 THEN 1 ELSE 0 END) as lead,
     count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and DATE(date)=?";
    $qq = $this->db->query($qr, array($this->member->id, date("Y-m-d")));
    if ($qq) {
      $data['dayli_static'] = $qq->row();
    } else {
      $data['dayli_static'] = 0;
    }

    //end đayli static

    $qr = "SELECT count(id) as click,
          SUM(CASE WHEN (date < '2025-11-01' OR (date >= '2025-11-01' AND amount3 > 0)) AND flead=1 THEN 1 ELSE 0 END) as lead,
          SUM(CASE WHEN flead=1 THEN amount2 ELSE 0 END) as reve , DATE(date) as dayli  FROM `cpalead_tracklink`  WHERE date > DATE_SUB(NOW(), INTERVAL 10 DAY) AND userid=? GROUP BY DATE(date) ";
    $data['chart'] = $this->db->query($qr, array($this->member->id))->result();

    $content = $this->load->view('dashboard/vdashboard.php', $data, true);
    return $this->load->view('default/vindex.php', array('content' => $content));
  }

  public function list_publisher(){
    return redirect('v2');
  }

  public function invite_publishers() {
    return redirect('v2');
  }

  public function rating_publishers() {
    return redirect('v2');
  }

  public function profile()
  {
    if ($_POST) {
      if ($this->input->post('action')) {
        if ($_POST['action'] == 'Update Password') { //change passsưord
          echo $this->changepass();
        } elseif ($_POST['action'] == 'update_info') { //profile
          echo $this->update_info();
        } elseif ($_POST['action'] == 'deletePostBack') { //del posstback
          echo $this->deletePostBack();
        } elseif ($_POST['action'] == 'addPostback') { //addpostback savepayoneer
          echo $this->addPostback();
        } elseif ($_POST['payment_method'] == 'paypal') {
          echo $this->savepaypal();
        } elseif ($_POST['payment_method'] == 'wire' || $_POST['payment_method'] == 'Bank Wire (VN Only)') {
          echo $this->savewire();
        } elseif ($_POST['payment_method'] == 'payoneer') {
          echo $this->savepayoneer();
        }
      }
      return;
    } else {
      $data['postBack'] = $this->Home_model->get_data('postback', array('affid' => $this->member->id));
      $data['userData'] = $this->member;
      $content = $this->load->view('profile/profile.php', $data, true);
      $this->load->view('default/vindex.php', array('content' => $content));
    }
  }

  public function referrals()
  {
    $content = $this->load->view('referrals.php', array(), true);
    $this->load->view('default/vindex.php', array('content' => $content));
  }

  public function account()
  {
    if ($_POST) {
      if ($this->input->post('action')) {
        if ($_POST['action'] == 'Update Password') {
          $this->changepass();
        } elseif ($_POST['action'] == 'Update Messaging') {
          $this->changemess();
        } elseif ($_POST['action'] == 'Save Details') {
          $this->update_info();
        } elseif ($_POST['action'] == 'Save Settings') {
          $this->save_settings();
        } elseif ($_POST['action'] == 'Update ChatHandle') {
          $this->chathandle();
        }
      }
      redirect(base_url('admin/panels_account.php'));
    } else {
      $content = $this->load->view('mod_publishers/default/account', array('content' => $this->member), true);
      $this->load->view('default/main.php', array('content' => $content));
    }
  }

  public function terms()
  {
    $this->content =  $this->pub_config['termsinfo'];
  }

  public function payments()
  {
    if ($_POST) {
      if ($this->input->post('action')) {
        if ($_POST['action'] == 'Save Payment Preferences') {
          if ($_POST['payment_method'] == 'paypal') {
            $this->savepaypal();
          } elseif ($_POST['payment_method'] == 'wire') {
            $this->savewire();
          }
        }
      }
      redirect(base_url('admin/panels_payments.php'));
    } else {
      $content = $this->load->view('default/payments.php', array('payment' => $this->Home_model->get_data('payment', array('userid' => $this->session->userdata('userid')), array(20), array('id', 'DESC'))), true);
      $this->load->view('default/main.php', array('content' => $content));
    }
  }

  public function post_payment()
  {
    $thongbao = '';
    if ($_POST) {
      if ($this->input->post('action')) {
        if ($_POST['payment_method'] == 'paypal') {
          $thongbao .= $this->savepaypal();
        }
        if ($_POST['payment_method'] == 'payoneer') {
          $thongbao .= $this->savepayoneer();
        } elseif ($_POST['payment_method'] == 'wire' || $_POST['payment_method'] == 'Bank Wire') {
          $thongbao .= $this->savewire();
        }
      }
    }

    $this->session->set_userdata('thongbao', '<div class="my-3"><p>' . $thongbao . '</p></div>');

    redirect(base_url('v2/profile/payment'));
  }
}
