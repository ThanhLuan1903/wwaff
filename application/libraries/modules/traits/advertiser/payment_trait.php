<?php

require_once APPPATH . 'libraries/payment/payment_plugin.php';

trait Advertiser_PaymentTrait
{

    public function payment_list()
    {
        $payments =  $this->db->where('adv_id', $this->session->userdata('user')->id)->get('advertiser_payment')->result();
        $need_payment = $this->Advertiser_model->check_arrive_paymterm($this->session->userdata('user')->id);
        $available = $this->Advertiser_model->need_payment_amount($this->session->userdata('user')->id);

        $content = $this->load->view('advertiser/payment/form', compact('payments', 'need_payment', 'available'), true);
        return $this->load->view('advertiser/default/vindex', compact('content'));
    }

    private function getApprovedAmountAndUpdateTracklink($offerId)
    {
        $adv_id = $this->session->userdata('user')->id;
        $offerIdList = implode(',', array_map('intval', $offerId));
        $sql = "
            SELECT SUM(amount3) as total_amount
            FROM cpalead_tracklink
            WHERE adv_pay = 0
            AND status = 4
            AND offerid IN ($offerIdList)
            FOR UPDATE
        ";

        $query = $this->db->query($sql);

        return $query->row()->total_amount;
    }

    private function updateTracklink($offerId, $adPayoutId)
    {
        $this->db->where('adv_pay', 0);
        $this->db->where('status', 4);
        $this->db->where_in('offerid', $offerId);
        $this->db->update('cpalead_tracklink', ['adv_pay' => $adPayoutId]);
    }

    public function request_payouts()
    {
        if (!$this->is_method_post()) {
            throw new Exception('Method is not supported');
        }
        $this->db->trans_start();

        $id = $this->input->post('pid');
        $amọntPay = 0;
        $offerId = $this->input->post('offersIdList');
        if (!empty($offerId) && empty($id)) {
            $offerId = explode(',', $offerId);
            $amọntPay = $this->getApprovedAmountAndUpdateTracklink($offerId);
        } else {
            return 'error';
        }

        $config['upload_path'] = './upload/payment_images/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        $imagePath = null;

        if (!empty($_FILES['payment_image']['name'])) {
            if (!$this->upload->do_upload('payment_image')) {
                $error = $this->upload->display_errors();
                throw new Exception('Image upload failed: ' . $error);
            } else {
                $uploadData = $this->upload->data();
                $imagePath = 'upload/payment_images/' . $uploadData['file_name'];
            }
        }

        if ($id) {
            $this->db->where('id', $id);
            $this->db->where('adv_id', $this->session->userdata('user')->id);
            $updateData = [
                'note' => $this->input->post('note'),
                'method' => $this->input->post('method')
            ];

            if ($imagePath) {
                $updateData['image_path'] = $imagePath;
            }

            $this->db->update('advertiser_payment', $updateData);
        } else {
            $data = [
                'amount' => preg_replace('/[^0-9.]/', '', $this->input->post('amount')),
                'note' => $this->input->post('note'),
                'method' => $this->input->post('method'),
                'adv_id' => $this->session->userdata('user')->id,
                'image_path' => $imagePath,
            ];

            $this->db->insert('advertiser_payment', $data);
            $id = $this->db->insert_id();
            $this->updateTracklink($offerId, $id);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            //log_message('error', 'Transaction failed');
        } else {
            //log_message('info', 'Transaction completed successfully');
        }
        return redirect(base_url('v2/payments'));
    }
}