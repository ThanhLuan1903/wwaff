<?php
require_once APPPATH . 'libraries/observer/classes/notification_payment.php';

class Payment extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Calculator_model');
    $this->load->model('Admin_model');
    $this->load->model('Builder_model');
  }

  /** Near to payment term */
  public function noti_near_expired_offer()
  {
    $paid_status = 4; // Apporved
    $query = "
      SELECT DISTINCT offerid, cpalead_offer.is_adv, cpalead_offer.title, cpalead_advertiser.username FROM cpalead_tracklink
      INNER JOIN cpalead_offer on cpalead_tracklink.offerid = cpalead_offer.id AND cpalead_offer.is_adv is not null
      LEFT JOIN cpalead_advertiser on cpalead_advertiser.id = cpalead_offer.is_adv
      WHERE cpalead_tracklink.status = $paid_status AND DATE_ADD(now(), interval 5 day) >= deadline
    ";

    $result = $this->db->query($query)->result();

    if (empty($result)) {
      echo "Nothing changed";
    }

    try {
      foreach ($result as $offer) {
        (new Notification_Payment($offer->is_adv))->notify_payment_near_expired($offer->id, $offer->title);
        echo "Have been sent notification to {$offer->username} <br/>";
      }
    } catch (\Throwable $th) {
      log_message('error', "[Error][Payment] $th");
    }
  }

  public function noti_expired_offer()
  {
    $paid_status = 4; // Apporved
    $query = "
      SELECT DISTINCT offerid, cpalead_offer.is_adv, cpalead_offer.title FROM cpalead_tracklink
      INNER JOIN cpalead_offer on cpalead_tracklink.offerid = cpalead_offer.id AND cpalead_offer.is_adv is not null
      LEFT JOIN cpalead_advertiser on cpalead_advertiser.id = cpalead_offer.is_adv
      WHERE cpalead_tracklink.status = $paid_status AND now() >= deadline
    ";

    $result = $this->db->query($query)->result();

    if (empty($result)) {
      echo "Nothing changed";
    }

    try {
      foreach ($result as $offer) {
        (new Notification_Payment($offer->is_adv))->notify_payment_expired($offer->id, $offer->title);
        echo "Have been sent notification to {$offer->username} <br/>";
      }
    } catch (\Throwable $th) {
      log_message('error', "[Error][Payment] $th");
    }
  }

  /** Pending Offer after 5 days from deadline of payment term */
  public function pending_offer()
  {
    $paid_status = 4; // Apporved
    $query = "
      SELECT DISTINCT offerid, cpalead_offer.is_adv FROM cpalead_tracklink
      INNER JOIN cpalead_offer on cpalead_tracklink.offerid = cpalead_offer.id AND cpalead_offer.is_adv is not null
      WHERE cpalead_tracklink.status = $paid_status AND now() >= DATE_ADD(deadline, interval 5 day)
    ";

    $result = $this->db->query($query)->result();
    $advertisers = [];

    if (empty($result)) {
      echo "Nothing changed";
    }

    try {
      foreach ($result as $offer) {
        $this->db->where('offer_id', $offer->offerid);
        $this->db->update('advertiser_offer_status', ['status' => 'Pending',  'updated_at' => (new DateTime())->format('Y-m-d H:m:i')]);
        (new Notification_Payment($offer->is_adv))->notify_payment_pending($offer->id, $offer->title);
        echo "Have been sent notification to {$offer->username} <br/>";
        array_push($advertisers, $offer->is_adv);
      }

      $affected_rows = $this->db->affected_rows();
      echo 'Have ' . $affected_rows . ' records been updated';
    } catch (\Throwable $th) {
      log_message('error', "[Error][Payment] $th");
    }
  }
}
