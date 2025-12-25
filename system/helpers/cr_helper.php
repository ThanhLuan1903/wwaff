<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cr_helper
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Admin_model');
        $this->CI->load->helper('timezone');
    }

    public function syncCrData($cr_key, $redis)
    {
        if (!$redis->exists($cr_key)) {
            return;
        }

        $redis->hIncrBy($cr_key, 'clicks', 1);
    }

    public function checkViolationHistory($pid, $offerid, $s2, $today)
    {
        $this->CI->db->where('error_type', 'CR Require');
        $this->CI->db->where('userid', $pid);
        $this->CI->db->where('offerid', $offerid);
        $this->CI->db->where('status', 'Warning');

        if ($s2 !== 0) {
            $this->CI->db->where('sub2', $s2);
        } else {
            $this->CI->db->where('(sub2 IS NULL OR sub2 = "" OR sub2 = 0)');
        }

        $this->CI->db->where('DATE(violation_time)', $today);
        return $this->CI->db->get('error_notis')->result();
    }

    public function getLatestViolation($pid, $offerid, $s2)
    {
        $this->CI->db->where('error_type', 'CR Require');
        $this->CI->db->where('userid', $pid);
        $this->CI->db->where('offerid', $offerid);

        if ($s2 !== 0) {
            $this->CI->db->where('sub2', $s2);
        } else {
            $this->CI->db->where('(sub2 IS NULL OR sub2 = "" OR sub2 = 0)');
        }

        $this->CI->db->order_by('violation_time', 'DESC');
        $this->CI->db->limit(1);
        $violation = $this->CI->db->get('error_notis')->row();

        if ($violation) {
            $details = json_decode($violation->details, true);
            if (isset($details['cr_max'])) {
                return $details['cr_max'];
            } elseif (isset($details['cr_mode'])) {
                return $details['cr_mode'];
            }
        }

        return null;
    }

    public function initializeCrCounter($cr_key, $offerid, $pid, $s2, $today, $redis)
    {
        $start = date('Y-m-d 12:00:00', strtotime($today));
        $end = date('Y-m-d 12:00:00', strtotime($today . ' +1 day'));

        $this->CI->db->select('
            COUNT(*) as clicks,
            SUM(CASE WHEN flead = 1 AND amount > 0 THEN 1 ELSE 0 END) as leads
        ');

        $this->CI->db->from('tracklink');
        $this->CI->db->where('offerid', $offerid);
        $this->CI->db->where('userid', $pid);
        $this->CI->db->where('date >=', $start);
        $this->CI->db->where('date <', $end);

        if ($s2 !== 0 && !empty($s2)) {
            $this->CI->db->where('s2', $s2);
        } else {
            $this->CI->db->where('(s2 IS NULL OR s2 = "" OR s2 = 0)');
        }

        $result = $this->CI->db->get()->row();
        $clicks = $result->clicks ? (int)$result->clicks : 0;
        $leads = $result->leads ? (int)$result->leads : 0;

        $count_cr = [
            "offerid" => $offerid,
            "userid" => $pid,
            "clicks" => $clicks,
            "leads" => $leads,
            'date' => $today
        ];

        if ($s2 !== 0) {
            $count_cr['sub2'] = $s2;
        }

        $redis->multi();
        foreach ($count_cr as $key => $value) {
            $redis->hSet($cr_key, $key, $value);
        }
        $redis->expire($cr_key, 172800);
        $redis->exec();

        return $count_cr;
    }

    public function handleDailyReset($cr_key, $count_cr, $today, $redis)
    {
        if (isset($count_cr['date']) && $count_cr['date'] != $today) {
            $redis->multi();
            $redis->hSet($cr_key, 'clicks', 0);
            $redis->hSet($cr_key, 'leads', 0);
            $redis->hSet($cr_key, 'date', $today);
            $redis->exec();

            $count_cr['clicks'] = 0;
            $count_cr['leads'] = 0;
            $count_cr['date'] = $today;
        }

        return $count_cr;
    }

    public function calculateAndCheckCr($count_cr, $cr_max, $cr_min, $min_conversions)
    {
        $clicks = isset($count_cr['clicks']) ? (int)$count_cr['clicks'] : 0;
        $leads = isset($count_cr['leads']) ? (int)$count_cr['leads'] : 0;

        if ($clicks == 0) {
            return [
                'passed' => true,
                'cr_value' => 0,
                'clicks' => 0,
                'leads' => $leads
            ];
        }

        $cr = round(($leads / $clicks) * 100, 2);
        if ($leads >= $min_conversions) {
            if ($cr < $cr_min || $cr > $cr_max) {
                return [
                    'passed' => false,
                    'cr_value' => $cr,
                    'clicks' => $clicks,
                    'leads' => $leads
                ];
            }
        }

        return [
            'passed' => true,
            'cr_value' => $cr,
            'clicks' => $clicks,
            'leads' => $leads
        ];
    }

    public function check_cr($offerid, $pid, $cr_key, $cr_min, $cr_max, $min_conversions, $s2, $redis)
    {
        $today = convert_to_gmt5();

        try {
            if (!$redis->exists($cr_key)) {
                $count_cr = $this->initializeCrCounter($cr_key, $offerid, $pid, $s2, $today, $redis);
            } else {
                $count_cr = $redis->hGetAll($cr_key);
                $count_cr = $this->handleDailyReset($cr_key, $count_cr, $today, $redis);
            }

            $cr_result = $this->calculateAndCheckCr($count_cr, $cr_max, $cr_min, $min_conversions);

            $cr = $cr_result['cr_value'];
            $clicks = $cr_result['clicks'];
            $leads = $cr_result['leads'];

            $return_data = [
                'x' =>  $cr_result['passed'],
                'cr_min' => $cr_min,
                'cr_max' => $cr_max,
                'cr_value' => $cr,
                'clicks' => $clicks,
                'leads' => $leads
            ];

            if ($s2 !== 0) {
                $return_data['sub2'] = $s2;
            }

            return $return_data;
        } catch (Exception $e) {
            log_message('error', 'Redis error in check_cr: ' . $e->getMessage());
            return ['x' => true, 'y' => false];
        }
    }

    public function showOverCrView($cr_min, $cr_max, $remaining_seconds, $cr_value)
    {
        header("HTTP/1.1 403 Forbidden");
        $this->CI->load->view('default/overCr.php', [
            "cr_min" => $cr_min,
            "cr_max" => $cr_max,
            "remaining_seconds" => $remaining_seconds,
            "cr_value" => $cr_value
        ]);
    }

    public function handleCrViolation($resultCr, $pid, $offerid, $s2, $suspend_key, $redis)
    {
        $clicks = $resultCr['clicks'];
        $leads = $resultCr['leads'];
        $cr_min = $resultCr['cr_min'];
        $cr_max = $resultCr['cr_max'];
        $cr_value = $resultCr['cr_value'];
        $now_timestamp = strtotime(convert_to_gmt5('Y-m-d H:i:s'));
        $expire_time = $now_timestamp + 3600;

        $is_low = $cr_value < $cr_min;
        $is_high = $cr_value > $cr_max;

        $today = convert_to_gmt5();
        $violation = $this->checkViolationHistory($pid, $offerid, $s2, $today);
        $has_warning_low = false;
        $has_warning_high = false;
        $warning_low_cr = null;

        foreach ($violation as $v) {
            if ($v->status == 'Warning') {
                $v_details = json_decode($v->details, true);
                $v_cr = isset($v_details['cr_value']) ? $v_details['cr_value'] : 0;

                if ($v_cr < $cr_min) {
                    $has_warning_low = true;
                    $warning_low_cr = $v_cr;
                } elseif ($v_cr > $cr_max) {
                    $has_warning_high = true;
                }
            }
        }

        if ($is_high) {
            if ($has_warning_high) {
                return;
            }
        }

        if ($is_low) {
            if ($has_warning_low && $warning_low_cr > 0) {
                $pause_threshold = $warning_low_cr * 0.8;

                if ($cr_value < $pause_threshold) {
                    $offer_info = $this->CI->Home_model->get_one('offer', ['id' => $offerid]);
                    $user_info = $this->CI->Home_model->get_one('users', ['id' => $pid]);

                    $conditiondisoffer = ['offerid' => $offerid, 'usersid' => $pid];
                    if ($s2 !== 0 && !empty($s2)) {
                        $conditiondisoffer['sub2'] = $s2;
                    } else {
                        $conditiondisoffer['sub2'] = null;
                    }

                    $existing_disoffer = $this->CI->db->get_where('disoffer', $conditiondisoffer)->num_rows();

                    if ($existing_disoffer == 0) {
                        $disoffer_data = [
                            'offerid' => $offerid,
                            'offername' => $offer_info->title,
                            'email' => $user_info->email,
                            'usersid' => $pid,
                            'reason' => 'CR Violation - Low CR'
                        ];

                        if (!empty($s2) && $s2 !== 0) {
                            $disoffer_data['sub2'] = $s2;
                        }

                        $this->CI->db->insert('disoffer', $disoffer_data);
                    }

                    $violation_data = [
                        'error_type' => 'CR Require',
                        'userid' => $pid,
                        'offerid' => $offerid,
                        'details' => json_encode([
                            'cr_value' => $cr_value,
                            'cr_min' => $cr_min,
                            'cr_max' => $cr_max,
                            'clicks' => $clicks,
                            'leads' => $leads
                        ]),
                        'violation_time' => convert_to_gmt5('Y-m-d H:i:s'),
                        'suspension_until' => convert_to_gmt5('Y-m-d H:i:s'),
                        'status' => 'Paused'
                    ];

                    if ($s2 !== 0 && !empty($s2)) {
                        $violation_data['sub2'] = $s2;
                    }

                    $this->CI->db->insert('error_notis', $violation_data);
                    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    header("Location: " . $current_url);
                    exit();
                } else {
                    return;
                }
            }
        }

        $suspend_data = json_encode([
            'expire_time' => $expire_time,
            'violation_cr' => $cr_value
        ]);
        $redis->setEx($suspend_key, 3600, $suspend_data);

        $violation_data = [
            'error_type' => 'CR Require',
            'userid' => $pid,
            'offerid' => $offerid,
            'details' => json_encode([
                'cr_value' => $cr_value,
                'cr_min' => $cr_min,
                'cr_max' => $cr_max,
                'clicks' => $clicks,
                'leads' => $leads
            ]),
            'violation_time' => convert_to_gmt5('Y-m-d H:i:s'),
            'suspension_until' => date('Y-m-d H:i:s', $expire_time),
            'status' => 'Warning'
        ];

        if ($s2 !== 0) {
            $violation_data['sub2'] = $s2;
        }

        $this->CI->db->insert('error_notis', $violation_data);

        return [
            'action' => 'show_warning_view',
            'cr_min' => $cr_min,
            'cr_max' => $cr_max,
            'remaining_seconds' => 3600,
            'cr_value' => $cr_value
        ];
    }
}
