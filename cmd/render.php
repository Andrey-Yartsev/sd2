<?php

foreach (db()->selectCol("SELECT * FROM sdDocuments WHERE dateRender < dateUpdate") as $bannerId) {
  O::di('BcRender', $bannerId)->render();
}
