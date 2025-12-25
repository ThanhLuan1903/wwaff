<?php

trait NotificationModules
{
  public function notification_center() {
    return $this->user->notification_center();
  }
}
