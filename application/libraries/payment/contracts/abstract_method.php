<?php

abstract class PaymentAbstract implements PaymentInteface
{
  /**
   * @return boolean
   */
  abstract function validate($form);
}
