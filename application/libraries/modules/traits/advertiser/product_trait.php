<?php
require_once(APPPATH . '/modules/adm_adc/services/classes/ThemeService.php');

trait Advertiser_ProductTrait
{
  private function handlePagination($total)
  {
    $this->load->library('pagination');
    $config['base_url'] = $this->base_url_trang;
    $config['total_rows'] = $total;
    $config['per_page'] = $this->per_page;
    $config['uri_segment'] = $this->pagina_uri_seg;
    $config['num_links'] = 7;
    $config['first_link'] = '<<';
    $config['first_tag_open'] = '<li class="firt_page">'; //div cho chu <<
    $config['first_tag_close'] = '</li>'; //div cho chu <<
    $config['last_link'] = '>>';
    $config['last_tag_open'] = '<li class="last_page">';
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
    $config['cur_tag_open'] = '<li class="active"><a href=#>';
    $config['cur_tag_close'] = '</a></li>';
    //--so 
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $this->pagination->initialize($config);
  }

  public function add_product($product_id = null)
  {
    /* 1. Lấy thông tin */
    $networks = $this->Home_model->get_data('network', ['show' => 1, 'adv_id' => $this->session->userdata('user')->id]);
    if (!$networks) {
      $networks = $this->Home_model->get_data('network', ['show' => 1, 'title' => $this->session->userdata('user')->username]);
    }

    $types = $this->Home_model->get_data('offertype', ['show' => 1]);
    $payment_terms = $this->Home_model->get_data('paymterm', ['show' => 1]);
    $devices = $this->Home_model->get_data('device', ['show' => 1]);
    $categories = $this->Home_model->get_data('offercat', ['show' => 1]);
    $countries = $this->Home_model->get_data('country', ['show' => 1]);
    $trafficTypes = $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE);
    $errors = '';

    /* 2. Nếu có data thì check và insert thông tin */
    if ($this->is_method_post() && $this->input->is_ajax_request()) {
      $is_validated = $this->validate_upsert_product();

      if ($is_validated) {
        // True thì trả về lỗi
        echo $this->insert_product();
      } else {
        // False thì trả về lỗi
        echo validation_errors();
      }
      return;
    }

    /* 3. Không có Post thì trả về form để add */
    $content = $this->load->view('advertiser/offers/add_product', compact('networks', 'types', 'payment_terms', 'devices', 'categories', 'countries', 'trafficTypes', 'errors'), true);
    $this->load->view('advertiser/default/vindex', compact('content', 'advertiser'));
  }

  public function update_product_form($id)
  {
    $networks = $this->Home_model->get_data('network', ['show' => 1, 'adv_id' => $this->session->userdata('user')->id]);

    if (!$networks) {
      $networks = $this->Home_model->get_data('network', ['show' => 1, 'title' => $this->session->userdata('user')->username]);
    }

    $types = $this->Home_model->get_data('offertype', ['show' => 1]);
    $payment_terms = $this->Home_model->get_data('paymterm', ['show' => 1]);
    $devices = $this->Home_model->get_data('device', ['show' => 1]);
    $categories = $this->Home_model->get_data('offercat', ['show' => 1]);
    $countries = $this->Home_model->get_data('country', ['show' => 1]);
    $udi =  $this->session->userdata('user')->id;
    $product = $this->db->get_where('offer', ['is_adv' => $this->session->userdata('user')->id, 'id' => $id])->row();
    $trafficTypes = $this->Custom_model->get_list_by_type(ThemeService::REGISTER_PAGE);

    if ($this->is_method_post() && $this->input->is_ajax_request()) {
      $is_validated = $this->validate_upsert_product();
      if ($is_validated) {
        echo $this->update_product($id);
      } else {
        echo validation_errors();
      }
      return;
    }

    $content = $this->load->view('advertiser/offers/update_product', compact('networks', 'types', 'payment_terms', 'devices', 'categories', 'countries', 'product', 'trafficTypes'), true);
    $this->load->view('advertiser/default/vindex', compact('content', 'advertiser'));
  }

  private function insert_product()
  {
    /* 1. Chuẩn bị data để insert */
    $data = $this->input->post();
    $data['point_geos'] = serialize($data['point_geos']);
    $data['percent_geos'] = serialize($data['percent_geos']);

    if (!empty($data['country'])) {
      $data['country'] = 'o' . implode('o', $data['country']) . 'o';
    } else {
      $data['country'] = 'o';
    }

    if (!empty($data['offercat'])) {
      $data['offercat'] = array_unique($data['offercat']);
      $data['offercat'] = 'o' . implode('o', $data['offercat']) . 'o';
    } else {
      $data['offercat'] = 'o';
    }

    /* 2. Xử lý vấn đề network */
    @$netdt = $this->Home_model->get_one('network', array('id' => $data['idnet']));

    if (empty($netdt)) {
      $adv_name = $this->session->userdata('user')->username;

      if (!empty($adv_name)) {
        $title = $adv_name;
      } else {
        $title = $data['idnet'];
      }

      $this->db->insert('network', ['title' => $title]);
      $inserted_network = $this->db->insert_id();
      @$netdt = $this->Home_model->get_one('network', array('id' => $inserted_network));
    }

    $data['idnet'] = $netdt->id;
    $pbv_array = unserialize($netdt->pb_value);
    unset($pbv_array['4']);
    unset($pbv_array['5']);
    $data['subid'] = $netdt->subid;
    $data['point'] = 0;
    $data['preview'] = serialize($data['preview']);
    $data['landingpage'] = serialize($data['landingpage']);
    $data['traffic_source'] = join(',', $data['traffic_source']);
    $data['restriced_traffics'] = join(',', $data['restriced_traffics']);

    if (empty($data['percent'])) {
      $data['percent'] = 0;
    }

    $data['is_adv'] = $this->session->userdata('user')->id;

    $inserted = $this->Advertiser_model->add_product($data);

    if ($inserted) {
      return 1;
    } else {
      return 'Error when inserting';
    }
  }

  public function update_product($product_id)
  {
    $data = $this->input->post();
    $data['point_geos'] = serialize($data['point_geos']);
    $data['percent_geos'] = serialize($data['percent_geos']);

    if (!empty($data['country'])) {
      $data['country'] = 'o' . implode('o', $data['country']) . 'o';
    } else {
      $data['country'] = 'o';
    }

    if (!empty($data['offercat'])) {
      $data['offercat'] = array_unique($data['offercat']);
      $data['offercat'] = 'o' . implode('o', $data['offercat']) . 'o';
    } else {
      $data['offercat'] = 'o';
    }

    @$netdt = $this->Home_model->get_one('network', array('id' => $data['idnet']));

    $pbv_array = unserialize($netdt->pb_value);
    unset($pbv_array['4']);
    unset($pbv_array['5']);
    $data['subid'] = $netdt->subid;
    $data['point'] = 0;

    if (empty($data['percent'])) {
      $data['percent'] = 0;
    }

    $data['is_adv'] = $this->session->userdata('user')->id;
    $data['preview'] = serialize($data['preview']);
    $data['landingpage'] = serialize($data['landingpage']);
    $data['traffic_source'] = join(',', $data['traffic_source']);
    $data['restriced_traffics'] = join(',', $data['restriced_traffics']);

    if ($this->Advertiser_model->update_product($product_id, $data)) {
      return 1;
    } else {
      return 'Nothing to update';
    }
  }

  public function my_product($page = 0)
  {
    $limit_page = 15;
    $start_offset = $page * $limit_page;

    /** Get Banners */
    $banners = $this->get_banners();
    $left_banners = isset($banners['left']) ? $banners['left'] : '';
    $right_banners = isset($banners['right']) ? $banners['right'] : '';

    /** Get Offers */
    list($products, $total) = $this->Advertiser_model->get_own_products($start_offset, $limit_page);
    $data['offer'] = $products;
    $data['final_page'] = ($start_offset + count($products)) >= $total;
    $this->total_rows = round($total);

    /** Other */
    $data['category'] = $this->Home_model->get_data('offercat', array('show' => 1));
    $data['country'] = $this->Home_model->get_data('country', array('show' => 1));
    $data['paymterm'] = $this->Home_model->get_data('paymterm', array('show' => 1));
    $data['types'] = $this->Home_model->get_data('offertype', array('show' => 1));
    $data['totals'] = $this->total_rows;
    $data['left_banners'] = $left_banners;
    $data['right_banners'] = $right_banners;

    if ($start_offset >= 1) {
      $content = $this->load->view('advertiser/offers/ajax/more_offer.php', $data, true);
      echo $content;
      return;
    }

    $content = $this->load->view('advertiser/offers/my_product.php', $data, true);
    return $this->load->view('advertiser/default/vindex.php', array('content' => $content));
  }

  public function update_status()
  {
    if (!$this->is_method_post() || !$this->input->is_ajax_request()) {
      throw new Exception('Method does not supported');
    }

    $offer_id = $this->input->post('offer_id');
    $isShow = $this->input->post('show');
    $this->db->where('id', $offer_id);
    $this->db->update('offer', ['show' => $isShow]);

    echo $this->db->affected_rows() > 0;
  }

  public function request_product($offset = 1)
  {
    $result = $this->Request_Product_model->getAdvProductPending($this->per_page, $offset, $this->session->userdata('user')->id);
    $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/');
    $this->handlePagination($result['total_rows']);
    $content =  $this->load->view('products/list', array('data' => $result['data'], 'pagination' => [
      'page' => $offset,
      'total_page' => ceil($result['total_rows'] / $this->per_page),
      'next_link' => $this->base_url_trang . '/' . ($offset + 1),
      'prev_link' => $this->base_url_trang . '/' . ($offset - 1),
      'base_link' => $this->base_url_trang,
    ]), true);

    return $this->load->view('advertiser/default/vindex.php', array('content' => $content));
  }

  public function add_request_product()
  {
    if ($this->is_method_post()) {
      $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[255]|xss_clean');
      $this->form_validation->set_rules('preview_link', 'Preview Link', 'trim|required|max_length[255]|valid_url|xss_clean');
      $this->form_validation->set_rules('payout', 'Payout', 'trim|required|integer|max_length[11]|xss_clean');
      $this->form_validation->set_rules('image_url', 'Image Url', 'trim|required|max_length[255]|valid_url|xss_clean');
      $data = $this->security->xss_clean($_POST);

      if ($this->form_validation->run() == TRUE) {
        $this->Request_Product_model->add([
          "name" => $data['name'],
          "preview_link" => $data['preview_link'],
          "payout" => $data['payout'],
          "image_url" => $data['image_url'],
          "created_by" => $this->session->userdata('userid'),
          "updated_by" => $this->session->userdata('userid'),
          "created_at" => date('Y-m-d H:i:s', time()),
          "updated_at" => date('Y-m-d H:i:s', time()),
          "is_adv" => $this->session->userdata('user')->id
        ]);
        echo json_encode(array('error' => false, 'data' => null));
        return;
        // }
      } else {
        $errors = array(
          "name" => form_error('name'),
          "preview_link" => form_error('preview_link'),
          "payout" => form_error('payout'),
          "image_url" => form_error('image_url'),
        );

        echo json_encode(array('error' => true, 'data' => $errors));
        return;
      }
    } else {
      echo "Method not allow";
    }
  }

  private function validate_upsert_product()
  {
    $geos = $this->input->post('point_geos');
    $percent_geos = $this->input->post('percent_geos');

    foreach ($percent_geos as $key => $value) {
      if ($value != '') {
        $this->form_validation->set_rules("percent_geos[$key]", "Percent of $key", "numeric");
      }
    }

    foreach ($geos as $key => $geo_percent) {
      if ($geo_percent != '') {
        $this->form_validation->set_rules("point_geos[$key]", "Payout of $key", "numeric");
      }
    }

    $this->form_validation->set_rules('title', 'Product Name', 'trim|required|xss_clean');

    $adv_data = $this->Home_model->get_one('advertiser', array('id' => $this->session->userdata('user')->id));
    $has_affiliate_program = 0;

    if (!empty($adv_data->user_setting)) {
      $user_setting = @unserialize($adv_data->user_setting);
      if (is_array($user_setting) && isset($user_setting['has_affiliate_program'])) {
        $has_affiliate_program = $user_setting['has_affiliate_program'];
      }
    }

    if ($has_affiliate_program == 1) {
      $this->form_validation->set_rules('idnet', 'Network', 'trim|required|xss_clean');
    }

    $this->form_validation->set_rules('paymterm_calc', 'Payment Term', 'trim|required|xss_clean');
    $this->form_validation->set_rules('device', 'Device', 'trim|required|xss_clean');
    $this->form_validation->set_rules('url', 'Track link', 'trim|regex_match[/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/]');
    $this->form_validation->set_rules('preview[0][name]', 'Preview Product Name', 'trim|required|xss_clean');
    $this->form_validation->set_rules('preview[0][value]', 'Preview Product Link', 'trim|required|xss_clean');
    $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
    $this->form_validation->set_rules('convert_on', 'Conversion Flow', 'trim|required|xss_clean');
    $this->form_validation->set_rules('type', 'Product Type', 'trim|required|xss_clean');
    $this->form_validation->set_rules('traffic_source', 'Allowed Traffic Sources', 'required|xss_clean');
    $this->form_validation->set_rules('restriced_traffics', 'Restricted Traffic Sources', 'required|xss_clean');
    $this->form_validation->set_rules('country', 'Product Geo and Payout Attached', 'required|xss_clean');
    $this->form_validation->set_rules('offercat', 'Product Category', 'required|xss_clean');
    $this->form_validation->set_rules('agree_with_term', 'Please agree with term', 'trim|required|xss_clean');
    return $this->form_validation->run();
  }
}
