<?php

require_once APPPATH . 'libraries/payment/payment_interface.php';
require_once APPPATH . 'libraries/payment/contracts/abstract_method.php';

class CryptoMethod extends PaymentAbstract implements PaymentInteface
{
  public function validate($form)
  {
  }

  public function send_payment($form)
  {
  }
}
