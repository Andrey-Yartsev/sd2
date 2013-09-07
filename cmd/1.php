<?php

Sflm::$frontend = 'default';
Sflm::flm('js')->addLib('sdEdit');
Sflm::flm('js')->code();
return;
(new PmLocalServer([
  'title' => 'Sample',
  'name' => 'id11',
  'type' => 'sd',
  'domain' => 'id11.sitedraw.ru',
  'active' => 1,
  'userId' => 1
]))->a_createProject();