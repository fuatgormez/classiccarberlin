<?php

include 'App/system.inc.php';
    try {

            if (SITE_STATUS == 'Y')
                {
                      require THEME."/index.php";
                } else{
                    require "theme/kapaliazra/index.php";
                }


        } catch (Exception $e) {
          die($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }

