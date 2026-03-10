<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adv_offer_api_model extends CI_Model
{
    public function find_user_by_api_key($api_key)
    {
        $api_key = trim((string)$api_key);
        if ($api_key === '') return null;

        return $this->db
            ->from('cpalead_api_key')
            ->where('api_key', $api_key)
            ->limit(1)
            ->get()
            ->row();
    }

    public function get_api_enabled_offers_by_user($user_id)
    {
        $user_id = (int)$user_id;
        if ($user_id <= 0) return array();

        $sql = "
            SELECT
                o.id,
                o.title,
                o.preview,
                o.img,
                o.description,
                o.offercat,
                o.point,
                o.percent,
                o.point_geos,
                o.percent_geos,
                o.cr,
                o.epc,
                o.show,
                o.created,
                o.country
            FROM cpalead_offer o
            WHERE o.apion = 1 AND o.show = 1
            ORDER BY o.id DESC
        ";

        $rows = $this->db->query($sql, array($user_id))->result();
        if (!$rows) return array();

        $result = array();
        foreach ($rows as $row) {
            $result[] = $this->map_offer_to_api_format($row);
        }

        return $result;
    }

    private function map_offer_to_api_format($row)
    {
        $offer_id = (int)$row->id;

        return array(
            'external_offer_id' => (string)$offer_id,
            'title'             => (string)$row->title,
            'preview_url'       => $this->extract_preview_url($row->preview, $row),
            'logo'              => $this->normalize_url($row->img),
            'description'       => $row->description !== null ? (string)$row->description : '',
            'cr'                => (float)$row->cr,
            'epc'               => $row->epc !== null ? (float)$row->epc : 0,
            'countries'         => $this->get_offer_countries($offer_id, $row),
            'categories'        => $this->get_offer_categories($row->offercat),
            'payout'            => $this->build_payout_from_geos($row),
            'status'            => ((int)$row->show === 1 ? 'active' : 'paused'),
            'updated_at'        => $this->format_date_ymd($row->updated_show_at ? $row->updated_show_at : $row->created),
        );
    }


    private function extract_preview_url($preview, $row = null)
    {
        $preview = trim((string)$preview);

        if ($preview !== '' && filter_var($preview, FILTER_VALIDATE_URL)) {
            return $preview;
        }

        $data = $this->safe_unserialize($preview);
        if (is_array($data)) {
            foreach ($data as $item) {
                if (is_array($item) && isset($item['value'])) {
                    $v = trim((string)$item['value']);
                    if ($v !== '' && filter_var($v, FILTER_VALIDATE_URL)) {
                        return $v;
                    }
                }
            }
        }

        if ($row && isset($row->url)) {
            $u = trim((string)$row->url);
            if ($u !== '' && filter_var($u, FILTER_VALIDATE_URL)) {
                return $u;
            }
        }

        return '';
    }



    private function build_payout_from_geos($row)
    {
        $pointData   = $this->safe_unserialize(isset($row->point_geos) ? $row->point_geos : '');
        $percentData = $this->safe_unserialize(isset($row->percent_geos) ? $row->percent_geos : '');

        if (!is_array($pointData)) $pointData = array();
        if (!is_array($percentData)) $percentData = array();

        $items = array();

        // fixed payouts
        foreach ($pointData as $geo => $val) {
            $value = (float)$val;
            if ($value > 0) {
                $items[] = array(
                    'country' => strtolower($geo) === 'all' ? 'all' : strtoupper(trim((string)$geo)),
                    'type'    => 'fixed',
                    'value'   => $value
                );
            }
        }

        // percent payouts
        foreach ($percentData as $geo => $val) {
            $value = (float)$val;
            if ($value > 0) {
                $items[] = array(
                    'country' => strtolower($geo) === 'all' ? 'all' : strtoupper(trim((string)$geo)),
                    'type'    => 'percent',
                    'value'   => $value
                );
            }
        }

        return array_values($items);
    }


    private function extract_geo_payout_info($serialized)
    {
        $serialized = trim((string)$serialized);

        $result = array(
            'value' => 0,
            'country' => ''
        );

        if ($serialized === '' || $serialized === 'N;') {
            return $result;
        }

        $data = $this->safe_unserialize($serialized);
        if (!is_array($data) || empty($data)) {
            return $result;
        }

        if (isset($data['all'])) {
            $v = (float)$data['all'];
            if ($v > 0) {
                return array(
                    'value' => $v,
                    'country' => 'all'
                );
            }
        }

        foreach ($data as $geo => $val) {
            $v = (float)$val;
            if ($v > 0) {
                return array(
                    'value' => $v,
                    'country' => strtoupper(trim((string)$geo))
                );
            }
        }

        return $result;
    }


    private function extract_geo_payout_value($serialized, $fallback = 0)
    {
        $serialized = trim((string)$serialized);

        if ($serialized === '' || $serialized === 'N;') {
            return (float)$fallback;
        }

        $data = $this->safe_unserialize($serialized);
        if (!is_array($data) || empty($data)) {
            return (float)$fallback;
        }

        if (isset($data['all'])) {
            $v = (float)$data['all'];
            if ($v > 0) {
                return $v;
            }
        }

        foreach ($data as $geo => $val) {
            $v = (float)$val;
            if ($v > 0) {
                return $v;
            }
        }

        return (float)$fallback;
    }


    private function safe_unserialize($value)
    {
        if (!is_string($value) || trim($value) === '') {
            return null;
        }

        $value = trim($value);

        if ($value === 'N;') {
            return null;
        }

        $out = @unserialize($value);
        if ($out === false && $value !== 'b:0;') {
            return null;
        }

        return $out;
    }



    private function normalize_url($url)
    {
        $url = trim((string)$url);
        return $url;
    }

    private function format_date_ymd($dt)
    {
        $dt = trim((string)$dt);
        if ($dt === '') return date('Y-m-d');
        return substr($dt, 0, 10);
    }

    private function build_payout($type, $point, $percent)
    {
        $type = strtolower(trim((string)$type));

        if ($type === 'percent') {
            return array(
                'type'  => 'percent',
                'value' => (float)$percent
            );
        }

        return array(
            'type'  => 'fixed',
            'value' => (float)$point
        );
    }

    private function get_offer_countries($offer_id)
    {
        $offer_id = (int)$offer_id;
        if ($offer_id <= 0) return array();

        $rows = $this->db
            ->select('country')
            ->from('cpalead_off_ctry')
            ->where('offer_id', $offer_id)
            ->get()
            ->result();

        if (!$rows) return array();

        $countries = array();
        foreach ($rows as $r) {
            $c = strtoupper(trim((string)$r->country));
            if ($c !== '') $countries[] = $c;
        }

        $countries = array_values(array_unique($countries));
        return $countries;
    }

    private function get_offer_categories($offercat)
    {
        $offercat = trim((string)$offercat);
        if ($offercat === '') return array();

        preg_match_all('/o(\d+)o?/', $offercat, $matches);
        if (empty($matches[1])) return array();

        $ids = array();
        foreach ($matches[1] as $id) {
            $id = (int)$id;
            if ($id > 0) $ids[] = $id;
        }

        $ids = array_values(array_unique($ids));
        if (empty($ids)) return array();

        $rows = $this->db
            ->select('offercat')
            ->from('cpalead_offercat')
            ->where_in('id', $ids)
            ->where('show', 1)
            ->get()
            ->result();

        if (!$rows) return array();

        $cats = array();
        foreach ($rows as $r) {
            $name = trim((string)$r->offercat);
            if ($name !== '') $cats[] = $name;
        }

        return array_values(array_unique($cats));
    }
}