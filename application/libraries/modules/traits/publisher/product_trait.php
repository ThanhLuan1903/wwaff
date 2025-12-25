<?php

trait Publisher_ProductTrait
{

  private function get_banners()
  {
    $left = $this->Home_model->get_data('banners', ['show' => 1, 'is_adv' => 0, 'location' => "Left"], null, ['position', 'asc']);
    $right = $this->Home_model->get_data('banners', ['show' => 1, 'is_adv' => 0, 'location' => "Right"], null, ['position', 'asc']);
    return compact('left', 'right');
  }

  private function get_titles()
  {
    $left = $this->Home_model->get_one('custom_features', ['type' => ThemeService::TITLE_BANNER_LEFT]);
    $right = $this->Home_model->get_one('custom_features', ['type' => ThemeService::TITLE_BANNER_RIGHT]);
    return compact('left', 'right');
  }

  public function add_product()
  {
    return redirect('v2');
  }

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

  public function request_product($offset = 1)
  {
    $result = $this->Request_Product_model->getProductPending($this->per_page, $offset, $this->session->userdata('userid'));
    $this->base_url_trang = base_url($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/');
    $this->handlePagination($result['total_rows']);
    $content =  $this->load->view('products/list', array('data' => $result['data'], 'pagination' => [
      'page' => $offset,
      'total_page' => ceil($result['total_rows'] / $this->per_page),
      'next_link' => $this->base_url_trang . '/' . ($offset + 1),
      'prev_link' => $this->base_url_trang . '/' . ($offset - 1),
      'base_link' => $this->base_url_trang,
    ]), true);
    $this->load->view('default/vindex.php', ['content' => $content]);
  }

  public function add_request_product()
  {
    $is_post_method = $this->input->server('REQUEST_METHOD') === 'POST';
    if ($is_post_method) {
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
          // "image_url" => $check_upload['path'],
          "image_url" => $data['image_url'],
          "created_by" => $this->session->userdata('userid'),
          "updated_by" => $this->session->userdata('userid'),
          "created_at" => date('Y-m-d H:i:s', time()),
          "updated_at" => date('Y-m-d H:i:s', time()),
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

  public function my_product($page = 0)
  {
    $uid = $this->member->id;
    $start_offset = $page * 12;
    $end_offset = $start_offset + 12;

    /** Get Banners */
    $banners = $this->get_banners();
    $left_banners = $banners['left'];
    $right_banners = $banners['right'];

    $titles = $this->get_titles();
    $left_title = $titles['left'];
    $right_title = $titles['right'];

    /** Get Offers */
    $get_offers = $this->Offer_model->get_available_offers($uid, $start_offset, $end_offset);
    $data['offer'] = $get_offers['offers'];
    $data['final_page'] = (round($get_offers['count'] / $this->per_page) + 1) == $page;
    $this->total_rows = $get_offers['count'];

    /** Other */
    $data['category'] = $this->Home_model->get_data('offercat', array('show' => 1));
    $data['country'] = $this->Home_model->get_data('country', array('show' => 1));
    $data['paymterm'] = $this->Home_model->get_data('paymterm', array('show' => 1));
    $data['types'] = $this->Home_model->get_data('offertype', array('show' => 1));
    $data['totals'] = $this->total_rows;
    $data['left_banners'] = $left_banners;
    $data['right_banners'] = $right_banners;
    $data['left_title'] = $left_title;
    $data['right_title'] = $right_title;

    if ($start_offset >= 1) {
      $content = $this->load->view('offers/ajax/lazy_offers.php', $data, true);
      echo $content;
    } else {
      $content = $this->load->view('offers/list_offers.php', $data, true);
      return $this->load->view('default/vindex.php', array('content' => $content));
    }
  }
}
