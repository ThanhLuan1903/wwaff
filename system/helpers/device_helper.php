<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Device_helper
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Admin_model');
    }

    public function check_device($offerid, $pid, $device, $sub2 = null)
    {
        $dev_mode = $this->CI->Admin_model->get_one('dev_set', array('offer_id' => $offerid));

        if (!$dev_mode) {
            $this->CI->db->trans_complete();
            return ['result' => true];
        }

        if (empty($device)) {
            return ['result' => "mobile"];
        }

        $this->CI->db->trans_start();

        $where = array(
            'offer_id' => $offerid,
            'pub_id' => $pid
        );

        if (!empty($sub2)) {
            $where['sub2'] = $sub2;
        } else {
            $where['sub2'] = null;
        }

        $counter = (array)$this->CI->Admin_model->get_one('device_counter', $where);
        $this->CI->db->trans_complete();

        if (!isset($counter['offer_id'])) {
            $counter = ['total' => 0, 'desk' => 0, 'mob' => 0];
        }

        if ($dev_mode->mode == 'mobile') {
            if ($device == 'desktop') {
                return ['result' => "mobile"];
            }
        } elseif ($dev_mode->mode == 'desktop') {
            if ($device == 'mobile') {
                return ['result' => "desktop"];
            }
        } elseif ($dev_mode->mode == 'all') {
            $desk_limit = floor($dev_mode->desk_pct * 20 / 100);
            if ($device == 'desktop' && $counter['desk'] >= $desk_limit) {
                return ['result' => "mobile"];
            }
        }

        return [
            'result' => true,
            'counter' => $counter,
            'is_new' => !isset($counter['offer_id']),
            'sub2' => $sub2
        ];
    }

    public function updateDeviceCounter($deviceCheck, $device_type, $offerid, $pid, $sub2 = null)
    {
        if (!isset($deviceCheck) || $deviceCheck['result'] !== true) {
            return;
        }

        $counter = $deviceCheck['counter'];
        $is_new_device_counter = $deviceCheck['is_new'];

        $update_data = [
            'total' => $counter['total'] + 1
        ];

        if ($device_type == 'desktop') {
            $update_data['desk'] = $counter['desk'] + 1;
        } else {
            $update_data['mob'] = $counter['mob'] + 1;
        }

        if (($counter['total'] + 1) % 20 == 0) {
            $update_data['desk'] = 0;
            $update_data['mob'] = 0;
        }

        $this->CI->db->trans_start();

        if ($is_new_device_counter) {
            $update_data['offer_id'] = $offerid;
            $update_data['pub_id'] = $pid;

            if (!empty($sub2)) {
                $update_data['sub2'] = $sub2;
            } else {
                $update_data['sub2'] = null;
            }

            $this->CI->db->insert('device_counter', $update_data);
        } else {
            $where = [
                'offer_id' => $offerid,
                'pub_id' => $pid
            ];

            if (!empty($sub2)) {
                $where['sub2'] = $sub2;
            } else {
                $where['sub2'] = null;
            }

            $this->CI->Admin_model->update(
                'device_counter',
                $update_data,
                $where
            );
        }

        $this->CI->db->trans_complete();
    }
}
