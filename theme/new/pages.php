<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$langDB['LANG_PAGE_PAGES'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-content">



                <!-- Main -->
                <div id="main-content">


                    <?php

                        try{
                            $db = new Database();
                            $queryPages = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_PAGES WHERE STATUS=? ORDER BY ID DESC",["Y"]);
                            $db->Disconnect();

                                if ($queryPages !=NULL){
                                    foreach ($queryPages as $queryPagesShow){

                                        echo'<article class="clearfix">
                                                <figure>
                                                    <a href="page/'.$queryPagesShow['SLUG'].'.html"><img src="'.THEME_URL.'/images/pages.png" class="alignleft wp-post-image" alt=""></a>
                                                </figure>
                                                <div class="post-content">
                                                    <h3 class="post-title"><a href="page/'.$queryPagesShow['SLUG'].'.html">'.$queryPagesShow['TITLE'].'</a></h3>
                                                    <a class="read-more" href="page/'.$queryPagesShow['SLUG'].'.html">'.$langDB['LANG_BTN_MORE'].'</a>
                                                    <p class="date"><em>'.strftime("%e %B %Y %H:%M", strtotime($queryPagesShow['ADDDATE'])).'</em></p>
                                                </div>
                        
                                            </article>';
                                    }
                                }else{
                                    echo $langDB['LANG_PAGE_NOTFOUND'];
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





