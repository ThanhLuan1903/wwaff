<?php

class Offer_model extends CI_Model
{

    private function generic_filter($uid)
    {
        return "`show` = 1 AND cpalead_offer.id not in (SELECT distinct  offerid FROM cpalead_disoffer WHERE usersid = $uid) AND smartoff =0 AND smartlink=0";
    }

    private function filter_by_name($name)
    {
        return is_numeric($name) ? "cpalead_offer.id = $name" : "title LIKE '%$name%' ";
    }

    private function filter_by_countries(array $countries)
    {
        $preProcess = join(" OR country LIKE ", $this->add_percent_char($countries));
        return "( country LIKE " . $preProcess . " OR country LIKE '%oallo%' )";
    }

    private function filter_by_categories(array $categories)
    {
        $preProcess = join(" OR offercat LIKE ", $this->add_percent_char($categories));
        return "( offercat LIKE " . $preProcess . ')';
    }

    private function filter_by_payment_terms(array $payments)
    {
        $paymentsIn = join(',', $payments);
        return "paymterm IN ($paymentsIn)";
    }

    private function filter_by_types(array $types)
    {
        $typesIn = join(',', $types);
        return "type IN ($typesIn)";
    }

    private function select($uid)
    {
        return "SELECT cpalead_offer.*, ( {$this->get_top_products($uid, 20)} WHERE tmp_ranking.id = cpalead_offer.id ) as ranking,
                    CASE cpalead_offer.request
                        WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid = cpalead_offer.id AND cpalead_request.userid = $uid limit 1)
                        ELSE 'Approved'
                    END AS status";
    }

    private function from($uid, $sort_field = 'id', $is_adv = 0)
    {
        if ($sort_field === 'favorite')
            return "FROM cpalead_offer INNER JOIN cpalead_favorite_offer ON cpalead_favorite_offer.offer_id = cpalead_offer.id AND cpalead_favorite_offer.user_id = $uid AND cpalead_favorite_offer.is_liked = 1 AND cpalead_favorite_offer.is_adv = $is_adv";
        return "FROM cpalead_offer ";
    }

    private function where($uid)
    {
        $ct = $this->session->userdata('oCountry');
        $cat = $this->session->userdata('oCat');
        $payments = $this->session->userdata('opaymterm');
        $oName = trim($this->session->userdata('oName'));
        $oTypes = $this->session->userdata('oTypes');

        $filter_countries = $ct ? "AND {$this->filter_by_countries($ct)}" : "";
        $filter_categories = $cat ? "AND {$this->filter_by_categories($cat)}" : "";
        $filter_payments = $payments ? "AND {$this->filter_by_payment_terms($payments)}" : "";
        $filter_name = $oName ? "AND {$this->filter_by_name($oName)}" : "";
        $filter_types = $oTypes ? "AND {$this->filter_by_types($oTypes)}" : "";
        $query = "WHERE {$this->generic_filter($uid)} $filter_countries $filter_categories $filter_payments $filter_name $filter_types";

        return $query;
    }

    private function order($sort_field = 'default', $sort_type = 'DESC')
    {
        switch ($sort_field) {
            case 'favorite':
                return " ORDER BY `id` $sort_type ";
            case 'default';
                return ' ORDER BY `id` DESC ';
            default:
                return " ORDER BY $sort_field $sort_type, id DESC";
        }
    }

    private function add_percent_char(array $data)
    {
        return array_map(function ($value) {
            return "'%o{$value}o%'";
        }, $data);
    }

    private function sort_options($sort = '')
    {
        $sort_field = 'id';
        $sort_type = 'desc';

        if ($sort) {
            $sort_offer = explode('-', $sort);
            $sort_field = $sort_offer[0];
            $sort_type = $sort_offer[1];
        }

        return compact('sort_field', 'sort_type');
    }

    public function get_top_products($uid, $limit)
    {
        return "SELECT tmp_ranking.ranking FROM (
                        SELECT (@cnt := @cnt + 1) AS ranking, id, lead
                        FROM cpalead_offer CROSS JOIN (SELECT @cnt := 0) AS dummy
                        WHERE {$this->generic_filter($uid)}
                        ORDER BY `lead` DESC, id DESC
                        LIMIT $limit 
                ) as tmp_ranking";
    }

    private function count_page($where)
    {
        $query = "SELECT COUNT(*) as total FROM cpalead_offer $where ";
        return $this->db->query($query)->row()->total;
    }

    public function list_offers($uid, $start_offset = 0, $end_offset = 12)
    {
        $is_adv = $this->session->userdata('role') == 2 ? 1 : 0;
        $sort_offer = $this->sort_options($this->session->userdata('sort_offer'));
        $select_section = $this->select($uid);
        $from_section = $this->from($uid, $sort_offer['sort_field'], $is_adv);
        $where_section = $this->where($uid);

        // Thêm điều kiện: nếu is_adv = 1 thì phải có approve trong advertiser_offer_status
        $where_section .= " AND (cpalead_offer.is_adv = 0 OR EXISTS (SELECT 1 FROM cpalead_advertiser_offer_status WHERE cpalead_advertiser_offer_status.offer_id = cpalead_offer.id AND cpalead_advertiser_offer_status.status = 'Approve'))";

        $order_section = $this->order($sort_offer['sort_field'], $sort_offer['sort_type']);

        $query = "$select_section $from_section $where_section $order_section LIMIT $start_offset, 12";
        return [
            'offers' => $this->db->query($query) ? $this->db->query($query)->result() : [],
            'count' => $this->count_page($where_section)
        ];
    }

    public function get_available_offers($uid, $start_offset = 0, $end_offset = 12)
    {
        $sort_offer = $this->sort_options($this->session->userdata('sort_offer'));
        $select_section = $this->select($uid);
        $from_section = $this->from($uid, $sort_offer['sort_field']);
        $where_section = $this->where($uid) . " AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid LIMIT 1) ELSE 'Approved' END) in ('Approved','Pending')";
        $order_section = $this->order($sort_offer['sort_field'], $sort_offer['sort_type']);
        $query = "$select_section $from_section $where_section $order_section LIMIT $start_offset, 12";
        return [
            'offers' => $this->db->query($query) ? $this->db->query($query)->result() : [],
            'count' => $this->count_page($where_section)
        ];
    }

    public function get_live_offers($uid, $start_offset = 0, $end_offset = 12)
    {
        $sort_offer = $this->sort_options($this->session->userdata('sort_offer'));
        $select_section = $this->select($uid);
        $from_section = $this->from($uid, $sort_offer['sort_field']);
        $where_section = $this->where($uid) . " AND (CASE cpalead_offer.request WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid =cpalead_offer.id AND cpalead_request.userid = $uid LIMIT 1) ELSE 'Approved' END)='Approved'";
        $order_section = $this->order($sort_offer['sort_field'], $sort_offer['sort_type']);

        $query = "$select_section $from_section $where_section $order_section LIMIT $start_offset, 12";

        return [
            'offers' => $this->db->query($query) ? $this->db->query($query)->result() : [],
            'count' => $this->count_page($where_section)
        ];
    }

    public function get_offer_by_cat($cat_id, $uid)
    {
        $qr = "SELECT cpalead_offer.* , 'Approved' as status
                FROM cpalead_offer
                WHERE `show` = 1 AND smartoff =0 AND smartlink=0 AND request = 1 AND product_cat = $cat_id
                ORDER BY `id` DESC 
                ";
        return $this->db->query($qr) ? $this->db->query($qr)->result() : null;
    }

    public function get_invited_offers($publisher_id, $start_offset = 0, $end_offset = 12)
    {
        $sort_offer = $this->sort_options($this->session->userdata('sort_offer'));
        $select_section = $this->select($publisher_id);
        $from_section = $this->from($publisher_id, $sort_offer['sort_field']);
        $where_section = $this->where($publisher_id);
        $order_section = $this->order($sort_offer['sort_field'], $sort_offer['sort_type']);
        $join_section = "INNER JOIN cpalead_invited_publishers ON cpalead_invited_publishers.product_id = cpalead_offer.id AND cpalead_invited_publishers.publisher_id = '$publisher_id' ";
        $join_staus = "INNER JOIN cpalead_advertiser_offer_status ON cpalead_advertiser_offer_status.offer_id = cpalead_offer.id AND cpalead_advertiser_offer_status.status = 'Approve'";
        $count_query = "$select_section $from_section $join_section $join_staus $where_section $order_section";
        $result_query = $count_query . " LIMIT $start_offset, $end_offset";
        return [
            'offers' => $this->db->query($result_query) ? $this->db->query($result_query)->result() : [],
            'count' => count($this->db->query($count_query)->result())
        ];
    }

    public function get_invitation_advertisers($publisher_id)
    {
        $query_string = " SELECT cpalead_advertiser.id, cpalead_advertiser.email,cpalead_advertiser.username , cpalead_advertiser.avatar_url  FROM cpalead_invited_publishers
        INNER JOIN cpalead_advertiser on cpalead_invited_publishers.advertiser_id = cpalead_advertiser.id
        WHERE cpalead_invited_publishers.publisher_id = $publisher_id
        GROUP BY cpalead_advertiser.id, cpalead_advertiser.email ";

        return $this->db->query($query_string)->result();
    }
}
