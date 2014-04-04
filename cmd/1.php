<?php

Sflm::setFrontend('default');
Sflm::frontend('js')->addLib('sdEdit');
Sflm::frontend('js')->code();
return;
(new PmLocalServer([
  'title' => 'Sample',
  'name' => 'id11',
  'type' => 'sd',
  'domain' => 'id11.sitedraw.ru',
  'active' => 1,
  'userId' => 1
]))->a_createProject();