<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users {	
	public function __construct($config = array())
	{
        if($this->session->userdata('role')==1){
            $table = 'users';
        }else if($this->session->userdata('role')==2){
            $table = 'advertiser';
            $this->is_adv =1;
        }
        if($this->session->userdata('logedin')){
            $this->db->select($table.'.*,cpalead_api_key.api_key');
            $this->db->from($table);
            $this->db->join('api_key', 'api_key.user_id ='.$table.'.id AND cpalead_api_key.is_adv = '.$this->is_adv, 'left');
            $this->db->where(array($table.'.id'=>$this->session->userdata('userid')));
            $this->member = $this->db->get()->row();
           $this->member_info = isset($this->member->mailling) ? unserialize($this->member->mailling) : [];           
        }
	}
    function index()
    {
        $CI =& get_instance();
        
    }
    function get_user($id=0){
        $th =& get_instance();
        $th->db->where('id',$id);
        
    }
    


}
// END CI_Email class

/* End of file Email.php */
/* Location: ./system/libraries/Email.php */
