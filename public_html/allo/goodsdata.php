<?php
exit;
require_once 'bootstrap.php';

$sql = "SELECT * FROM `allo_goods` WHERE `goods_status` = 'wait' LIMIT 1";
