<?php

require_once APPPATH . 'libraries/payment/payment_interface.php';
require_once APPPATH . 'libraries/payment/methods/paypal_method.php';
require_once APPPATH . 'libraries/payment/methods/crypto_method.php';

class PaymentPlugin
{  
  const PAY_PAL = 'PayPal';
  const CRYPTO = 'Crypto';

  /**
   * factory
   *
   * @param  mixed $type
   * @return PaymentInteface
   */
  public static function factory($type)
  {
    switch ($type) {
      case 'PayPal':
        return new PayPalMethod();
      case 'Crypto':
        return new CryptoMethod();
      default:
        throw new Exception('Not supported the payment method');
    }
  }
}
