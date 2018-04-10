<?php
@$link = $_GET['link'];

        try{

                $db = new Database();
                $pageDetails = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_PAGES WHERE SLUG=? AND STATUS=?",[$link,"Y"]);
                $db->Disconnect();

                if ($pageDetails == NULL) {
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
                <span><?=$pageDetails['TITLE'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-content">
               <small><?=html_entity_decode($pageDetails['CONTENT']);?></small>
                <p><a href="<?=URL;?>/pages" class="read-less"><?=$langDB['LANG_BACK'];?></a></p>

            </div>


                <hr class="separator">



        </div><!-- End Main -->

        <div class="container-bottom"></div>

    </div> <!-- End Content-->

</div><!-- End Container -->





