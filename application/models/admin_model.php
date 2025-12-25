<?php
class Admin_model extends CI_Model {
    
    private $table_setting='setting';
    function __construct()
    {
        parent::__construct();
    }
    //$query->free_result(); 
    
    function select_max($table,$file){
         $this->db->select_max($file);
         $query1 = $this->db->get($table);
         $row = $query1->row(); 
         if(empty($row)){
            return false;
         }else  return $row->$file;
    }
    function get_one($table,$where){
        $this->db->where($where);
        $query = $this->db->get($table);
        if($query->num_rows() > 0 ){
            $data = $query->row();
            $query->free_result();
           return $data;
        }else return false;
    }
    function get_number($table,$where=''){
        if(!empty($where)){
            $this->db->where($where);
        }
        $query = $this->db->get($table);
        return $query->num_rows();
    }
    function get_data($table,$where='',$order='',$limit='',$select=''){
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($order)){
            if(is_array($order) &&!empty($order[0]) && !empty($order[1])){
                $this->db->order_by($order['0'],$order['1']);
            }else
            $this->db->order_by('id','DESC');
        }
        if(!empty($limit)){
            if(empty($limit['1'])){
                $this->db->limit($limit['0']);                
            }else $this->db->limit($limit['0'],$limit['1']);
            
        }
        if(!empty($select)){
            $this->db->select($select);
        }
        
        $query = $this->db->get($table);
        if ($query !== false) {
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
            return $data;
        }else return false;}
    }    
    function check_trung($nd,$table){
        $this->db->where($nd);
        $query = $this->db->get($table);
        if($query->num_rows()>0){
            $query->free_result();
            return true;
        }return false;
    }
    
    function xoa($table,$where=''){
        if(!empty($where)){
        $this->db->where($where);
        $this->db->delete($table,$where);
        return true;
        }else return false;
    }
    function update($table,$data,$where=''){        
        $this->db->where($where);
        $this->db->update($table, $data);             
    }

    function get_top_10_balance_month() {
        $query = "SELECT * FROM (
            SELECT cpalead_users.username, sum(cpalead_tracklink.amount2) as finance
            FROM cpalead_tracklink
                     CROSS JOIN (SELECT @cnt := 0) AS dummy
                     INNER JOIN cpalead_users on cpalead_users.id = cpalead_tracklink.userid and cpalead_users.status = 1
            WHERE cpalead_tracklink.flead = 1 AND (date >= ADDDATE(LAST_DAY(SUBDATE(CURRENT_DATE(), INTERVAL 1 MONTH)), 1) AND date <= LAST_DAY(CURRENT_DATE()))  AND amount2 <> 0
            GROUP BY cpalead_users.email
            UNION
            SELECT username, amount FROM cpalead_custom_sale_rewards WHERE type = 2
            ORDER BY finance DESC
            LIMIT 10 ) current;
        ";
        $records = $this->db->query($query) ? $this->db->query($query)->result() : null;
        return $records;
    }
}