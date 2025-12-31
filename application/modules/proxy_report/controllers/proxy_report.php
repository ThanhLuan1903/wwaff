<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Proxy_report extends CI_Controller
{ //admin
    private $page_load = '';
    private $databk    = '';
    private $base_url_trang = '#';
    private $total_rows     = 100;
    private $per_page       = 50;
    ///
    public $pub_config = '';
    private $base_key  = '';

    public function __construct()
    {
        parent::__construct();
        $this->load_thuvien();
        $this->base_key = $this->config->item('base_key');
        $this->load->helper(array('excel', 'timezone'));

        if ((!$this->session->userdata('adlogedin') || !$this->session->userdata('aduserid')) && $this->session->userdata('role') != 2) {
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        } else {
            $this->session->set_userdata('upanh', 1);
        }
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->managerid  = $this->session->userdata('aduserid');
        $this->users      = $this->Admin_model->get_one('cpalead_manager', array('id' => $this->session->userdata('aduserid')));
        if ($this->users->parrent > 0) {
            $url = $this->uri->segment(2);
            if ($url == 'rvdata') {
                echo 'Error Permission!!';
                exit();
            }
        }
    }

    public function search()
    {
        $searchSubid  = $this->input->post('searchSubid');
        $uid = array_unique(array_values(array_filter(explode(PHP_EOL, $searchSubid))));
        $ac = $this->input->post('action');
    }

    public function rvdata()
    {
        $ac  = $this->input->post('action');
        $uid = $this->input->post('uid');
        $this->action($ac, $uid);
    }

    public function action($ac, $uid)
    {
        $this->db->trans_strict(FALSE);
        if (!empty($uid)) {
            if ($ac == 'pending') {
                $status = 1;
            } elseif ($ac == 'declined') {
                $status = 2;
            } elseif ($ac == 'pay') {
                $status = 3;
            }
            if ($ac == 'approved') {
                $status = 4;
                $this->db->where('status', 2);
                $this->db->where_in('id', $uid);
                $dt = $this->db->get('tracklink')->result();
                if (!empty($dt)) {
                    $this->updateTransctionData($dt, 'pending');
                }
                $this->db->where_in('id', $uid);
                $this->db->update('tracklink', ['status' => $status]);
            } else {
                $this->db->where(array('status !=' => $status));
                $this->db->where_in('id', $uid);
                $dt = $this->db->get('tracklink')->result();
                $this->updateTransctionData($dt, $ac);
            }
        }
        $this->session->set_userdata('updatedone', '<div class="alert alert-success" role="alert"><a href="#" class="alert-link">Successfully updated</a></div>');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function randomPay($randomPay, $ac)
    {
        if ($ac == 'pending') {
            $status = 1;
        } elseif ($ac == 'declined') {
            $status = 2;
        } elseif ($ac == 'pay') {
            $status = 3;
        }

        $data = $this->getData(null, $status, 1);
        if (!empty($data['dulieu'])) {
            $total_amount = 0;
            $arrData      = array();
            foreach ($data['dulieu'] as $tempdata) {
                $total_amount += $tempdata->amount2;
                if ($total_amount > $randomPay) {
                    if ($ac == 'declined') {
                        $arrData[] = $tempdata;
                    }
                    break;
                }
                $arrData[] = $tempdata;
            }
            $this->updateTransctionData($arrData, $ac);
            $this->session->set_userdata('updatedone', '<div class="alert alert-success" role="alert"><a href="#" class="alert-link">Successfully updated</a></div>');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function updateTransctionData($dt, $ac)
    {
        $this->db->trans_start();
        $this->updateData($dt, $ac);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function updateData($dt, $ac)
    {
        if ($ac == 'pending') {
            if ($dt) {
                $Aruserid = $ArtrackID = array();
                foreach ($dt as $dt) {
                    $avaialbe = $curent = $balance = 0;
                    $curent   = $dt->amount2;
                    if ($dt->status == 3) {
                        $avaialbe = $dt->amount2;
                    } elseif ($dt->status == 2) {
                        $balance = $dt->amount2;
                    }

                    @$Aruserid[$dt->userid]['balance'] += $balance;
                    @$Aruserid[$dt->userid]['curent'] += $curent;
                    @$Aruserid[$dt->userid]['avaialbe'] += $avaialbe;

                    $ArtrackID[$dt->userid][] = $dt->id;
                }
                if ($Aruserid) {
                    foreach ($Aruserid as $Userid => $amount) {
                        $balance  = (float) $amount['balance'];
                        $curent   = (float) $amount['curent'];
                        $avaialbe = (float) $amount['avaialbe'];

                        $this->db->where('id', $Userid)
                            ->set('balance', "balance +$balance", FALSE)
                            ->set('curent', "curent +$curent", FALSE)
                            ->set('available', "available -$avaialbe", FALSE)
                            ->update('users');

                        $pref = $avaialbe * 0.3;
                        $qr   = "
                            UPDATE cpalead_users
                                INNER JOIN cpalead_users t ON cpalead_users.id = t.ref
                                SET cpalead_users.available = cpalead_users.available - $pref
                                WHERE t.id = $Userid
                                ";
                        $this->db->query($qr);
                        $this->db->where_in('id', $ArtrackID[$Userid]);
                        $this->db->update('tracklink', array('status' => 1));
                    }
                }
            }
        } elseif ($ac == 'declined') {
            if ($dt) {
                $Aruserid = $ArtrackID = array();

                foreach ($dt as $dt) {
                    $avaialbe = $curent = $balance = 0;
                    $balance  = $dt->amount2;
                    if ($dt->status == 3) {
                        $avaialbe = $dt->amount2;
                    } elseif ($dt->status == 1) {
                        $curent = $dt->amount2;
                    }

                    @$Aruserid[$dt->userid]['balance'] += $balance;
                    @$Aruserid[$dt->userid]['curent'] += $curent;
                    @$Aruserid[$dt->userid]['avaialbe'] += $avaialbe;

                    $ArtrackID[$dt->userid][] = $dt->id;
                }
                if ($Aruserid) {
                    foreach ($Aruserid as $Userid => $amount) {
                        $balance  = (float) $amount['balance'];
                        $curent   = (float) $amount['curent'];
                        $avaialbe = (float) $amount['avaialbe'];

                        $this->db->where('id', $Userid)
                            ->set('balance', "balance -$balance", FALSE)
                            ->set('curent', "curent -$curent", FALSE)
                            ->set('available', "available -$avaialbe", FALSE)
                            ->update('users');

                        $pref = $avaialbe * 0.3;
                        $qr   = " UPDATE cpalead_users
                                    INNER JOIN cpalead_users t ON cpalead_users.id = t.ref
                                    SET cpalead_users.available = cpalead_users.available - $pref
                                    WHERE t.id = $Userid ";
                        $this->db->query($qr);
                        $this->db->where_in('id', $ArtrackID[$Userid]);
                        $this->db->update('tracklink', array('status' => 2));
                    }
                }
            }
        } elseif ($ac == 'pay') {
            if ($dt) {
                $Aruserid = $ArtrackID = array();
                foreach ($dt as $dt) {
                    $avaialbe = $curent = $balance = 0;

                    $avaialbe = $dt->amount2;
                    if ($dt->status == 2) {
                        $balance = $dt->amount2;
                    } elseif ($dt->status == 1) {
                        $curent = $dt->amount2;
                    }

                    @$Aruserid[$dt->userid]['balance'] += $balance;
                    @$Aruserid[$dt->userid]['curent'] += $curent;
                    @$Aruserid[$dt->userid]['avaialbe'] += $avaialbe;

                    $ArtrackID[$dt->userid][] = $dt->id;
                }
                if ($Aruserid) {
                    foreach ($Aruserid as $Userid => $amount) {
                        $balance  = (float) $amount['balance'];
                        $curent   = (float) $amount['curent'];
                        $avaialbe = (float) $amount['avaialbe'];
                        //update vào user
                        $this->db->where('id', $Userid)
                            ->set('balance', "balance +$balance", FALSE)
                            ->set('curent', "curent -$curent", FALSE)
                            ->set('available', "available +$avaialbe", FALSE)
                            ->update('users');
                        //update cho ref
                        $pref = $avaialbe * 0.3;
                        $qr   = "
                            UPDATE cpalead_users
                                INNER JOIN cpalead_users t ON cpalead_users.id = t.ref
                                SET cpalead_users.available = cpalead_users.available+$pref
                                WHERE t.id = $Userid
                                ";
                        $this->db->query($qr);

                        //update vào tracklink
                        $this->db->where_in('id', $ArtrackID[$Userid]);
                        $this->db->update('tracklink', array('status' => 3));
                    }
                }
            }
        }
    }

    public function index($offset = 0)
    {
        $data = $this->getData($offset);
        // đổi múi giờ chỗ này 
        if ($this->session->userdata('timezone') == 1) {
            foreach ($data['dulieu'] as $conversion) {
                $conversion->date = timestamp_to_gmt5($conversion->date, 'Y-m-d H:i:s');
            }
        }
        $this->renderView($data);
    }

    public function renderView($data)
    {
        $this->total_rows     = $data['totalRows'];
        $this->pagina_uri_seg = 3;
        $this->pagina_baseurl = base_url() . $this->uri->segment(1) . '/';
        $this->phantrang();
        $data['networks'] = $this->Home_model->get_data('network', array(), array(), array('title', 'ASC'));
        $content          = $this->load->view('proxy_report', $data, true);
        if ($this->managerid == 1) {
            $this->load->view('admin/index', array('content' => $content));
        } else {
            $this->load->view('manager/index', array('content' => $content));
        }
    }

    public function exportExcel()
    {
        $alldata = $this->getData();

        if ($this->session->userdata('timezone') == 1) {
            foreach ($alldata['dulieu'] as $conversion) {
                $conversion->date = timestamp_to_gmt5($conversion->date, 'Y-m-d H:i:s');
            }
        }
        if (!empty($alldata['dulieu'])) {
            $data = array();
            foreach ($alldata['dulieu'] as $row) {
                $data[] = (array) $row;
            }

            $column_names = array(
                'ID',
                'S2',
                'User ID',
                'Offer ID',
                'Offer Name',
                'IP',
                'Date',
                'Amount',
                'Fraud Score',
                'Proxy',
                'Referrer',
                'Status',
                'User Language',
                'OS Name',
                'Browser',
                'Device Type',
                'Device Manufacturer'
            );

            export_to_excel(date('Y-m-d') . '_convert_Report.xlsx', $data, $column_names);
        } else {
            echo 'data empty!';
        }
    }

    private function getData($offset = null, $status = Null, $randomOrder = false)
    {
        $data = $this->locdulieu();
        if ($data['timezone'] == 1) {
            $data['from'] = $data['from'] . " 12:00:00";
            $data['to'] = date('Y-m-d', strtotime('+1 day', strtotime($data['to']))) . " 11:59:59";
        } else {
            $data['from'] = $data['from'] . " 00:00:00";
            $data['to'] = $data['to'] . " 23:59:59";
        }

        $where_manager = '';
        $manager_join = '';
        $where = ' AND flead =1 ';
        $where .= " AND ((tl.date < '2025-11-01')OR (tl.date >= '2025-11-01' AND tl.amount3 > 0))";

        if (!empty($data['userid'])) {
            $where .= " AND userid =" . (int)$data['userid'];
        }
        if (!empty($data['offerid'])) {
            $where .= " AND offerid =" . (int)$data['offerid'];
        }
        if (!empty($data['amount2'])) {
            $where .= " AND amount2 >" . (int)$data['amount2'];
        }
        if (!empty($data['fraud_score'])) {
            $where .= " AND fraud_score >" . (int)$data['fraud_score'];
        }
        if (!empty($data['status']) && $data['status'] != 'all') {
            $where .= " AND tl.status = " . (int)$data['status'];
        }

        if (!empty($status)) {
            $where .= " AND tl.status !=" . (int)$status;
        }
        if (!empty($data['network']) && $data['network'] != 'all') {
            $where .= " AND tl.idnet = " . (int)$data['network'];
        }

        if ($this->managerid > 1) {
            $manager_join  = "
                INNER JOIN cpalead_users ON tl.userid = cpalead_users.id
                INNER JOIN cpalead_manager ON cpalead_users.manager = cpalead_manager.id
            ";
        }
        $listSearchUid = $this->session->userdata('listSearchUid');
        $listSearchUid2 = $this->session->userdata('listSearchUid2');
        if (!empty($listSearchUid)) {
            $where .= " AND tl.id IN {$listSearchUid}";
        }
        if (!empty($listSearchUid2)) {
            $where .= " AND tl.s2 IN {$listSearchUid2}";
        }
        if (!is_null($offset)) {
            $limit = " LIMIT $offset,$this->per_page";
        } else {
            $limit = "";
        }

        $duplicateSql = "";
        if (!empty($data['dupips']) && $data['dupips'] == 1) {
            $fr =  $data['from'] . ' 00:00:00';
            $t = $data['to'] . ' 23:59:59';
            $duplicateSql = " AND tl.ip IN (
                SELECT ip
                FROM cpalead_tracklink
                WHERE date BETWEEN '$fr' AND '$t' $where
                GROUP BY ip
                HAVING COUNT(ip) > 1
            )";
            $qr = "
                SELECT tl.id,tl.s2,tl.userid,tl.offerid,tl.oname,tl.ip,tl.date,tl.amount2,tl.amount3,tl.fraud_score,tl.proxy,tl.referrer,tl.countries
                ,tl.status,tl.user_language,tl.os_name,tl.browser,tl.device_type,tl.device_manuf,n.adv_id
                FROM `cpalead_tracklink` tl
                LEFT JOIN cpalead_network n ON tl.idnet = n.id
                $manager_join
                WHERE date BETWEEN ? AND ? $where
                $duplicateSql
                ORDER BY tl.ip, tl.date DESC
                $limit
            ";
        } else {
            $order_by = isset($randomOrder) && $randomOrder ? "ORDER BY RAND()" : "ORDER BY tl.date DESC";
            $qr = "
                    SELECT tl.id,tl.s2,tl.userid,tl.offerid,tl.oname,tl.ip,tl.date,tl.amount2,tl.amount3,tl.fraud_score,tl.proxy,tl.referrer,tl.countries
                    ,tl.status,tl.user_language,tl.os_name,tl.browser,tl.device_type,tl.device_manuf,n.adv_id
                    FROM `cpalead_tracklink` tl
                    LEFT JOIN cpalead_network n ON tl.idnet = n.id
                    $manager_join
                    WHERE date BETWEEN ? AND ? $where
                    $order_by
                    $limit
                ";
        }

        // $data['dulieu'] = $this->db->query($qr, array($data['from'] . " 00:00:00", $data['to'] . " 23:59:59"))->result();
        $data['dulieu'] = $this->db->query($qr, array($data['from'], $data['to']))->result();
        $qr = "
        SELECT COUNT(*) as total  FROM `cpalead_tracklink` tl
        $manager_join
         WHERE date BETWEEN ? AND ? $where $duplicateSql";
        $data['totalRows'] = $this->db->query($qr, array($data['from'] . " 00:00:00", $data['to'] . " 23:59:59"))->row()->total;
        return $data;
    }

    private function convertArrayToString($searchSubid)
    {
        $listSearchUid = array_unique(array_values(array_filter(explode(PHP_EOL, trim($searchSubid)))));
        if (!empty($listSearchUid)) {
            $v = '';
            $ct = count($listSearchUid);
            $i = 0;
            foreach ($listSearchUid as $listSearchUid) {
                $i++;
                $v .= '"' . trim($listSearchUid) . '"';
                if ($i != $ct) {
                    $v .= ',';
                }
            }
            if ($v) {
                $listSearchUid = "({$v})";
            }
        }
        return $listSearchUid;
    }

    public function filtdata()
    {
        if ($_POST['from'] && !empty($_POST['submit'])) {
            $fr = $this->input->post('from');
            $to = $this->input->post('to');
            $offerid = $this->input->post('offerid');
            $userid = $this->input->post('userid');
            $amount2 = $this->input->post('amount2');
            $fraud_score = $this->input->post('fraud_score');
            $status = $this->input->post('status');
            $dupips = $this->input->post('dupips');
            $network = $this->input->post('network');
            $searchSubid = trim($this->input->post('searchSubid'));
            $listSearchUid = $this->convertArrayToString($searchSubid);

            $searchSubid2 = trim($this->input->post('searchSubid2'));
            $listSearchUid2 = $this->convertArrayToString($searchSubid2);

            $timezone = $this->input->post('timezone');
            $this->session->set_userdata('timezone', $timezone);
            if ($fr) {
                $this->session->set_userdata('from', $fr);
            }
            if ($to) {
                $this->session->set_userdata('to', $to);
            }

            if ($listSearchUid) {
                $this->session->set_userdata('searchSubid', $searchSubid);
                $this->session->set_userdata('listSearchUid', $listSearchUid);
            } else {
                $this->session->unset_userdata('listSearchUid');
                $this->session->unset_userdata('searchSubid');
            }
            if ($listSearchUid2) {
                $this->session->set_userdata('searchSubid2', $searchSubid2);
                $this->session->set_userdata('listSearchUid2', $listSearchUid2);
            } else {
                $this->session->unset_userdata('listSearchUid2');
                $this->session->unset_userdata('searchSubid2');
            }

            if ($dupips) {
                $this->session->set_userdata('dupips', $dupips);
            } else {
                $this->session->unset_userdata('dupips');
            }

            if ($userid) {
                $this->session->set_userdata('userid', $userid);
            } else {
                $this->session->unset_userdata('userid');
            }

            if ($offerid) {
                $this->session->set_userdata('offerid', $offerid);
            } else {
                $this->session->unset_userdata('offerid');
            }
            if ($amount2) {
                $this->session->set_userdata('amount2', $amount2);
            } else {
                $this->session->unset_userdata('amount2');
            }
            if ($fraud_score) {
                $this->session->set_userdata('fraud_score', $fraud_score);
            } else {
                $this->session->unset_userdata('fraud_score');
            }
            if ($status == 'all' || $status == '') {
                $this->session->unset_userdata('status');
            } else {
                $this->session->set_userdata('status', $status);
            }
            if ($network == 'all') {
                $this->session->unset_userdata('network');
            } else {
                $this->session->set_userdata('network', $network);
            }
        } elseif (!empty($_POST['reset'])) {
            $this->session->unset_userdata('userid');
            $this->session->unset_userdata('offerid');
            $this->session->unset_userdata('from');
            $this->session->unset_userdata('to');
            $this->session->unset_userdata('amount2');
            $this->session->unset_userdata('fraud_score');
            $this->session->unset_userdata('status');
            $this->session->unset_userdata('listSearchUid');
            $this->session->unset_userdata('dupips');
            $this->session->unset_userdata('network');
            $this->session->unset_userdata('timezone');
        }

        if (!empty($_POST['actionPay'])) {
            $this->randomPay((int)$_POST['randomPay'], $_POST['actionPay']);
        } elseif (!empty($_POST['export'])) {
            $this->exportExcel();
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function locdulieu()
    {
        if ($this->session->userdata('table12') != 'proxy_report') {
            $this->session->set_userdata('table12', 'proxy_report');
            $this->session->unset_userdata('userid');
            $this->session->unset_userdata('offerid');
            $this->session->unset_userdata('from');
            $this->session->unset_userdata('to');
            $this->session->unset_userdata('amount2');
            $this->session->unset_userdata('fraud_score');
            $this->session->unset_userdata('status');
            $this->session->unset_userdata('listSearchUid');
            $this->session->unset_userdata('dupips');
            $this->session->unset_userdata('network');
            $this->session->unset_userdata('timezone');
        }

        if ($this->session->userdata('from')) {
            $data['from']  = $this->session->userdata('from');
            $data['to']  = $this->session->userdata('to');
        } else {
            $data['from'] = date("Y-m-d", strtotime('6 days ago'));
            $data['to']   = date("Y-m-d"); //ngay hoom nay
            $this->session->set_userdata('from', $data['from']);
            $this->session->set_userdata('to', $data['to']);
        }
        $offerid = $this->session->userdata('offerid');
        if ($offerid) {
            $data['offerid'] = $offerid;
        }
        $userid = $this->session->userdata('userid');
        if ($userid) {
            $data['userid'] = $userid;
        }

        $amount2 = $this->session->userdata('amount2');
        if ($amount2) {
            $data['amount2'] = $amount2;
        }

        $fraud_score = $this->session->userdata('fraud_score');
        if ($fraud_score) {
            $data['fraud_score'] = $fraud_score;
        }

        $dupips = $this->session->userdata('dupips');
        if ($dupips) {
            $data['dupips'] = $dupips;
        }

        $status = $this->session->userdata('status');
        if ($status == 'all') {
            unset($data['status']);
        } elseif ($status == 1 || $status == 2 || $status == 3 || $status == 4) {
            $data['status'] = $status;
        } else {
            $data['status'] = '';
        }

        $network = $this->session->userdata('network');
        if ($status == 'all') {
            unset($data['network']);
        } else {
            $data['network'] = $network;
        }

        $timezone = $this->session->userdata('timezone');
        if ($timezone) {
            $data['timezone'] = $timezone;
        }
        return $data;
    }

    public function load_thuvien()
    {
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model("Admin_model");
    }

    public function phantrang()
    {
        $this->load->library('pagination'); // da load ben tren
        $config['base_url'] = $this->pagina_baseurl;
        $config['total_rows'] = $this->total_rows;
        $config['per_page'] = $this->per_page;
        $config['uri_segment'] = 2;
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
        //-----
        $this->pagination->initialize($config);
    }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */