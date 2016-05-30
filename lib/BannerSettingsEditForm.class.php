<?php

class BannerSettingsEditForm extends BannerSettingsForm {

  protected $bannerId;

  function __construct($bannerId) {
    $this->bannerId = $bannerId;
    $this->defaultData = db()->getRow('bcBanners', $this->bannerId);
    parent::__construct();
  }

  protected function defineOptions() {
    return array_merge(parent::defineOptions(), [
        'title'       => 'Edit banner',
        'submitTitle' => 'Save'
      ]);
  }

  protected function _update(array $data) {
    db()->update('bcBanners', $this->bannerId, $data);
  }

}