<?php

class BannerSettingsEditForm extends BannerSettingsForm {

  protected $bannerId, $banner;

  function __construct($bannerId) {
    $this->bannerId = $bannerId;
    $this->banner = $this->defaultData  = db()->getRow('sdDocuments', $this->bannerId);
    parent::__construct();
  }

  protected function defineOptions() {
    return array_merge(parent::defineOptions(), [
      'title'       => 'Edit banner',
      'submitTitle' => 'Save'
    ]);
  }

  protected function _update(array $data) {
    db()->update('sdDocuments', $this->bannerId, $data);
  }

}