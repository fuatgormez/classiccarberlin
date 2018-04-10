<?php

error_reporting(E_ALL | E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_CORE_ERROR | E_COMPILE_ERROR);
@ini_set('display_errors', true);
@ini_set('html_errors', true);
//========================================================================================================
$callBackUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index.php";
//========================================================================================================

$db = new Database();
$settingShow = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_SETTINGS");
$newDate = date("j F Y g:i", strtotime($settingShow["STATUSDATE"]));

define("PATH", realpath("."));
define("URL", $settingShow["URL"]);
define("THEME_URL", $settingShow["URL"]."/theme/".$settingShow["THEME"]);
define("THEME", PATH."/theme/".$settingShow["THEME"]);
define("THEME_DIR", $settingShow["THEME"]);
define("SITE_TITLE", $settingShow["TITLE"]);
define("SITE_DESC", $settingShow["DESCRIPTION"]);
define("SITE_KEYW", $settingShow["KEYWORDS"]);
define("SITE_LOGO", $settingShow["LOGO"]);
define("SITE_STATUS", $settingShow["STATUS"]);
define("SITE_STATUSDATE", $newDate);
define("SITE_STATUSMESSAGE", html_entity_decode($settingShow["STATUSMESSAGE"]));
define("SITE_IMPRESSUM", html_entity_decode($settingShow["IMPRESSUM"]));
define("SITE_AGB", html_entity_decode($settingShow["AGB"]));
define("SITE_EMAIL", $settingShow["EMAIL"]);
define("SITE_TEL1", $settingShow["TEL1"]);
define("SITE_TEL2", $settingShow["TEL2"]);
define("SITE_TEL3", $settingShow["TEL3"]);
define("SITE_FAX1", $settingShow["FAX1"]);
define("SITE_FAX2", $settingShow["FAX2"]);
define("SITE_FAX3", $settingShow["FAX3"]);
define("SITE_ADRESS", $settingShow["ADRESS"]);
define("SITE_MAPS", $settingShow["MAPS"]);
define("SITE_FACEBOOK", $settingShow["FACEBOOK"]);
define("SITE_TWITTER", $settingShow["TWITTER"]);
define("SITE_YOUTUBE", $settingShow["YOUTUBE"]);
define("SITE_INSTAGRAM", $settingShow["INSTAGRAM"]);
define("SITE_GOOGLE", $settingShow["GOOGLE"]);
define("SITE_LINKEDIN", $settingShow["LINKEDIN"]);
define("SITE_FLICKR", $settingShow["FLICKR"]);

$db->Disconnect();
//========================================================================================================

//========================================================================================================
$db = new Database();
$managerAccessShow = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_ACCESS");

define("MANAGER_WEBSITE_SETTINGS", $managerAccessShow["MANAGERSETTINGS"]);
define("MANAGER_SETTINGS", $managerAccessShow["MANAGERSETTINGS"]);
define("MANAGER_CONTACTS", $managerAccessShow["MANAGERCONTACTS"]);

define("MANAGER_USER_ADD", $managerAccessShow["USERADD"]);
define("MANAGER_USER_EDIT", $managerAccessShow["USEREDIT"]);
define("MANAGER_USER_VIEW", $managerAccessShow["USERVIEW"]);
define("MANAGER_USER_DELETE", $managerAccessShow["USERDELETE"]);

define("MANAGER_PAGE_ADD", $managerAccessShow["PAGEADD"]);
define("MANAGER_PAGE_EDIT", $managerAccessShow["PAGEEDIT"]);
define("MANAGER_PAGE_VIEW", $managerAccessShow["PAGEVIEW"]);
define("MANAGER_PAGE_DELETE", $managerAccessShow["PAGEDELETE"]);

define("MANAGER_IMAGE_ADD", $managerAccessShow["IMAGEADD"]);
define("MANAGER_IMAGE_VIEW", $managerAccessShow["IMAGEVIEW"]);
define("MANAGER_IMAGE_DELETE", $managerAccessShow["IMAGEDELETE"]);

define("MANAGER_VIDEO_ADD", $managerAccessShow["VIDEOADD"]);
define("MANAGER_VIDEO_EDIT", $managerAccessShow["VIDEOEDIT"]);
define("MANAGER_VIDEO_VIEW", $managerAccessShow["VIDEOVIEW"]);
define("MANAGER_VIDEO_DELETE", $managerAccessShow["VIDEODELETE"]);

define("MANAGER_SLIDER_ADD", $managerAccessShow["SLIDERADD"]);
define("MANAGER_SLIDER_EDIT", $managerAccessShow["SLIDEREDIT"]);
define("MANAGER_SLIDER_VIEW", $managerAccessShow["SLIDERVIEW"]);
define("MANAGER_SLIDER_DELETE", $managerAccessShow["SLIDERDELETE"]);

define("MANAGER_NEWS_ADD", $managerAccessShow["NEWSADD"]);
define("MANAGER_NEWS_EDIT", $managerAccessShow["NEWSEDIT"]);
define("MANAGER_NEWS_VIEW", $managerAccessShow["NEWSVIEW"]);
define("MANAGER_NEWS_DELETE", $managerAccessShow["NEWSDELETE"]);

define("MANAGER_NOTICE_ADD", $managerAccessShow["NOTICEADD"]);
define("MANAGER_NOTICE_EDIT", $managerAccessShow["NOTICEEDIT"]);
define("MANAGER_NOTICE_VIEW", $managerAccessShow["NOTICEVIEW"]);
define("MANAGER_NOTICE_DELETE", $managerAccessShow["NOTICEDELETE"]);

define("MANAGER_CATEGORY_ADD", $managerAccessShow["CATEGORYADD"]);
define("MANAGER_CATEGORY_EDIT", $managerAccessShow["CATEGORYEDIT"]);
define("MANAGER_CATEGORY_VIEW", $managerAccessShow["CATEGORYVIEW"]);
define("MANAGER_CATEGORY_DELETE", $managerAccessShow["CATEGORYDELETE"]);

define("MANAGER_ORDER_VIEW", $managerAccessShow["ORDERVIEW"]);
define("MANAGER_ORDER_DELETE", $managerAccessShow["ORDERDELETE"]);

$db->Disconnect();
//========================================================================================================