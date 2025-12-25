<?php
class Adv_invoice_model extends CI_Model {
    
    private $table_setting='setting';
    function __construct()
    {
        parent::__construct();
    } 
    /*
     * Get all adv appved tracklink
     * @param array $ids idvinvoices
     */
    public function getApprovedTracklink($ids){   
        $this->db->select("id, userid, amount2, 1 as status", FALSE);
        $this->db->where_in('status', [4]);
        $this->db->where_in('adv_pay', $ids);
        return $this->db->get('tracklink')->result();        
    }
    public function removeAdvpayTracklink($ids){
        $this->db->where_in('adv_pay', $ids);
        $this->db->update('tracklink', array('adv_pay' => 0));
    }
    public function updateTracklinkStatus($ids, $status){
        $this->db->where_in('adv_pay', $ids);
        $this->db->update('tracklink', array('status' => $status));
    }
}