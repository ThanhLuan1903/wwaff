<?php

trait Publisher_Statistic_Trait
{
  private function getLeadCondition()
  {
    return "((t1.date < '2025-11-01') OR (t1.date >= '2025-11-01' AND t1.amount2 > 0))";
  }

  public function stastic_conversion($offset = 0, $limit = 50)
  {
    $limit = 50;
    $page = $this->uri->segment(4);
    if ($page) {
      $offset = $page;
    }

    $data = $this->locdulieu();
    $where = $data['where'];
    $leadCond = $this->getLeadCondition();
    $data['to'] = date('Y-m-d', strtotime('-1 day', strtotime($data['to'])));
    $qr = "SELECT t1.*,cpalead_offer.confirm_date, cpalead_offer.hold_period, cpalead_offer.paymterm_calc,
           case when (SELECT COUNT(*) FROM cpalead_tracklink
               WHERE userid = t1.userid
               AND offerid = t1.offerid
               AND ip = t1.ip
               AND flead = 1
               AND smartlink = 0
               AND smartoff = 0
           ) > 1 THEN 1 ELSE 0 END as duplicate_ip,
           case when (SELECT COUNT(*) FROM cpalead_tracklink
               WHERE offerid = t1.offerid
               AND userid = t1.userid
               AND device_model = t1.device_model
               AND useragent = t1.useragent
               AND flead = 1
               AND smartlink = 0
               AND smartoff = 0
           ) > 1 then 1 else 0 END as duplicate_device,
           case when (SELECT COUNT(*) FROM cpalead_tracklink
               WHERE offerid = t1.offerid
               AND userid = t1.userid
               AND user_language is not null
               AND (lower(user_language) not like concat('%', lower(countries), '%') 
               AND user_language <> '*')
               AND flead = 1
               AND smartlink = 0
               AND smartoff = 0
           ) > 1 then 1 else 0 END as diff_language
           FROM `cpalead_tracklink` t1
           INNER JOIN cpalead_offer on cpalead_offer.id = t1.offerid
           WHERE t1.userid = ? AND date(t1.date) BETWEEN ? AND ?
           AND t1.flead = 1
           AND $leadCond
           $where
           ORDER BY t1.date DESC, t1.id DESC
           LIMIT $offset, $limit";

    $data['data'] = $this->db->query($qr, [$this->member->id, $data['from'], $data['to']])->result();

    $count_qr = "SELECT COUNT(*) as total FROM cpalead_tracklink t1
                 WHERE t1.userid=? AND t1.flead=1 AND date(t1.date) BETWEEN ? AND ? AND $leadCond $where";
    $this->total_rows = $this->db->query($count_qr, [$this->member->id, $data['from'], $data['to']])->row()->total;
    $this->pagina_uri_seg = 4;
    $this->pagina_baseurl = base_url() . 'v2/statistics/conversions/';
    $this->per_page       = $limit;
    $this->phantrang_statistic();

    $data['total_rows']   = $this->total_rows;
    $data['showing_from'] = $offset + 1;
    $data['showing_to']   = min($offset + $limit, $this->total_rows);

    $content = $this->load->view('statistics/conversions.php', $data, true);
    $this->load->view('default/vindex.php', ['content' => $content]);
  }

  private function convertStringLineToArray($data)
  {
    return explode("\n", str_replace("\r", "", $data));
  }

  private function convertArrToSqlstring($array)
  {
    $result = '';

    foreach ($array as $key => $values) {
      if ($result !== '') {
        $result .= ' AND ';
      }
      $valuesString = '(' . implode(', ', $values) . ')';
      $result .= "t1.{$key} in $valuesString";
    }
    return $result;
  }

  public function stastic_clicks($offset = 0, $limit = 50)
  {
    if ($_POST) {
      $this->handlePostData();
    }

    if (!$this->session->userdata('from')) {
      $from = date('Y-m-d', time());
      $this->session->set_userdata('from', $from);
    } else {
      $from = $this->session->userdata('from');
    }
    if (!$this->session->userdata('to')) {
      $to = date('Y-m-d', time());
      $this->session->set_userdata('to', $to);
    } else {
      $to = $this->session->userdata('to');
    }

    $leadCond = $this->getLeadCondition();
    $whereIn = [];
    if ($this->session->userdata('clickid')) {
      $clickid = $this->session->userdata('clickid');
      $clickid = $this->convertStringLineToArray($clickid);
      $whereIn['id'] = $clickid;
    }
    if ($this->session->userdata('sOffer')) {
      $oid = $this->session->userdata('sOffer');
      $oid = $this->convertStringLineToArray($oid);
      $whereIn['offerid'] = $oid;
    }
    if ($this->session->userdata('ips')) {
      $ips = $this->session->userdata('ips');
      $ips = $this->convertStringLineToArray($ips);
      $whereIn['ip'] = $ips;
    }
    
    $where = '';
    if ($whereIn) $where = ' AND ' . $this->convertArrToSqlstring($whereIn);
    $qr = "SELECT t1.*,
                case when (SELECT COUNT(*) FROM cpalead_tracklink
                                          WHERE userid = t1.userid
                                          AND offerid = t1.offerid
                                          AND ip = t1.ip
                                          AND flead = 1
                                          AND smartlink = 0
                                          AND smartoff = 0
                                          ) > 1 THEN 1 ELSE 0 END as duplicate_ip,
              case when (SELECT COUNT(*) FROM cpalead_tracklink
                          WHERE offerid = t1.offerid
                            AND userid = t1.userid
                            AND device_model = t1.device_model
                            AND useragent = t1.useragent
                            AND flead = 1
                            AND smartlink = 0
                            AND smartoff = 0
                        ) > 1 then 1 else 0 END as duplicate_device,
                case when (SELECT COUNT(*) FROM cpalead_tracklink
                            WHERE offerid = t1.offerid
                            AND userid = t1.userid
                            AND user_language is not null
                            AND (lower(user_language) not like concat('%', lower(countries), '%') AND user_language <> '*')
                            AND flead = 1
                            AND smartlink = 0
                            AND smartoff = 0
                ) > 1 then 1 else 0 END as diff_language
            FROM `cpalead_tracklink` t1
            INNER JOIN cpalead_offer on cpalead_offer.id = t1.offerid
            WHERE userid = ? AND date(date) BETWEEN ? AND ?
            AND $leadCond
            $where
            ORDER BY `id` DESC
            LIMIT $offset, $limit";
    $data['data'] = $this->db->query($qr, array($this->member->id, $from, $to))->result();
    //phan trang
    $qr  = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` t1 WHERE t1.userid=? AND t1.flead=1 AND date(date) BETWEEN ? AND ? AND $leadCond $where";
    $this->total_rows = $this->db->query($qr, array($this->member->id, $from, $to))->row()->total;
    $this->pagina_uri_seg = 4;
    $this->pagina_baseurl =  base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/';
    $this->phantrang();
    //end phan trangs        
    $content = $this->load->view('statistics/clicks.php', $data, true);
    $this->load->view('default/vindex.php', array('content' => $content));
  }

  private function handlePostData()
  {
    $uri = $this->session->userdata('uri');
    if ($this->input->post('reset') || $uri != $this->uri->segment(3)) {
      $this->session->set_userdata('uri', $this->uri->segment(3));
      $this->session->unset_userdata('dtfrom');
      $this->session->unset_userdata('dtto');
      $this->session->unset_userdata('clickid');
      $this->session->unset_userdata('sOffer');
      $this->session->unset_userdata('ips');
    } else {
      $sdate = $this->input->post('sdate', true);
      $ips  = $this->input->post('ips');
      $dtcheckdup  = $this->input->post('dtcheckdup');
      $useragent  = $this->input->post('useragent');
      if ($sdate) {
        $date = explode('-', $sdate);
        $from = trim($date[0]);
        $to   = trim($date[1]);
      }
      $this->session->set_userdata('dtfrom', $from);
      $this->session->set_userdata('dtto', $to);
      $this->session->set_userdata('clickid', $this->input->post('clickid', true));
      $this->session->set_userdata('sOffer', $this->input->post('sOffer', true));
      $this->session->set_userdata('ips', $ips);
    }
  }

  private function locdulieu()
  {
    $dt = '';
    $uri = trim($this->uri->segment(3));
    if ($uri != 'smartlinks' && $uri != 'smlinks_convert' && $uri != 'smartoffers' && $uri != 'smoffers_convert') {
      $dt = ' AND t1.smartlink =0 AND t1.smartoff=0';
    }

    $ct = $this->session->userdata('sCountry');
    if ($ct) {
      $dt .=  " AND t1.countries IN ('" . implode("','", $ct) . "')";
    }

    $soff = $this->session->userdata('sOffer');
    if ($soff) {
      $dt .=  " AND t1.offerid IN ('" . implode("','", $soff) . "')";
    }

    $sos = $this->session->userdata('sOs');
    if ($sos) {
      $dt .= " AND t1.os_name IN ('" . implode("','", $sos) . "')";
    }


    $data['where'] = $dt;

    if ($this->session->userdata('from')) {
      $data['from']  = $this->session->userdata('from');
      $data['to']  = $this->session->userdata('to');
    } else {
      $data['from']   = date("Y-m-d", strtotime('6 days ago'));
      $data['to']  = date("Y-m-d");
      $this->session->set_userdata('from', $data['from']);
      $this->session->set_userdata('to', $data['to']);
    }
    $data['to'] = date('Y-m-d', strtotime('+1 day', strtotime($data['to'])));
    $qr = "SELECT offerid,oname FROM `cpalead_tracklink`  WHERE userid=? and date(date) BETWEEN ? AND ?  group by offerid";
    $data['soffer'] = $this->db->query($qr, array($this->member->id, $data['from'], $data['to']))->result();

    $qr = "SELECT os_name FROM `cpalead_tracklink`  WHERE userid=? and date(date) BETWEEN ? AND ?  group by os_name";
    $data['os_name'] = $this->db->query($qr, array($this->member->id, $data['from'], $data['to']))->result();
    $data['country'] = $this->Home_model->get_data('country', array('show' => 1));

    return $data;
  }

  public function approve_tracklinks()
  {
    throw new Exception("You don't have permission");
  }

  function phantrang_statistic()
  {
    $this->load->library('pagination');
    $config['base_url'] = $this->pagina_baseurl;
    $config['total_rows'] = $this->total_rows;
    $config['per_page'] = $this->per_page;
    $config['uri_segment'] = 4;
    $config['num_links'] = 6;
    $config['first_link'] = '<<';
    $config['first_tag_open'] = '<li class="firt_pag">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = '>>';
    $config['last_tag_open'] = '<li class="last_pag">';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = '&gt;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '&lt;';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="current">';
    $config['cur_tag_close'] = '</li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $this->pagination->initialize($config);
  }
}
