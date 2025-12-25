<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Adv_cron extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function update_confirm_expired()
    {
        return 1;
        // Nè, nó đó auto approved
        $sql = "
            UPDATE cpalead_tracklink AS t
            JOIN cpalead_offer AS o ON o.id = t.offerid
            SET t.status = 4
            WHERE t.status = 1 AND o.is_adv > 0
            AND CURDATE() > DATE_ADD(
                CASE 
                    WHEN o.paymterm_calc = 2 THEN DATE_ADD(t.date, INTERVAL (7 - DAYOFWEEK(t.date)) DAY)
                    WHEN o.paymterm_calc = 1 THEN LAST_DAY(t.date)
                END,
                INTERVAL (o.confirm_date + 5) DAY
            )
        ";
        $this->db->query($sql);
        echo "Updated rows: " . $this->db->affected_rows() . "\n";
    }

    public function update_offer_show_expired()
    {
        return 1;
        $sql_ids = "
            SELECT o.id
            FROM cpalead_offer o
            JOIN (
                SELECT
                    t.offerid,
                    MAX(t.date) AS max_date
                FROM cpalead_tracklink t
                WHERE t.status IN (1, 4)
                GROUP BY t.offerid
            ) latest ON latest.offerid = o.id
            JOIN cpalead_tracklink t2 ON t2.offerid = o.id AND t2.date = latest.max_date
            WHERE o.is_adv > 0
            AND CURDATE() > DATE_ADD(
                CASE
                    WHEN o.paymterm_calc = 2 THEN DATE_ADD(t2.date, INTERVAL (7 - DAYOFWEEK(t2.date)) DAY)
                    WHEN o.paymterm_calc = 1 THEN LAST_DAY(t2.date)
                END,
                INTERVAL (o.hold_period + 5) DAY
            )
        ";
        $query = $this->db->query($sql_ids);
        $offer_ids = array_column($query->result_array(), 'id');

        if (!empty($offer_ids)) {
            $this->db->trans_begin();

            $ids_str = implode(',', $offer_ids);
            $sql_update = "UPDATE cpalead_offer SET `show` = 0 WHERE id IN ($ids_str)";
            $this->db->query($sql_update);
            $this->db->where_in('offer_id', $offer_ids);
            $this->db->update('cpalead_advertiser_offer_status', array('status' => 'Pause'));

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo "Update failed.\n";
            } else {
                $this->db->trans_commit();
                echo "Updated offers: " . count($offer_ids) . "\n";
            }
        } else {
            echo "No offers to update.\n";
        }
    }
}