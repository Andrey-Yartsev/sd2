<?php

class BlogSettingsForm extends Form {

  const defaultLimit = 2;

  function __construct() {
    parent::__construct([
      [
        'title' => 'Кол-во выводимых записей',
        'name' => 'limit',
        'type' => 'num',
        'help' => 'По умолчанию: '.self::defaultLimit
      ],
      /*
      [
        'type' => 'header',
        'title' => 'adsd'
      ],
      [
        'title' => 'qwdcqwdqd',
        'type' => 'text',
      ]
      */
    ]);
  }

}
