<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crontab extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
        $this->base_key = $this->config->item('base_key');
    }

    function index()
    {
        /*
        echo $yesterday =  date('Y-m-d 23:59:59',strtotime('-1day'));
        $pub_config= unserialize(file_get_contents('setting_file/publisher.txt'));
        echo $minpay = $pub_config['minpay'];
        */
    }

    public function update_status_expired()
    {
        return 1;
        $sql = "
            UPDATE cpalead_tracklink AS t
            JOIN cpalead_offer AS o ON o.id = t.offerid
            SET t.status = 4
            WHERE t.status = 1 AND o.is_adv > 0
            AND CURDATE() > DATE_ADD(
                CASE 
                    WHEN o.paymterm_calc = 2 THEN DATE_ADD(t.date, INTERVAL (7 - DAYOFWEEK(t.date)) DAY)
                    WHEN o.paymterm_calc = 1 THEN LAST_DAY(t.date)
                END,
                INTERVAL (o.confirm_date + 5) DAY
            )
        ";
        $this->db->query($sql);
        echo "Done\n";
    }

    function cronmonth()
    {
        return 1;
        $text =  ' Invoice: ' . date('M Y', strtotime('-2 month'));
        $pub_config = unserialize(file_get_contents('setting_file/publisher.txt'));
        $minpay = (int)$pub_config['minpay'];
        $endate =  date('Y-m-01 00:00:00', strtotime('-1 month'));
        $yesterday =  date('Y-m-d 23:59:59', strtotime('-1day'));
        $qr = "
            SELECT SUM(amount2) as pay,userid
            from cpalead_tracklink
            inner join cpalead_users
                on cpalead_tracklink.userid = cpalead_users.id
            WHERE cpalead_tracklink.status =1 and cpalead_tracklink.date>cpalead_users.date_invoice and date< '$endate'
            GROUP BY userid
            HAVING pay >=$minpay
        ";
        $data = $this->db->query($qr)->result();
        $this->db->trans_strict(FALSE);
        if (!empty($data)) {
            foreach ($data as $data) { //log
                $this->db->trans_start();
                $point = $data->pay;
                $this->db->where('id', $data->userid);
                $this->db->set('curent', "curent - $point", FALSE);
                $this->db->set('pending', "pending + $point", FALSE);
                $this->db->set('log', "invoice: $yesterday - $point");
                $this->db->set('date_invoice', $endate);
                $this->db->update('users');
                if ($this->db->affected_rows() > 0) {
                    $this->db->insert('invoice', array(
                        'status' => 'Pending',
                        'amount' => $point,
                        'note' => $text,
                        'usersid' => $data->userid,
                        'date' => $yesterday
                    ));
                }
                $this->db->trans_complete();
            }
        }
    }

    function cron24h()
    {
        $qr = "
        UPDATE `cpalead_offer` 
            SET cr= ROUND((lead/click)*100, 2),
                epc =  ROUND((revenue/click),2)     
            WHERE revenue>0 AND auto_cr=0
        ";
        $this->db->query($qr);
    }

    function listCapKeys($type = 'all')
    {
        try {
            echo "<pre>";

            $patterns = [];

            if ($type === 'daily' || $type === 'all') {
                $patterns[] = 'wwaff_dailycap_*';
            }

            if ($type === 'monthly' || $type === 'all') {
                $patterns[] = 'wwaff_monthlycap_*';
            }

            foreach ($patterns as $pattern) {
                $keys = $this->redis->keys($pattern);
                foreach ($keys as $key) {
                    echo "KEY: $key\n";

                    $hashData = $this->redis->hGetAll($key);
                    if (!empty($hashData)) {
                        foreach ($hashData as $subKey => $value) {
                            echo "  SUBKEY: $subKey = $value\n";
                        }
                    } else {
                        echo "  (No sub-keys)\n";
                    }
                    echo "\n";
                }
            }

            echo "</pre>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function resetDailyCap()
    {
        try {
            $keys = $this->redis->keys('wwaff_dailycap_*');
            $deletedCount = 0;

            if (!empty($keys)) {
                $deletedCount = $this->redis->del($keys);
            }

            echo "Reset daily cap: Deleted $deletedCount keys at " . date('Y-m-d H:i:s') . "<br>";
            $this->resetOverallDailyCap();
        } catch (Exception $e) {
            echo "Error resetting daily cap: " . $e->getMessage();
        }
    }

    function resetOverallDailyCap()
    {
        try {
            $keys = $this->redis->keys('wwaff_allpubcap_*');
            $deletedCount = 0;

            if (!empty($keys)) {
                $deletedCount = $this->redis->del($keys);
            }

            echo "Reset overall daily cap: Deleted $deletedCount keys at " . date('Y-m-d H:i:s') . "<br>";
        } catch (Exception $e) {
            echo "Error resetting overall daily cap: " . $e->getMessage() . "<br>";
        }
    }

    function resetMonthlyCap()
    {
        try {
            $keys = $this->redis->keys('wwaff_monthlycap_*');
            $deletedCount = 0;

            if (!empty($keys)) {
                $deletedCount = $this->redis->del($keys);
            }

            echo "Reset monthly cap: Deleted $deletedCount keys at " . date('Y-m-d H:i:s');
        } catch (Exception $e) {
            echo "Error resetting monthly cap: " . $e->getMessage();
        }
    }

    public function debug_all_redis_keys()
    {
        try {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            $all_keys = $redis->keys('*offLang*');

            echo "<h3>Redis Keys (offLang)</h3>";
            echo "<pre>";

            if (empty($all_keys)) {
                echo "Không có key offLang nào trong Redis.";
            } else {
                $grouped_keys = [
                    'offLang' => [],
                    'other' => []
                ];

                foreach ($all_keys as $key) {
                    if (strpos($key, '-offLang-') !== false) {
                        $grouped_keys['offLang'][] = $key;
                    } else {
                        $grouped_keys['other'][] = $key;
                    }
                }

                foreach ($grouped_keys as $type => $keys) {
                    if (!empty($keys)) {
                        echo "\n=== {$type} Keys ===\n";
                        foreach ($keys as $key) {
                            $value = $redis->get($key);
                            $ttl = $redis->ttl($key);
                            $ttl_info = $ttl > 0 ? " (TTL: {$ttl}s)" : ($ttl == -1 ? " (No expire)" : " (Expired)");
                            echo "{$key} => {$value}{$ttl_info}\n";
                        }
                    }
                }

                echo "\n=== Summary ===\n";
                foreach ($grouped_keys as $type => $keys) {
                    $count = count($keys);
                    if ($count > 0) {
                        echo "{$type}: {$count} keys\n";
                    }
                }
                echo "Total: " . count($all_keys) . " keys\n";
            }

            echo "</pre>";
            $redis->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function update_decline_rate_perPub()
    {
        $log_separator = str_repeat("=", 60);
        $timestamp = date('Y-m-d H:i:s');

        echo "\n{$log_separator}\n";
        echo "[{$timestamp}] Bắt đầu update decline rate cho users...\n";

        $start_time = microtime(true);

        $sql = "
        UPDATE cpalead_users u
        LEFT JOIN (
            SELECT 
                userid,
                SUM(CASE WHEN status = 2 THEN amount2 ELSE 0 END) as declined,
                SUM(CASE WHEN status = 3 THEN amount2 ELSE 0 END) as pay,
                SUM(CASE WHEN status = 4 THEN amount2 ELSE 0 END) as approved
            FROM cpalead_tracklink
            WHERE status IN (2, 3, 4)
            GROUP BY userid
        ) t ON u.id = t.userid
        SET u.decline_rate = CASE
            WHEN t.userid IS NULL THEN NULL
            WHEN (t.declined + t.pay + t.approved) = 0 THEN NULL
            WHEN t.declined = 0 THEN 0
            WHEN (t.pay + t.approved) = 0 THEN 100
            ELSE ROUND((t.declined / (t.declined + t.pay + t.approved)) * 100, 2)
        END
        ";

        $this->db->query($sql);
        $affected = $this->db->affected_rows();

        $end_time = microtime(true);
        $execution_time = round($end_time - $start_time, 2);

        echo "[{$timestamp}] Updated: {$affected} users\n";
        echo "[{$timestamp}] Thời gian: {$execution_time} giây\n";
        echo "{$log_separator}\n\n";
    }

    public function listCrKeys()
    {
        try {
            echo "<pre>";
            echo "<h3>CR Count Keys</h3>";

            $cr_keys = $this->redis->keys('*-crCount-*');

            if (empty($cr_keys)) {
                echo "Không có CR key nào.\n";
            } else {
                echo "Tổng: " . count($cr_keys) . " keys\n\n";

                foreach ($cr_keys as $key) {
                    echo "KEY: $key\n";
                    $data = $this->redis->hGetAll($key);
                    $ttl = $this->redis->ttl($key);
                    $ttl_info = $ttl > 0 ? "{$ttl}s" : ($ttl == -1 ? "No expire" : "Expired");

                    if (!empty($data)) {
                        $clicks = isset($data['clicks']) ? $data['clicks'] : 0;
                        $leads = isset($data['leads']) ? $data['leads'] : 0;
                        $cr = $clicks > 0 ? round(($leads / $clicks) * 100, 2) : 0;

                        echo "  userid: " . (isset($data['userid']) ? $data['userid'] : 'N/A') . "\n";
                        echo "  offerid: " . (isset($data['offerid']) ? $data['offerid'] : 'N/A') . "\n";
                        echo "  sub2: " . (isset($data['sub2']) ? $data['sub2'] : 'N/A') . "\n";
                        echo "  clicks: $clicks\n";
                        echo "  leads: $leads\n";
                        echo "  CR: {$cr}%\n";
                        echo "  date: " . (isset($data['date']) ? $data['date'] : 'N/A') . "\n";
                        echo "  TTL: $ttl_info\n";
                    } else {
                        echo "  (Empty hash)\n";
                    }
                    echo "\n";
                }
            }

            echo "</pre>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function listSuspendKeys()
    {
        try {
            echo "<pre>";
            echo "<h3>Suspend Keys</h3>";

            $suspend_keys = $this->redis->keys('*-suspend-*');

            if (empty($suspend_keys)) {
                echo "Không có Suspend key nào.\n";
            } else {
                echo "Tổng: " . count($suspend_keys) . " keys\n\n";

                foreach ($suspend_keys as $key) {
                    echo "KEY: $key\n";
                    $data_json = $this->redis->get($key);
                    $ttl = $this->redis->ttl($key);

                    if ($data_json) {
                        $data = json_decode($data_json, true);
                        $expire_time = isset($data['expire_time']) ? $data['expire_time'] : 0;
                        $violation_cr = isset($data['violation_cr']) ? $data['violation_cr'] : 0;

                        $now = time();
                        $remaining = $expire_time - $now;

                        echo "  violation_cr: {$violation_cr}%\n";
                        echo "  expire_time: " . date('Y-m-d H:i:s', $expire_time) . "\n";
                        echo "  remaining: " . ($remaining > 0 ? "{$remaining}s" : "Expired") . "\n";
                        echo "  TTL: " . ($ttl > 0 ? "{$ttl}s" : "Expired") . "\n";
                    } else {
                        echo "  (Empty or expired)\n";
                    }
                    echo "\n";
                }
            }

            echo "</pre>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteSuspendKey($key = '')
    {
        if (empty($key)) {
            echo "Usage: /crontab/deleteSuspendKey/{key_name}";
            return;
        }

        try {
            // Decode URL nếu key có ký tự đặc biệt
            $key = urldecode($key);

            if (!$this->redis->exists($key)) {
                echo "Key không tồn tại: $key";
                return;
            }

            $this->redis->del($key);
            echo "Đã xoá key: $key";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function debugUnknownBrowserValues()
    {
        $pattern = $this->base_key . '-unknownBrowser-*';
        $keys = $this->redis->keys($pattern);

        if ($keys) {
            echo "<pre>";
            foreach ($keys as $key) {
                $value = $this->redis->get($key);
                echo $key . " => " . $value . "\n";
            }
            echo "</pre>";
        } else {
            echo "không có key nào hết";
        }
    }

    function clear_unknowbrowser_keys()
    {
        $base_key = $this->config->item('base_key');
        $pattern = $base_key . '-unknownBrowser-*';

        $keys = $this->redis->keys($pattern);
        $deleted = 0;

        if (!empty($keys)) {
            foreach ($keys as $key) {
                $this->redis->del($key);
                $deleted++;
            }
        }

        log_message('info', '[Crontab] Cleared ' . $deleted . ' unknow browser keys');
        echo json_encode(['status' => 'success', 'deleted' => $deleted]);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */