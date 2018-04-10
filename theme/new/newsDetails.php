<?php
$link = $_GET['link'];
try{

    $db = new Database();
    $Details = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_NEWS WHERE SLUG=? AND STATUS=?",[$link,"Y"]);
    $tags    = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_TAGS WHERE NEWSID=?",[$Details['ID']]);
    $db->Disconnect();

                if ($Details == NULL) {
                    return sweetalert($langDB["LANG_NO_RESULT"], $langDB["LANG_REDIRECTING"], "error", "index.html", "3000");
                }


} catch (Exception $e) {
    die ('Es gibt ein Problem: ' . $e->getMessage());
}


?>
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


                    <?php

                        try{



                                        echo'<h2 class="title-heading"> '.$Details['TITLE'].' </h2>
                                            <article class="clearfix">
                                                
                                                <div class="post-content">
                                                    <p>'.html_entity_decode($Details['CONTENT']).'</p>
                                                    <p class="notice">'.$langDB['LANG_TAGS'].': '.$tags['TAGS'].'</p>
                                                    <p class="date"><em>'.strftime("%e %B %Y %H:%M", strtotime($Details['ADDDATE'])).'</em></p>
                                                    <a class="read-less" href="'.URL.'/news">'.$langDB['LANG_BACK'].'</a>
                                                </div>
                        
                                            </article>';


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





