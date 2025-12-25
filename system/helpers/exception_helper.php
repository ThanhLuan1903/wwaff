<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exception_helper
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Admin_model');
    }

    public function hasException($rule_type, $exceptioncase, $current_sub2 = null)
    {
        $has_general = false;
        $has_specific = false;

        foreach ($exceptioncase as $exc) {
            if ($exc->rule_type === $rule_type) {
                if ($exc->sub2 === null || $exc->sub2 === '') {
                    $has_general = true;
                }
                if ($exc->sub2 === $current_sub2 && $current_sub2 !== null) {
                    $has_specific = true;
                }
            }
        }

        if ($has_general) {
            return true;
        }

        return $has_specific && $current_sub2 !== null;
    }

    public function getcap($cap, $offerid, $pid, $s2, $period = 0)
    {
        $this->CI->db->select('custom_cap');
        $condition = [
            'offer_id' => $offerid,
            'pub_id'   => $pid,
            'period'   => $period
        ];

        if ($s2) {
            $condition['s2'] = $s2;
        } else {
            $this->CI->db->where("(s2 IS NULL OR s2 = '' OR s2 = '0')", null, false);
        }
        $this->CI->db->where($condition);
        $exccap = $this->CI->db->get('exccap')->result_array();


        if (!empty($exccap)) {
            $cap = $exccap[0]['custom_cap'];
        }

        return $cap;
    }
}

/* End of file exception_helper.php */
/* Location: ./application/helpers/exception_helper.php */