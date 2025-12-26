<?php

require_once APPPATH . 'libraries/observer/classes/notification_publisher_update_info.php';

class Advertiser_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    private function add_percent_char(array $data)
    {
        return array_map(function ($value) {
            return "'%o{$value}o%'";
        }, $data);
    }

    private function generic_filter($uid)
    {
        return " cpalead_offer.id not in (SELECT distinct  offerid FROM cpalead_disoffer WHERE usersid = $uid) ";
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

    private function select($uid)
    {
        return "SELECT cpalead_offer.*, ( {$this->get_top_products($uid, 20)} WHERE tmp_ranking.id = cpalead_offer.id ) as ranking,
                    CASE cpalead_offer.request
                        WHEN 1 THEN (SELECT status From cpalead_request where cpalead_request.offerid = cpalead_offer.id AND cpalead_request.userid = $uid limit 1)
                        ELSE 'Approved'
                    END AS status";
    }

    private function from($uid, $sort_field = 'id')
    {
        // if ($sort_field === 'favorite')
        //     return "FROM cpalead_offer INNER JOIN cpalead_favorite_offer ON cpalead_favorite_offer.offer_id = cpalead_offer.id AND cpalead_favorite_offer.user_id = $uid AND cpalead_favorite_offer.is_liked = 1 AND cpalead_favorite_offer.is_adv = 1";
        return "FROM cpalead_offer";
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

        $query = "WHERE cpalead_offer.is_adv = '$uid' AND cpalead_offer.show = 1 AND {$this->generic_filter($uid)} $filter_countries $filter_categories $filter_payments $filter_name $filter_types";
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

    private function sort_options($sort = '')
    {
        $sort_field = 'default';
        $sort_type = 'desc';

        if ($sort) {
            $sort_offer = explode('-', $sort);
            $sort_field = $sort_offer[0];
            $sort_type = $sort_offer[1];
        }

        return compact('sort_field', 'sort_type');
    }

    function get_list_country()
    {
        $query = $this->db->where('show', 1)->get('country');
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else return null;
    }

    function get_list_p_categories()
    {
        $query = $this->db->where('show', 1)->get('offercat');
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else return null;
    }

    function add($data)
    {
        $this->db->insert('advertiser', [
            'username' => $data['username'],
            'email' => $data['email'],
            'address' => $data['address'],
            'password' => $data['password'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'avatar_url' => $data['avatar_url'],
            'product_geo_ids' => $data['product_geo_ids'],
            'social_network' => $data['social_network'],
            'website' => $data['website'],
            'is_company' => $data['is_company'],
            'how_to_get_traffic' => $data['how_to_get_traffic'],
            'user_setting' => $data['user_setting'],
            'ref_pub_token' => $data['ref_pub_token'],
            'using_ref_token' => $data['using_ref_token']
        ]);
        $user = $this->db->where('email', $data['email'])->get('advertiser')->row();
        foreach ($data['traffic_source_id'] as $traffic) {
            $this->db->insert('advertiser_traffic', [
                'traffic_source_id' => $traffic,
                'advertiser_id' => $user->id
            ]);
        }
        foreach ($data['product_categories'] as $pcate) {
            $this->db->insert('advertiser_pcategories', [
                'product_category_id' => $pcate,
                'advertiser_id' => $user->id
            ]);
        }

        if ($data['has_affiliate_program'] == 0) {
            $pbvalue = [
                'clickid' => ['clickid', ''],
                'commission' => ['commission', ''],
                'sale_amount' => ['sale_amount', ''],
                'pub_id' => ['pub_id', ''],
                'view2' => ['view2', ''],
                'view3' => ['view3', ''],
                'view4' => ['view4', ''],
                'view5' => ['view5', ''],
                'lead_date' => ['lead_date', ''],
                'click_date' => ['click_date', ''],
                'click_url' => ['click_url', ''],
                'lead_Geo' => ['lead_Geo', ''],
            ];
            $this->load->helper('string');
            $randomString = random_string('alnum', 9);
            $inserData = [
                'pb_pass' => $randomString,
                'adv_id' =>  $user->id,
                'title' => 'Main Network - ' . $data['username'],
                'pb_value' => serialize($pbvalue),
                'show' => 1,
                'order' => 0,
                'subid' => '?pub_id=#pubid#&clickid=#clickid#'
            ];
            $this->db->insert('cpalead_network', $inserData);
        }

        return true;
    }

    function getListAdvertiser($limit, $offset)
    {
        $offset = $offset - 1;
        $query_string = "
        SELECT cpalead_advertiser.*, t1.*, t2.*, cpalead_advertiser.id as id, cpalead_manager.username as manager, cpalead_manager.id as manager_id
        FROM (
            SELECT
            cpalead_advertiser.id,
            SUM(IF (cpalead_tracklink.status = 1, cpalead_tracklink.amount2, 0)) as pending,
            SUM(IF (cpalead_tracklink.status = 2, cpalead_tracklink.amount2, 0)) as declined,
            SUM(IF (cpalead_tracklink.status = 3, cpalead_tracklink.amount2, 0)) as paid
        FROM cpalead_advertiser
        LEFT JOIN cpalead_offer on cpalead_offer.is_adv = cpalead_advertiser.id
        LEFT JOIN cpalead_tracklink on cpalead_offer.id = cpalead_tracklink.offerid
        GROUP BY cpalead_advertiser.id
        ) as t1
        INNER JOIN (
        SELECT
            cpalead_advertiser.id,
            SUM(cpalead_advertiser_payment.amount) as invoice
        FROM cpalead_advertiser
        LEFT JOIN cpalead_advertiser_payment ON cpalead_advertiser_payment.adv_id = cpalead_advertiser.id AND cpalead_advertiser_payment.status = 'Complete'
        GROUP BY cpalead_advertiser.id
        ) as t2 on t2.id = t1.id
        INNER JOIN cpalead_advertiser on t1.id = cpalead_advertiser.id
        INNER JOIN cpalead_manager on cpalead_manager.id = cpalead_advertiser.manager
        LIMIT $offset, $limit
        ";

        $total_rows = $this->db->count_all_results('advertiser', FALSE);

        $query = $this->db->query($query_string);

        if ($query) {
            $data = $query->result();
            $query->free_result();
            return array(
                'total_rows' => $total_rows,
                'data' => $data
            );
        } else {
            return array(
                'total_rows' => 0,
                'data' => [],
            );
        };
    }

    function update_status($id, $status)
    {
        try {
            $this->db->where('id', $id);
            $this->db->update('advertiser', ['status' => $status]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    function get_payments($query = [], $offset = 0, $per_page = 10)
    {
        if ($query['status'])
            $this->db->where_in('status', $query['status']);
        if ($query['date']) {
            $first = date("Y-m-01", strtotime($query['date']));
            $end = date("Y-m-t", strtotime($query['date']));
            $this->db->where('date >=', $first);
            $this->db->where('date <=', $end);
        }

        if ($query['adv_id'])
            $this->db->where('adv_id', $query['adv_id']);

        $query = $this->db->get('advertiser_payment', $per_page, $offset)->result();
        $total = count($this->db->get('advertiser_payment')->result());
        return [$query, $total];
    }

    function update_status_payment($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update('advertiser_payment', ['status' => $status]);

        return $this->db->affected_rows() >= 1;
    }

    function delete_payment($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('advertiser_payment');
        return $this->db->affected_rows() >= 1;
    }

    function add_product($data)
    {
        $this->db->insert('offer', $data);
        $offer_id = $this->db->insert_id();
        $this->db->insert('advertiser_offer_status', ['offer_id' => $offer_id, 'status' => 'Pending']);
        return $this->db->affected_rows() >= 1;
    }

    function get_products($offset, $limit = 10, $where = '')
    {
        /* COUNT ALL PRODUCT */
        $count_sql = "SELECT COUNT(*) as total FROM cpalead_offer";
        if (!empty($where)) {
            $count_sql .= " WHERE 1=1 $where";
        }
        $count_result = $this->db->query($count_sql)->row();
        $total = $count_result ? (int)$count_result->total : 0;

        /*  GET RESULTS AND PAGINATION  */
        $where_sql = "";
        if (!empty($where)) {
            $where_sql = "WHERE 1=1 $where";
        }

        $query = "SELECT cpalead_offer.*, cpalead_network.title as nettile, cpalead_advertiser_offer_status.status as product_status 
            FROM cpalead_offer 
            LEFT JOIN cpalead_advertiser_offer_status on cpalead_advertiser_offer_status.offer_id = cpalead_offer.id
            LEFT JOIN cpalead_network ON cpalead_offer.idnet = cpalead_network.id 
            $where_sql
            ORDER BY cpalead_offer.id DESC
            LIMIT $offset, $limit";

        $result = $this->db->query($query);
        $products = $result ? $result->result() : null;
        return [$products, $total];
    }

    function invite_publisher($product_id, $advertiser_id, $publisher_id, $message = "You have a invitation from Advertiser")
    {
        $this->db->where(['userid' => $publisher_id, 'offerid' => $product_id]);
        $requested = $this->db->get('request')->row();

        if ($requested) {
            $request_id = $requested->id;
        } else {
            $this->db->insert('request', ['userid' => $publisher_id, 'offerid' => $product_id, 'crequest' => $message]);
            $request_id = $this->db->insert_id();
        }

        $this->db->insert('invited_publishers', ['request_id' => $request_id, 'publisher_id' => $publisher_id, 'advertiser_id' => $advertiser_id, 'product_id' => $product_id, 'invitation_message' => $message]);
        return $this->db->affected_rows() >= 1;
    }

    function rating_publisher($rating, $advertiser_id, $publisher_id)
    {
        $isExists = $this->db->get_where('publisher_rating', ['advertiser_id' => $advertiser_id, 'publisher_id' => $publisher_id]);

        if ($isExists->num_rows === 1) {
            return false;
        }

        $this->db->insert('publisher_rating', ['publisher_id' => $publisher_id, 'advertiser_id' => $advertiser_id, 'rating' => $rating]);
        if ($this->db->affected_rows() >= 1) {
            $advertiser = $this->Home_model->get_one('advertiser', ['id' => $advertiser_id]);
            (new Notification_Publisher_Update_Info($publisher_id))->notify_receive_rating($advertiser);
            return true;
        }
    }

    function get_own_products($start_offset = 0, $limit = 12)
    {
        $uid = $this->session->userdata('user')->id;

        $sort_offer = $this->sort_options($this->session->userdata('sort_offer'));
        $select_section = $this->select($uid);
        $from_section = $this->from($uid, $sort_offer['sort_field']);
        $where_section = $this->where($uid);
        $order_section = $this->order($sort_offer['sort_field'], $sort_offer['sort_type']);

        $count_query = "SELECT COUNT(*) as total $from_section $where_section";
        $total = $this->db->query($count_query)->row()->total;

        $query = "$select_section $from_section $where_section $order_section";
        $result = $query . " LIMIT $start_offset, $limit";
        $records = $this->db->query($result) ? $this->db->query($result)->result() : [];
        return [$records, $total];
    }

    function get_my_approved_products()
    {
        $advertiser_id = $this->session->userdata('user')->id;
        $q = "SELECT cpalead_offer.* FROM cpalead_offer
        INNER JOIN cpalead_advertiser_offer_status on cpalead_offer.id = cpalead_advertiser_offer_status.offer_id
        WHERE cpalead_offer.is_adv = '$advertiser_id' AND cpalead_offer.`show` = 1 AND cpalead_advertiser_offer_status.status = 'Approve'";

        $query = $this->db->query($q);
        $results = $query ? $query->result() : [];
        return $results;
    }

    function get_invited_products($publisher_id)
    {
        $advertiser_id = $this->session->userdata('user')->id;
        $q = "SELECT cpalead_invited_publishers.* FROM cpalead_invited_publishers
        INNER JOIN cpalead_offer on cpalead_offer.id = cpalead_invited_publishers.product_id
        INNER JOIN cpalead_advertiser_offer_status on cpalead_advertiser_offer_status.offer_id = cpalead_offer.id
        WHERE cpalead_offer.`show` = 1 AND cpalead_invited_publishers.publisher_id = '$publisher_id' AND cpalead_advertiser_offer_status.status = 'Approve' AND cpalead_offer.is_adv = $advertiser_id";

        $query = $this->db->query($q);
        $results = $query ? $query->result() : [];
        return $results;
    }

    function get_requested_products($publisher_id)
    {
        $q = "SELECT cpalead_request.* FROM cpalead_request
        INNER JOIN cpalead_offer ON cpalead_offer.id = cpalead_request.offerid and cpalead_offer.`show` = 1
        WHERE cpalead_request.userid = '$publisher_id' AND cpalead_offer.is_adv = '{$this->session->userdata('user')->id}'";

        $query = $this->db->query($q);
        $results = $query ? $query->result() : [];
        return $results;
    }

    function change_password($old_password, $new_password)
    {
        $id = $this->session->userdata('user')->id;
        $advertiser = $this->db->get_where('advertiser', ['id' => $id, 'password' => sha1(md5($old_password))]);

        if ($advertiser->result()) {
            $this->db->where('id', $id);
            $this->db->update('advertiser', ['password' => sha1(md5($new_password))]);
            return $this->db->affected_rows() >= 1;
        }

        return false;
    }

    public function update_profile($data)
    {

        $traffic_sources = $data['traffic_source'];
        $product_cats = $data['product_categories'];
        $data['product_geo_ids'] = serialize($data['product_geo_ids']);
        unset($data['traffic_source']);
        unset($data['product_categories']);
        // Update Profile table
        $id = $this->session->userdata('user')->id;
        $this->db->where('id', $id);
        $this->db->update('advertiser', $data);
        // Update traffic source table

        $this->db->delete('advertiser_traffic', ['advertiser_id' => $id]);
        foreach ($traffic_sources as $traffic) {
            $this->db->insert('advertiser_traffic', ['traffic_source_id' => $traffic, 'advertiser_id' => $id]);
        }
        // Update Product Categories Table
        $this->db->delete('advertiser_pcategories', ['advertiser_id' => $id]);
        foreach ($product_cats as $cat) {
            $this->db->insert('advertiser_pcategories', ['product_category_id' => $cat, 'advertiser_id' => $id]);
        }

        return $this->db->affected_rows() >= 1;
    }

    public function get_new_publishers()
    {
        $id = $this->session->userdata('user')->id;
        $qr = " SELECT 
                cpalead_users.*, 
                cpalead_publisher_rating.rating,
                (SELECT SUM(rating)/count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as avg_rating,
                (SELECT count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as count_rating,
                (SELECT group_concat(type) from cpalead_offertype WHERE find_in_set(id, cpalead_users.conversion_flow )) as product_type,
                (SELECT group_concat(device) from cpalead_device WHERE find_in_set(id, cpalead_users.traffic_device )) as traffic_device,
                (SELECT group_concat(offercat) from cpalead_offercat WHERE find_in_set(id, cpalead_users.product_categories )) as product_cats,
                (SELECT LOWER(group_concat(keycode)) from cpalead_country WHERE find_in_set(id, cpalead_users.product_geos )) as product_geos,
                (SELECT SUM(amount) from cpalead_invoice WHERE usersid = cpalead_users.id and status = 'Complete') as total_invoice,
                (SELECT SUM(rating)/count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as avg_rating
            FROM cpalead_users 
            LEFT JOIN cpalead_publisher_rating ON cpalead_publisher_rating.publisher_id = cpalead_users.id AND cpalead_publisher_rating.advertiser_id = '$id'
            WHERE cpalead_users.`show` = 1
            ORDER BY cpalead_users.id DESC
            LIMIT 20
        ";

        $query = $this->db->query($qr);
        return $query ? $query->result() : null;
    }

    public function get_invited_publishers()
    {
        $id = $this->session->userdata('user')->id;
        $query = "SELECT 
            cpalead_users.*, cpalead_publisher_rating.rating, 
            (SELECT SUM(rating)/count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as avg_rating,
            (SELECT count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as count_rating,
            (SELECT group_concat(type) from cpalead_offertype WHERE find_in_set(id, cpalead_users.conversion_flow )) as product_type,
            (SELECT group_concat(device) from cpalead_device WHERE find_in_set(id, cpalead_users.traffic_device )) as traffic_device,
            (SELECT group_concat(offercat) from cpalead_offercat WHERE find_in_set(id, cpalead_users.product_categories )) as product_cats,
            (SELECT LOWER(group_concat(keycode)) from cpalead_country WHERE find_in_set(id, cpalead_users.product_geos )) as product_geos,
            (SELECT SUM(amount) from cpalead_invoice WHERE usersid = cpalead_users.id and status = 'Complete') as total_invoice,
            (SELECT SUM(rating)/count(*) from cpalead_publisher_rating where publisher_id = cpalead_users.id) as avg_rating
        FROM cpalead_invited_publishers
        INNER JOIN cpalead_users on cpalead_users.id = cpalead_invited_publishers.publisher_id 
        LEFT JOIN cpalead_publisher_rating ON cpalead_publisher_rating.publisher_id = cpalead_users.id AND cpalead_publisher_rating.advertiser_id = '$id'
        WHERE cpalead_invited_publishers.advertiser_id = '$id' and cpalead_users.`show` = 1 GROUP BY cpalead_invited_publishers.publisher_id";

        $results = $this->db->query($query);
        return $results ? $results->result() : null;
    }

    public function get_conversion_flow($ids)
    {
        $this->db->where_in('id', $ids);
        $query = $this->db->get('offertype');
        return $query ? $query->result() : null;
    }

    public function add_new_advertiser($data)
    {

        $entity = [
            'is_company' => $data['type_account'] == 'Persional' ? 0 : 1,
            'email' => $data['email'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => sha1(md5($data['password'])),
            'phone' => $data['phone'],
            'social_network' => $data['social_network'],
            'website' => $data['website'],
            'user_setting' => serialize($data['user_setting']),
            'username' => $data['username'],
        ];
        $this->db->insert('advertiser', $entity);
        return $this->db->affected_rows() >= 1;
    }

    public function update_advertiser($id, $data)
    {
        $isExists = $this->db->get_where('advertiser', ['id' => $id])->result();

        if (!$isExists)
            return false;

        if (isset($data['password'])) {
            $data['password'] = sha1(md5($data['password']));
        }

        $this->db->where('id', $id);
        $this->db->update('advertiser', $data);
        return $this->db->affected_rows() >= 1;
    }

    public function update_product($product_id, $data)
    {
        $advertiser_id = $this->session->userdata('user')->id;
        $isExists = $this->db->get_where('offer', ['is_adv' => $advertiser_id, 'id' => $product_id])->num_rows() > 0;

        if (!$isExists) {
            throw new Exception("Not Found");
        }

        $this->db->where('offer_id', $product_id);
        $this->db->update('advertiser_offer_status', ['status' => 'Pending']);

        $this->db->where('is_adv', $advertiser_id);
        $this->db->where('id', $product_id);
        $this->db->update('offer', $data);

        return $this->db->affected_rows() >= 1;
    }

    public function list_invited_publishers()
    {
        $advertiser_id = $this->session->userdata('user')->id;

        $query = "SELECT DISTINCT cpalead_invited_publishers.publisher_id, cpalead_users.*
        FROM cpalead_invited_publishers
        INNER JOIN cpalead_users on cpalead_users.id = cpalead_invited_publishers.publisher_id
        WHERE cpalead_invited_publishers.advertiser_id = $advertiser_id";

        $this->db->cache_on();
        $result = $this->db->query($query)->result();
        $total = count($result);
        $this->db->cache_off();
        return [$result, $total];
    }

    public function list_my_publishers()
    {
        $advertiser_id = $this->session->userdata('user')->id;

        $this->db->cache_on();
        $my_publishers_query = "
        SELECT 
            cpalead_users.*,
            cpalead_users_dashboard.epc,
            cpalead_users_dashboard.conversion_rate,
            cpalead_users_dashboard.level,
            (SELECT rating FROM cpalead_publisher_rating WHERE publisher_id = cpalead_request.userid AND advertiser_id = $advertiser_id) as rating,
            (SELECT LOWER(group_concat(keycode)) from cpalead_country WHERE find_in_set(id, cpalead_users.product_geos )) as product_geos
            FROM cpalead_users
        INNER JOIN cpalead_request ON cpalead_request.userid = cpalead_users.id
        INNER JOIN cpalead_offer ON cpalead_offer.id = cpalead_request.offerid
        INNER JOIN cpalead_advertiser_offer_status on cpalead_advertiser_offer_status.offer_id = cpalead_offer.id
        LEFT JOIN cpalead_users_dashboard on cpalead_users_dashboard.user_id = cpalead_users.id
        WHERE cpalead_offer.is_adv = $advertiser_id AND cpalead_advertiser_offer_status.status = 'Approve'
        AND NOT EXISTS (SELECT 1 FROM cpalead_invited_publishers WHERE cpalead_invited_publishers.product_id = cpalead_offer.id AND cpalead_invited_publishers.publisher_id = cpalead_users.id)
        GROUP BY cpalead_users.email
        ORDER BY (SELECT tmp.updated_at FROM cpalead_request tmp WHERE tmp.userid = cpalead_users.id ORDER BY id DESC LIMIT 1) DESC
        ";

        $result = $this->db->query($my_publishers_query)->result();
        $total = count($result);
        $this->db->cache_off();
        return [$result, $total];
    }

    public function check_arrive_paymterm($advertiser_id)
    {
        $paid_status = 4; // Apporved
        $query_string = "
            SELECT count(*) as need_payment FROM cpalead_tracklink
            INNER JOIN cpalead_offer ON cpalead_offer.id = cpalead_tracklink.offerid
            WHERE cpalead_tracklink.status = $paid_status 
                AND cpalead_offer.is_adv = $advertiser_id 
                AND cpalead_tracklink.deadline < DATE_ADD(NOW(), interval 5 day);
        ";

        $result = $this->db->query($query_string)->row();

        if ($result->need_payment > 0) {
            return true;
        }

        return false;
    }

    public function need_payment_amount($advertiser_id)
    {
        $paid_status = 4; // Apporved
        $query = "
            SELECT sum(amount3) as need_pay FROM cpalead_tracklink
            INNER JOIN cpalead_offer on cpalead_tracklink.offerid = cpalead_offer.id AND cpalead_offer.is_adv = $advertiser_id
            WHERE cpalead_tracklink.status = $paid_status AND adv_pay = 0
        ";
        return $this->db->query($query)->row()->need_pay;
    }
}