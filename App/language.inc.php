<?php

session_start();
ob_start();

$lang = strip_tags($_GET['lang']);

$server = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index.php";

    if ($lang == 'de' || $lang == 'tr' || $lang == 'en'){

        $_SESSION['lang'] = $lang;
        header('location:'.$server);

    }else{
        header('location:index.html');
    }