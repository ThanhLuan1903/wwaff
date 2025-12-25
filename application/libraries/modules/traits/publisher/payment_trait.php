<?php
trait Publisher_PaymentTrait
{
  public function payment_list()
  {
    $this->db->where('usersid', $this->member->id);
    $data['payment'] = $this->db->order_by('id', 'DESC')->get('invoice')->result();
    $content = $this->load->view('payments/listpm.php', $data, true);
    $this->load->view('default/vindex.php', array('content' => $content));
  }

  public function request_payouts()
  {
    $point = floatval($this->input->post('amount'));
    $pmethod = $this->input->post('payment_method');
    $paymentId = (int)$this->input->post('pid');
    $uid = $this->member->id;
    $minpay = floatval($this->pub_config['minpay']);
    $available = floatval($this->member->available);

    // Validate payment method
    if ($pmethod == "pmchose") {
      $this->session->set_userdata('err_po', 'Please select a payment method!');
      redirect(base_url('v2/payments'));
      return;
    }

    // Validate amount > 0
    if ($point <= 0) {
      $this->session->set_userdata('err_po', 'Invalid amount!');
      redirect(base_url('v2/payments'));
      return;
    }

    // Get payment note
    $note = $this->_getPaymentNote($pmethod);

    // Update existing payment info
    if ($paymentId) {
      $this->db->where(array('id' => $paymentId, 'usersid' => $uid, 'status' => 'Pending'));
      $this->db->update('invoice', array('note' => $note, 'method' => $pmethod));

      if ($this->db->affected_rows() > 0) {
        $this->session->set_userdata('succ_po', 'Updated!');
      } else {
        $this->session->set_userdata('err_po', 'Error!');
      }
      redirect(base_url('v2/payments'));
      return;
    }

    // New payment request - chỉ check available >= minpay
    if ($available < $minpay) {
      $this->session->set_userdata('err_po', 'Minimum balance required: $' . $minpay);
      redirect(base_url('v2/payments'));
      return;
    }

    // Cap point to available balance
    if ($point > $available) {
      $point = $available;
    }

    $date = date("Y-m-d H:i:s");
    
    // Start transaction
    $this->db->trans_start();

    $this->db->where('id', $uid);
    $this->db->where('available >=', $point);
    $this->db->set('available', 'available - ' . $point, FALSE);
    $this->db->set('pending', 'pending + ' . $point, FALSE);
    $this->db->set('log', "invoice: $date - $point");
    $this->db->update('users');

    if ($this->db->affected_rows() > 0) {
      $this->db->insert('invoice', array(
        'status' => 'Pending',
        'amount' => $point,
        'method' => $pmethod,
        'note' => $note,
        'usersid' => $uid,
        'date' => $date,
        'type' => 3
      ));

      $this->session->set_userdata('succ_po', 'Payout request submitted!');
    } else {
      $this->session->set_userdata('err_po', 'Insufficient balance!');
    }

    $this->db->trans_complete();

    redirect(base_url('v2/payments'));
  }

  private function _getPaymentNote($pmethod)
  {
    switch ($pmethod) {
      case 'PayPal':
        return $this->input->post('payment_paypal_email');
      case 'Payoneer':
        return $this->input->post('payment_payoneer_email');
      case 'Crypto':
        return $this->input->post('payment_Crypto');
      case 'Bank Wire':
        return serialize($this->input->post('BankWire'));
      default:
        return '';
    }
  }
}
