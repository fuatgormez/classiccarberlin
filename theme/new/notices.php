<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$langDB['LANG_PAGE_NOTICES'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-content">



                <!-- Main -->
                <div id="main-content">
                    <h2 class="title-heading"> <?=$langDB['LANG_NOTICES'];?> </h2>

                    <?php

                        try{
                            $db = new Database();
                            $queryNotices = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_NOTICES WHERE STATUS=? ORDER BY ID DESC",["Y"]);
                            $db->Disconnect();

                                if ($queryNotices !=NULL){
                                    foreach ($queryNotices as $queryNoticesShow){

                                        echo'<article class="clearfix">
                                                <figure>
                                                    <a href="notice/'.$queryNoticesShow['SLUG'].'.html"><img src="'.THEME_URL.'/images/notices.png" class="alignleft wp-post-image" alt=""></a>
                                                </figure>
                                                <div class="post-content">
                                                    <h3 class="post-title"><a href="notice/'.$queryNoticesShow['SLUG'].'.html">'.$queryNoticesShow['TITLE'].'</a></h3>
                                                    <a class="read-more" href="notice/'.$queryNoticesShow['SLUG'].'.html">'.$langDB['LANG_BTN_MORE'].'</a>
                                                    <p class="date"><em>'.strftime("%e %B %Y %H:%M", strtotime($queryNoticesShow['ADDDATE'])).'</em></p>
                                                </div>
                        
                                            </article>';
                                    }
                                }else{
                                    echo $langDB['LANG_NOTICE_NOTFOUND'];
                                }

                        } catch (Exception $e) {
                            die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
                        }
                    ?>


                </div><!-- End Main -->



            </div>






        </div><!-- End Main -->

        <div class="container-bottom"></div>

    </div> <!-- End Content-->

</div><!-- End Container -->





