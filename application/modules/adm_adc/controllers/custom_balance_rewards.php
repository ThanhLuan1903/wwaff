<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Custom_balance_rewards extends CI_Controller
{
  //admin
  public $pub_config = '';

  function __construct()
  {
    parent::__construct();

    $this->authenticated();

    $this->load->helper(array('form', 'url'));
    $this->load->library('session');
    $this->load->library('form_validation');
    $this->load->model('Home_model');
    $this->load->model('Admin_model');
    $this->load->model('Custom_model');
  }

  private function authenticated()
  {
    $this->base_key = $this->config->item('base_key');

    if (!$this->session->userdata('adlogedin')) {
      redirect('ad_user');
      $this->inic->sysm();
      exit();
    } else {
      $this->session->set_userdata('upanh', 1);
    }
    $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
    $this->db->trans_strict(FALSE);
  }

  public function view()
  {
    $rewards = $this->Admin_model->get_data('publisher_top_10_month_rewards', null, ['0' => 'ranking', '1' => 'ASC']);
    $balance_users = $this->Admin_model->get_top_10_balance_month();
    $custom_users = $this->Admin_model->get_data('custom_sale_rewards', ['type' => 2], ['0' => 'amount', '1' => 'DESC']);

    $top10_rewards = [];

    foreach ( $rewards as $reward ) {
      $top10_rewards[$reward->ranking] = $reward->reward;
    }

    $content = $this->load->view('admin/content/balance_rewards/view', compact('top10_rewards', 'rewards', 'balance_users', 'custom_users'), true);
    $this->load->view('admin/index', compact('content'));
  }

  /**
   * path: /admin/custom_balance_rewards/view
   */
  public function reward($ranking = null, $is_delete = null)
  {
    $post_data = $this->input->post();

    if ($post_data) {
      /** Update or insert */
      switch ($ranking) {
        case true:
          $this->db->where('ranking', $ranking);
          $this->db->update('publisher_top_10_month_rewards', ['reward' => $post_data['reward']]);
          break;
        default:
          $this->db->insert('publisher_top_10_month_rewards', $post_data);
          break;
      }

      if ($this->db->affected_rows() >= 1) {
        $this->session->set_flashdata('success_reward', 'Updated successfully');
      } else {
        $this->session->set_flashdata('error_reward', 'Update Failed');
      }
      return redirect('/admin/custom_balance_rewards/view');
    }

    if ($is_delete && $ranking) {
      $this->db->where('ranking', $ranking);
      $this->db->delete('publisher_top_10_month_rewards');
      $this->session->set_flashdata('success_reward', 'Deleted successfully');
      return redirect('/admin/custom_balance_rewards/view');
    }

    $reward = $this->Admin_model->get_one('publisher_top_10_month_rewards', ['ranking' => $ranking]);
    $content = $this->load->view('admin/content/balance_rewards/reward_form', compact('reward'), true);
    $this->load->view('admin/index', compact('content'));
  }

  public function custom_user($id = null, $is_delete = null) {

    $post_data = $this->input->post();

    if ($post_data) {
      /** Update or insert */
      switch ($id) {
        case true:
          $this->db->where('id', $id);
          $this->db->update('custom_sale_rewards', ['amount' => $post_data['amount']]);
          break;
        default:
          $this->db->insert('custom_sale_rewards', $post_data);
          break;
      }

      if ($this->db->affected_rows() >= 1) {
        $this->session->set_flashdata('success_custom_user', 'Updated successfully');
      } else {
        $this->session->set_flashdata('error_custom_user', 'Update Failed');
      }
      return redirect('/admin/custom_balance_rewards/view');
    }

    $user = $this->Admin_model->get_one('custom_sale_rewards', ['type' => 2, 'id' => $id]);
    $content = $this->load->view('admin/content/balance_rewards/add_top_user', compact('user'), true);
    $this->load->view('admin/index', compact('content'));
  }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */