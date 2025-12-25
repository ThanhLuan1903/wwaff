<?php
require_once APPPATH . '/modules/adm_mng/services/abstracts/BaseService.php';

class ThemeService extends BaseService {
  const BG_LOGIN = 'login-page';
  const TITLE_BANNER = 'title-banner';
  const TITLE_BANNER_LEFT = 'title-banner-left';
  const TITLE_BANNER_RIGHT ='title-banner-right';
  const REGISTER_PAGE = 'register-page';
  const TITLE_PUBLISHER = 'title-publisher';
  const TITLE_PUBLISHER_LEFT = 'title-publisher-left';
  const TITLE_PUBLISHER_RIGHT = 'title-publisher-right';

  public function __construct()
  {
    parent::__construct();
  }

  public function update($type, $content)
  {
    if ($type == self::BG_LOGIN) {
      return $this->editLoginBackground($content);
    } else if (in_array($type, [ self::TITLE_BANNER_LEFT, self::TITLE_BANNER_RIGHT, self::TITLE_PUBLISHER_LEFT, self::TITLE_PUBLISHER_RIGHT ])) {
      return $this->editTitleBanner($type, $content);
    } else if (preg_match("/^register\-page\-[0-9]*$/", $type)) {
      return $this->editRegisterTrafficType($type, $content);
    }
  }

  private function editLoginBackground($bgUrl) 
  {
    $record = $this->Admin_model->get_one('custom_features', ['type' => self::BG_LOGIN]);
    if (!$record)
      return $this->db->insert('custom_features', ['content' => $bgUrl, 'type' => self::BG_LOGIN]);
    return $this->db->where('type', self::BG_LOGIN)->update('custom_features', ['content' => $bgUrl ]);
  }

  private function editTitleBanner($type, $title)
  {
    $record = $this->Admin_model->get_one('custom_features', ['type' => $type]);
    if (!$record) {
      return $this->db->insert('custom_features', ['content'=> $title, 'type' => $type]);
    }
      
    return $this->db->where('type', $type)->update('custom_features', ['content' => $title]);
  }

  private function editRegisterTrafficType($type, $content) 
  {
    $id = end(explode('-',$type));
    $record = $this->Custom_model->find_by_id($id);
    if (empty($record))
      return $this->db->insert('custom_features', ['content' => $content, 'type' => self::REGISTER_PAGE]);
    return $this->db->update('custom_features', compact('content'), compact('id'));
  }

  public function delete($id)
  {
    return $this->Custom_model->delete_by_id($id);
  }
}