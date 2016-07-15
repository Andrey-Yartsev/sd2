<?php

foreach (db()->selectCol("SELECT * FROM bcBanners WHERE dateRender < dateUpdate") as $bannerId) {
  O::di('BcRender', $bannerId)->render();
}
