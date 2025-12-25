<?php
require_once APPPATH . '/modules/adm_adc/services/abstracts/BaseService.php';

class CustomSaleReward extends BaseService
{
  const REWARD_RANKING = 'reward-ranking';
  const REWARD_RANKING_1 = 'reward-ranking-1';
  const REWARD_RANKING_2 = 'reward-ranking-2';
  const REWARD_RANKING_3 = 'reward-ranking-3';
  const REWARD_RANKING_4 = 'reward-ranking-4';
  const REWARD_RANKING_5 = 'reward-ranking-5';
  const REWARD_RANKING_6 = 'reward-ranking-6';
  const REWARD_RANKING_7 = 'reward-ranking-7';
  const REWARD_RANKING_8 = 'reward-ranking-8';
  const REWARD_RANKING_9 = 'reward-ranking-9';
  const REWARD_RANKING_10 = 'reward-ranking-10';

  public function __construct()
  {
    parent::__construct();
  }

  public function update($type, $content)
  {
    return $this->updateRanking(self::REWARD_RANKING . "-$type", $content);
  }

  public function delete($type)
  {
    return $this->Custom_model->delete($type);
  }

  private function updateRanking($type, $content)
  {
    $record = $this->Custom_model->find_by_type($type);
    if (!$record)
      return $this->db->insert('custom_features', compact('type', 'content'));
    return $this->Custom_model->update($type, $content);
  }

}
