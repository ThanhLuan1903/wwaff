<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mailjet {

    private $api_key = 'f72d1ba0c0980ed9b2ab149300bf84ae';
    private $api_secret ='be17294b3469f062cb022b1fd2ac4626';
    private $api_url = 'https://api.mailjet.com/v3.1/send';

    public function __construct() {
    }

    public function send_email($to_email,  $subject, $message, $from ='', $name='') {
      if (empty($from)) {
            return ['success' => false, 'http_code' => 0, 'response' => 'Missing FROM email'];
        }
        $data = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $from,
                        'Name' => $name
                    ],
                    'To' => [
                        [
                            'Email' => $to_email
                        ]
                    ],
                    'Subject' => $subject,
                    'TextPart' => strip_tags($message),
                    'HTMLPart' => $message,
                    'CustomID' => 'AppGettingStartedTest'
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_key . ':' . $this->api_secret);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
          if ($response === false) {
            return ['success' => false, 'http_code' => $http_code, 'response' => 'cURL error: ' . $curl_err];
        }

        $success = in_array($http_code, [200, 201], true);

        return ['success' => $success, 'http_code' => $http_code, 'response' => $response];
    }
}
/*
user
$this->load->library('Mailjet'); 
 $this->mailjet->send_email($email ,$tieude,$noidung);

*/