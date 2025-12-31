<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Postback extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $this->base_key = $this->config->item('base_key');
        $this->redis = new Redis();
        $this->redis->connect('redis', 6379);
        $this->load_thuvien();
    }

    function testpb()
    {
        echo 'hello testpb';
    }

    function index()
    {
        echo 'helloo';
    }

    function curlip($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function banner($idpb = 0, $password = '')
    {
        if (!is_numeric($idpb)) {
            $idpb = 0;
        }
        $this->db->select('pb_value,id,title');
        $network = $this->Home_model->get_one('network', array('id' => $idpb, 'pb_pass' => $password));
        if (!empty($network)) {
            $pb_value_array = unserialize($network->pb_value);
            $tracklink = $this->input->get_post($pb_value_array['clickid'][0], TRUE);
            $sale_amount = $this->input->get_post($pb_value_array['sale_amount'][0], TRUE);
            if ($tracklink) {
                if (strpos($tracklink, 'dvTest')) {
                    $adv_id = 0;
                    $adv = explode('_', $tracklink);
                    if (!empty($adv[1])) $adv_id = $adv[1];
                    $commission = $this->input->get_post($pb_value_array['commission'][0], TRUE);
                    $this->db->insert('adv_postback_log', array(
                        'tracklink' => $adv_id,
                        'finalurl' => 'Adv Test Postback',
                        'response' => 'Comission:' . $commission,
                        'userids' => $adv_id,
                        'campaignid' => 0,
                    ));
                    echo 1;
                    return;
                }
            }

            if (!empty($pb_value_array['commission'][0])) {
                $point_net = (float)$this->input->get_post($pb_value_array['commission'][0], true);
            }

            echo $this->postbackAction($tracklink, $point_net, false, $sale_amount);
        }
    }

    function pushConversion()
    {
        if (!($this->session->userdata('admin')) &&  ($this->session->userdata('role') != 2)) {
            echo 'You need permission to perform this action!';
            exit();
        } else {
            $data = $this->input->Post('data');
            if (!empty($data)) {
                foreach ($data as $leadData) {
                    $this->postbackAction((int)$leadData['trackId'], (float)$leadData['amount2'], true);
                }
            }
        }
    }

    function admin_add_lead()
    {
        if (!($this->session->userdata('admin'))) {
            echo 'You need permission to perform this action!';
            exit();
        } else {
            $data = $this->input->Post('data');
            if (!empty($data)) {
                foreach ($data as $leadData) {
                    $amount2 = isset($leadData['amount2']) ? $leadData['amount2'] : 0;
                    $saleAmount = isset($leadData['saleAmount']) && $leadData['saleAmount'] !== '' ? (float)$leadData['saleAmount'] : 0;
                    $this->postbackAction($leadData['trackId'], $amount2, false, $saleAmount);
                }
            }
        }
    }

    public function apiPostback($tracklink, $point_net = 0, $lead_amount = 0)
    {

        $point_net = (float)$point_net;
        $this->postbackAction($tracklink, $point_net, true, $lead_amount);
    }

    private function postbackAction($tracklink, $point_net, $isFromApiAdv = false, $lead_amount = 0)
    {
        if ($tracklink) {

            $qr = "
               SELECT cpalead_tracklink.*,cpalead_offer.percent as offpercent,cpalead_users.dislead 
               FROM cpalead_tracklink
               LEFT JOIN cpalead_users ON cpalead_users.id = cpalead_tracklink.userid
               LEFT JOIN cpalead_offer ON cpalead_offer.id = cpalead_tracklink.offerid
               WHERE cpalead_tracklink.id = '$tracklink' AND cpalead_tracklink.flead =0 AND cpalead_tracklink.status=0
            ";

            $track = $this->db->query($qr)->row();
            if (!empty($track)) {

                if ($this->disLead($track) == 1) {
                    return 1;
                }

                $point = 0;
                $dataUpdate = array(
                    'flead' => 1,
                    'status' => 1,
                    'lead_amount' => !empty($lead_amount) ? $lead_amount : 0
                );

                if ($isFromApiAdv) {
                    $point = $point_net > 0 ? $point_net : $track->amount3;
                } else {
                    if ($track->amount2 > 0) {
                        $point = $track->amount2;
                    } else {
                        $point = round($point_net * (100 - $track->offpercent) / 100, 2);
                        $dataUpdate['amount3'] = $point_net;
                    }
                }
                $dataUpdate['amount'] = $point;
                $dataUpdate['amount2'] = $point;

                $this->db->where('id', $tracklink);
                $this->db->update('tracklink', $dataUpdate);


                if ($this->db->affected_rows() > 0) {
                    $this->db->where('id', $track->userid)
                        ->set('curent', "curent +$point", FALSE)
                        ->set('balance', "balance +$point", FALSE)
                        ->update('users');

                    $this->db->where(array('id' => $track->offerid))
                        ->set('lead', 'lead+1', false)
                        ->set('revenue', "revenue+$point", false)
                        ->update('offer');

                    $this->sendPubPostback($track, $point, $lead_amount);
                    $this->incrementCapByPub($track->offerid, $track->userid, $track->s2, $track->date);
                    $this->incrementAllpubDailyCap($track->offerid, $track->date);
                    if ($point > 0) {
                        $this->update_crKey($track);
                        $this->update_unknowBrowser($track);
                    }
                }

                return 1;
            } else {
                return 0;
            }
        }
    }

    private function disLead($track)
    {
        $key = $this->base_key . '-' . $track->offerid;
        $tlead_key = $key . '-tlead';
        $ct = $this->redis->INCR($tlead_key . "-" . $track->userid, 1);
        $dislead = $track->dislead;
        $mchan = array();
        if ($dislead >= 1) {
            $ttc = round(100 / $dislead, 1);
            $j = 0;
            for ($i = 0; $i < 100; $i++) {
                $j = $j + 1;
                if ($j >= $ttc) {
                    $mchan[] = $i;
                    $j = $j - $ttc;
                }
            }
        }
        if (in_array($ct, $mchan)) {
            return 1;
        }

        if ($ct >= 100) {
            $this->redis->INCR($tlead_key . "-" . $track->userid, -99);
        }
        return 0;
    }

    private function sendPubPostback($track, $point = 0, $lead_amount = 0)
    {
        if ((float)$point == 0) {
            $this->db->insert('postback_log', array(
                'finalurl'   => 'SKIPPED: point = 0',
                'response'   => 'No postback sent (point is zero)',
                'tracklink'  => $track->id,
                'userids'    => $track->userid,
                'campaignid' => $track->offerid
            ));
            return;
        }
        $pb = $this->Home_model->get_data('postback', array('affid' => $track->userid));
        if ($pb) {
            foreach ($pb as $pb) {
                $url = $pb->postback;

                if (strpos($url, '{sum}')) {
                    $url = str_replace('{sum}', $point, $url);
                }
                if (strpos($url, '{payout}')) {
                    $url = str_replace('{payout}', $point, $url);
                }
                if (strpos($url, '{commission}')) {
                    $url = str_replace('{commission}', $point, $url);
                }
                if (strpos($url, '{sale_amount}')) {
                    $url = str_replace('{sale_amount}', $lead_amount, $url);
                }
                if (strpos($url, '{offerid}')) {
                    $url = str_replace('{offerid}', rawurlencode($track->offerid), $url);
                }
                if (strpos($url, '{view}')) {
                    $url = str_replace('{view}', $track->s1, $url);
                }
                if (strpos($url, '{view2}')) {
                    $url = str_replace('{view2}', $track->s2, $url);
                }
                if (strpos($url, '{view3}')) {
                    $url = str_replace('{view3}', $track->s3, $url);
                }
                if (strpos($url, '{view4}')) {
                    $url = str_replace('{view4}', $track->s4, $url);
                }
                if (strpos($url, '{view5}')) {
                    $url = str_replace('{view5}', $track->s5, $url);
                }
                if (strpos($url, '{view6}')) {
                    $url = str_replace('{view6}', $track->s6, $url);
                }

                $resutl = $this->curl_senpost($url);
                $this->db->insert('postback_log', array(
                    'finalurl' => $url,
                    'response' => $resutl,
                    'tracklink' => $track->id,
                    'userids' => $track->userid,
                    'campaignid' => $track->offerid
                ));
            }
        } else {
            $url = $resutl = 'Not Postback URL';
            $this->db->insert('postback_log', array(
                'finalurl' => $url,
                'response' => $resutl,
                'tracklink' => $track->id,
                'userids' => $track->userid,
                'campaignid' => $track->offerid
            ));
        }
    }

    function checkProxy($ip, $user_agent, $user_language, $strictness)
    {
        $key = '56b4f42494b6455d97fce1b5bac29f85';
        $parameters = array(
            'key' => $key,
            'ip'    => $ip,
            'user_agent' => $user_agent,
            'user_language' => $user_language,
            'strictness' => $strictness
        );

        $formatted_parameters = http_build_query($parameters);

        $url = sprintf(
            'https://network.affmine.com/api/proxy/proxy_lookup.php?%s',
            $formatted_parameters
        );


        $timeout = 5;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        $json = curl_exec($curl);
        curl_close($curl);

        return $json;
    }

    function curl_senpost($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function incrementCapByPub($offerid, $userid, $s2 = '', $leadDate = '')
    {
        if (empty($leadDate)) {
            $leadDate = date('Y-m-d H:i:s');
        }

        $today_gmt5 = convert_to_gmt5('Y-m-d');

        $daily_start = $today_gmt5 . ' 12:00:00';
        $daily_end = date('Y-m-d H:i:s', strtotime($daily_start . ' +1 day'));

        $monthly_start = date('Y-m-01', strtotime($today_gmt5)) . ' 12:00:00';
        $monthly_end = date('Y-m-d H:i:s');

        $subkey = "pub:{$userid}";
        if ($s2 && $s2 !== 0 && $s2 !== null) {
            $subkey .= "_s2:{$s2}";
        }

        if ($leadDate >= $daily_start && $leadDate < $daily_end) {
            $dailyOfferKey = "wwaff_dailycap_{$offerid}";
            if ($this->redis->exists($dailyOfferKey)) {
                $this->redis->hIncrBy($dailyOfferKey, $subkey, 1);
            }
        }

        if ($leadDate >= $monthly_start && $leadDate <= $monthly_end) {
            $monthlyOfferKey = "wwaff_monthlycap_{$offerid}";
            if ($this->redis->exists($monthlyOfferKey)) {
                $this->redis->hIncrBy($monthlyOfferKey, $subkey, 1);
            }
        }
    }

    public function incrementAllpubDailyCap($offerid, $leadDate = '')
    {
        if (empty($leadDate)) {
            $leadDate = date('Y-m-d H:i:s');
        }

        $today_gmt5 = convert_to_gmt5('Y-m-d');
        $daily_start = $today_gmt5 . ' 12:00:00';
        $daily_end = date('Y-m-d H:i:s', strtotime($daily_start . ' +1 day'));

        if ($leadDate >= $daily_start && $leadDate < $daily_end) {
            $rediskey = "wwaff_allpubcap_{$offerid}";

            $this->redis->incrBy($rediskey, 1);

            if ($this->redis->ttl($rediskey) <= 0) {
                $this->redis->expire($rediskey, 86400);
            }
        }
    }

    function load_thuvien()
    {
        $this->load->helper(array('timezone', 'cr'));
        $this->load->model("Admin_model");
    }

    function debug()
    {
        //if($_POST){$vv=serialize($_POST);}else $vv='-get-';
        //$uri = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"].'--'.$vv;        
        //$this->db->insert('debug',array('debug1'=>$uri)); 

    }

    function update_crKey($track)
    {
        $cr_helper = new Cr_helper();

        try {
            $offerid = $track->offerid;
            $pid = $track->userid;
            $s2 = $track->s2;
            if (empty($s2)) $s2 = 0;
            $offer = $this->Home_model->get_one('offer', ['id' => $offerid]);
            $track_date = timestamp_to_gmt5($track->date, 'Y-m-d');
            $today = convert_to_gmt5('Y-m-d');

            if ($offer->reqcr) {
                if ($s2 !== 0 && !empty($s2)) {
                    $cr_key = $this->base_key . '-crCount-' . $pid . '-' . $offerid . '-' . $s2;
                    $suspend_key = $this->base_key . '-suspend-' . $pid . '-' . $offerid . '-' . $s2;
                } else {
                    $cr_key = $this->base_key . '-crCount-' . $pid . '-' . $offerid;
                    $suspend_key = $this->base_key . '-suspend-' . $pid . '-' . $offerid;
                }

                if ($this->redis->exists($suspend_key)) {
                    goto update_leads;
                }

                if (!$this->redis->exists($cr_key)) {
                    $cr_helper->initializeCrCounter($cr_key, $offerid, $pid, $s2, $today, $this->redis);
                }

                $count_cr = $this->redis->hGetAll($cr_key);

                if (empty($count_cr)) {
                    log_message('error', "Redis hGetAll returned empty data for key: $cr_key");
                    return;
                }

                $stored_date = isset($count_cr['date']) ? $count_cr['date'] : null;
                if ($stored_date !== $track_date) {
                    return;
                }

                $exceptionwhere = ['offer_id' => $offerid, 'pub_id' => $pid];
                $exceptioncase = $this->Admin_model->get_data('exc', $exceptionwhere);
                $cr_exception = $this->hasException('cr', $exceptioncase, $s2);
                $mode = $this->Home_model->get_one('off_cr', array('offer_id' => $offerid));

                if (isset($mode)) {
                    $cr_max = $mode->cr_mode;
                    $cr_min = $mode->cr_min;
                    $min_conversions = $mode->min_conversions;
                }

                if (!$cr_exception) {
                    $this->db->where('error_type', 'CR Require');
                    $this->db->where('userid', $pid);
                    $this->db->where('offerid', $offerid);
                    $this->db->where('DATE(violation_time)', $today);
                    $this->db->where('status', 'Warning');
                    if ($s2 !== 0 && !empty($s2)) {
                        $this->db->where('sub2', $s2);
                    } else {
                        $this->db->where('(sub2 IS NULL OR sub2 = "" OR sub2 = 0)');
                    }

                    $violation = $this->db->get('error_notis')->result();

                    if (is_array($violation) && count($violation) >= 1) {
                        $high_count = 0;

                        foreach ($violation as $v) {
                            $v_details = json_decode($v->details, true);
                            $v_cr = isset($v_details['cr_value']) ? $v_details['cr_value'] : 0;

                            if ($v_cr > $cr_max) {
                                $high_count++;
                            }
                        }

                        $leads = (int)$count_cr['leads'] + 1;
                        $clicks = (int)$count_cr['clicks'];

                        if ($clicks > 0) {
                            $cr = round(($leads / $clicks) * 100, 2);
                        } else {
                            $cr = 0;
                        }

                        if ($leads >= $min_conversions && $cr > $cr_max) {
                            if ($high_count >= 1) {
                                $offer_info = $this->Home_model->get_one('offer', ['id' => $offerid]);
                                $user_info = $this->Home_model->get_one('users', ['id' => $pid]);
                                $conditiondisoffer = ['offerid' => $offerid, 'usersid' => $pid];
                                if ($s2 !== 0 && !empty($s2)) {
                                    $conditiondisoffer['sub2'] = $s2;
                                } else {
                                    $conditiondisoffer['sub2'] = null;
                                }

                                $existing_disoffer = $this->db->get_where('disoffer', $conditiondisoffer)->num_rows();

                                if ($existing_disoffer == 0) {
                                    $disoffer_data = [
                                        'offerid' => $offerid,
                                        'offername' => $offer_info->title,
                                        'email' => $user_info->email,
                                        'usersid' => $pid,
                                        'reason' => 'CR Violation - High CR'
                                    ];

                                    if (!empty($s2) && $s2 !== 0) {
                                        $disoffer_data['sub2'] = $s2;
                                    }

                                    $this->db->insert('disoffer', $disoffer_data);
                                }

                                $violation_data = [
                                    'error_type' => 'CR Require',
                                    'userid' => $pid,
                                    'offerid' => $offerid,
                                    'details' => json_encode([
                                        'cr_value' => $cr,
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

                                $this->db->insert('error_notis', $violation_data);
                            }
                        }
                    }
                }

                update_leads:

                $this->redis->multi();
                $this->redis->hIncrBy($cr_key, 'leads', 1);
                $this->redis->exec();
            }
        } catch (Exception $e) {
            log_message('error', 'Redis error in update_crKey: ' . $e->getMessage());
        }
    }

    private function hasException($rule_type, $exceptioncase, $current_sub2 = null)
    {
        $has_general = false;
        $has_specific = false;

        if (!is_array($exceptioncase) && !is_object($exceptioncase)) {
            return false;
        }

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

        $has_exception = false;
        if ($has_general) {
            $has_exception = true;
        } else {
            $has_exception = $has_specific && $current_sub2 !== null;
        }

        return $has_exception;
    }

    function update_unknowBrowser($track)
    {
        if ($track->browser !== "Unknown Browser") {
            return;
        }

        try {
            $offerid = $track->offerid;
            $pid = $track->userid;
            $s2 = $track->s2;
            $today = convert_to_gmt5('Y-m-d');
            $key = $this->base_key . '-unknownBrowser-' . $offerid . '-' . $pid;

            if ($s2 !== 0 && !empty($s2)) {
                $key = $key . '-' . $s2;
            }

            if (!$this->redis->exists($key)) {
                $this->initialbrowserCounter($key, $offerid, $pid, $s2, $today);
            } else {
                $this->redis->incr($key);
            }
        } catch (Exception $e) {
            log_message('error', 'update_unknowBrowser: ' . $e->getMessage());
        }
    }

    public function initialbrowserCounter($key, $offerid, $pid, $s2, $today)
    {
        $start = date('Y-m-d 12:00:00', strtotime($today));
        $end = date('Y-m-d 12:00:00', strtotime($today . ' +1 day'));

        $this->db->select('COUNT(*) as leads');
        $this->db->from('tracklink');
        $this->db->where('offerid', $offerid);
        $this->db->where('userid', $pid);
        $this->db->where('date >=', $start);
        $this->db->where('date <', $end);
        $this->db->where('flead', 1);
        $this->db->where('browser', "Unknown Browser");

        if ($s2 !== 0 && !empty($s2)) {
            $this->db->where('s2', $s2);
        } else {
            $this->db->where('(s2 IS NULL OR s2 = "" OR s2 = 0)');
        }

        $result = $this->db->get()->row();
        $leads = $result->leads ? (int)$result->leads : 0;

        $this->redis->set($key, $leads);
        $this->redis->expire($key, 1 * 24 * 60 * 60);
    }
}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */