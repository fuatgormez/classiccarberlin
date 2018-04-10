<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo SITE_TITLE;?></title>

    <link name="author" href="<?php echo URL;?>" />
    <meta name="description" content="<?php echo SITE_TITLE;?>">

    <!-- Favicons -->
    <link rel="shortcut icon" href="<?php echo URL;?>/theme/kapali/favicon.ico">

    <!-- Mobile -->
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

	<!-- CSS start here -->
	<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/theme/kapali/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/theme/kapali/css/styles.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/theme/kapali/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/theme/kapali/css/animate.css" />
	<!-- CSS end here -->
	<!-- Google fonts start here -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	<!-- Google fonts end here -->
</head>
<body class="ux">
  <div class="bg-overlay"></div>
	<!-- Preloader start here -->
	<div id="preloader">
		<div id="status"></div>
	</div>
	<!-- Preloader end here -->
<!-- About Icon start here -->
	<div class="about-us">
		<a href="#" class="fa fa-file-text-o tool-tip" data-toggle="modal" data-target=".bs-example-modal-lg" data-placement="right" title="Hakkımızda"></a>
	</div>
<!-- About Icon end here -->
<!-- Contact Icon start here -->
	<div class="contact-us">
		<a href="#" class="fa fa-envelope-o tool-tip" data-toggle="modal" data-target=".bs-example-modal-lg2"  data-placement="left" title="İletişim"></a>
	</div>
<!-- Contact Icon end here -->
	<!-- Main container start here -->
	<section class="container main-wrapper">

		<!-- Slogan start here -->
		<section class="slogan fade-down">
			<h1><?php echo SITE_STATUSMESSAGE;?></h1>
		</section>
		<!-- Slogan end here -->

    <!-- Newsletter start here -->
    <section class="newsletter row fade-down">

            <form action="" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="contact col-md-6 fade-down validate" novalidate>
            <div id="mc_embed_signup_scroll" class="form-group">
                <div><span class="email-ico"> <i class="fa fa-envelope-o"></i> </span>
              <input type="email" value="" name="Eposta" class="required email" id="mce-EMAIL" placeholder="email@email.com">          </div>
            <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display:none"></div>
                <div class="response" id="mce-success-response" style="display:none"></div>
            </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

            <div class="clear"><input type="submit" value="+" name="Newsletter" id="mc-embedded-subscribe" class="btn-submit"></div>
            </div>
        </form>
    </section>
    <!-- Newsletter end here -->
		<!-- Social icons start here -->
		<ul class="connect-us row fade-down">
			<li><a href="<?php echo SITE_FACEBOOK;?>" class="fb tool-tip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
			<li><a href="<?php echo SITE_TWITTER;?>" class="twitter tool-tip" title="Twitter"><i class="fa fa-twitter"></i></a></li>

		</ul>
		<!-- Social icons end here -->
		<!-- Footer start here -->
		<footer class="fade-down">
			<p class="footer-text">&copy; <?php echo SITE_TITLE;?> 2016, All Rights Reserved.</p>
		</footer>
		<!-- Footer end here -->
	</section>
<!-- About start here -->
  <div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true" data-keyboard="true" data-backdrop="static" tabindex="-1">
    <a href="#" class="fa fa-times cls-pop" data-dismiss="modal"></a>
    <div class="modal-dialog modal-lg clearfix">
      <div class="modal-content pop-up">
        <h3><?php echo SITE_TITLE;?></h3>
        <div class="clearfix">
            <div>
                <?php

                $db = new Database();
                $HakkimizdaGoster = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_PAGES WHERE ID = 31");
                if($HakkimizdaGoster>0){

                echo html_entity_decode($HakkimizdaGoster["CONTENT"]);
                }else{
                    echo "Keine Inhalt...";
                }
                $db->Disconnect();
                ?>
             </div>
      </div>

      </div>
    </div>
  </div>
<!-- About end here -->
<!-- Contact start here -->
  <div class="modal fade bs-example-modal-lg2" role="dialog" aria-hidden="true" data-keyboard="true" data-backdrop="static" tabindex="-1">
    <a href="#" class="fa fa-times cls-pop" data-dismiss="modal"></a>
    <div class="modal-dialog modal-lg">
      <div class="modal-content pop-up pop-up-cnt">
        <h3>KONTAKT!</h3>

        <div class="clearfix cnt-wrap">
         <form id="contactform" name="contactform" action="" method="post" novalidate>
         	<div id="result"></div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 columns">
                <input type="text" id="name" placeholder="Name *" name="AdSoyad" />
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 columns">
                <input type="text"  id="email" placeholder="email@name.com" name="Eposta" />
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 columns">
                <textarea id="comments" name="Mesaj" placeholder="Nachrichten *" ></textarea>
              </div>



              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center columns">
                <button name="IletisimFormu" id="submit" class="contact-btn-submit" type="submit">SEND</button>
              </div>
            </form>
        </div>


        <div class="clearfix cnt-wrap">
          <div class="col-md-4 col-sm-4">
            <i class="fa fa-phone"></i>
            <h4>TELEFON</h4>
            <p><?php echo SITE_TEL1;?></p>
          </div>

          <div class="col-md-4 col-sm-4">
            <i class="fa fa-envelope-o"></i>
            <h4>EMAIL</h4>
            <p><?php echo SITE_EMAIL;?></p>
          </div>
          <div class="col-md-4 col-sm-4">
            <i class="fa fa-map-marker"></i>
            <h4>ADRESE</h4>
            <p><?php echo SITE_ADRESS;?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- Contact end here -->
		<!-- Main container start here -->
		<!-- Javascript framework and plugins start here -->
		<script type="text/javascript" src="<?php echo URL;?>/theme/kapali/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo URL;?>/theme/kapali/js/bootstrap.min.js"></script>
		<script src="<?php echo URL;?>/theme/kapali/js/jquery.validate.min.js"></script>
		<script src="<?php echo URL;?>/theme/kapali/js/modernizr.js"></script>
		<script type="text/javascript" src="<?php echo URL;?>/theme/kapali/js/appear.js"></script>
		<script src="<?php echo URL;?>/theme/kapali/js/jquery.knob.js"></script>
		<script src="<?php echo URL;?>/theme/kapali/js/jquery.ccountdown.js"></script>
		<script src="<?php echo URL;?>/theme/kapali/js/init.js"></script>
		<script src="<?php echo URL;?>/theme/kapali/js/general.js"></script>

<!-- Javascript framework and plugins end here -->
</body>
</html>

<?php
        if(isset($_POST['Newsletter'])){
          $_POST  = multiDimensionalArrayMap('cleanEvilTags', $_POST);
          $_POST  = multiDimensionalArrayMap('cleanData', $_POST);
            $Eposta =trim(htmlspecialchars($_POST['Eposta']));
            $EklemeTarihi = date("Y-m-d H:i:s");

        try {
            if($Eposta!=''){
                $db = new Database();
                $ekle = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_NEWSLETTER(EMAIL, EKLENMETARIHI)VALUE(?,?)",[$Eposta,$EklemeTarihi]);

                echo '<script>alert("Ihre Email wurde hinzugefügt!");</script>';
            }else{
                echo '<script>alert("Ihre Email wurde nicht hinzugefügt!");</script>';
            }
        } catch (Exception $e) {
            die ('Es gibt ein Problem: ' . $e->getMessage());
        }
            $db->Disconnect();

        }

        if(isset($_POST['IletisimFormu'])){
          $_POST  = multiDimensionalArrayMap('cleanEvilTags', $_POST);
          $_POST  = multiDimensionalArrayMap('cleanData', $_POST);
            $AdSoyad 	= trim(htmlspecialchars($_POST["AdSoyad"]));
            $Mesaj	 	= trim(htmlspecialchars($_POST["Mesaj"]));
            $Eposta	 	= trim(htmlspecialchars($_POST["Eposta"]));
            $EklemeTarihi = date("Y-m-d H:i:s");

            try {
                if ($AdSoyad !='' && $Mesaj !='') {
                    $db = new Database();
                    $ekle = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_CONTACTFORM(NAME, MESSAGE, EMAIL, ADDDATE)VALUE(?,?,?,?)",[$AdSoyad,$Mesaj,$Eposta,$EklemeTarihi]);

                    echo '<script>alert("Ihre nachrichten wurde gesendet!");</script>';
                }else {
                    echo '<script>alert("Ihre nachrichten wurde nicht gesendet!");</script>';
                }
            } catch (Exception $e) {
                die ('Es gibt ein Problem: ' . $e->getMessage());
            }
            $db->Disconnect();
        }