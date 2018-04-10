<?php
require_once 'db.inc.php';
require_once 'security.inc.php';
require_once 'lang.inc.php';
require_once 'access.inc.php';
require_once 'functions.inc.php';


if (@$_COOKIE['FG_Manager_UserName'] != NULL) {
    $loginUserID     = $_COOKIE["FG_Manager_UserID"];
    $loginUserIP     = $_COOKIE["FG_Manager_IP"];
    $loginUsername   = $_COOKIE["FG_Manager_UserName"];
    $loginUserPass   = $_COOKIE["FG_Manager_Password"];
    $loginUserRank   = $_COOKIE["FG_Manager_Rank"];
    $loginUserEmail  = $_COOKIE["FG_Manager_Email"];
    @$loginUserImage  = $_COOKIE["FG_Manager_Image"];

}elseif (@$_SESSION['Login'] != NULL){
    $loginUserID     = $_SESSION["userID"];
    $loginUserIP     = $_SESSION["userIP"];
    $loginUsername   = $_SESSION["userName"];
    $loginUserPass   = $_SESSION["userPass"];
    $loginUserRank   = $_SESSION["userRank"];
    $loginUserEmail  = $_SESSION["userEmail"];
    $loginUserImage  = $_SESSION["userImage"];


}

## Case Start##
//class pageCase extends Fonksiyon {
//========================================================================================================

//========================================================================================================
     function siteContent(){
        $fonk = new Fonksiyon();
        global $do,$lang,$langDB, $loginUserID, $loginUserIP, $loginUsername,$loginUserRank,$loginUserEmail,$loginUserImage;;
        $do = filter_input(INPUT_GET, 'do', FILTER_SANITIZE_STRING);
        Switch ($do){

            case "cars":
                require_once THEME."/reservation.php";
                require_once THEME."/cars.php";
                break;

            case "carDetails":
                require_once THEME."/reservation.php";
                require_once THEME."/carDetails.php";
                break;

            case "news":
                require_once THEME."/reservation.php";
                require_once THEME."/news.php";
                break;

            case "newsDetails":
                require_once THEME."/reservation.php";
                require_once THEME."/newsDetails.php";
                break;

            case "notices":
                require_once THEME."/reservation.php";
                require_once THEME."/notices.php";
                break;

            case "noticeDetails":
                require_once THEME."/reservation.php";
                require_once THEME."/noticeDetails.php";
                break;

            case "videos":
                require_once THEME."/reservation.php";
                require_once THEME."/videos.php";
                break;

            case "videoDetails":
                require_once THEME."/reservation.php";
                require_once THEME."/videoDetails.php";
                break;

            case "images":
                require_once THEME."/reservation.php";
                require_once THEME."/images.php";
                break;

            case "agb":
                require_once THEME."/reservation.php";
                require_once THEME."/agb.php";
                break;

            case "impressum":
                require_once THEME."/reservation.php";
                require_once THEME."/impressum.php";
                break;

            case "carDetails":
                require_once THEME."/reservation.php";
                require_once THEME."/carDetails.php";
                break;

            case "reservation":
                require_once THEME."/reservation.php";
                break;

            case "pages":
                require_once THEME."/reservation.php";
                require_once THEME."/pages.php";
                break;

            case "pageDetails":
                require_once THEME."/reservation.php";
                require_once THEME."/pageDetails.php";
                break;

            case "contact":
                require_once THEME."/reservation.php";
                require_once THEME."/contact.php";
                break;
            default:
                if (!$do){
                    require_once THEME."/slider.php";
                    require_once THEME."/reservation.php";
                    require_once THEME."/homePage.php";
                }else {
                    require_once THEME."/reservation.php";
                    require_once THEME."/404.php";
                }
                break;
        }
    }
//========================================================================================================
     function adminContent(){
        $fonk = new Fonksiyon();
        $date    = date('Y-m-d H:i:s');
        $newDate = new DateTime($date);

        global $page,$langDB, $loginUserID, $loginUserIP, $loginUsername,$loginUserRank,$loginUserEmail,$loginUserImage;
        switch($page){

            case "logs":
                include 'logs.php';
                break;

            case "advertisementsList":
                if($loginUserRank <= MANAGER_USER_VIEW){
                    include 'advertisementsList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "advertisementAdd":
                if($loginUserRank <= MANAGER_USER_ADD){
                    include 'advertisementAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "advertisementEdit":
                if($loginUserRank <= MANAGER_USER_EDIT){
                    include 'advertisementEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "advertisementDelete":
                $ID = intval($_GET['ID']);

                    $db = new Database();

                    $message    = 'Kategori sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);

                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_ADVERTISEMENTS WHERE ID=?",[$ID]);
                    $db->Disconnect();

                if (!$deleteRow) {
                    echo sweetalert("Kategori silindi!","Yönlendiriliyorsunuz..","success","index.php?page=categoriesList","2000");

                }else {
                    echo sweetalert("Kategori silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=categoriesList","2000");
                    exit;
                }
                break;
            case "advertisementStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $statusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_ADVERTISEMENTS SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;

                case "categoriesList":
                if($loginUserRank <= MANAGER_USER_VIEW){
                    include 'categoriesList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "categoryAdd":
                if($loginUserRank <= MANAGER_USER_ADD){
                    include 'categoryAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "categoryEdit":
                if($loginUserRank <= MANAGER_USER_EDIT){
                    include 'categoryEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "categoryDelete":
                $ID = intval($_GET['ID']);

                    $db = new Database();

                    $message    = 'Kategori sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);

                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_CATEGORIES WHERE ID=?",[$ID]);
                    $db->Disconnect();

                if (!$deleteRow) {
                    echo sweetalert("Kategori silindi!","Yönlendiriliyorsunuz..","success","index.php?page=categoriesList","2000");

                }else {
                    echo sweetalert("Kategori silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=categoriesList","2000");
                    exit;
                }
                break;
            case "categoryStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $statusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_CATEGORIES SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;

            case "carsList":
                if($loginUserRank <= MANAGER_USER_VIEW){
                    include 'carsList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "carAdd":
                if($loginUserRank <= MANAGER_USER_ADD){
                    include 'carAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "carEdit":
                if($loginUserRank <= MANAGER_USER_EDIT){
                    include 'carEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "carDelete":
                $ID = intval($_GET['ID']);

                    $db = new Database();

                    $message    = 'Araba sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);

                    $carImage  = $db->getRows("SELECT images.ID,images.CARID,image.IMAGESID,image.IMAGE,image.THUMBNAIL FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON images.ID=image.IMAGESID WHERE images.CARID=?",[$ID]);
                    foreach ($carImage as $carDeleteImage){
                        @unlink('../uploads/images/'.$carDeleteImage['IMAGE']);
                        @unlink('../uploads/images/thumb/'.$carDeleteImage['THUMBNAIL']);
                    }

                    $deleteImageRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGES WHERE CARID=?",[$ID]);
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_CARS WHERE ID=?",[$ID]);
                    $db->Disconnect();

                if (!$deleteRow) {
                    echo sweetalert("Araba silindi!","Yönlendiriliyorsunuz..","success","index.php?page=carsList","2000");

                }else {
                    echo sweetalert("Araba silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=carsList","2000");
                    exit;
                }
                break;
            case "carStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $pageStatusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_CARS SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;
            

            case "surveysList":
                include 'surveysList.php';
                break;
            case "surveyAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'surveyAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "surveyEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'surveyEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "surveyDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_SURVEYS WHERE ID = ?", [$ID]);
                    $db->Disconnect();
                    echo sweetalert("Anket silindi!","","success","index.php?page=surveysList","2000");
                    exit;
                }else {
                    echo sweetalert("Anket silinemedi!","","error","index.php?page=surveysList","2000");
                    exit;
                }
                break;


            case "languagesList":
                include 'languagesList.php';
                break;
            case "languageAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'languageAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "languageEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'languageEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "languageDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_LANGUAGE WHERE ID = ?", [$ID]);
                    $db->Disconnect();
                    echo sweetalert("Kelime silindi!","","success","index.php?page=languagesList","2000");
                    exit;
                }else {
                    echo sweetalert("Kelime silinemedi!","","error","index.php?page=languagesList","2000");
                    exit;
                }
                break;


            case "menusList":
                include 'menusList.php';
                break;
            case "menuAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'menuAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "menuEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'menuEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "menuDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_MENUS WHERE ID = ?", [$ID]);
                    $db->Disconnect();
                    echo sweetalert("Menü silindi!","","success","index.php?page=menusList","2000");
                    exit;
                }else {
                    echo sweetalert("Menü silinemedi!","","error","index.php?page=menusList","2000");
                    exit;
                }
                break;
            case "menuStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $pageStatusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_MENUS SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;

            case "activitiesList":
                include 'activitiesList.php';
                break;
            case "activityAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'activityAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "activityEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'activityEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "activityDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_ACTIVITIES WHERE ID = ?", [$ID]);
                    $db->Disconnect();
                    echo sweetalert("Üye silindi!","","success","index.php?page=activitiesList","2000");
                    exit;
                }else {
                    echo sweetalert("Üye silinemedi!","","error","index.php?page=activitiesList","2000");
                    exit;
                }
                break;



            case "webSettings":
                if($loginUserRank <= MANAGER_WEBSITE_SETTINGS){
                    include 'webSettings.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }
                break;

            case "ManagerAccess":
                if($loginUserRank <= MANAGER_SETTINGS){
                    include 'ManagerAccess.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

            case "ManagerSettings":
                if($loginUserRank <= MANAGER_CONTACTS){
                    include 'ManagerSettings.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }
                break;
            case "ManagerAdd":
                if($loginUserRank = 1){
                    include 'ManagerAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }
                break;
            case "ManagerEdit":
                if($loginUserRank == $loginUserID && $loginUserRank <= 2){
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }else {
                    include 'ManagerEdit.php';
                }
                break;
            case "ManagerDelete":
                $ID = intval($_GET['ID']);
                if($ID != 1 AND $_SESSION['userID'] != $ID){
                    $db = new Database();
                    $getRow = $db->getRow("SELECT ID FROM ".TABLE_PREFIX."TBL_USERS WHERE ID = ?",[$ID]);
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_USERS WHERE ID = ?", [$ID]);
                    $db->Disconnect();
                    echo sweetalert("Manager gelösct!","","success","index.php?page=ManagerSettings","2000");
                    exit;
                }else{
                    echo sweetalert("Manager nicht gelösct!","","success","index.php?page=ManagerSettings","2000");
                    exit;
                }
                break;

            case "ContactSettings":
                if($loginUserRank <= MANAGER_CONTACTS){
                    include 'ContactSettings.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }
                break;


            case "contactFormList":
                if($loginUserRank <= MANAGER_CONTACTS){
                    include 'contactFormList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }
                break;
            case "contactFormDetail":
                if($loginUserRank <= MANAGER_CONTACTS){
                    include 'contactFormDetail.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }
                break;
            case "contactMessageDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $fuat = array();
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_CONTACTFORM WHERE ID=?",[$ID]);

                    if ($deleteRow !=NULL){
                        $fuat['ok'];
                    }else{
                        $fuat['hata'];
                    }

                    $message    = 'İletişim Mesajını sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
                    $db->Disconnect();

                    echo sweetalert("Mesaj silindi!","Yönlendiriliyorsunuz..","success","index.php?page=contactFormList","2000");

                }else {
                    echo sweetalert("Mesaj silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=contactFormList","2000");
                    exit;
                }
                break;

            case "pagesList":
                if($loginUserRank <= MANAGER_PAGE_VIEW){
                    include 'pagesList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "pageAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'pageAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "pageEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'pageEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "pageDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_PAGES WHERE ID=?",[$ID]);

                    $IP         = $_SERVER['REMOTE_ADDR'];
                    $message    = 'Sayfa sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$IP,$Date]);
                    $db->Disconnect();

                    echo sweetalert("Sayfa silindi!","Yönlendiriliyorsunuz..","success","index.php?page=pagesList","2000");

                }else {
                    echo sweetalert("Sayfa silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=pagesList","2000");
                    exit;
                }
                break;
            case "pageStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $pageStatusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_PAGES SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkniz bulunmuyor!","","error","index.php","1000");
                }

                break;

            case "newsList":
                if($loginUserRank <= MANAGER_PAGE_VIEW){
                    include 'newsList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "newsAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'newsAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "newsEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'newsEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "newsDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_NEWS WHERE ID=?",[$ID]);

                    $IP         = $_SERVER['REMOTE_ADDR'];
                    $message    = 'Haber sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$IP,$Date]);
                    $db->Disconnect();

                    echo sweetalert("Haber silindi!","Yönlendiriliyorsunuz..","success","index.php?page=newsList","2000");

                }else {
                    echo sweetalert("Haber silinemedi!","Yölendiriliyorsunuz..","error","$callBackUrl","2000");
                    exit;
                }
                break;
            case "newsStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $pageStatusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_NEWS SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;

            case "noticesList":
                if($loginUserRank <= MANAGER_PAGE_VIEW){
                    include 'noticesList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "noticeAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'noticeAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "noticeEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'noticeEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "noticeDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_NOTICES WHERE ID=?",[$ID]);

                    $IP         = $_SERVER['REMOTE_ADDR'];
                    $message    = 'Duyuru sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$IP,$Date]);
                    $db->Disconnect();

                    echo sweetalert("Duyuru silindi!","Yönlendiriliyorsunuz..","success","index.php?page=noticesList","2000");

                }else {
                    echo sweetalert("Duyuru silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=noticesList","2000");
                    exit;
                }
                break;
            case "noticeStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $pageStatusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_NOTICES SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;

            case "videosList":
                if($loginUserRank <= MANAGER_PAGE_VIEW){
                    include 'videosList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "videoAdd":
                if($loginUserRank <= MANAGER_PAGE_ADD){
                    include 'videoAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "videoEdit":
                if($loginUserRank <= MANAGER_PAGE_EDIT){
                    include 'videoEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "videoDelete":
                $ID = intval($_GET['ID']);
                if ($loginUserRank <= MANAGER_PAGE_DELETE) {
                    $db = new Database();
                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_VIDEOS WHERE ID=?",[$ID]);

                    $IP         = $_SERVER['REMOTE_ADDR'];
                    $message    = 'Video sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$IP,$Date]);
                    $db->Disconnect();

                    echo sweetalert("Video silindi!","Yönlendiriliyorsunuz..","success","index.php?page=videosList","2000");

                }else {
                    echo sweetalert("Video silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=videosList","2000");
                    exit;
                }
                break;
            case "videoStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $pageStatusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_VIDEOS SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;

            case "usersList":
                if($loginUserRank <= MANAGER_USER_VIEW){
                    include 'usersList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "userAdd":
                if($loginUserRank <= MANAGER_USER_ADD){
                    include 'userAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "userEdit":
                if($loginUserRank <= MANAGER_USER_EDIT){
                    include 'userEdit.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "userDelete":
                $ID = intval($_GET['ID']);
                $userImageDelete = $_GET['userImageDelete'];
                if ($loginUserRank <= MANAGER_USER_DELETE && $ID !=1 ) {
                    $db = new Database();

                    $message    = 'Üye sildi!';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);

                    $userImage  = $db->getRow("SELECT images.ID,images.USERID,image.IMAGESID,image.IMAGE FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON images.ID=image.IMAGESID WHERE images.USERID=?",[$ID]);
                    @unlink('../uploads/images/users/'.$userImage['IMAGE']);

                    $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_USERS WHERE ID=?",[$ID]);
                    $db->Disconnect();



                    echo sweetalert("Üye silindi!","Yönlendiriliyorsunuz..","success","index.php?page=usersList","2000");

                }else {
                    echo sweetalert("Üye silinemedi!","Yölendiriliyorsunuz..","error","index.php?page=usersList","2000");
                    exit;
                }
                break;
            case "userStatus":
                if(!empty($_POST)){
                    $val    = $_POST['val'];
                    $ID     = intval($_POST['ID']);

                    $db = new Database();
                    $pageStatusUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_USERS SET STATUS=? WHERE ID=?",[$val,$ID]);
                    $db->Disconnect();

                }else{
                    echo sweetalert("Buraya girmek için yetkiniz bulunmuyor!","","error","index.php","1000");
                }

                break;


            case "imageAdd":
                if($loginUserRank <= MANAGER_IMAGE_ADD){
                    include 'imageAdd.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "imagesList":
                if($loginUserRank <= MANAGER_IMAGE_VIEW){
                    include 'imagesList.php';
                }else {
                    echo sweetalert("Bu işlem için yetkiniz bulunmuyor!","","error","index.php","2000");
                    exit;
                }

                break;
            case "imageDelete":
                $ID  = intval($_GET['ID']);
                @$one = intval($_GET['one']);
                if($loginUserRank <= MANAGER_IMAGE_DELETE){
                    $db = new Database();

                    if ($one == NULL){
                        $queryImages = $db->getRows("SELECT images.ID,images.ADDDATE,image.THUMBNAIL,image.IMAGE,image.IMAGESID FROM ".TABLE_PREFIX."TBL_IMAGES images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE image ON images.ID=image.IMAGESID WHERE images.ID",[$ID]);
                        $deleteRow = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGES WHERE ID = ?", [$ID]);

                        foreach ($queryImages as $queryImagesRemove ){
                            @unlink('../uploads/images/'.$queryImagesRemove['IMAGE']);
                            @unlink('../uploads/images/thumb/'.$queryImagesRemove['THUMBNAIL']);
                        }

                    }else{
                        $queryImages = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_IMAGE WHERE ID = ?", [$one]);
                        $aaa    = $queryImages['IMAGE'];
                        $deleteRowImages    = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGES WHERE SLUG=?", [$aaa]);
                        $deleteImageRow     = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGE WHERE ID = ?", [$one]);


                        @unlink('../uploads/images/'.$queryImages['IMAGE']);
                        @unlink('../uploads/images/thumb/'.$queryImages['THUMBNAIL']);
                    }

                    $IP         = $_SERVER['REMOTE_ADDR'];
                    $message    = 'Resim sildi';
                    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);



                    $db->Disconnect();
                    echo sweetalert("Resim silindi!","","success","index.php?page=imagesList","2000");
                    exit;
                }else {
                    echo sweetalert("Resim silinemedi!","","error","index.php?page=imagesList","2000");
                    exit;
                }
                break;


            case "Login":
                include "Login.php";
                break;
            case "Logout":
                include "Logout.php";
                break;

            default:
                if (!$page){
                    require_once '../Admin/homePage.php';
                }else {
                    require_once 'index.php';
                }
                break;

        }
    }
//========================================================================================================

//}## Case End##


//$pageCase = new pageCase();
