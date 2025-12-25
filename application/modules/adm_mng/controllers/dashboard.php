<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public $pub_config = '';
    function __construct()
    {
        parent::__construct();
        $this->load_thuvien();
        $this->base_key = $this->config->item('base_key');

        if (!$this->session->userdata('adlogedin')) {
            redirect('ad_user');
            $this->inic->sysm();
            exit();
        } else {
            $this->session->set_userdata('upanh', 1);
        }
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
    }

    private function apply_filters($type)
    {
        $this->db->from('error_notis');

        if ($type != 'all') {
            $error_type_map = [
                'device' => 'Duplicate Device',
                'cr' => 'CR Require',
                'ip' => 'Duplicate IP',
                'brower' => 'Unknow Browser'
            ];

            if (isset($error_type_map[$type])) {
                $this->db->where('error_type', $error_type_map[$type]);
            }
        }

        if ($this->session->userdata('error_from')) {
            $this->db->where('violation_time >=', $this->session->userdata('error_from') . ' 00:00:00');
        } else {
            $this->db->where('violation_time >=', date('Y-m-d', strtotime('-7 days')) . ' 00:00:00');
        }

        if ($this->session->userdata('error_to')) {
            $this->db->where('violation_time <=', $this->session->userdata('error_to') . ' 23:59:59');
        } else {
            $this->db->where('violation_time <=', date('Y-m-d') . ' 23:59:59');
        }

        if ($this->session->userdata('error_pubid'))
            $this->db->like('userid', $this->session->userdata('error_pubid'));
        if ($this->session->userdata('error_oid'))
            $this->db->like('offerid', $this->session->userdata('error_oid'));
        if ($this->session->userdata('error_sub2'))
            $this->db->like('sub2', $this->session->userdata('error_sub2'));
        if ($this->session->userdata('error_status') && $this->session->userdata('error_status') != 'all')
            $this->db->where('status', $this->session->userdata('error_status'));
    }


    function show()
    {
        $type = $this->uri->segment(4) ? $this->uri->segment(4) : "all";
        $offset = $this->uri->segment(5) ? $this->uri->segment(5) : 0;

        $this->db->select('*');
        $this->apply_filters($type);
        $rows = $this->db->count_all_results();
        $this->initPagination($rows, $type);

        $this->db->select('*');
        $this->apply_filters($type);
        $this->db->order_by('id', 'DESC');
        $error_notis = $this->db->limit($this->pagination->per_page, $offset)->get()->result_array();
        $error_notis = $this->process_violation_numbering($error_notis);

        $content = $this->load->view('manager/content/report_violation.php', array('dulieu' => $error_notis, 'start_count' => $offset + 1, 'current_type' => $type), true);
        $this->load->view('manager/index', array('content' => $content));
    }

    private function process_violation_numbering($error_notis)
    {
        foreach ($error_notis as &$item) {
            $details = json_decode($item['details'], true);
            if (is_array($details)) {
                $item = array_merge($item, $details);
            }

            $this->db->select('COUNT(*) as total_count');
            $this->db->from('error_notis');
            $this->db->where('offerid', $item['offerid']);
            $this->db->where('userid', $item['userid']);
            $this->db->where('status', $item['status']);
            $this->db->where('error_type', $item['error_type']);

            if (isset($item['sub2']) && !empty($item['sub2'])) {
                $this->db->where('sub2', $item['sub2']);
            } else {
                $this->db->where('(sub2 IS NULL OR sub2 = "")');
            }

            $total_count = $this->db->get()->row()->total_count;

            if ($total_count <= 1) {
                $item['violation_count'] = 1;
                continue;
            }

            $this->db->select('id');
            $this->db->from('error_notis');
            $this->db->where('offerid', $item['offerid']);
            $this->db->where('userid', $item['userid']);
            $this->db->where('status', $item['status']);
            $this->db->where('error_type', $item['error_type']);

            if (isset($item['sub2']) && !empty($item['sub2'])) {
                $this->db->where('sub2', $item['sub2']);
            } else {
                $this->db->where('(sub2 IS NULL OR sub2 = "")');
            }

            $this->db->order_by('id', 'ASC');
            $group_records = $this->db->get()->result_array();
            $violation_mapping = array();
            $violation_number = 1;
            foreach ($group_records as $record) {
                $violation_mapping[$record['id']] = $violation_number;
                $violation_number++;
            }

            $item['violation_count'] = $violation_mapping[$item['id']];
        }

        return $error_notis;
    }

    function search()
    {
        if ($this->input->post('reset')) {
            $this->reset_search();
            return;
        } elseif ($this->input->post('export')) {
            $this->export_excel();
            return;
        } else {
            $this->do_search();
            return;
        }
    }

    private function do_search()
    {
        $current_type = 'all';
        $referer = $this->input->server('HTTP_REFERER');
        if ($referer) {
            if (strpos($referer, '/show/device') !== false) $current_type = 'device';
            elseif (strpos($referer, '/show/cr') !== false) $current_type = 'cr';
            elseif (strpos($referer, '/show/ip') !== false) $current_type = 'ip';
            elseif (strpos($referer, '/show/brower') !== false) $current_type = 'brower';
        }

        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $pubid = $this->input->post('pubid');
        $oid = $this->input->post('oid');
        $status = $this->input->post('status');
        $sub2 = $this->input->post('sub2');

        $this->session->set_userdata('error_from', $from);
        $this->session->set_userdata('error_to', $to);
        $this->session->set_userdata('error_pubid', $pubid);
        $this->session->set_userdata('error_oid', $oid);
        $this->session->set_userdata('error_status', $status);
        $this->session->set_userdata('error_sub2', $sub2);

        $this->db->select('*');
        $this->apply_filters($current_type);
        $rows = $this->db->count_all_results();
        $this->initPagination($rows, $current_type);

        $this->db->select('*');
        $this->apply_filters($current_type);
        $this->db->order_by('id', 'DESC');
        $error_notis = $this->db
            ->limit($this->pagination->per_page, 0)
            ->get()
            ->result_array();

        $error_notis = $this->process_violation_numbering($error_notis);

        $content = $this->load->view(
            'manager/content/report_violation.php',
            array('dulieu' => $error_notis, 'start_count' => 1, 'current_type' => $current_type),
            true
        );
        $this->load->view('manager/index', array('content' => $content));
    }

    private function reset_search()
    {
        $this->session->unset_userdata('error_from');
        $this->session->unset_userdata('error_to');
        $this->session->unset_userdata('error_pubid');
        $this->session->unset_userdata('error_oid');
        $this->session->unset_userdata('error_sub2');
        $this->session->unset_userdata('error_type');
        $this->session->unset_userdata('error_status');

        redirect('manager/dashboard/show');
    }

    private function export_excel()
    {
        $current_type = 'all';
        $referer = $this->input->server('HTTP_REFERER');
        if ($referer) {
            if (strpos($referer, '/show/device') !== false) $current_type = 'device';
            elseif (strpos($referer, '/show/cr') !== false) $current_type = 'cr';
            elseif (strpos($referer, '/show/ip') !== false) $current_type = 'ip';
            elseif (strpos($referer, '/show/brower') !== false) $current_type = 'brower';
        }

        $this->db->select('*');
        $this->apply_filters($current_type);
        $this->db->order_by('id', 'DESC');
        $error_notis = $this->db->get()->result_array();

        $error_notis = $this->process_violation_numbering($error_notis);
        $excel_data = array();
        $index = 1;

        foreach ($error_notis as $item) {
            if ($item['error_type'] == 'Duplicate Device') {
                $detail_col1 = isset($item['os_name']) ? $item['os_name'] : 'N/A';
                $detail_col2 = isset($item['browser']) ? $item['browser'] : 'N/A';
                $detail_col3 = isset($item['browserversion']) ? $item['browserversion'] : 'N/A';
            } elseif ($item['error_type'] == 'Duplicate IP') {
                $detail_col1 = isset($item['ip_address']) ? $item['ip_address'] : 'N/A';
                $detail_col2 = isset($item['duplicate_count']) ? $item['duplicate_count'] : 'N/A';
                $detail_col3 = isset($item['month_period']) ? $item['month_period'] : 'N/A';
            } elseif ($item['error_type'] == 'Unknow Browser') {
                $detail_col1 = isset($item['Browser']) ? $item['Browser'] : 'N/A';
                $detail_col2 = isset($item['OS']) ? $item['OS'] : 'N/A';
                $detail_col3 = 'N/A';
            } else {
                $detail_col1 = isset($item['clicks']) ? $item['clicks'] : 0;
                $detail_col2 = isset($item['leads']) ? $item['leads'] : 0;
                $detail_col3 = isset($item['cr_value']) ? ($item['cr_value'] . '%') : 'N/A';
            }

            $excel_data[] = array(
                $index,
                $item['userid'],
                $item['offerid'],
                isset($item['sub2']) ? $item['sub2'] : 'N/A',
                $item['error_type'],
                $detail_col1,
                $detail_col2,
                $detail_col3,
                ucfirst($item['status']),
                isset($item['violation_time']) ? $item['violation_time'] : 'N/A',
                isset($item['suspension_until']) ? $item['suspension_until'] : 'N/A',
                $item['violation_count']
            );
            $index++;
        }

        $column_names = array(
            'No.',
            'Pub ID',
            'Offer ID',
            'Sub2',
            'Error Type',
            'Detail 1',
            'Detail 2',
            'Detail 3',
            'Status',
            'Violation Time',
            'Suspend Until',
            'Violation Count'
        );

        $type_label = ($current_type == 'all') ? 'All' : ucfirst($current_type);
        $filename = 'Violations_Report_' . $type_label . '_' . date('Y-m-d_H-i-s') . '.xlsx';

        $this->load->helper('excel');
        export_to_excel($filename, $excel_data, $column_names);
    }

    function load_thuvien()
    {
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model("Admin_model");
    }

    function initPagination($row, $type = 'all')
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url('manager/dashboard/show/' . $type);
        $config['total_rows'] = $row;
        $config['per_page'] = 20;
        $config['uri_segment'] = 5;

        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
    }

    function charts()
    {
        // --- Top 10 publishers ---
        $this->db->select('userid, COUNT(*) as violation_count, 
                   SUM(CASE WHEN status = "warning" THEN 1 ELSE 0 END) as warning_count,
                   SUM(CASE WHEN status = "paused" THEN 1 ELSE 0 END) as paused_count');
        $this->db->from('error_notis');

        // Apply date filters if exists
        $date_from = $this->session->userdata('error_from') ?: date('Y-m-d', strtotime('-30 days'));
        $date_to   = $this->session->userdata('error_to') ?: date('Y-m-d');

        $this->db->where('violation_time >=', $date_from . ' 00:00:00');
        $this->db->where('violation_time <=', $date_to . ' 23:59:59');

        $this->db->group_by('userid');
        $this->db->order_by('violation_count', 'DESC');
        $this->db->limit(10);

        $top_publishers = $this->db->get()->result_array();

        // --- Violation types for top publishers ---
        $pub_ids = array_column($top_publishers, 'userid');
        $pub_error_types = [];

        if (!empty($pub_ids)) {
            $this->db->select('userid, error_type, COUNT(*) as count');
            $this->db->from('error_notis');
            $this->db->where_in('userid', $pub_ids);
            $this->db->where('violation_time >=', $date_from . ' 00:00:00');
            $this->db->where('violation_time <=', $date_to . ' 23:59:59');
            $this->db->group_by(['userid', 'error_type']);
            $violations_by_type = $this->db->get()->result_array();

            foreach ($violations_by_type as $v) {
                if (!isset($pub_error_types[$v['userid']])) {
                    $pub_error_types[$v['userid']] = [];
                }
                $pub_error_types[$v['userid']][$v['error_type']] = $v['count'];
            }
        }

        // --- Trend data by day ---
        $this->db->select('DATE(violation_time) as day, COUNT(*) as count');
        $this->db->from('error_notis');
        $this->db->where('violation_time >=', $date_from . ' 00:00:00');
        $this->db->where('violation_time <=', $date_to . ' 23:59:59');
        $this->db->group_by('DATE(violation_time)');
        $this->db->order_by('day', 'ASC');
        $trend_query = $this->db->get()->result_array();

        $trend_labels = array_column($trend_query, 'day');
        $trend_counts = array_column($trend_query, 'count');

        $data = [
            'top_publishers'  => $top_publishers,
            'pub_error_types' => $pub_error_types,
            'date_from'       => $date_from,
            'date_to'         => $date_to,
            'trend_labels'    => $trend_labels,
            'trend_counts'    => $trend_counts
        ];

        $content = $this->load->view('manager/content/violation_charts.php', $data, true);
        $this->load->view('manager/index', ['content' => $content]);
    }

    function contact_list($offset = 0) { 
        $key = $this->input->post('keycode');
        $limit = (int) $this->input->post('show_num');
        
        if (!$limit) {
            $session_limit = $this->session->userdata('limit');
            $limit = isset($session_limit[0]) ? $session_limit[0] : 10;
        }
        
        if (!empty($key)) {
            $this->session->set_userdata('search_key', $key);
        } else {
            $key = $this->session->userdata('search_key');
        }
        
        $this->session->set_userdata('limit', [$limit]);  

        $this->db->select('*')->from('cpalead_contact');
        if (!empty($key)) { 
            $this->db->like('email', $key);
            $this->db->or_like('thongtin', $key);
        }
        $this->db->order_by('id','DESC');
        $query = $this->db->get(NULL, $limit, $offset);
        $data['dulieu'] = $query->result();
        
        $this->db->from('cpalead_contact');
        if (!empty($key)) {
            $this->db->like('email', $key);
            $this->db->or_like('thongtin', $key);
        }
        $total_records = $this->db->count_all_results();
        $data['total_records'] = $total_records;
        $data['search_key'] = $key;
        $data['search_limit'] = $limit;

        // Pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('manager/dashboard/contact');
        $config['total_rows'] = $total_records;
        $config['per_page'] = $limit;
        $config['uri_segment'] = 4;
        $config['use_page_numbers'] = FALSE;
        
        // Style pagination (Bootstrap 3)
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        
        $this->pagination->initialize($config);
        
        $content = $this->load->view('manager/content/contact_listd', $data, true);
        $this->load->view('manager/index', ['content' => $content]);
    }

    function contact() {
        if (empty($this->input->post())) { $this->session->unset_userdata('search_key');}
        $this->contact_list(0);
    }

    function contact_clear() {
        $this->session->unset_userdata(['contact_search_key', 'contact_search_limit']);
        redirect(base_url('manager/dashboard/contact'));
    }
    function contact_detail($id) {
        $data['contact'] = $this->db->get_where('cpalead_contact', ['id' => (int)$id])->row();
        if (!$data['contact']) { show_404(); }

        $content = $this->load->view('manager/content/contact_edit', $data, TRUE);
        $this->load->view('manager/index', ['content' => $content]);
    }

    function contact_delete($id){
        $this->db->where('id', (int)$id)->delete('cpalead_contact');
        redirect('manager/dashboard/contact');
    }
}