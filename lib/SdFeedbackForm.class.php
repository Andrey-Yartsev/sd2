<?php

class SdFeedbackForm extends Form {

  function __construct() {
    parent::__construct([
      ['type' => 'col'], [
        'title'    => 'Комментарий',
        'type'     => 'textarea',
        'name'     => 'text',
        'required' => true
      ], ['type' => 'col'], [
        'title' => 'Представьтесь, пожалуйста',
        'type'  => 'text',
        'name'  => 'name'
      ], [
        'title' => 'Ваш e-mail',
        'type'  => 'text',
        'name'  => 'email',
      ], [
        'title' => 'Ваш телефон',
        'type'  => 'text',
        'name'  => 'phone',
      ]
    ], ['submitTitle' => 'Отправить']);
  }

  protected function _update(array $data) {
    (new SendEmail)->send(Config::getVar('feedbackEmails'), 'Новый отзыв с '.SITE_TITLE, Tt()->getTpl('common/table', $this->getTitledData()));
  }

}