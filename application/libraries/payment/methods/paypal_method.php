<?php

require_once APPPATH . 'libraries/payment/payment_interface.php';
require_once APPPATH . 'libraries/payment/contracts/abstract_method.php';

class PayPalMethod extends PaymentAbstract implements PaymentInteface
{
  public function validate($form)
  {
  }
  
  public function send_payment($form)
  {
    $errors = $this->validate($form);

    if (!$errors)
      return $errors;
  }
}
