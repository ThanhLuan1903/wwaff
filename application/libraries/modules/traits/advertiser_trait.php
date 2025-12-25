<?php


trait AdvertiserTrait
{
  public function get_data_dashboard()
  {
    $this->clear_filter();
    $advertiser = $this->session->userdata('user');
    $data = array();
    $data = $this->get_dashboard_publishers();
    $data['top_10_rewards'] = $this->Home_model->get_data('publisher_top_10_month_rewards', [], null, ['0' => 'ranking', 'ASC']);
    $data['balance_users'] = $this->Admin_model->get_top_10_balance_month();
    $data['custom_sale_rewards'] = $this->get_custom_top_10_sale_rewards();
    $data['sum_sale_rewards'] = $this->sum_rewards($data['top_10_rewards'], 'reward');
    $data['sum_custom_sale_rewards'] = $this->sum_rewards($data['custom_sale_rewards'], 'reward');
    $data['news'] = $this->Home_model->get_data('content', array('show' => 1), array(9), array('id', 'DESC'));
    list($balance, $hold, $available) = $this->get_payments();
    $data['balance'] = $balance;
    $data['hold'] = $hold;
    $data['available'] = $available;
    $data['need_payment'] = $this->Advertiser_model->check_arrive_paymterm($this->session->userdata('user')->id);

    $qr = 'SELECT count(id) as click, sum(flead) as lead, count(DISTINCT ip) as hosts  FROM `cpalead_tracklink`  WHERE userid=? and DATE(date)=?';
    $qq = $this->db->query($qr, array($advertiser->id, date("Y-m-d")));
    if ($qq) {
      $data['dayli_static'] = $qq->row();
    } else {
      $data['dayli_static'] = 0;
    }

    $qr = 'SELECT 
    count(cpalead_tracklink.id) as click, 
    sum(cpalead_tracklink.flead) as lead, 
    SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.amount2 ELSE 0 END) as reve, 
    DATE(cpalead_tracklink.date) as dayli  
    FROM `cpalead_tracklink`
    INNER JOIN cpalead_offer on cpalead_offer.id = cpalead_tracklink.offerid
    WHERE cpalead_offer.is_adv = ? AND cpalead_tracklink.date > DATE_SUB(NOW(), INTERVAL 10 DAY) GROUP BY DATE(cpalead_tracklink.date) ';
    $data['chart'] = $this->db->query($qr, array($this->session->userdata('user')->id, $advertiser->id))->result();
    return $data;
  }

  function get_dashboard_publishers()
  {
    $invited_publishers = $this->Advertiser_model->get_invited_publishers();
    $new_publishers = $this->Advertiser_model->get_new_publishers();

    return compact('invited_publishers', 'new_publishers');
  }

  function get_banners()
  {
    $left_banners = $this->Home_model->get_data('banners', ['show' => 1, 'is_adv' => 1, 'location' => "Left"], null, ['position', 'asc']);
    $right_banners = $this->Home_model->get_data('banners', ['show' => 1, 'is_adv' => 1, 'location' => "Right"], null, ['position', 'asc']);
    return [$left_banners, $right_banners];
  }

  function get_payments()
  {
    $advertiser_id = $this->session->userdata('user')->id;
    $adv_dashboard = $this->Admin_model->get_one('advertiser_dashboard', compact('advertiser_id'));
    return [$adv_dashboard->balance, $adv_dashboard->holding, $adv_dashboard->available];
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

  public function get_publishers($page = 0, $limit = 24, $filters = [])
  {
    $start_offset = $page * $limit;
    $this->db->select("
    cpalead_users.*, cpalead_publisher_rating.rating, 
    cpalead_users_dashboard.level,
    cpalead_users_dashboard.epc,
    cpalead_users_dashboard.conversion_rate,
    (SELECT SUM(rating)/count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as avg_rating,
    (SELECT count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as count_rating,
    (SELECT group_concat(type) from cpalead_offertype WHERE find_in_set(id, cpalead_users.conversion_flow )) as product_type,
    (SELECT group_concat(device) from cpalead_device WHERE find_in_set(id, cpalead_users.traffic_device )) as traffic_device,
    (SELECT group_concat(offercat) from cpalead_offercat WHERE find_in_set(id, cpalead_users.product_categories )) as product_cats,
    (SELECT LOWER(group_concat(keycode)) from cpalead_country WHERE find_in_set(id, cpalead_users.product_geos )) as product_geos,
    (SELECT SUM(amount) from cpalead_invoice WHERE usersid = cpalead_users.id and status = 'Complete') as total_invoice
    ");
    $this->db->from('cpalead_users');
    $this->db->join('cpalead_users_dashboard', 'cpalead_users_dashboard.user_id = cpalead_users.id', 'left');
    $this->db->where('status', 1);

    foreach ($filters as $key => $filter) {
      if ($key == 'search_input' && $filter) {
        $this->db->where("(cpalead_users.id = '$filter' OR cpalead_users.username like '%$filter%' OR cpalead_users.email like '%$filter%' )");
      }

      if ($key == 'offercat' && $filter) {
        $this->db->where("FIND_IN_SET('$filter', product_categories)");
      }

      if ($key == 'countries' && $filter) {
        $query = [];

        foreach ($filter as $country) {
          array_push($query, "FIND_IN_SET('$country', product_geos)");
        }
        $this->db->where("(" . join(" OR ", $query) . ")");
      }

      if ($key == 'offer_type' && $filter) {
        $query = [];

        foreach ($filter as $type) {
          array_push($query, "FIND_IN_SET('$type', conversion_flow)");
        }
        $this->db->where("(" . join(" OR ", $query) . ")");
      }

      if ($key == 'sort-by-id' && $filter) {
        $this->db->order_by('id', $filter);
      }

      if ($key == 'sort-by-rating' && $filter) {
        $this->db->order_by('avg_rating', $filter);
      }

      if ($key == 'sort-by-level' && $filter) {
        $this->db->order_by('level', $filter);
      }

      if ($key == 'sort-by-epc' && $filter) {
        $this->db->order_by('epc', $filter);
      }

      if ($key == 'sort-by-cr' && $filter) {
        $this->db->order_by('conversion_rate', $filter);
      }
    }

    $session_id = $this->session->userdata('user')->id;
    $this->db->join('cpalead_publisher_rating', "cpalead_publisher_rating.publisher_id = cpalead_users.id AND cpalead_publisher_rating.advertiser_id = '$session_id'", 'left');

    $result = $this->db->get();
    $total = $result ? count($result->result()) : 0;
    $query = $this->db->query($this->db->last_query() . " LIMIT $start_offset, $limit");
    return [$query ? $query->result() : null, $total];
  }

  public function clear_filter()
  {
    $this->session->unset_userdata('offercat');
    $this->session->unset_userdata('search_input');
    $this->session->unset_userdata('offer_types');
    $this->session->unset_userdata('countries');
    $this->session->unset_userdata('sort-by-id');
  }
}