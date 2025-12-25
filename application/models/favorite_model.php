<?php
class Favorite_model extends CI_Model {

    private $table = 'favorite_offer';

    public function __construct()
    {
        parent::__construct(); 
    }

    private function get_user_id() {
        $userId = $this->session->userdata('userid');

        if (!$userId) 
            throw new Exception('You should log in first');
        return $userId;
    }
    
    /**
     * find_favorite_offer
     * Set condition for a user's favorites
     * @param  int $offerId
     */
    public function find_favorite_offer($offerId, $is_adv = 0) {
        $userId = $this->get_user_id();
        $this->db->where('offer_id', $offerId);
        $this->db->where('user_id', $userId);
        $this->db->where('is_adv', $is_adv);
        return $this->db->get($this->table);
    }

    public function insert_favorite_offer($offerId, $isAdv = 0) {
        $userId = $this->get_user_id();
        return  $this->db->insert($this->table, [ 'user_id' => $userId, 'offer_id' => $offerId, 'is_adv' => $isAdv ]);
    }
    
    public function update_favorite_offer($offerId, $isLiked, $isAdv = 0) {
        $userId = $this->get_user_id();
        return $this->db->where(['offer_id' => $offerId, 'user_id' => $userId, 'is_adv' => $isAdv])->update($this->table, ['is_liked' => !$isLiked, 'is_adv' => $isAdv]);
    }

    public function favorite_offer_actions($offerId, $isAdv = 0) {
        $isAdv = $this->session->userdata('role') == 2 ? 1 : 0;
        $query = $this->find_favorite_offer($offerId, $isAdv);
        $isLiked = $query->first_row()->is_liked;
        // Insert if not exists
        if ( $isLiked != NULL ) {
            $this->update_favorite_offer($offerId, $isLiked, $isAdv);
        } else { // Update if exists and shift value
            $this->insert_favorite_offer($offerId, $isAdv);
        }

        return $this->db->affected_rows() > 0 ? !$isLiked : FALSE;
    }
}
?>