<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class ExceptionHandler extends CI_Controller
{
    public $pub_config = '';
    private $base_key = '';
    private $redis;

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
        $this->managerid = $this->session->userdata('aduserid');
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
        $this->load->helper(array('timezone'));
    }

    function show_modal()
    {
        $where = $this->security->xss_clean($_POST);
        $data = $this->Admin_model->get_data('exc', $where, array('id', 'DESC'));

        $title = '';

        if (!empty($where) && isset($where['rule_type'])) {
            switch ($where['rule_type']) {
                case 'cr':
                    $title = 'CR Require';
                    break;
                case 'device':
                    $title = 'Request Device';
                    break;
                case 'speed':
                    $title = 'Speed Control';
                    break;
                case 'hours':
                    $title = 'Working Hours';
                    break;
                default:
                    $title = 'Exception';
                    break;
            }
        }

        $view_data = [
            "data" => $data,
            "title" => $title
        ];

        $view = $this->load->view('default/exception_modal', $view_data, true);
        echo $view;
    }

    function save_exce()
    {
        try {
            $data = $this->input->post();

            if (empty($data['pub_id']) || empty($data['offer_id']) || empty($data['rule_type'])) {
                echo json_encode(['status' => 'error']);
                return;
            }

            if (isset($data['sub2']) && empty($data['sub2'])) {
                echo json_encode(['status' => 'error']);
                return;
            }

            $where = [
                'rule_type' => $data['rule_type'],
                'pub_id' => $data['pub_id'],
                'offer_id' => $data['offer_id']
            ];

            if (isset($data['sub2']) && !empty($data['sub2'])) {
                $where['sub2'] = $data['sub2'];
            } else {
                $where['sub2'] = null;
                unset($data['sub2']);
            }

            $existing = $this->db->get_where('exc', $where)->row();

            if ($existing) {
                echo json_encode(['status' => 'duplicate']);
                return;
            }

            $result = $this->db->insert('exc', $data);

            if ($result) {
                $insert_id = $this->db->insert_id();
                echo json_encode(['status' => 'success', 'id' => $insert_id]);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } catch (Exception $e) {
            log_message('error', 'Exception save failed: ' . $e->getMessage());
            echo json_encode(['status' => 'error']);
        }
    }

    function delete_exc()
    {
        try {
            $id = $this->input->post('id');

            if (empty($id)) {
                echo 'error';
                return;
            }

            $existing = $this->db->get_where('exc', ['id' => $id])->row();

            if (!$existing) {
                echo 'not_found';
                return;
            }

            $this->db->where('id', $id);
            $result = $this->db->delete('exc');

            if ($result) {
                echo 'success';
            } else {
                echo 'error';
            }
        } catch (Exception $e) {
            log_message('error', 'Delete exception failed: ' . $e->getMessage());
            echo 'error';
        }
    }

    function show_capModal()
    {
        $period = $this->input->post('period');
        $offer_id = $this->input->post('offer_id');
        $conditions = [
            'offer_id' => $offer_id,
            'period'   => $period
        ];

        $this->db->select('*');
        $this->db->where($conditions);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get('exccap')->result_array();

        $data = [
            'exceptions' => $result,
            'period'     => $period
        ];

        $view = $this->load->view('default/capException_modal', $data, true);
        echo $view;
    }

    function save_cappub()
    {
        try {
            $data = $this->input->post();

            if (empty($data['pub_id']) || empty($data['custom_cap']) || empty($data['offer_id'])) {
                echo json_encode(['status' => 'error']);
                return;
            }

            $condition = [
                'pub_id' => $data['pub_id'],
                'offer_id' => $data['offer_id'],
                'period' => $data['period']
            ];

            if ($data['s2'] == 0 || $data['s2'] == '') {
                $this->db->where('s2 IS NULL', null, false);
            } else {
                $condition['s2'] = $data['s2'];
            }

            $this->db->where($condition);
            $existing = $this->db->get('exccap')->row();

            if ($existing) {
                echo json_encode(['status' => 'duplicate']);
                return;
            }

            $insert_data = [
                'pub_id' => $data['pub_id'],
                'offer_id' => $data['offer_id'],
                'custom_cap' => $data['custom_cap'],
                'period' => $data['period'],
                's2' => !empty($data['s2']) ? $data['s2'] : null,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->db->insert('exccap', $insert_data);

            if ($result) {
                $insert_id = $this->db->insert_id();
                $s2_display = !empty($data['s2']) ? $data['s2'] : 'All';

                $html = "<tr data-id='" . $insert_id . "'>"
                    . "<td>" . $data['pub_id'] . "</td>"
                    . "<td>" . $s2_display . "</td>"
                    . "<td>" . $data['custom_cap'] . "</td>"
                    . "<td><button type='button' class='remove-cap-btn btn btn-xs btn-danger'>Remove</button></td>"
                    . "</tr>";

                echo json_encode(['status' => 'success', 'html' => $html]);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } catch (Exception $e) {
            log_message('error', 'Cap exception save failed: ' . $e->getMessage());
            echo json_encode(['status' => 'error']);
        }
    }

    function delete_exccap()
    {
        try {
            $id = $this->input->post('id');
            $sub2 = $this->input->post('sub2');
            $period = $this->input->post('period');

            if (empty($id)) {
                echo 'error';
                return;
            }

            $this->db->where('id', $id);
            $result = $this->db->delete('exccap');

            if ($result) {
                echo 'success';
            } else {
                echo 'error';
            }
        } catch (Exception $e) {
            log_message('error', 'Delete cap failed: ' . $e->getMessage());
            echo 'error';
        }
    }

    function load_thuvien()
    {
        $this->load->helper(array('alias_helper', 'text', 'form'));
        $this->load->model("Admin_model");
    }
}
