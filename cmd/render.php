<?php

foreach (db()->selectCol("SELECT * FROM bcBanners WHERE dateRender < dateUpdate") as $bannerId) {
  BcCore::render($bannerId);
}
