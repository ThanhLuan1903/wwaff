<?php

class Request_Product_model extends CI_Model
{

    private $table = 'request_product';

    public function __construct()
    {
        parent::__construct(); 
    }

    function add($data) {
        return $this->db->insert($this->table, $data);
    }

    function getProductPending($limit, $offset, $user_id) {
        $total_rows = $this->db->where('created_by', $user_id)->count_all_results($this->table, FALSE);
        $query = $this->db
            ->select("id, name, preview_link, image_url, CONCAT('$', FORMAT(cpalead_request_product.payout, 0)) as cust_payout, status", false)
            ->get_where($this->table, array('created_by' => $user_id, 'is_adv' => null), $limit, $offset - 1);
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
            return array(
                total_rows => $total_rows,
                data => $data
            );
        } else {
            return array(
                total_rows => 0,
                data => [],
            );
        };
    }

    function getAdvProductPending($limit, $offset, $advertiser_id) {
        $total_rows = $this->db->where('is_adv', $advertiser_id)->count_all_results($this->table, FALSE);
        $query = $this->db
            ->select("id, name, preview_link, image_url, CONCAT('$', FORMAT(cpalead_request_product.payout, 0)) as cust_payout, status", false)
            ->get_where($this->table, array('is_adv' => $advertiser_id), $limit, $offset - 1);
        if($query){
            $data = $query->result();
            $query->free_result();
            return array(
                total_rows => $total_rows,
                data => $data
            );
        } else {
            return array(
                total_rows => 0,
                data => [],
            );
        };
    }

    function getAllProduct($limit, $offset) {
        $total_rows = $this->db->count_all_results($this->table, FALSE);
        $query = $this->db
            ->select("id, name, preview_link, image_url, CONCAT('$', FORMAT(cpalead_request_product.payout, 0)) as cust_payout, status", false)
            ->get_where($this->table, array('is_adv' => null), $limit, $offset - 1);
        if($query){
            $data = $query->result();
            $query->free_result();
            return array(
                total_rows => $total_rows,
                data => $data
            );
        } else {
            return array(
                total_rows => 0,
                data => [],
            );
        };
    }

    function getAllAdvProduct($limit, $offset) {
        $total_rows = $this->db->count_all_results($this->table, FALSE);
        $query = $this->db
            ->select("id, name, preview_link, image_url, CONCAT('$', FORMAT(cpalead_request_product.payout, 0)) as cust_payout, status", false)
            ->get_where($this->table, 'is_adv is not null', $limit, $offset - 1);
        if($query){
            $data = $query->result();
            $query->free_result();
            return array(
                total_rows => $total_rows,
                data => $data
            );
        } else {
            return array(
                total_rows => 0,
                data => [],
            );
        };
    }

    function updateStatusRequest($id, $status) {
        $this->db->where('id', $id)->update($this->table, array('status' => $status));
    }

    function update_request_product($id, $data) {
        $isExists = $this->Home_model->get_one($this->table, ['id' => $id]);

        if ($isExists) {
            $this->db->where('id', $id);
            $this->db->update($this->table, $data);
        }
    } 
}
?>