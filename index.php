<?php

include 'App/system.inc.php';
    try {

            if (SITE_STATUS == 'Y')
                {
                      require THEME."/index.php";
                } else{
                    require "theme/kapali/index.php";
                }


        } catch (Exception $e) {
          die('Bir sorun var!: ' . $e->getMessage());
    }

