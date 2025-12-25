<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cj_postback extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        $this->base_key = $this->config->item('base_key');
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }

    function index() {}

    function getCjData()
    {
        $to = date('Y-m-d', strtotime('+1 day'));
        $from = date('Y-m-d', strtotime('-7 day'));
        $ch = curl_init();
        $data = '{ 
                publisherCommissions
                    (
                    forPublishers: ["6120227"],
                    sincePostingDate:"' . $from . 'T00:00:00Z",
                    beforePostingDate:"' . $to . 'T00:00:00Z"
                    )
                {count payloadComplete records 
                    { pubCommissionAmountUsd shopperId }
                }
                    
            }';
        curl_setopt($ch, CURLOPT_URL, 'https://commissions.api.cj.com/query');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $headers = array();
        $headers[] = 'Authorization: Bearer 6j145nh7kkv4rw345ysczvxkwk';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $dt = json_decode($result);
        $dt = $dt->data->publisherCommissions->records;
        $where_in = '';
        $arr_track_point = array();
        if ($dt) {
            foreach ($dt as $dt) {
                $point = (float)$dt->pubCommissionAmountUsd;
                $track = trim($dt->shopperId);
                $track = (int)str_replace('api', '', $track);
                if ($track) {
                    if ($where_in) $where_in .= ",$track";
                    else $where_in .= "$track";
                    $arr_track_point[$track] = $point;
                }
            }
            if ($where_in) {
                $where_in = "cpalead_tracklink.id IN ($where_in)";
                $qr = "
                    SELECT cpalead_tracklink.*,cpalead_offer.percent as offpercent,cpalead_users.dislead 
                    FROM cpalead_tracklink
                    LEFT JOIN cpalead_users ON cpalead_users.id = cpalead_tracklink.userid
                    LEFT JOIN cpalead_offer ON cpalead_offer.id = cpalead_tracklink.offerid
                    WHERE cpalead_tracklink.flead=0 AND $where_in
                    ";
                $track = $this->db->query($qr)->result();
                if (!empty($track)) {
                    foreach ($track as $track) {
                        $point = $arr_track_point[$track->id];
                        echo $track->id . '-' . $point . '<br>';
                        $this->postback($track, $point);
                    }
                }
            }
        }
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

    function debug($vv)
    {
        if ($_POST) {
            $vv = serialize($_POST);
        } else $vv = '';
        $uri = $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"] . '--' . $vv;
        $this->db->insert('debug', array('debug1' => $uri));
    }

    function postback($track = 0, $point_net = 0)
    {
        $point = 0;
        if (!empty($track)) {
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
                echo 1;
                return;
            }

            if ($ct >= 100) {
                $this->redis->INCR($tlead_key . "-" . $track->userid, -99);
            }

            $strictness = (int)file_get_contents('setting_file/strictness.txt');
            $json_result = $this->checkProxy($track->ip, $track->useragent, $track->user_language, $strictness);
            $result = json_decode($json_result, true);
            $fraud_score  = $proxy = '0';

            if ($result['success'] == true) {
                if ($result['fraud_score']) $fraud_score = $result['fraud_score'];
                if ($result['proxy']) $proxy = $result['proxy'];
            }

            if ($track->amount2 > 0) {
                $point = $track->amount2;
            } else {
                $point = round($point_net * $track->offpercent / 100, 2);
            }

            $this->db->where('id', $track->id);
            if ($point != 0) {
                $this->db->update('tracklink', array('amount' => $point, 'amount2' => $point, 'flead' => 1, 'status' => 1, 'fraud_score' => $fraud_score, 'proxy' => $proxy));
            } else {
                $this->db->update('tracklink', array('amount' => $point, 'flead' => 1, 'status' => 1, 'fraud_score' => $fraud_score, 'proxy' => $proxy));
            }

            if ($this->db->affected_rows() > 0) {
                $this->db->where('id', $track->userid)
                    ->set('curent', "curent +$point", FALSE)
                    ->set('balance', "balance +$point", FALSE)
                    ->update('users');

                $this->db->where(array('id' => $track->offerid))
                    ->set('lead', 'lead+1', false)
                    ->set('revenue', "revenue+$point", false)
                    ->update('offer');

                $pb = $this->Home_model->get_one('postback', array('affid' => $track->userid));
                if (!empty($pb)) {
                    $url = $pb->postback;

                    if (strpos($url, '{sum}')) {
                        //
                        $url = str_replace('{sum}', $point, $url);
                    }
                    if (strpos($url, '{payout}')) {
                        //
                        $url = str_replace('{payout}', $point, $url);
                    }
                    if (strpos($url, '{offerid}')) {
                        //
                        $url = str_replace('{offerid}', rawurlencode($track->offerid), $url);
                    }
                    if (strpos($url, '{sub1}')) {
                        //
                        $url = str_replace('{sub1}', $track->s1, $url);
                    }

                    if (strpos($url, '{sub2}')) {
                        //
                        $url = str_replace('{sub2}', $track->s2, $url);
                    }

                    if (strpos($url, '{sub3}')) {
                        //
                        $url = str_replace('{sub3}', $track->s3, $url);
                    }
                    if (strpos($url, '{sub4}')) {
                        //
                        $url = str_replace('{sub4}', $track->s4, $url);
                    }
                    if (strpos($url, '{sub5}')) {
                        //
                        $url = str_replace('{sub5}', $track->s5, $url);
                    }
                    if (strpos($url, '{sub6}')) {
                        //
                        $url = str_replace('{sub6}', $track->s6, $url);
                    }


                    $resutl = $this->curl_senpost($url);
                } else {
                    $url = $resutl = 'Not Postback URL';
                }

                $this->db->insert('postback_log', array(
                    'finalurl' => $url,
                    'response' => $resutl,
                    'tracklink' => $track->id,
                    'userids' => $track->userid,
                    'campaignid' => $track->offerid
                ));
            }
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

    function thongbao($netname = '')
    {
        switch ($netname) {
            case 'Sonic':
                $eventId = $this->input->get('eventId');
                echo $eventId . ":OK";
                break;
            case 'PaymentWall':
                echo 'OK';
                break;
            default:
                echo 1;
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */