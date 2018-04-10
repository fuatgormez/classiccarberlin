<?php
$link = $_GET['link'];

try{

    $db = new Database();
    $Details = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_VIDEOS WHERE SLUG=? AND STATUS=?",[$link]);
    $tags    = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_TAGS WHERE VIDEOSID=?",[$Details['ID']]);
    $db->Disconnect();

    if ($Details == NULL) {
        return sweetalert($langDB["LANG_NO_RESULT"], $langDB["LANG_REDIRECTING"], "error", "index.html", "3000");
    }


} catch (Exception $e) {
    die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
}


?>
<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$Details['TITLE'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-content">


                <div class="columns">

                    <?php

                        try{


                                if ($Details !=NULL){

                                        $newYoutubeUrl = explode("https://youtu.be/",$Details['LINK']);
                                        echo'<div class="one"><br>
                                                
                                                
                                                <p class="video-container"><iframe width="%100" height="%100" src="https://www.youtube.com/embed/'.$newYoutubeUrl[1].'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></p>
                                                <p>'.html_entity_decode($Details['CONTENT']).'</p>
                                                <p class="notice">'.$langDB['LANG_TAGS'].': '.$tags['TAGS'].'</p>
                                                <p class="date"><em>'.strftime("%e %B %Y %H:%M", strtotime($Details['ADDDATE'])).'</em></p>
                                                <a class="read-less" href="'.URL.'/videos">'.$langDB['LANG_BACK'].'</a>
                                                <hr class="separator">
                                            </div>';

                                }else{
                                    echo $langDB['LANG_VIDEO_NOTFOUND'];
                                }

                        } catch (Exception $e) {
                            die ('Es gibt ein Problem: ' . $e->getMessage());
                        }
                    ?>



                </div>


            </div>






        </div><!-- End Main -->

        <div class="container-bottom"></div>

    </div> <!-- End Content-->

</div><!-- End Container -->





