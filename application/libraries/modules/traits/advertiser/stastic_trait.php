<?php

trait Advertiser_Statistic_Trait
{
    public function approve_tracklinks()
    {
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');
        if (empty($ids) || empty($status)) {
            return 0;
        }
        $this->db->trans_start();
        if ($status == 1 or $status == 4) {
            $this->db->where('status', 2);
            $this->db->where_in('id', $ids);
            $dt = $this->db->get('tracklink')->result();
            if (!empty($dt)) {
                if ($this->load->controller('proxy_report/updateData', [$dt, 'pending'])) {
                }
            }
            $this->db->where_in('id', $ids);
            $this->db->update('tracklink', ['status' => $status]);
        } else {
            $this->db->select("id, userid, amount2, 1 as status", FALSE);
            $this->db->where_in('status', [1, 4]);
            $this->db->where_in('id', $ids);
            $dt = $this->db->get('tracklink')->result();
            if (!empty($dt)) {
                if ($this->load->controller('proxy_report/updateData', [$dt, 'declined'])) {
                    $this->db->where_in('id', $ids);
                    $this->db->update('tracklink', ['status' => $status]);
                }
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function phantrang()
    {
        $this->load->library('pagination');
        $config['base_url'] = $this->pagina_baseurl;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 3;
        $config['num_links'] = 7;
        $config['first_link'] = '<<';
        $config['first_tag_open'] = '<li class="firt_page">';
        $config['first_tag_close'] = '</li>';
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
        //-----
        $this->pagination->initialize($config);
    }

    public function stastic_clicks($offset = 0, $limit = 50)
    {
        $advId = $this->session->userdata('user')->id;

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
        if ($whereIn) {
            $where = ' AND ' . $this->convertArrToSqlstring($whereIn);
        }

        if (!empty($to) && !empty($from)) {
            $to = date('Y-m-d', strtotime($to . "+1 days"));
            if ($this->session->userdata('dtcheckdup')) {
                $uag = $sqluag = '';
                if ($this->session->userdata('useragent')) {
                    $uag = ',cpalead_tracklink.useragent';
                    $sqluag = ' AND cpalead_tracklink.useragent =tr1.useragent ';
                }
                $qr = "
                SELECT * FROM
                (
                    SELECT COUNT(offerid) as dup,offerid,ip $uag
                    FROM cpalead_tracklink
                    WHERE date BETWEEN  '$from' AND '$to' $where
                    GROUP BY offerid,ip $uag HAVING COUNT(offerid)>1
                ) tr1
                INNER JOIN cpalead_tracklink ON tr1.offerid = cpalead_tracklink.offerid AND cpalead_tracklink.ip =tr1.ip  $sqluag
                ORDER BY cpalead_tracklink.ip,cpalead_tracklink.id  $uag desc
                LIMIT $offset,$this->per_page
            ";
                $data['dulieu'] = $this->db->query($qr)->result();
                $qr = "
            SELECT COUNT(*) as total FROM
                (
                    SELECT COUNT(offerid) as dup,offerid,ip $uag
                    FROM cpalead_tracklink
                    WHERE date BETWEEN  '$from' AND '$to' $where
                    GROUP BY offerid,ip $uag HAVING COUNT(offerid)>1
                ) tr1
                INNER JOIN cpalead_tracklink ON tr1.offerid = cpalead_tracklink.offerid AND cpalead_tracklink.ip =tr1.ip $l

            ";
                $this->total_rows = $this->db->query($qr)->row()->total;
            } else {
                $qr = "
                SELECT cpalead_tracklink.*
                FROM cpalead_tracklink
                INNER JOIN cpalead_network ON cpalead_network.adv_id = $advId AND cpalead_tracklink.idnet = cpalead_network.id
                WHERE date BETWEEN  '$from' AND '$to'  $where
                ORDER BY cpalead_tracklink.id desc
                LIMIT $offset,$limit
            ";
                $data['dulieu'] = $this->db->query($qr)->result();
                $qr = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE date BETWEEN  '$from' AND '$to' $where ";
                $this->total_rows = $this->db->query($qr)->row()->total;
            }
        } else {
            $data['dulieu'] = '';
        }

        $this->pagina_baseurl = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/';
        $this->phantrang();
        $content = $this->load->view('advertiser/statistics/clicks.php', $data, true);
        $this->load->view('advertiser/default/vindex.php', array('content' => $content));
    }

    public function stastic_conversion($offset = 0, $limit = 50, $json = false)
    {
        $data = $this->locdulieu();
        $where = $data['where'];
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
           AND (lower(user_language) not like concat('%', lower(countries), '%') AND user_language <> '*')
           AND flead = 1
           AND smartlink = 0
           AND smartoff = 0
            ) > 1 then 1 else 0 END as diff_language
           FROM `cpalead_tracklink` t1
           INNER JOIN cpalead_offer on cpalead_offer.id = t1.offerid
           WHERE cpalead_offer.is_adv = ? AND date(date) BETWEEN ? AND ?
           AND t1.flead = 1
           $where
           ORDER BY `date` DESC, `id` DESC";

        $data['data'] = $this->db->query($qr, array($this->session->userdata('user')->id, $data['from'], $data['to']))->result();

        $count_qr = "SELECT COUNT(*) as total FROM `cpalead_tracklink` t1 
                 INNER JOIN cpalead_offer on cpalead_offer.id = t1.offerid
                 WHERE cpalead_offer.is_adv = ? AND t1.flead=1 AND date(date) BETWEEN ? AND ? $where";
        $this->total_rows = $this->db->query($count_qr, array($this->session->userdata('user')->id, $data['from'], $data['to']))->row()->total;

        $data['total_rows'] = $this->total_rows;

        if ($json) {
            return $data['data'];
        } else {
            $content = $this->load->view('statistics/conversions.php', $data, true);
            $this->load->view('advertiser/default/vindex.php', array('content' => $content));
        }
    }

    private function convertArrToSqlstring($array)
    {
        $result = '';

        foreach ($array as $key => $values) {
            if ($result !== '') {
                $result .= ' AND ';
            }
            $valuesString = '(' . implode(', ', $values) . ')';
            $result .= "cpalead_tracklink.{$key} in $valuesString";
        }
        return $result;
    }

    private function convertStringLineToArray($data)
    {
        return explode("\n", str_replace("\r", "", $data));
    }

    private function handlePostData()
    {
        $uri = $this->session->userdata('uri');
        if ($this->input->post('reset') || $uri != $this->uri->segment(3)) {

            $this->session->unset_userdata('from');
            $this->session->unset_userdata('to');
            $this->session->unset_userdata('clickid');
            $this->session->unset_userdata('sOffer');
            $this->session->unset_userdata('ips');
            $this->session->set_userdata('uri', $this->uri->segment(3));
        } else {
            $sdate = $this->input->post('sdate', true);
            $ips = $this->input->post('ips');
            $dtcheckdup = $this->input->post('dtcheckdup');
            $useragent = $this->input->post('useragent');
            if ($sdate) {
                $date = explode('-', $sdate);
                $from = trim($date[0]);
                $to = trim($date[1]);
            }
            $this->session->set_userdata('from', $from);
            $this->session->set_userdata('to', $to);
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
            $dt .= " AND t1.countries IN ('" . implode("','", $ct) . "')";
        }

        $soff = $this->session->userdata('sOffer');
        if ($soff) {
            $dt .= " AND t1.offerid IN ('" . implode("','", $soff) . "')";
        }

        $sos = $this->session->userdata('sOs');
        if ($sos) {
            $dt .= " AND t1.os_name IN ('" . implode("','", $sos) . "')";
        }

        $data['where'] = $dt;
        if ($this->session->userdata('from')) {
            $data['from'] = $this->session->userdata('from');
            $data['to'] = $this->session->userdata('to');
        } else {
            $data['from'] = date("Y-m-d", strtotime('6 days ago'));
            $data['to'] = date("Y-m-d");
            $this->session->set_userdata('from', $data['from']);
            $this->session->set_userdata('to', $data['to']);
        }
        $data['to'] = date('Y-m-d', strtotime('+1 day', strtotime($data['to'])));
        return $data;
    }
}
