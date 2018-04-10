<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$langDB['LANG_PAGE_VIDEOS'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-content">


                <div class="columns">

                    <?php

                        try{
                            $db = new Database();
                            $queryVideo = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_VIDEOS WHERE STATUS=? ORDER BY ID DESC",["Y"]);
                            $db->Disconnect();

                                if ($queryVideo !=NULL){
                                    foreach ($queryVideo as $queryVideoShow){
                                        $newYoutubeUrl = explode("https://youtu.be/",$queryVideoShow['LINK']);
                                        echo'<div class="one-half"><br>
                                                
                                                <h4><a href="'.URL.'/video/'.$queryVideoShow['SLUG'].'.html">'.$queryVideoShow['TITLE'].'</a></h4>
                                                <p class="video-container"><iframe width="400" height="400" src="https://www.youtube.com/embed/'.$newYoutubeUrl[1].'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></p>
                                                <p>'.html_entity_decode($queryVideoShow['CONTENT']).'</p>
                                                <p class="date"><em>'.strftime("%e %B %Y %H:%M", strtotime($queryVideoShow['ADDDATE'])).'</em></p>
                                                <a class="read-more" href="'.URL.'/video/'.$queryVideoShow['SLUG'].'.html">'.$langDB['LANG_BTN_MORE'].'</a>
                                                <hr class="separator">
                                            </div>';
                                    }
                                }else{
                                    echo $langDB['LANG_VIDEO_NOTFOUND'];
                                }

                        } catch (Exception $e) {
                            die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
                        }
                    ?>



                </div>


            </div>






        </div><!-- End Main -->

        <div class="container-bottom"></div>

    </div> <!-- End Content-->

</div><!-- End Container -->





