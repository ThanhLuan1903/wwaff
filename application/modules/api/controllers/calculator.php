<?php
require_once APPPATH . 'libraries/observer/classes/notification_publisher_update_info.php';
require_once APPPATH . 'libraries/modules/traits/publisher_trait.php';

class Calculator extends CI_Controller
{
    use PublisherTrait;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Calculator_model');
        $this->load->model('Admin_model');
        $this->load->model('Builder_model');
        $this->session->unset_userdata('sort');
        $this->session->unset_userdata('order');

        ini_set('max_execution_time', -1);
    }

    public function calc_publisher($user_id)
    {
        $this->db->where('id', $user_id);
        $isExistsPublisher = $this->db->get('users');

        if ($isExistsPublisher->num_rows() <= 0) {
            throw new Error('Publisher Not Found');
        }

        list($epc, $conversion_rate, $declined, $total, $hosts, $level, $rating) = $this->Calculator_model->publisher_info($user_id);
        $this->db->where('user_id', $user_id);
        $isUpdate = $this->db->get('users_dashboard');

        if ($isUpdate->num_rows() > 0) {
            $old = $isUpdate->row();

            if ($old->level < $level) {
                (new Notification_Publisher_Update_Info($user_id))->notify_level_up($level);
            }

            $this->db->where('user_id', $user_id);
            $this->db->update('users_dashboard', compact('epc', 'conversion_rate', 'declined', 'total', 'hosts', 'level', 'rating'));
            echo $this->db->affected_rows() > 0;
            return;
        }

        $result = $this->db->insert('users_dashboard', compact('user_id', 'epc', 'conversion_rate', 'declined', 'total', 'hosts', 'level', 'rating'));
        echo $this->db->affected_rows() > 0;
        return;
    }

    public function calc_advertiser($advertiser_id)
    {
        $this->db->where('id', $advertiser_id);
        $advertiser = $this->db->get('advertiser');

        if ($advertiser->num_rows() <= 0) {
            throw new Error('Advertiser Not Found');
        }

        list($balance, $holding, $available, $pending, $declined, $paid, $invoice) = $this->Calculator_model->advertiser_info($advertiser_id);
        $this->db->where('advertiser_id', $advertiser_id);
        $isExists = $this->db->get('advertiser_dashboard')->num_rows() > 0;

        if ($isExists) {
            $updated_at = date('Y-m-d H:i:m');
            $this->db->where('advertiser_id', $advertiser_id);
            $this->db->update('advertiser_dashboard', compact('balance', 'holding', 'available', 'pending', 'declined', 'paid', 'invoice', 'updated_at'));
            echo $this->db->affected_rows() > 0;
            return;
        }

        $this->db->insert('advertiser_dashboard', compact('advertiser_id', 'balance', 'holding', 'available', 'pending', 'declined', 'paid', 'invoice'));
        echo $this->db->affected_rows() > 0;
        return;
    }

    public function all_publishers()
    {
        $update_records = $this->Builder_model
            ->select("SELECT cpalead_users.id, cpalead_users_dashboard.level")
            ->query_from("FROM cpalead_users_dashboard INNER JOIN cpalead_users on cpalead_users.id = cpalead_users_dashboard.user_id")
            ->all();

        $insert_records = $this->Builder_model
            ->select("SELECT cpalead_users.id, cpalead_users_dashboard.level")
            ->query_from("FROM cpalead_users_dashboard INNER JOIN cpalead_users on cpalead_users.id = cpalead_users_dashboard.user_id WHERE NOT EXISTS( SELECT 1 FROM cpalead_users_dashboard WHERE user_id = cpalead_users.id)")
            ->all();

        ob_implicit_flush(true);
        echo json_encode(['update' => count($update_records), 'insert' => count($insert_records)]);
        ob_end_flush();

        try {
            foreach ($update_records as $publisher) {
                $user_id                                                                 = $publisher->id;
                list($epc, $conversion_rate, $declined, $total, $hosts, $level, $rating) = $this->Calculator_model->publisher_info($user_id);

                if ($publisher->level < $level) {
                    (new Notification_Publisher_Update_Info($user_id))->notify_level_up($level);
                }

                $updated_at = date('Y-m-d H:i:m');
                $this->db->where('user_id', $user_id);
                $this->db->update('users_dashboard', compact('epc', 'conversion_rate', 'declined', 'total', 'hosts', 'level', 'rating', 'updated_at'));
            }

            foreach ($insert_records as $publisher) {
                $user_id                                                                 = $publisher->id;
                list($epc, $conversion_rate, $declined, $total, $hosts, $level, $rating) = $this->Calculator_model->publisher_info($user_id);
                $this->db->insert('users_dashboard', compact('user_id', 'epc', 'conversion_rate', 'declined', 'total', 'hosts', 'level', 'rating'));
            }
        } catch (\Throwable $th) {
            log_message('error', $th);
        }

        echo 'Done';
        return;
    }

    public function all_advertisers()
    {
        $update_records = $this->Builder_model
            ->select("SELECT cpalead_advertiser.id")
            ->query_from("FROM cpalead_advertiser_dashboard INNER JOIN cpalead_advertiser on cpalead_advertiser.id = cpalead_advertiser_dashboard.advertiser_id")
            ->all();

        $insert_records = $this->Builder_model
            ->select("SELECT cpalead_advertiser.id")
            ->query_from("FROM cpalead_advertiser WHERE NOT EXISTS( SELECT 1 FROM cpalead_advertiser_dashboard WHERE advertiser_id = cpalead_advertiser.id)")
            ->all();

        ob_implicit_flush(true);
        echo json_encode(['update' => count($update_records), 'insert' => count($insert_records)]);
        ob_end_flush();

        try {
            foreach ($update_records as $advertiser) {
                $advertiser_id                                                             = $advertiser->id;
                list($balance, $holding, $available, $pending, $declined, $paid, $invoice) = $this->Calculator_model->advertiser_info($advertiser_id);
                $updated_at                                                                = date('Y-m-d H:i:m');
                $this->db->where('advertiser_id', $advertiser_id);
                $this->db->update('advertiser_dashboard', compact('balance', 'holding', 'available', 'pending', 'declined', 'paid', 'invoice', 'updated_at'));
            }

            foreach ($insert_records as $advertiser) {
                $advertiser_id                                                             = $advertiser->id;
                list($balance, $holding, $available, $pending, $declined, $paid, $invoice) = $this->Calculator_model->advertiser_info($advertiser_id);
                $this->db->insert('advertiser_dashboard', compact('advertiser_id', 'balance', 'holding', 'available', 'pending', 'declined', 'paid', 'invoice'));
            }
        } catch (\Throwable $th) {
            log_message('error', $th);
        }

        echo 'Done';
        return;
    }

    public function calc_pub_ranking()
    {
        $top10ThisMonth = $this->get_top_10_sale_awards();

        foreach ($top10ThisMonth as $range => $value) {
            $range += 1;
            $current_range = $this->Admin_model->get_one('snap_ranking', ['type' => 2, 'range' => $range]);
            $user          = $this->Admin_model->get_one('users', ['email' => $value->username]);

            if (!$current_range) {
                $this->db->insert('snap_ranking', [
                    'type'     => 2,
                    'range'    => $range,
                    'username' => $value->username,
                    'amount'   => $value->amount,
                    'reward'   => $value->reward,
                ]);
            } elseif ($current_range->username != $value->username) {
                $this->db->where('range', $range);
                $this->db->update('snap_ranking', ['username' => $value->username, 'amount' => $value->amount, 'reward' => $value->reward]);
            } else {
                continue;
            }

            if ($user) {
                (new Notification_Publisher_Update_Info($user->id))->notify_ranking($range);
                echo 'Notified to publisher has email: ' . $user->email;
            }
        }

        echo 'Finished';
        return;
    }
}