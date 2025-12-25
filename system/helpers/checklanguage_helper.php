<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Checklanguage_helper
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Admin_model');
    }

    public function checkLanguage($offerid, $lang)
    {
        $allowedLang = $this->CI->Admin_model->get_data('off_lang', array('offer_id' => $offerid));
        if (empty($allowedLang)) {
            return true;
        }

        $browserLangs = explode(',', $lang);
        $firstLang = $browserLangs[0];
        $parts = explode(';', $firstLang);
        $langCode = trim($parts[0]);

        if (strpos($langCode, '-') !== false) {
            $langCode = explode('-', $langCode)[0];
        }
        $langCode = strtolower($langCode);

        foreach ($allowedLang as $value) {
            if (strtolower($value->lang_code) === $langCode) {
                return true;
            }
        }

        return $langCode;
    }

    public function getSuitableOffer($offerid, $browserLangCodes)
    {
        $this->CI->db->select('offer.title, offer.id');
        $this->CI->db->from('offer');
        $this->CI->db->join('off_lang', 'off_lang.offer_id = offer.id', 'inner');
        $this->CI->db->where(['offer.request' => 0, 'offer.show' => 1]);
        $this->CI->db->where_in('off_lang.lang_code', $browserLangCodes);
        $this->CI->db->order_by('RAND()');
        $this->CI->db->limit(3);
        $query = $this->CI->db->get();
        return $query->result();
    }
}
