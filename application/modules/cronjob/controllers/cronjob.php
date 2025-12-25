<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
class Cronjob extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
    }

    function index()
    {
        echo 'Làm gì thế?';
    }

    function daycron()
    {
        $this->db->empty_table('ipclick');
    }
    
    function offercap()
    {
        $date = '2013-09-27';
        $this->db->where(array('show' => 1, 'capped >' => 0));
        $this->db->select('id,capped');
        $t = $this->db->get('offer')->result();
        if (!empty($t)) {
            foreach ($t as $t) {
                $dulieu[$t->id] = $t->capped;
                $wherein[] = $t->id;
            }

            $this->db->where_in('idoffer', $wherein);
            $this->db->where(array('lead >' => 0, 'date' => $date));
            $this->db->select('idoffer');
            $this->db->select_sum('lead');
            $this->db->group_by('idoffer');
            $dt = $this->db->get('report')->result();
            if (!empty($dt)) {
                foreach ($dt as $dt) {
                    if ($dt->lead >= $dulieu[$dt->idoffer]) {
                        $mangupdate[] = $dt->idoffer;
                    }
                }
                if (!empty($mangupdate)) {
                    $this->db->where_in('id', $mangupdate);
                    $this->db->update('offer', array('show' => 0));
                }
            }
        }
    }
}
