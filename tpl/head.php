<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?= SITE_TITLE ?></title>
  {sflm}
  <? if ($d['sfl'] != 'sdSite') { ?>
    <script src="/i/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
  <? } ?>
</head>
<style>
  .contentOverlay {
    position: absolute;
    z-index: 200;
    background: #555;
    width: 2000px;
    height: 2000px;
    opacity: 0.7;
    pointer-events: none;
  }
  .preview .contentOverlay {
    background: #fff;
    opacity: 1;
  }
  .preview #layers, .preview #panel {
    visibility: hidden;
  }
  .contentOverlayBorder {
    position: absolute;
    z-index: 200;
    border: 1px solid #555;
    box-sizing: border-box;
    width: 100%;
    pointer-events: none;
  }
  .preview .contentOverlayBorder {
    border: none;
  }
  .contentOverlayLeft {
    left: -2000px;
  }
  .contentOverlayTop {
    left: -1000px;
    top: -2000px;
  }
  .contentOverlayBottom {
    left: 0;
  }
  .contentOverlayRight {
    top: 0;
  }

  /* ---------------- панель управления порядком блоков --------------- */
  #globalLoader {
    z-index: 2100;
  }
  #layers {
    position: absolute;
    top: 0;
    right: 150px;
    z-index: 2000;
  }
  #layers .cont {
    position: fixed;
    padding: 10px 0;
    width: 150px;
    background: #AEAA9F url(/sd/img/panelBg.png) repeat-y top left;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    border-bottom-left-radius: 7px;
  }
  #layers .tit {
    padding-left: 15px;
    text-align: left;
    margin-top: 0;
    border-top: 0;
    border-bottom: 1px solid #444;
    cursor: pointer;
  }
  #layers .tit:hover {
    text-decoration: underline;
  }
  #layers .tit:active,
  #layers .tit.drag {
    cursor: url(http://www.google.com/intl/en_ALL/mapfiles/closedhand.cur) 4 4, move;
    text-decoration: underline;
    color: #00A6CF;
    border-bottom-color: #00A6CF;
  }
  #layers .tit img {
    max-height: 20px;
    max-width: 20px;
    margin: 0;
  }
  #layers .tit .ico {
    margin-right: 10px;
    display: inline-block;
    width: 20px;
    height: 20px;
    vertical-align: middle;
    text-align: center;
  }
  /* -- */
  body {
    height: 100%;
  }
  .body {
    overflow: hidden;
    height: 100%;
  }
</style>
