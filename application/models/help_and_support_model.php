<?php

class Help_And_Support_model extends CI_Model
{

    private $table = 'help_and_support';

    public function __construct()
    {
        parent::__construct(); 
    }

    function add($data) {
        return $this->db->insert($this->table, $data);
    }

    function updateTotalComment($id) {
        $info = $this->db->where('id', $id)->get($this->table)->row();
        return $this->db->where('id', $id)->update($this->table, array('total_comment' => $info->total_comment + 1));
    }

    function getListConversation($limit, $offset, $user_id, $is_adv = 0) {
        $total_rows = $this->db->where("cpalead_help_and_support.parent_id IS NULL and cpalead_help_and_support.is_adv = $is_adv")->count_all_results($this->table, FALSE);
        $condition = array();
        if($user_id == null) {
            $condition = array('parent_id' => null, 'is_adv' => $is_adv);
        } else {
            $condition = array('parent_id' => null, 'user_id' => $user_id, 'is_adv' => $is_adv);   
        }
        $query = $this->db
                ->select("id, name, email, content, title, updated_at", false)
                ->order_by("updated_at DESC")
                ->get_where($this->table, $condition, $limit, $offset - 1);
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

    function getConversation($id) {
        $query = $this->db
            ->select("id, name, email, content, title, total_comment")
            ->where('id', $id)
            ->get($this->table);

        if($query->num_rows() > 0 ){
            $data = $query->row();
            $query->free_result();
            return $data;
        } else return null;
    }

    function getListComment($limit, $offset, $id) {
        $query = $this->db
            ->select("id, name, email, content, created_at")
            ->order_by("updated_at DESC")
            ->where('parent_id', $id)
            ->get_where($this->table, array('parent_id' => $id), $limit, $offset - 1);
        if($query->num_rows() > 0){
            $data = $query->result();
            $query->free_result();
            return array(
                data => $data
            );
        } else {
            return array(
                data => [],
            );
        };
    }

    function getParent($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

}
?>