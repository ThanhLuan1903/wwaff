<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Tracktest extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index() {}

    function advPostbackTest()
    {
        $adv_id = (int)$this->input->get('adv');
        $offerurl = $this->input->get('offerurl');
        $postback_id = (int)$this->input->get('postback_id');
        $network = $this->db->where(['adv_id' => $adv_id, 'id' => $postback_id])->get('network')->row();
       
        if ($network) {
            $pb_value = unserialize($network->pb_value);

            $subidTest = 'advTest_' . $adv_id;

            $offerurl .= $network->subid . $subidTest;
            if (!empty($pb_value['pub_id'][1]) && strpos($offerurl, $pb_value['pub_id'][1])) {
                $offerurl = str_replace($pb_value['pub_id'][1], 1000, $offerurl);
            } else {
                $offerurl .= (strpos($offerurl, '?') ? '&pub_id=' : '?pub_id=') . '1000';
            }
        } else {
            echo 'Your postback is not exist!';
            return;
        }

        if ($offerurl) {
            redirect(urldecode($offerurl));
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */