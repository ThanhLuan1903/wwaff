<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_header_avatar')) {
    function get_header_avatar()
    {
        $CI =& get_instance();

        $defaultAvatar = base_url('temp/default/images/avt_unknow.jpeg');

        $role = (int)$CI->session->userdata('role');
        $uid  = (int)$CI->session->userdata('userid');

        // ===== USER / PUBLISHER =====
        if ($role === 1) {
            if ($uid <= 0) return $defaultAvatar;

            $row = $CI->db->select('mailling')
                ->from('users')
                ->where('id', $uid)
                ->limit(1)
                ->get()
                ->row();

            if (!$row || empty($row->mailling)) return $defaultAvatar;

            $acc = @unserialize($row->mailling);
            if (is_array($acc) && !empty($acc['avartar'])) {
                return base_url($acc['avartar']);
            }

            return $defaultAvatar;
        }

        // ===== ADVERTISER =====
        $user = $CI->session->userdata('user');
        if (is_object($user) && !empty($user->avatar_url)) {
            return base_url($user->avatar_url);
        }

        return $defaultAvatar;
    }
}