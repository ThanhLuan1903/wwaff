<?php

class Calculator_model extends CI_Model
{
  private $advertiser_amount = 'amount3';
  private $publisher_amount = 'amount2';
  /**
   * The function is used for calculating balance, holding and available of the Advertiser
   *
   * @param  int $advertiser_id
   * @return void
   */
  public function advertiser_info($advertiser_id)
  {
    $pending = $this->db->select("sum({$this->advertiser_amount}) as pending")
      ->from('cpalead_offer')
      ->join('cpalead_tracklink', 'cpalead_tracklink.offerid = cpalead_offer.id')
      ->where([
        'cpalead_offer.is_adv' => $advertiser_id,
        'cpalead_tracklink.status' => 1, // Pending or Approved
        'cpalead_tracklink.smartoff' => 0,
        'cpalead_tracklink.smartlink' => 0
      ])
      ->get()->row()->pending;
    
    $approve = $this->db->select("sum({$this->advertiser_amount}) as Approved")
    ->from('cpalead_offer')
    ->join('cpalead_tracklink', 'cpalead_tracklink.offerid = cpalead_offer.id')
    ->where([
      'cpalead_offer.is_adv' => $advertiser_id,
      'cpalead_tracklink.status' => 4,  
      'cpalead_tracklink.smartoff' => 0,
      'cpalead_tracklink.smartlink' => 0
    ])
      ->get()->row()->Approved;
    
    $declined = $this->db->select("sum({$this->advertiser_amount}) as declined")
      ->from('cpalead_offer')
      ->join('cpalead_tracklink', 'cpalead_tracklink.offerid = cpalead_offer.id')
      ->where([
        'cpalead_offer.is_adv' => $advertiser_id,
        'cpalead_tracklink.status' => 2, // Declined
        'cpalead_tracklink.smartoff' => 0,
        'cpalead_tracklink.smartlink' => 0
      ])
      ->get()->row()->declined;

    $paid = $this->db->select("sum({$this->advertiser_amount}) as paid")
      ->from('cpalead_offer')
      ->join('cpalead_tracklink', 'cpalead_tracklink.offerid = cpalead_offer.id')
      ->where([
        'cpalead_offer.is_adv' => $advertiser_id,
        'cpalead_tracklink.status' => 3, // Paid
        'cpalead_tracklink.smartoff' => 0,
        'cpalead_tracklink.smartlink' => 0
      ])
      ->get()->row()->paid;

    $invoice = $this->db->select("sum(amount) as invoice")
      ->from('cpalead_advertiser_payment')
      ->where(['cpalead_advertiser_payment.adv_id' => $advertiser_id, 'status' => 'Complete'])
      ->get()->row()->invoice;

    $hold = $pending;
    //$available = (float)$paid - (float)$invoice;
    $available = (float)$approve;
    // $balance = $hold + $available - $declined;
    $balance = $available +  $pending;;

    return [$balance, $hold, $available, $pending, $declined, $paid, $invoice];
  }

  /**
   * The function is used for calculating EPC/Conversion/Hosts/Total/Declined/Level of the publisher
   * @param int $publisher_id
   */
  public function publisher_info($publisher_id)
  {
    $hosts = $this->db->select('count(DISTINCT cpalead_tracklink.ip) as hosts')->from('cpalead_tracklink')->where(['userid' => $publisher_id,  'smartlink' => 0, 'smartoff' => 0])->get()->row()->hosts;
    $clicks = $this->db->select('count(cpalead_tracklink.id) as clicks')->from('cpalead_tracklink')->where(['userid' => $publisher_id,'smartlink' => 0, 'smartoff' => 0])->get()->row()->clicks;
    $convertion = $this->db->select('sum(flead) as lead')->from('cpalead_tracklink')->where(['userid' => $publisher_id, 'smartlink' => 0, 'smartoff' => 0])->get()->row()->lead;
    $total = $this->db->select('sum(amount2) as total')->from('cpalead_tracklink')->where(['userid' => $publisher_id, 'flead' => 1, 'smartlink' => 0, 'smartoff' => 0])->get()->row()->total;
    $declined = $this->db->select('sum(amount2) as declined')->from('cpalead_tracklink')->where(['userid' => $publisher_id, 'status' => 2, 'smartlink' => 0, 'smartoff' => 0])->get()->row()->declined;
    
    // $epc = $total / $clicks;
    // $convertion_rate = ($convertion / $clicks) * 100;
    $epc = $total / $hosts;
    $convertion_rate = ($convertion / $hosts) * 100;
    $level = $this->publisher_level($publisher_id, $declined, $total);
    $rating = $this->db->select('SUM(rating)/count(*) as rating')->from('cpalead_publisher_rating')->where(['publisher_id' => $publisher_id])->get()->row()->rating;
    return [$epc, $convertion_rate, $declined, $total, $hosts, $level, $rating];
  }

  public function publisher_level($publisher_id, $declined, $total)
  {
    $percent = $declined / $total;
    $total_invoice = $this->db->select('sum(amount) as total_invoice')->from('cpalead_invoice')->where(['usersid' => $publisher_id, 'status' => 'Complete'])->get()->row()->total_invoice;
    $current_level = 0;

    switch (true) {
      case $total_invoice >= 500 && $total_invoice < 2000:
        $current_level = 1;
        break;
      case $total_invoice >= 2000 && $total_invoice < 5000:
        $current_level = 2;
        break;
      case $total_invoice >= 5000 && $total_invoice < 10000:
        $current_level = 3;
        break;
      case $total_invoice >= 10000 && $total_invoice < 20000:
        $current_level = 4;
        break;
      case $total_invoice >= 20000:
        $current_level = 5;
        break;
    }

    if ($percent >= 0.7 && $current_level > 0) {
      $current_level = 0;
    } elseif ($percent >= 0.6 && $percent < 0.7 && $current_level > 0) {
      $current_level = 1;
    } elseif ($percent >= 0.5 && $percent < 0.6 && $current_level > 2) {
      $current_level = 2;
    } elseif ($percent >= 0.4 && $percent < 0.5 && $current_level > 3) {
      $current_level = 3;
    } elseif ($percent >= 0.3 && $percent < 0.4 && $current_level > 4) {
      $current_level = 4;
    }

    return $current_level;
  }
}
