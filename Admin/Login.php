<?php

include("../App/system.inc.php");
if (!empty($_COOKIE['FG_Manager_UserName']) || !empty($_SESSION['Login'])) {
    header("location:index.php");
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=SITE_TITLE ." | ". $langDB['LANG_MANAGER_LOGIN'];?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Sweetalert -->
    <link rel="stylesheet" type="text/css" href="../App/sweetalert-master/dist/sweetalert.css">
    <script src="../App/sweetalert-master/dist/sweetalert.min.js"></script>

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen   animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">CAR</h1>

        </div>
        <h3><?=$langDB['LANG_MANAGER_LOGIN'];?></h3>

        <form class="m-t" role="form" action="" method="post">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="<?=$langDB['LANG_USERNAME_OR_EMAIL'];?>" name="username" required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="<?=$langDB['LANG_PASSWORD'];?>" name="password" required="">
            </div>
            <div class="form-group">
                <div class="checkbox i-checks"><label> <input type="checkbox" name="rememberMe" value="1"><i></i> <?=$langDB['LANG_BTN_REMEMMERME'];?>! </label></div>
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b" name="submit"><?=$langDB['LANG_BTN_LOGIN']?>!</button>

        </form>

    </div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
</body>

</html>



<?php
if(isset($_POST["submit"])){
    $_POST      = multiDimensionalArrayMap('cleanEvilTags', $_POST);
    $_POST      = multiDimensionalArrayMap('cleanData', $_POST);

    $reusername     = $_POST['username'];
    $password       = sha1($_POST['password']);
    @$rememberMe    = intval($_POST['rememberMe']);


    $IP         = $_SERVER['REMOTE_ADDR'];
    $date    = date('Y-m-d H:i:s');
    try{

        if (empty($reusername)) {
            return sweetalert($langDB['LANG_USERNAME_IS_REQUIRED'],$langDB['LANG_REDIRECTING'],"error","Login.php","2000");
            exit;
        }else if (empty($password)) {
            return sweetalert($langDB['LANG_PASSWORD_IS_REQUIRED'],$langDB['LANG_REDIRECTING'],"error","Login.php","2000");
            exit;
        }else{
            $db = new Database();
            $queryUser  = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_USERS WHERE (USERNAME=? OR EMAIL=?) AND PASSWORD=?",[$reusername,$reusername,$password]);
            $ID         = $queryUser['ID'];
            $reusername = $queryUser['USERNAME'];
            $password   = $queryUser['PASSWORD'];
            $rank       = $queryUser['RANK'];
            $email      = $queryUser['EMAIL'];
            $userImage  = $db->getRow("SELECT images.ID,images.USERID,image.IMAGE,image.IMAGESID FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON images.ID=image.IMAGESID WHERE images.USERID=? ",[$ID]);

            if($queryUser > 0){

                if ($rememberMe)
                {
                    setcookie("FG_Manager_UserID", $ID, time()+(86400*365*10), '/', null, null, true);
                    setcookie("FG_Manager_IP", $IP, time()+(86400*365*10), '/', null, null, true);
                    setcookie("FG_Manager_UserName", $reusername, time()+(86400*365*10), '/', null, null, true);
                    setcookie("FG_Manager_Password", $password, time()+(86400*365*10), '/', null, null, true);
                    setcookie("FG_Manager_Email", $email, time()+(86400*365*10), '/', null, null, true);
                    setcookie("FG_Manager_Rank", $rank, time()+(86400*365*10), '/', null, null, true);
                    setcookie("FG_Manager_Image", $userImage['IMAGE'], time()+(86400*365*10), '/', null, null, true);

                }else{
                    $_SESSION['Login'] = true; // Set Session

                    $_SESSION['userID']     = $ID; // Set Session
                    $_SESSION['userIP']     = $IP; // Set Session
                    $_SESSION['userName']   = $reusername; // Set Session
                    $_SESSION['userPass']   = $password; // Set Session
                    $_SESSION['userRank']   = $rank; // Set Session
                    $_SESSION['userEmail']  = $email; // Set Session
                    $_SESSION['userImage']  = $userImage['IMAGE']; // Set Session

                }

                $message    = '<label class="text-navy">eingeloggt!</label>';
                $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$reusername,$IP,$date]);

                return sweetalert($langDB['LANG_LOGIN_SUCCESSFUL'],$langDB['LANG_REDIRECTING'],"success","index.php","1500");
                exit();

            }else{
                return sweetalert($langDB['LANG_LOGIN_IS_NOT_SUCCESSFUL'],$langDB['LANG_REDIRECTING'],"error","Login.php","2000");
                exit();
            }
            $db->Disconnect();
        }
    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }



}
?>
