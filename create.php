<?php

Lib::addFolder(NGN_ENV_PATH.'/pm/lib');
PmLocalProjectCore::create([
  'noDb' => true,
  'name'   => 'a'.time(),
  'domain' => 'a'.time().'.s12.majexa.ru'
]);