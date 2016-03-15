<?php

$items = new SdPageBlockItems;
$id = $items->create([
  'data' => [
    'type'        => 'text',
    'position'    => [
      'x' => 123,
      'y' => 54
    ],
    'ownPageId'   => 1,
    'containerId' => 'head'
  ]
]);
output3($id);
die2($items->getItemF($id));
