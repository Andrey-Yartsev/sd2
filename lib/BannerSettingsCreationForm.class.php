<?php

class BannerSettingsCreationForm extends BannerSettingsForm {

  protected function defineOptions() {
    return array_merge(parent::defineOptions(), [
      [
        'title'       => 'Create banner...',
        'submitTitle' => 'Create'
      ]
    ]);
  }

  public $createdId;

  protected function _update(array $data) {
    $this->createdId = BcCore::createBanner($data['size'], $data['title']);
  }

}