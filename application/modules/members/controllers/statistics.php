<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once APPPATH . 'libraries/modules/module.php';

class Statistics extends CI_Controller
{
    private $allchild  = array();
    private $per_page  = 50;
    public $total_rows = 0;
    public $route;

    private $joinWithRole     = '';
    private $filter_with_role = '';
    private $amountColumn     = 'amount2';

    public function __construct()
    {
        parent::__construct();
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));

        if ($this->session->userdata('role') == 1) {
            $table        = 'users';
            $this->is_adv = 0;
        } elseif ($this->session->userdata('role') == 2) {
            $table              = 'advertiser';
            $this->is_adv       = 1;
            $this->amountColumn = 'amount3';
        }
        if ($this->session->userdata('logedin')) {
            $this->db->select($table . '.*,cpalead_api_key.api_key');
            $this->db->from($table);
            $this->db->join('api_key', 'api_key.user_id =' . $table . '.id AND cpalead_api_key.is_adv = ' . $this->is_adv, 'left');
            $this->db->where(array($table . '.id' => $this->session->userdata('userid')));
            $this->member      = $this->db->get()->row();
            $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];
        } elseif ($this->uri->segment(3) != 'in' && $this->uri->segment(3) != 'up') {
            redirect('v2/sign/in');
        }

        $this->joinWithRole     = $this->session->userdata('role') == 2 ? "INNER JOIN cpalead_offer ON cpalead_tracklink.offerid = cpalead_offer.id AND cpalead_offer.is_adv = {$this->session->userdata('user')->id}" : '';
        $this->filter_with_role = $this->session->userdata('role') == 2 ? "" : "cpalead_tracklink.userid={$this->member->id} AND";
    }

    public function index($article_id = 0)
    {
        echo 123;
    }
    private function getLeadCondition()
    {
        return "((cpalead_tracklink.date < '2025-11-01') OR (cpalead_tracklink.date >= '2025-11-01' AND cpalead_tracklink.amount2 > 0))";
    }

    public function dayli()
    {
        $data  = $this->locdulieu();
        $where = $data['where'];
        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.date,
                        count(cpalead_tracklink.id) as click,
                        SUM(CASE WHEN cpalead_tracklink.status=2 THEN 1 ELSE 0 END) as declined,
                        SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as reve,
                        sum(CASE WHEN cpalead_tracklink.flead=1 AND {$this->getLeadCondition()} THEN 1 ELSE 0 END) as lead,count(DISTINCT cpalead_tracklink.ip) as hosts
        FROM `cpalead_tracklink`
        {$this->joinWithRole}
        WHERE {$this->filter_with_role}  date(cpalead_tracklink.date) BETWEEN ? AND ? $where group by DATE(cpalead_tracklink.date)";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/dayli.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function ajax_sub_dayli()
    {
        $date = $this->input->post('date');
        //xử lsy bộ lọc
        $dt = '';
        //lọc theo country
        $ct = $this->session->userdata('sCountry');
        if ($ct) {
            $dt .= " AND cpalead_tracklink.countries IN ('" . implode("','", $ct) . "')";
        }

        //bộ lọc offer sOffer
        $soff = $this->session->userdata('sOffer');
        if ($soff) {
            $dt .= " AND cpalead_tracklink.offerid IN ('" . implode("','", $soff) . "')";
        }
        //bộ lọc OS sOs
        $sos = $this->session->userdata('sOs');
        if ($sos) {
            $dt . " AND cpalead_tracklink.os_name IN ('" . implode("','", $sos) . "')";
        }
        $leadCond = $this->getLeadCondition();
        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.date,
                    count(cpalead_tracklink.id) as click,
                    SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as reve,
                    SUM(CASE WHEN cpalead_tracklink.flead=1 AND {$leadCond} THEN 1 ELSE 0 END) as lead,
                    count(DISTINCT cpalead_tracklink.ip) as hosts
        FROM `cpalead_tracklink`
        {$this->joinWithRole}
        WHERE {$this->filter_with_role} DATE(cpalead_tracklink.date)=?  $dt group by HOUR(cpalead_tracklink.date)";
        $dayli_rp = $this->db->query($qr, array($date))->result();
        if ($dayli_rp) {
            foreach ($dayli_rp as $dayli_rp) {
                echo '
                           <tr role="row" class="_1xlMlIRHcfJahC1c76JzJV sub_dayli_' . $date . '" >
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _1YEl4yCJEz0C3EFWAe9CjL"><span>' . date("H:m", strtotime($dayli_rp->date)) . '</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>' . $dayli_rp->hosts . '</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>' . $dayli_rp->click . '</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>' . $dayli_rp->click . '</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>' . $dayli_rp->lead . '</span></span></td>
                              <td role="cell"><span class="_1zXei-ymiJr9KAeJboeM6O _2qzGcj9CQQHZm8SCJRN_wI"><span>$' . number_format(round($dayli_rp->reve, 2), 2) . '</span></span></td>
                           </tr>
                           ';
            }
        }
    }

    public function getApprovedLead()
    {

        if ($this->is_adv != 1) {
            return;
        }
        $where = ' cpalead_tracklink.adv_pay = ? ';
        $payment_id = $this->input->get_post('payment_id', 0);

        $qr = "
            SELECT cpalead_tracklink.offerid,
            cpalead_tracklink.oname,
            count(cpalead_tracklink.id) as click,
            SUM(CASE WHEN cpalead_tracklink.status=1 THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN cpalead_tracklink.status=2 THEN 1 ELSE 0 END) as declined,
            SUM(CASE WHEN cpalead_tracklink.status=3 THEN 1 ELSE 0 END) as payed,
            SUM(CASE WHEN cpalead_tracklink.status=4 THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as mtotal,
            SUM(CASE WHEN cpalead_tracklink.status=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as mpending,
            SUM(CASE WHEN cpalead_tracklink.status=2 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as mdeclined,
            SUM(CASE WHEN cpalead_tracklink.status=3 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as mpayed,
            SUM(CASE WHEN cpalead_tracklink.status=4 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as mapproved,
            sum(cpalead_tracklink.flead) as lead,
            count(DISTINCT cpalead_tracklink.ip) as hosts
            FROM `cpalead_tracklink`
            {$this->joinWithRole}
            WHERE {$this->filter_with_role} $where
            GROUP BY cpalead_tracklink.offerid
            HAVING SUM(CASE WHEN cpalead_tracklink.status = 4 THEN 1 ELSE 0 END) > 0";
        $data['page'] = 1;
        $data['data'] = $this->db->query($qr, array($payment_id))->result();
        echo json_encode($data);
    }

    public function conversions($offset = 0)
    {

        $this->load->helper('adv_status_convert');
        $route = new Module();
        $route->conversion($offset);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $route->approve_tracklinks();
        }
    }

    public function clicks($offset = 0)
    {

        $route = new Module();
        $route->clicks($offset);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            //$route->approve_tracklinks();
        }
    }

    public function offers($offset = 0)
    {
        $data  = $this->locdulieu();
        $where = $data['where'];

        $leadCond = $this->getLeadCondition();

        $qr = "SELECT cpalead_tracklink.offerid,cpalead_tracklink.oname,
        COUNT(cpalead_tracklink.id) AS click,
        SUM(CASE WHEN (cpalead_tracklink.status=1 AND ($leadCond)) THEN 1 ELSE 0 END) AS pending,
        SUM(CASE WHEN (cpalead_tracklink.status=2 AND ($leadCond)) THEN 1 ELSE 0 END) AS declined,
        SUM(CASE WHEN (cpalead_tracklink.status=3 AND ($leadCond)) THEN 1 ELSE 0 END) AS payed,
        SUM(CASE WHEN (cpalead_tracklink.status=4 AND ($leadCond)) THEN 1 ELSE 0 END) AS approved,
        SUM(CASE WHEN (cpalead_tracklink.flead= 1 AND ($leadCond)) THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) AS mtotal,
        SUM(CASE WHEN (cpalead_tracklink.status=1 AND ($leadCond)) THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) AS mpending,
        SUM(CASE WHEN (cpalead_tracklink.status=2 AND ($leadCond)) THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) AS mdeclined,
        SUM(CASE WHEN (cpalead_tracklink.status=3 AND ($leadCond)) THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) AS mpayed,
        SUM(CASE WHEN (cpalead_tracklink.status=4 AND ($leadCond)) THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) AS mapproved,
        SUM(CASE WHEN ($leadCond) THEN cpalead_tracklink.flead ELSE 0 END) AS lead,
        COUNT(DISTINCT cpalead_tracklink.ip) AS hosts
        FROM cpalead_tracklink
        {$this->joinWithRole}
        WHERE {$this->filter_with_role} DATE(cpalead_tracklink.date) BETWEEN ? AND ? $where GROUP BY cpalead_tracklink.offerid";
        $data['data'] = $this->db->query($qr, [$data['from'], $data['to']])->result();
        $content = $this->load->view('statistics/offers.php', $data, true);
        $this->load->view('default/vindex.php', ['content' => $content]);
    }

    public function browsers()
    {
        $data  = $this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.browser,
                    count(cpalead_tracklink.id) as click,
                    SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as reve,
                    sum(cpalead_tracklink.flead) as lead,
                    count(DISTINCT cpalead_tracklink.ip) as hosts
        FROM `cpalead_tracklink`
        {$this->joinWithRole}
        WHERE {$this->filter_with_role}  date(cpalead_tracklink.date) BETWEEN ? AND ? $where group by cpalead_tracklink.browser";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/browsers.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function smartlinks()
    {
        $data          = $this->locdulieu();
        $where         = $data['where'];
        $queryWithRole = $this->session->userdata('role') == 2 ? "cpalead_offer.is_adv = {$this->session->userdata('user')->id} AND" : "cpalead_tracklink.userid = {$this->member->id} AND";

        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.smartlink,count(cpalead_tracklink.id) as click,SUM(CASE WHEN cpalead_tracklink.status=2 THEN 1 ELSE 0 END) as declined,
                SUM(CASE WHEN cpalead_tracklink.flead=1 THEN amount2 ELSE 0 END) as reve,sum(cpalead_tracklink.flead) as lead,count(DISTINCT cpalead_tracklink.ip) as hosts ,
                cpalead_offer.title as oname
                FROM `cpalead_tracklink`
                LEFT JOIN cpalead_offer ON cpalead_tracklink.smartlink= cpalead_offer.id
                WHERE $queryWithRole cpalead_tracklink.smartlink>0 and  date(cpalead_tracklink.date) BETWEEN ? AND ? $where group by cpalead_tracklink.smartlink";

        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/smartlinks.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function smlinks_convert($offset = 0)
    { //smartlink convert
        $data          = $this->locdulieu();
        $where         = $data['where'];
        $queryWithRole = $this->session->userdata('role') == 2 ? "cpalead_offer.is_adv = {$this->session->userdata('user')->id} AND" : "cpalead_tracklink.userid = {$this->member->id} AND";
        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.* , cpalead_offer.title as smatlink_name
        FROM `cpalead_tracklink`
        LEFT JOIN cpalead_offer ON cpalead_tracklink.smartlink= cpalead_offer.id
        WHERE $queryWithRole cpalead_tracklink.flead=1 AND  date(cpalead_tracklink.date) BETWEEN ? AND ? $where AND cpalead_tracklink.smartlink>0 ORDER BY cpalead_tracklink.id DESC LIMIT $offset,$this->per_page";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();
        //phan trang
        $qr                   = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE userid=? AND flead=1 AND  date(date) BETWEEN ? AND ? $where AND cpalead_tracklink.smartlink>0";
        $this->total_rows     = $this->db->query($qr, array($this->member->id, $data['from'], $data['to']))->row()->total;
        $this->pagina_uri_seg = 4;
        $this->pagina_baseurl = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/';
        $this->phantrang();
        //end phan trangs
        $content = $this->load->view('statistics/smlinks_convert.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function smartoffers()
    {
        $data          = $this->locdulieu();
        $where         = $data['where'];
        $queryWithRole = $this->session->userdata('role') == 2 ? "cpalead_offer.is_adv = {$this->session->userdata('user')->id} AND" : "cpalead_tracklink.userid = {$this->member->id} AND";

        //lấy dữ liệu từ tracklink
        $qr = "
        SELECT cpalead_tracklink.smartoff,
        count(cpalead_tracklink.id) as click,
        SUM(CASE WHEN cpalead_tracklink.status=1 THEN 1 ELSE 0 END) as approved,
        SUM(CASE WHEN cpalead_tracklink.status=2 THEN 1 ELSE 0 END) as declined,
         SUM(CASE WHEN cpalead_tracklink.status=3 THEN 1 ELSE 0 END) as payed,

        SUM(CASE WHEN cpalead_tracklink.flead=1 THEN amount2 ELSE 0 END) as mtotal,
        SUM(CASE WHEN cpalead_tracklink.status=1 THEN amount2 ELSE 0 END) as mpending,
        SUM(CASE WHEN cpalead_tracklink.status=2 THEN amount2 ELSE 0 END) as mdeclined,
        SUM(CASE WHEN cpalead_tracklink.status=3 THEN amount2 ELSE 0 END) as mpayed,
        sum(cpalead_tracklink.flead) as lead,
        count(DISTINCT cpalead_tracklink.ip) as hosts ,
        cpalead_offer.title as oname

        FROM `cpalead_tracklink`
        LEFT JOIN cpalead_offer ON cpalead_tracklink.smartoff= cpalead_offer.id
        WHERE $queryWithRole cpalead_tracklink.smartoff>0 and  date(cpalead_tracklink.date) BETWEEN ? AND ? $where
        group by cpalead_tracklink.smartoff";

        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/smartoffs.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function smoffers_convert($offset = 0)
    { 
        $data          = $this->locdulieu();
        $where         = $data['where'];
        $queryWithRole = $this->session->userdata('role') == 2 ? "cpalead_offer.is_adv = {$this->session->userdata('user')->id} AND" : "cpalead_tracklink.userid = {$this->member->id} AND";
        $qr = "SELECT cpalead_tracklink.* , cpalead_offer.title as smoffers_name
        FROM `cpalead_tracklink`
        LEFT JOIN cpalead_offer ON cpalead_tracklink.smartoff= cpalead_offer.id
        WHERE $queryWithRole cpalead_tracklink.flead=1 AND  date(cpalead_tracklink.date) BETWEEN ? AND ? $where AND cpalead_tracklink.smartoff>0 ORDER BY cpalead_tracklink.id DESC LIMIT $offset,$this->per_page";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $qr                   = "SELECT COUNT(*) as total  FROM `cpalead_tracklink` WHERE userid=? AND flead=1 AND  date(date) BETWEEN ? AND ? $where AND cpalead_tracklink.smartoff>0";
        $this->total_rows     = $this->db->query($qr, array($this->member->id, $data['from'], $data['to']))->row()->total;
        $this->pagina_uri_seg = 4;
        $this->pagina_baseurl = base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/';
        $this->phantrang();
        //end phan trangs
        $content = $this->load->view('statistics/smoffers_convert.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function os()
    {
        $data  = $this->locdulieu();
        $where = $data['where'];

        //lấy dữ liệu từ tracklink
        $qr = "SELECT cpalead_tracklink.os_name,
                    count(cpalead_tracklink.id) as click,
                    SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as reve,
                    sum(cpalead_tracklink.flead) as lead,
                    count(DISTINCT cpalead_tracklink.ip) as hosts
        FROM `cpalead_tracklink`
        {$this->joinWithRole}
        WHERE {$this->filter_with_role}  date(cpalead_tracklink.date) BETWEEN ? AND ? $where group by cpalead_tracklink.os_name";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/os.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function devices()
    {
        $data  = $this->locdulieu();
        $where = $data['where'];

        $qr = "SELECT
            cpalead_tracklink.device_type,
            count(cpalead_tracklink.id) as click,
            SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as reve,
            sum(cpalead_tracklink.flead) as lead,count(DISTINCT cpalead_tracklink.ip) as hosts
        FROM `cpalead_tracklink`
        {$this->joinWithRole}
        WHERE {$this->filter_with_role}  date(cpalead_tracklink.date) BETWEEN ? AND ? $where group by cpalead_tracklink.device_type";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/devices.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function countries()
    {
        $data  = $this->locdulieu();
        $where = $data['where'];

        $qr = "SELECT
        cpalead_tracklink.countries,
        count(cpalead_tracklink.id) as click,
        SUM(CASE WHEN flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as reve,
        sum(cpalead_tracklink.flead) as lead,
        count(DISTINCT cpalead_tracklink.ip) as hosts
        FROM `cpalead_tracklink`
        WHERE {$this->filter_with_role}  date(cpalead_tracklink.date) BETWEEN ? AND ? $where group by cpalead_tracklink.countries";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/countries.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function sub($num = 1)
    {
        $num = (int) $num;
        if ($num < 1 & $num > 6) {
            return;
        }
        $sub         = 's' . $num;
        $data        = $this->locdulieu();
        $where       = $data['where'];
        $data['sub'] = $sub;

        $qr = "SELECT $sub,
        count(cpalead_tracklink.id) as click,
        SUM(CASE WHEN cpalead_tracklink.flead=1 THEN cpalead_tracklink.{$this->amountColumn} ELSE 0 END) as reve,
        sum(cpalead_tracklink.flead) as lead,
        count(DISTINCT ip) as hosts
        FROM `cpalead_tracklink`
        {$this->joinWithRole}
        WHERE {$this->filter_with_role}  date(cpalead_tracklink.date) BETWEEN ? AND ? $where group by $sub";
        $data['data'] = $this->db->query($qr, array($data['from'], $data['to']))->result();

        $content = $this->load->view('statistics/subid.php', $data, true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function locdulieu($type = 0)
    {
        $dt = '';
        $uri = trim($this->uri->segment(3));
        if ($uri != 'smartlinks' && $uri != 'smlinks_convert' && $uri != 'smartoffers' && $uri != 'smoffers_convert') {
            $dt = ' AND cpalead_tracklink.smartlink =0 AND cpalead_tracklink.smartoff=0';
        }

        $ct = $this->session->userdata('sCountry');
        if ($ct) {
            $dt .= " AND cpalead_tracklink.countries IN ('" . implode("','", $ct) . "')";
        }

        $soff = $this->session->userdata('sOffer');
        if ($soff) {
            $dt .= " AND cpalead_tracklink.offerid IN ('" . implode("','", $soff) . "')";
        }
        $sos = $this->session->userdata('sOs');
        if ($sos) {
            $dt . " AND cpalead_tracklink.os_name IN ('" . implode("','", $sos) . "')";
        }

        $data['where'] = $dt;
        if ($this->session->userdata('from')) {
            $data['from'] = $this->session->userdata('from');
            $data['to']   = $this->session->userdata('to');
        } else {
            $data['from'] = date("Y-m-d", strtotime('6 days ago')); 
            $data['to']   = date("Y-m-d"); 
            $this->session->set_userdata('from', $data['from']);
            $this->session->set_userdata('to', $data['to']);
        }
        /* $data['to'] = date('Y-m-d', strtotime('+1 day', strtotime($data['to']))); */
        $qr             = "SELECT offerid,oname FROM `cpalead_tracklink`  WHERE userid=? and  date(date) BETWEEN ? AND ?  group by offerid";
        $data['soffer'] = $this->db->query($qr, array($this->session->userdata('userid'), $data['from'], $data['to']))->result();

        $qr              = "SELECT os_name FROM `cpalead_tracklink`  WHERE userid=? and  date(date) BETWEEN ? AND ?  group by os_name";
        $data['os_name'] = $this->db->query($qr, array($this->session->userdata('userid'), $data['from'], $data['to']))->result();

        $data['country'] = $this->Home_model->get_data('country', array('show' => 1));

        return $data;
    }

    public function ajax_static_dayli()
    {
        $name = $this->input->post('name');
        $gt   = $this->input->post('gt');
        if ($name == 'date') {
            $arr = explode("#", $gt);
            $this->session->set_userdata('from', $arr[0]);
            $this->session->set_userdata('to', $arr[1]);
        } elseif ($name) {
            $this->session->set_userdata($name, $gt);
        }
        echo 1;
    }

    public function nodata()
    {
        $content = $this->load->view('statistics/dayli.php', array(), true);
        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function phantrang()
    {
        $this->load->library('pagination'); // da load ben tren
        $config['base_url']        = $this->pagina_baseurl;
        $config['total_rows']      = $this->total_rows;
        $config['per_page']        = $this->per_page;
        $config['uri_segment']     = $this->pagina_uri_seg;
        $config['num_links']       = 7;
        $config['first_link']      = '<<';
        $config['first_tag_open']  = '<li class="firt_page">'; //div cho chu <<
        $config['first_tag_close'] = '</li>'; //div cho chu <<
        $config['last_link']       = '>>';
        $config['last_tag_open']   = '<li class="last_page">';
        $config['last_tag_close']  = '</li>';
        //-------next-
        $config['next_link']      = 'next &gt;';
        $config['next_tag_open']  = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        //------------preview
        $config['prev_link']      = '&lt; prev';
        $config['prev_tag_open']  = '<li>';
        $config['prev_tag_close'] = '</li>';
        // ------------------cu?npage
        $config['cur_tag_open']  = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        //--so
        $config['num_tag_open']  = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        //-----
        $config['anchor_class'] = 'class="page-link" ';
        $this->pagination->initialize($config);
    }
}
