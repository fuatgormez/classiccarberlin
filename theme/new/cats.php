<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$langDB['LANG_PAGE_NEWS'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-content">



                <!-- Main -->
                <div id="main-content">
                    <h2 class="title-heading"> <?=$langDB['LANG_NEWS'];?> </h2>

                    <?php

                        try{
                            $db = new Database();
                            $query = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_CATEGORIES WHERE STATUS=? ORDER BY ID DESC",["Y"]);
                            $db->Disconnect();

                                if ($query !=NULL){
                                    foreach ($query as $queryShow){

                                        echo'<article class="clearfix">
                                                <figure>
                                                    <a href="'.URL.'/news/'.$queryShow['SLUG'].'.html"><img src="'.THEME_URL.'/images/news.png" class="alignleft wp-post-image" alt=""></a>
                                                </figure>
                                                <div class="post-content">
                                                    <h3 class="post-title"><a href="'.URL.'/news/'.$queryShow['SLUG'].'.html">'.$queryShow['TITLE'].'</a></h3>
                                                    <a class="read-more" href="'.URL.'/news/'.$queryShow['SLUG'].'.html">'.$langDB['LANG_BTN_MORE'].'</a>
                                                    <p class="date"><em>'.strftime("%e %B %Y %H:%M", strtotime($queryShow['ADDDATE'])).'</em></p>
                                                </div>
                        
                                            </article>';
                                    }
                                }else{
                                    echo $langDB['LANG_NEWS_NOTFOUND'];
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