<?php

Sflm::setFrontendName('asd');
$form = new SdCufonSettingsForm(47, new SdPageBlockItems(6));

print gettype($form->defaultData['shadow'])."\n";
print_r($form->getElement('shadow')->value());
