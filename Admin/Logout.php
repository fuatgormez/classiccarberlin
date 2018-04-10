<?php

    $message    = '<label class="text-danger">ausgeloggt!</label>';


    $db = new Database();
    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
    $db->Disconnect();

session_destroy ();

setcookie("FG_Manager_UserID", "$loginUserID", time() -315360000);
setcookie("FG_Manager_IP", "$loginUserIP", time() -315360000);
setcookie("FG_Manager_UserName", "$loginUsername", time() -315360000);
setcookie("FG_Manager_Password", "$loginUserPass", time() -315360000);
setcookie("FG_Manager_Email", "$loginUserEmail", time() -315360000);
setcookie("FG_Manager_Rank", "$loginUserRank", time() -315360000);
setcookie("FG_Manager_Image", "$loginUserImage", time() -315360000);
header("Cache-Control: no-cache");
header("Location: Login.php");