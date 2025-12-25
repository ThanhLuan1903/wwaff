<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/modules/adm_adc/services/classes/ThemeService.php';
require_once APPPATH . '/modules/authenticated_controller.php';
require_once APPPATH . 'libraries/modules/module.php';
require_once APPPATH . 'libraries/observer/classes/notification_request_offer.php';

class Offers extends AuthenticatedController
{

    private $per_page = 12;
    public $total_rows = 6;
    public $pub_config = '';
    /** @var MemberModel */
    public $member = '';
    public $member_info = '';
    public $route;

    function  __construct()
    {
        parent::__construct();
        $this->load->model('Offer_model');
        $this->load->model('Custom_model');
        $this->pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        $this->route = new Module();
        if ($this->session->userdata('logedin')) {
            $this->member = $this->Home_model->get_one('users', array('id' => $this->session->userdata('userid')));
            $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : null;
        } else {
            redirect('v2/logout');
        }

        if ($this->session->userdata('role') === Auth_plugin::PUBLISHER_ROLE && empty($this->member)) {
            redirect('v2/sign/in');
        }
    }

    private function get_banners()
    {
        $left = $this->Home_model->get_data('banners', ['show' => 1, 'is_adv' => 0, 'location' => "Left"], null, ['position', 'asc']);
        $right = $this->Home_model->get_data('banners', ['show' => 1, 'is_adv' => 0, 'location' => "Right"], null, ['position', 'asc']);
        return compact('left', 'right');
    }

    function search_offer()
    {
        $key = 'oName';
        $gt = $this->input->post('oName');
        $this->session->set_userdata($key, $gt);
        redirect('v2/offers');
    }

    function list_offers($page = 0)
    {
        $uid = $this->session->userdata('role') == 2 ? $this->session->userdata('userid') : $this->member->id;
        $start_offset = $page * 12;
        $end_offset = $start_offset + $this->per_page;

        $banners = $this->get_banners();
        $left_banners = $banners['left'];
        $right_banners = $banners['right'];

        $get_offers = $this->Offer_model->list_offers($uid, $start_offset, $end_offset);
        $data['offer'] = $get_offers['offers'];
        $data['final_page'] = (round($get_offers['count'] / $this->per_page)) == $page;
        $this->total_rows = round($get_offers['count']);

        $data['category'] = $this->Home_model->get_data('offercat', array('show' => 1));
        $data['country'] = $this->Home_model->get_data('country', array('show' => 1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm', array('show' => 1));
        $data['types'] = $this->Home_model->get_data('offertype', array('show' => 1));
        $data['totals'] = $this->total_rows;
        $data['left_banners'] = $left_banners;
        $data['right_banners'] = $right_banners;
        $data['left_title'] = $this->Custom_model->find_by_type(ThemeService::TITLE_BANNER_LEFT);
        $data['right_title'] = $this->Custom_model->find_by_type(ThemeService::TITLE_BANNER_RIGHT);

        if ($start_offset >= 1) {
            $content = $this->load->view('offers/ajax/lazy_offers.php', $data, true);
            echo $content;
        } else {
            $content = $this->load->view('offers/list_offers.php', $data, true);

            if ($this->session->userdata('role') == 1) {
                $this->load->view('default/vindex.php', array('content' => $content));
            } else {
                $this->load->view('advertiser/default/vindex.php', array('content' => $content));
            }
        }
    }

    function available($page = 0)
    {
        return $this->route->my_product($page);
    }

    function update_status()
    {
        return $this->route->update_status();
    }

    function live($page = 0)
    {
        $uid = $this->member->id;
        $start_offset = $page * 12;
        $end_offset = $start_offset + 12;

        $banners = $this->get_banners();
        $left_banners = $banners['left'];
        $right_banners = $banners['right'];

        $get_offers = $this->Offer_model->get_live_offers($uid, $start_offset, $end_offset);
        $data['offer'] = $get_offers['offers'];
        $data['final_page'] = (round($get_offers['count'] / $this->per_page) + 1) == $page;
        $this->total_rows = $get_offers['count'];

        $this->pagina_uri_seg = 4;
        $this->pagina_baseurl =  base_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/';

        $data['category'] = $this->Home_model->get_data('offercat', array('show' => 1));
        $data['country'] = $this->Home_model->get_data('country', array('show' => 1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm', array('show' => 1));
        $data['totals'] = $this->total_rows;
        $data['types'] = $this->Home_model->get_data('offertype', array('show' => 1));
        $data['left_banners'] = $left_banners;
        $data['right_banners'] = $right_banners;

        if ($start_offset >= 1)
            return $content = $this->load->view('offers/ajax/lazy_offers.php', $data, true);

        $content = $this->load->view('offers/list_offers.php', $data, true);
        return $this->load->view('default/vindex.php', array('content' => $content));
    }

    function ajax_serach_offer()
    {
        $name = $this->input->post('name');
        $gt = $this->input->post('gt');
        if ($name) {
            $this->session->set_userdata($name, $gt);
        }
        echo 1;
    }

    function request($id = 0)
    {
        $url = $_SERVER['HTTP_REFERER'];
        if ($id) {
            if ($_POST) {
                $re_apply = $this->input->post('re-apply');

                if ($re_apply) {
                    $this->db->where('offerid', $id);
                    $this->db->where('status', 'Deny');
                    $this->db->where('userid', $this->member->id);
                    $this->db->update('request', ['status' => 'Pending', 'date' => (new DateTime())->format('Y-m-d'), 'crequest' => $this->input->post('request', true)]);
                    (new Notification_Request_Offer($this->member->id, $id))->notify_re_apply();
                } else {
                    $this->db->insert(
                        'request',
                        array(
                            'crequest' => $this->input->post('request', true),
                            'status' => 'Pending',
                            'userid' => $this->member->id,
                            'offerid' => $id,
                            'check_trung' => $this->member->id . '-' . $id,
                            'ip' => $this->input->ip_address(),
                            'traffic_source' => $this->input->post('traffic_source')
                        )
                    );
                    (new Notification_Request_Offer($this->member->id, $id))->notify_apply();
                }
            }
        }

        redirect($url);
    }

    function update_request()
    {
        if (!$this->input->is_ajax_request() || !$this->input->post()) {
            throw new Exception('Does not support methods');
        }

        $request_id = $this->input->post('request_id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $offer_id = $this->input->post('offer_id');
        $ip = null;
        $this->db->where('id', $request_id);

        if ($field == 'status' && $value == 'Approved') {
            $ip = $this->input->ip_address();
            $this->db->update('request', [$field => $value, 'ip' => $ip]);
            (new Notification_Request_Offer($this->member->id, $offer_id))->notify_pub_agreed();
            return;
        } elseif ($field == 'status' && $value == 'Pending') {
            (new Notification_Request_Offer($this->member->id, $offer_id))->notify_pub_pending();
        } elseif ($field == 'status' && $value == 'Deny') {
            (new Notification_Request_Offer($this->member->id, $offer_id))->notify_pub_denied();
        }

        $this->db->update('request', [$field => $value]);
        echo $this->db->affected_rows();
    }

    function offer_view($id = 0)
    {
        $id = (int)$id;
        if (!$id)
            $id = (int)$this->input->get_post('offer_id');
        $off = $this->Home_model->get_one('offer', array('show' => 1, 'id' => $id));
        if ($off) {
            $country = 'VN';
            $status = 'Approved';
            if ($off->request) {
                $status = 'none';
                $this->db->select('status');
                $rq = $this->Home_model->get_one('request', array('userid' => $this->session->userdata('userid'), 'offerid' => $off->id));
                if (!empty($rq)) {
                    $status =  $rq->status;
                }
            }

            $offercat = $this->Home_model->get_data('offercat');
            foreach ($offercat as $offercat) {
                $moffercat[$offercat->id] = $offercat->offercat;
            }

            $content = $this->load->view('offers/campaign_view.php', array('offer' => $off, 'offercat' => $moffercat, 'status' => $status), true);
        } else {
            $content = 'Offer now found!';
        }

        $this->load->view('default/vindex.php', array('content' => $content));
    }

    public function list_invites($page = 0)
    {
        $publisher_id = $this->session->userdata('user')->id;

        $start_offset = $page * 12;
        $end_offset = $start_offset + $this->per_page;

        $banners = $this->get_banners();
        $left_banners = $banners['left'];
        $right_banners = $banners['right'];

        $get_offers =  $this->Offer_model->get_invited_offers($publisher_id, $start_offset, $end_offset);
        $data['invitation_advertisers'] = $this->Offer_model->get_invitation_advertisers($publisher_id);
        $data['invited_offers'] = $get_offers['offers'];
        $data['final_page'] = (round($get_offers['count'] / $this->per_page)) == $page;
        $this->total_rows = round($get_offers['count']);

        $data['category'] = $this->Home_model->get_data('offercat', array('show' => 1));
        $data['country'] = $this->Home_model->get_data('country', array('show' => 1));
        $data['paymterm'] = $this->Home_model->get_data('paymterm', array('show' => 1));
        $data['types'] = $this->Home_model->get_data('offertype', array('show' => 1));
        $data['totals'] = $this->total_rows;
        $data['left_banners'] = $left_banners;
        $data['right_banners'] = $right_banners;
        $data['left_title'] = $this->Custom_model->find_by_type(ThemeService::TITLE_BANNER_LEFT);
        $data['right_title'] = $this->Custom_model->find_by_type(ThemeService::TITLE_BANNER_RIGHT);

        if ($start_offset >= 1) {
            $content = $this->load->view('offers/ajax/lazy_offers.php', $data, true);
            echo $content;
        } else {
            $content = $this->load->view('offers/invited_offers.php', $data, true);
            $this->load->view('default/vindex.php', array('content' => $content));
        }
    }
}
