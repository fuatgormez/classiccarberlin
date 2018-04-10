<?php
require_once "../../../App/db.inc.php";

$db = new Database();
$aa = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_CARS");

foreach ($aa as $bb)
{
    echo $bb['TITLE'];
}

$abc = "deneme";
//$db->truncate("TRUNCATE table FG_TBL_LOGS");
//$db->insertRow("INSERT INTO FG_TBL_LOGS SET MESSAGE=?",[$abc]);

