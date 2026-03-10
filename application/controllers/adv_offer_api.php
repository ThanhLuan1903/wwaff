<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adv_offer_api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Adv_offer_api_model');
    }

    private function json_out($http_code, $payload)
    {
        $this->output->set_status_header((int)$http_code);
        $this->output->set_content_type('application/json', 'utf-8');
        $this->output->set_output(json_encode($payload));
    }

    private function get_api_key()
    {
        $k = $this->input->get_request_header('API-Key', TRUE);
        if (!$k && isset($_SERVER['HTTP_API_KEY'])) $k = $_SERVER['HTTP_API_KEY'];
        if (!$k) $k = $this->input->get('API-Key', TRUE);
        if (!$k) $k = $this->input->get('API-KEY', TRUE);
        return trim((string)$k);
    }

    public function offers()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'GET') {
            $this->json_out(405, array(
                'status' => 4,
                'error'  => 'Method not allowed'
            ));
            return;
        }

        $api_key = $this->get_api_key();
        if ($api_key === '') {
            $this->json_out(401, array(
                'status' => 2,
                'error'  => 'Invalid token'
            ));
            return;
        }

        $apiUser = $this->Adv_offer_api_model->find_user_by_api_key($api_key);
        if (!$apiUser) {
            $this->json_out(401, array(
                'status' => 2,
                'error'  => 'Invalid token'
            ));
            return;
        }

        $offers = $this->Adv_offer_api_model->get_api_enabled_offers_by_user((int)$apiUser->user_id);

        $this->json_out(200, array(
            'offers' => $offers
        ));
    }
}