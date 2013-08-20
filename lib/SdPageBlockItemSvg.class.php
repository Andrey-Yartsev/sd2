<?php

class SdPageBlockItemSvg extends SdPageBlockItem {

  protected function html(array $tplData) {
    if (empty($tplData['name'])) return '';
    return parent::html([
      'html' => (new SvgItem(Sflm::$absBasePaths['sd'].'/svg/'.$tplData['name'].'.svg'))->html()
    ]);
  }

}