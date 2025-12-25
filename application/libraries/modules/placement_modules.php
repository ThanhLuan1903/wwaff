<?php

trait PlacementModules {

  public function placements() {
    return $this->user->placements();
  }

  public function send_request() {
    return $this->user->send_request();
  }

  public function update_placements() {
    return $this->user->update_placements();
  }
}