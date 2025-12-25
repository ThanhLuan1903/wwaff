<?php
require_once APPPATH . '/modules/adm_mng/services/classes/CustomSaleReward.php';

class ServiceProvider
{
  const THEME_SERVICE = 'theme';
  const CUSTOM_REWARD = 'custom-rewards';

  private $service;

  public function get_service($service)
  {
    switch($service) {
      case self::THEME_SERVICE:
        return $this->service = new ThemeService();
      case self::CUSTOM_REWARD:
        return $this->service = new CustomSaleReward();
      default:
        throw new Exception('Should be specified service');
    }

    return $this;
  }

  public function edit($type, $content)
  {
    return $this->service->update($type, $content);
  }

  public function delete($type)
  {
    return $this->service->delete($type);
  }
}
