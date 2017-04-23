<?php

$s = '-u '.DB_USER.' -p'.DB_PASS.' '.DB_NAME;
$folder = __DIR__;
print `mysql $s < $folder/sql/structure.sql`;
print `mysql $s < $folder/sql/fixture.sql`;
