<?php

class DocumentSettingsCreationForm extends BannerSettingsForm {

  protected function defineOptions() {
    return array_merge(parent::defineOptions(), [
        'title'       => Locale::get('newDocument', 'sd'),
        'submitTitle' => 'Create'
      ]);
  }

  public $createdId;

  protected function _update(array $data) {
    $this->createdId = Sd2Core::createDocument($data['size'], $data['title']);
  }

}