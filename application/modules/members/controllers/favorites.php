<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Favorites extends CI_Controller {    

    public function __construct()
    {
        parent::__construct();    
        $this->load->model('Favorite_model');
    }

    public function offer($offerId) {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            return $this->Favorite_model->favorite_offer_actions($offerId);
        }

        redirect('v2/offers');
    }
}

?>

