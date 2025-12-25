<?php

trait SessionTrait {
  public function clear_filter_session() {
    $this->session->unset_userdata('sort_offer');
    $this->session->unset_userdata('oCountry');
    $this->session->unset_userdata('oCat');
    $this->session->unset_userdata('opaymterm');
    $this->session->unset_userdata('oName');
  }
}