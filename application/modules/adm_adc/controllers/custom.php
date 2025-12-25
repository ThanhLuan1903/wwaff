<?php
require_once(APPPATH . '/modules/adm_adc/services/ServiceProvider.php');
require_once(APPPATH . '/modules/adm_adc/services/classes/ThemeService.php');

class Custom extends CI_Controller
{
  public $serviceProvider;

  public function __construct()
  {
    parent::__construct();
    $this->authenticated();
    $this->load->model('Admin_model');
    $this->load->model('Custom_model');
    $this->load->library('pagination');
    $this->serviceProvider = new ServiceProvider();
    $this->config_pagination();
  }

  private function config_pagination()
  {
    $config['base_url'] = '#';
    $config['per_page'] = 10;
    $config['total_rows'] = 200;

    $this->pagination->initialize($config);
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
    $data = [
      'loginTheme' => $this->Admin_model->get_one('custom_features', ['type' => ThemeService::BG_LOGIN]),
      'titleBanners' => $this->Custom_model->get_list_by_type(ThemeService::TITLE_BANNER),
      'titlePublishers' => $this->Custom_model->get_list_by_type(ThemeService::TITLE_PUBLISHER),
      'trafficTypes' => $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE),
      'publisherBanners' => $this->Custom_model->get_banners_by_role(1)
    ];
    $content = $this->load->view('admin/content/customs/view', $data, true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function edit($type)
  {
    $data = $this->Custom_model->find_by_type($type);
    $content = $this->load->view('admin/content/customs/form', ['titleBanner' => $data], true);
    return $this->load->view('admin/index', compact('content'));
  }
  public function edit_register_page($id = null)
  {
    $data = $this->Custom_model->find_by_id($id);
    $content = $this->load->view('admin/content/customs/form_traffic_type', ['traffic_type' => $data], true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function update($service)
  {
    if (!$this->input->post())
      throw new Exception("Method is not allowed");

    $type = $this->input->post('type');
    $content = $this->input->post('content');

    $this->serviceProvider->get_service($service);

    if ($this->serviceProvider->edit($type, $content))
      $this->session->set_flashdata('success', 'Updated successfully');

    if ($this->uri->segment(4) == 'custom-rewards')
      return redirect('admin/custom_sale_rewards/view');
    return redirect('admin/custom/view');
  }

  public function delete_reward($type)
  {
    $this->serviceProvider->get_service(ServiceProvider::CUSTOM_REWARD);

    if ($this->serviceProvider->delete($type))
      $this->session->set_flashdata('success', 'Deleted successfully');

    return redirect($_SERVER['HTTP_REFERER']);
  }

  public function delete($serivce, $id)
  {
    $this->serviceProvider->get_service($serivce);

    if ($this->serviceProvider->delete($id))
      $this->session->set_flashdata('success', 'Deleted successfully');
    return redirect($_SERVER['HTTP_REFERER']);
  }

  public function offer_titles()
  {
    $offer_titles = $this->Custom_model->get_list_by_type(ThemeService::TITLE_BANNER);
    $content = $this->load->view('admin/content/customs/offer_titles', ['titleBanners' => $offer_titles], true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function edit_title_offer($type = null)
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    $tittle = null;

    if (!empty($type)) {
      $tittle = $this->Custom_model->find_by_type($type);
    }

    if ($is_post_method) {
      $this->serviceProvider->get_service(ServiceProvider::THEME_SERVICE);
      $content = $this->input->post('content');
      $type = $this->input->post('type');
      $isExists = $this->Custom_model->find_by_type($type);

      if ($this->serviceProvider->edit($type, $content)) {
        $this->session->set_flashdata('success', 'Updated successfully');
      } else {
        $this->session->set_flashdata('error', 'Updated Failed');
      }

      return redirect(base_url('admin/custom/offer_titles'));
    }

    $content = $this->load->view('admin/content/customs/edit_offer_title', ['title' => $tittle], true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function publisher_titles()
  {
    $titles = $this->Custom_model->get_list_by_type(ThemeService::TITLE_PUBLISHER);
    $content = $this->load->view('admin/content/customs/publisher_titles', ['titles' => $titles], true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function edit_publisher_title($type = null)
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    $tittle = null;

    if (!empty($type)) {
      $tittle = $this->Custom_model->find_by_type($type);
    }

    if ($is_post_method) {
      $this->serviceProvider->get_service(ServiceProvider::THEME_SERVICE);
      $content = $this->input->post('content');
      $type = $this->input->post('type');
      $isExists = $this->Custom_model->find_by_type($type);

      if ($this->serviceProvider->edit($type, $content)) {
        $this->session->set_flashdata('success', 'Updated successfully');
      } else {
        $this->session->set_flashdata('error', 'Updated Failed');
      }

      return redirect(base_url('admin/custom/publisher_titles'));
    }

    $content = $this->load->view('admin/content/customs/edit_publisher_title', ['title' => $tittle], true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function publisher_banners()
  {
    $banners =  $this->Custom_model->get_banners_by_role(1);
    $content = $this->load->view('admin/content/customs/publisher_banners', ['banners' => $banners], true);
    return $this->load->view('admin/index', compact('content'));
  }

  public function edit_publisher_banner($id = null)
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    $banner = null;

    if (!empty($id)) {
      $banner = $this->Admin_model->get_one('banners', ['id' => $id]);
    }

    if ($is_post_method) {
      $this->db->where('id', $id);
      $this->db->update('banners', $this->input->post());
      if ($this->db->affected_rows() > 0) {
        $this->session->set_flashdata('success', 'Updated successfully');
      } else {
        $this->session->set_flashdata('error', 'Updated Failed');
      }

      return redirect(base_url('admin/custom/publisher_banners'));
    }

    $content = $this->load->view('admin/content/customs/edit_publisher_banner', ['banner' => $banner], true);
    return $this->load->view('admin/index', compact('content'));
  }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */