<!doctype html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en-US"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en-US"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en-US"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-US"> <!--<![endif]-->
    <head>
        <!-- META TAGS -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width" />
    
        <title><?=SITE_TITLE;?></title>
    
        <!-- FAVICON -->
        <link rel="shortcut icon" href="<?=THEME_URL;?>/images/favicon.png" />
    
    
        <!-- Google Web Fonts-->
        <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
    
    
        <!-- Style Sheet-->
        <link rel='stylesheet' href='<?=THEME_URL;?>/css/main.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?=THEME_URL;?>/css/media-queries.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?=THEME_URL;?>/js/flexslider/flexslider.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?=THEME_URL;?>/js/prettyphoto/prettyPhoto.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?=THEME_URL;?>/js/the-tooltip/the-tooltip.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?=THEME_URL;?>/css/custom.css' type='text/css' media='all' />
        <link rel='stylesheet' href='<?=THEME_URL;?>/js/jquery-ui-1.9.0.custom/css/trontastic/jquery-ui-1.9.0.custom.css' type='text/css' media='all' />
        <link rel="stylesheet" href="<?=URL;?>/assets/css/pluging/lightbox/lightbox.min.css">


        <!-- Script-->
        <script type='text/javascript' src='<?=THEME_URL;?>/js/jquery-1.8.3.min.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/elastislide/jquery.easing.1.3.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/elastislide/jquery.elastislide.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/prettyphoto/jquery.prettyPhoto.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/jquery.validate.min.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/jquery.form.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/flexslider/jquery.flexslider-min.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/jquery.isotope.min.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/the-tooltip/the-tooltip.min.js'></script>

        <!-- Sweetalert -->
        <link rel="stylesheet" type="text/css" href="<?=URL;?>/App/sweetalert-master/dist/sweetalert.css">
        <script src="<?=URL;?>/App/sweetalert-master/dist/sweetalert.min.js"></script>


        <!--[if lt IE 9]>
        <script src="<?=THEME_URL;?>/js/html5.js"></script>
        <![endif]-->
    
    
        <!--[if (gte IE 6)&(lte IE 8)]>
        <script defer src="s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.4-min.js"></script>
        <script defer src="js/the-tooltip/selectivizr-min.js"></script>
        <![endif]-->
    
    </head>
    <body>
    
        <!-- Start wrap -->
        <div id="page-content-wrap">
        
            <!-- Start Header -->
            <div id="header-wrapper">
                <header id="header">
                    <h6>
                        <a href="<?=URL;?>/tr"><img title="Turkisch" src="<?=URL;?>/assets/img/flags/32/Turkey.png"> </a>

                        <a href="<?=URL;?>/en"><img title="Englisch" src="<?=URL;?>/assets/img/flags/32/United-States.png"> </a>

                        <a href="<?=URL;?>/de"><img title="Deutsch" src="<?=URL;?>/assets/img/flags/32/Germany.png"></a>
                    </h6>
                    <!--Left Menu -->
                    <nav class="main-menu left clearfix">
                        <div class="menu-left-main-menu-container">
                            <ul id="menu-left-main-menu" class="clearfix">
                                <li class="menu-item"><a href="index.html"><?=$langDB['LANG_HOMEPAGE'];?></a></li>

                                <li class="menu-item"><a href="#"><?=$langDB['LANG_PAGES'];?></a>
                                    <ul class="sub-menu">
                                        <?php
                                            $db = new Database();
                                            $queryPages = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_PAGES WHERE STATUS = 'Y'");
                                            $db->Disconnect();

                                                foreach ($queryPages as $queryPageShow){
                                                    echo'<li class="menu-item"><a href="'.URL.'/page/'.$queryPageShow['SLUG'].'.html">'.$queryPageShow['TITLE'].'</a></li>';
                                                }
                                        ?>

                                    </ul>
                                </li>
                                <li class="menu-item"><a href="<?=URL;?>/notices"><?=$langDB['LANG_NOTICES'];?></a></li>
                            </ul>
                        </div>
                    </nav>
                    
                    <!-- Header Logo -->
                    <div id="logo">
                        <!-- Website Logo -->
                        <a href="<?=URL;?>/index.html"  title="<?=SITE_TITLE;?>">
                        	<img src="<?=URL;?>/uploads/logo/<?=SITE_LOGO;?>" alt="<?=SITE_TITLE;?>">
                        </a>
                    </div>
                    
                    <!-- Right Menu -->
                    <nav class="main-menu right clearfix">
                        <div class="menu-right-main-menu-container">
                            <ul id="menu-right-main-menu" class="clearfix">
                                <li class="menu-item"><a href="<?=URL;?>/contact"><?=$langDB['LANG_CONTACT'];?></a></li>
                                <li class="menu-item"><a href="<?=URL;?>/videos"><?=$langDB['LANG_VIDEOS'];?></a></li>
                                <li class="menu-item"><a href="<?=URL;?>/images"><?=$langDB['LANG_GALLERY'];?></a></li>
                            </ul>
                        </div>
                    </nav>
                
                </header>
            
            </div><!-- End Header -->

            <?=siteContent()?>

            <!-- Start Footer -->
            <div id="footer-wrapper">
                <footer id="footer">

                    <!-- Footer Menu -->
                    <nav id="footer-menu">
                        <ul id="menu-footer-menu" class="clearfix">
                            <li><a href="<?=URL;?>"><?=$langDB['LANG_HOMEPAGE'];?></a></li>
                            <li><a href="<?=URL;?>/impressum"><?=$langDB['LANG_IMPRESSUM'];?></a></li>
                            <li><a href="<?=URL;?>/agb"><?=$langDB['LANG_AGB'];?></a></li>
                            <li><a href="<?=URL;?>/cars"><?=$langDB['LANG_CARS'];?></a></li>
                            <li><a href="<?=URL;?>/pages"><?=$langDB['LANG_PAGES'];?></a></li>
                            <li><a href="<?=URL;?>/notices"><?=$langDB['LANG_NOTICES'];?></a></li>
                            <li><a href="<?=URL;?>/news"><?=$langDB['LANG_NEWS'];?></a></li>
                            <li><a href="<?=URL;?>/videos"><?=$langDB['LANG_VIDEOS'];?></a></li>
                            <li><a href="<?=URL;?>/images"><?=$langDB['LANG_GALLERY'];?></a></li>
                            <li><a href="<?=URL;?>/contact"><?=$langDB['LANG_CONTACT'];?></a></li>
                        </ul>
                    </nav>

                    <!-- Social Icons -->
                    <ul class="social-nav">
                        <li class="twitter"><a target="_blank" href="<?=SITE_TWITTER;?>"></a></li>
                        <li class="facebook"><a target="_blank" href="<?=SITE_FACEBOOK;?>"></a></li>
                        <li class="mail"><a target="_blank" href="mailto:<?=SITE_EMAIL;?>"></a></li>
                        <li class="rss"><a target="_blank" href="#"></a></li>
                    </ul>                
                    
                    <address><?=SITE_ADRESS;?></address>
                    <p>TEL: <?=SITE_TEL1 . " - " . SITE_TEL2;?> </p>
                    <p class="copyright">Copyright © 2018 RentaClassicCarBerlin. <?=$langDB['LANG_COPYRIGHT'];?></p>

                    
                </footer>
            </div><!-- End Footer -->
        
        </div><!-- End Page wrap -->
        
        <a href="#top" id="scroll-top"></a>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/jquery-ui-1.9.0.custom/js/jquery-ui-1.9.0.custom.min.js'></script>
        <script type='text/javascript' src='<?=THEME_URL;?>/js/custom.js'></script>
        <script src="<?=URL;?>/assets/js/pluging/lightbox/lightbox.min.js"></script>


    
    </body>
</html>