<?php

class BcBanner extends ArrayAccesseble {

  function __construct(array $data) {
    if ((new SdPageBlockItems($data['id']))->hasAnimation()) {
      if (file_exists(UPLOAD_PATH.'/banner/animated/'.$data['id'].'.gif')) {
        $data['downloadLink'] = '/list/download/'.$data['id'];
        $data['downloadFile'] = UPLOAD_PATH.'/banner/animated/'.$data['id'].'.gif';
      }
    }
    else {
      if (file_exists(UPLOAD_PATH.'/banner/static/'.$data['id'].'.png')) {
        $data['downloadLink'] = '/list/download/'.$data['id'];
        $data['downloadFile'] = UPLOAD_PATH.'/banner/static/'.$data['id'].'.png';
      }
    }
    $this->r = $data;
  }

}