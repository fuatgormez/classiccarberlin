<?php

try{
    $db = new Database();
    $langDB = array();
    $languageQuery = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_LANGUAGE");

        if (@$_SESSION['lang'] !=NULL){
            foreach ($languageQuery as $languageShow){
                $langDB[$languageShow['TITLE']] = $languageShow[$_SESSION['lang']];
            }
        }else{
            foreach ($languageQuery as $languageShow){
                $langDB[$languageShow['TITLE']] = $languageShow["de"];
            }
        }

    $db->Disconnect();
} catch (Exception $e) {
    die ($langDB['LANG_CATCH_PROBLEM'] . $e->getMessage());
}