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
    right: 200px;
    z-index: 2000;
  }
  #layers .item {
    position: relative;
  }
  #layers .btns {
    position: absolute;
    top: 0;
    right: 0;
    height: 30px;
    padding-left: 15px;
    width: 70px;
  }
  #layers .btns .smIcons {
    margin-top: 7px;
  }
  #layers .btns .smIcons.dummy {
    width: 16px;
    height: 16px;
    margin-right: 4px;
  }
  #layers .cont {
    position: fixed;
    padding: 10px 0;
    width: 200px;
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

  /* -- background, button -- dialogs */
  #background_message,
  #button_message {
    padding: 10px;
  }
  #background_message img,
  #button_message img{
    cursor: pointer;
    display: block;
    float: left;
    margin: 0 1px 2px 0;
    padding: 2px;
    border: 1px solid #fff;
  }
  #background_message img:hover,
  #button_message img:hover {
    border: 1px solid #ccc;
  }
  #background_message img.selected,
  #button_message img.selected{
    background: #bfdeff;
    border-color: #555;
  }

  #button_message img {
    max-width: 100px;
    max-height: 50px;
  }

</style>
