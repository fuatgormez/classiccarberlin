<?php
//========================================================================================================
require_once("../App/system.inc.php");
require_once("class/class.upload.php");
//========================================================================================================
$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

//========================================================================================================
if (@$_COOKIE['FG_Manager_UserName'] == NULL && @$_SESSION['Login'] == NULL) {

    header("location:Login.php");
    exit;
}
//========================================================================================================
// Dynamic Table Language Select
if(@$_SESSION['lang'] == "tr")
        {
            $langSession = 'Turkish';
        }elseif(@$_SESSION['lang'] == "en")
        {
            $langSession = 'English';
        }else
        {
            $langSession = 'German';
        }

//========================================================================================================
//global $loginUserID, $loginUserIP, $loginUsername,$loginUserRank,$loginUserEmail,$loginUserImage;
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?=SITE_TITLE . " | " .$langDB['LANG_ADMIN_HOMEPAGE']?></title>



    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- dataTables-->
    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <!-- blueimp gallery -->
    <link href="css/plugins/lightbox2/css/lightbox.css" rel="stylesheet">

    <!-- Sweetalert -->
    <link rel="stylesheet" type="text/css" href="../assets/plugins/sweetalert-master/dist/sweetalert.css">
    <script src="../assets/plugins/sweetalert-master/dist/sweetalert.min.js"></script>

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="js/sistem.js"></script>



</head>

<body>
<div id="wrapper">

    <?php require_once ('sidebar.php');?>



    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="index.php" title="<?=$langDB['LANG_ADMIN_HOMEPAGE'];?>"><i class="fa fa-home"></i> </a>


                    <?php

                        if ($page !=NULL){
                           echo '<a class="navbar-minimalize minimalize-styl-2 btn btn-danger " title="Web Sitesi Ayarları" href="'.URL.'/admin/index.php?page=webSettings"><i class="fa fa-cog"></i> </a><a class="navbar-minimalize minimalize-styl-2 btn btn-info " title="Yönetici Ayarları" href="index.php"><i class="fa fa-user"></i></a>';
                        }

                    ?>

                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="<?=URL;?>" target="_blank"><?=$langDB['LANG_ADMIN_WEB_HOMEPAGE'];?> </a>


                </div>


                <ul class="nav navbar-top-links navbar-right">
                    <li><a href="<?=URL;?>/en" ><img src="img/flags/16/United-States.png"></a></li>
                    <li><a href="<?=URL;?>/de" ><img src="img/flags/16/Germany.png"></a></li>
                    <li><a href="<?=URL;?>/tr" ><img src="img/flags/16/Turkey.png"></a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <?php

                                $db = new Database();
                                $queryContactMessage = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_CONTACTFORM WHERE READED=? ORDER BY ID DESC",['N']);
                                $db->Disconnect();

                            ?>
                            <i class="fa fa-envelope"></i>  <span class="label label-warning"><?=count($queryContactMessage);?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <?php

                                if ($queryContactMessage !=NULL){
                                    foreach ($queryContactMessage AS $queryContactMessageShow){
                                        echo'<li>
                                                <div class="dropdown-messages-box">
                                                    
                                                    <div class="media-body text-left link-block">
                                                        <a style="padding-left: 0px" href="index.php?page=contactFormDetail&ID='.$queryContactMessageShow['ID'].'"> <strong>'.$queryContactMessageShow['NAME'].'</strong> : '.$queryContactMessageShow['SUBJECT'].'</a><br>
                                                        <small class="text-muted">'.time_elapsed_string($queryContactMessageShow['ADDDATE']).'</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="divider"></li>';
                                    }
                                }else{
                                    echo '<li>'.$langDB['LANG_NO_MESSAGE'].'</li>';
                                }
                            ?>



                            <li>
                                <div class="text-center link-block">
                                    <a href="index.php?page=contactFormList">
                                        <i class="fa fa-envelope"></i> <strong><?=$langDB['LANG_ALL_MESSAGE']?></strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="index.php?page=Logout">
                            <i class="fa fa-sign-out"></i> <?=$langDB['LANG_BTN_LOGOUT'];?>!
                        </a>
                    </li>

                </ul>

            </nav>
        </div>

            <!-- Your Page Content Here -->
            <?=adminContent();?>

            <!-- Your Page Content Here -->

        <div class="footer">
            <div class="pull-right text-quay">
                 <strong>Coder</strong> <a href="http://fuatgormez.de" target="_blank">FG.</a>
            </div>
            <div class="text-quay">
                <strong>Copyright © 2017 </strong> <?=SITE_TITLE;?>
            </div>
        </div>

    </div>



</div>



<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>



<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>
<script src="js/demo/peity-demo.js"></script>


<!-- Custom and plugin javascript -->

<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>


<!-- dataTables-->
<script src="js/plugins/dataTables/datatables.min.js"></script>

<!-- GITTER -->
<script src="js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="js/plugins/chartJs/Chart.min.js"></script>


<!-- Toastr -->
<script src="js/plugins/toastr/toastr.min.js"></script>

<!-- blueimp gallery -->
<script src="js/plugins/lightbox2/js/lightbox.js"></script>


<?php echo @$page == 'imagesList' ? '<!-- Clipboard --><script src="js/plugins/clipboard/clipboard.min.js"></script>' : null; ?>
<?php echo @$page == 'categoryAdd' || @$page == 'categoryEdit' || @$page == 'pageAdd' || @$page == 'pageEdit' || @$page == 'newsAdd' || @$page == 'newsEdit' || @$page == 'noticeAdd' || @$page == 'noticeEdit' || @$page == 'videoAdd' || @$page == 'videoEdit' || @$page == 'imageAdd' || @$page == 'imageEdit' || @$page == 'userEdit' || $page == 'webSettings' || $page == 'carAdd' || $page == 'carEdit' ? '<!-- ckeditor --><script src="js/plugins/ckeditor5/ckeditor.js"></script><script src="js/plugins/ckeditor5/js/sample.js"></script>' : null; ?>


<script>
    $(document).ready(function() {

        <?php echo @$page == 'categoryAdd' || @$page == 'categoryEdit' || @$page == 'pageAdd' || @$page == 'pageEdit' || @$page == 'newsAdd' || @$page == 'newsEdit' || @$page == 'noticeAdd' || @$page == 'noticeEdit'|| @$page == 'videoAdd' || @$page == 'videoEdit' || @$page == 'imageAdd' || @$page == 'imageEdit' || @$page == 'userEdit' || $page == 'webSettings' || $page == 'carAdd' || $page == 'carEdit' ? 'initSample();' : null; ?>



        $('.dataTables-example').DataTable({
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            "language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?=$langSession?>.json"}
        });





        //popup messeage only once
        var alerted = localStorage.getItem('alerted') || '';
        if (alerted != 'yes') {

            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('<?=$loginUsername;?>', '<?=$langDB["LANG_WELCOME"]?>');

            }, 1300);

            localStorage.setItem('alerted','yes');
        }

        <!-- logs -->
            setInterval(function() {$("#logs").load("index.php?page=logs #logs");}, 2000);
        <!-- /logs -->



    });





</script>
</body>
</html>
