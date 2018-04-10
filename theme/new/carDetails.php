<?php
$link = $_GET['link'];

        try{

            $db = new Database();
            $carDetails = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_CARS WHERE SLUG=? AND STATUS=?",[$link,"Y"]);

                //$carQuery = $db->getRows("SELECT image.IMAGE as IMAGE, image.THUMBNAIL as THUMBNAIL FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON image.IMAGESID=images.CARID WHERE CARID=?",[$ID]);

            $carQuery = $db->getRows("SELECT image.IMAGE as IMAGE, image.THUMBNAIL as THUMBNAIL FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON image.IMAGESID=images.ID WHERE CARID=?",[$carDetails['ID']]);

            $db->Disconnect();

                if ($carDetails == NULL) {
                    return sweetalert($langDB["LANG_NO_RESULT"], $langDB["LANG_REDIRECTING"], "error", "index.html", "3000");
                }


        } catch (Exception $e) {
            die ($langDB['LANG_CATCH_PROBLEM'] . $e->getMessage());
        }


?>
<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$carDetails['TITLE'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-head">





                <p> <span class="carText"><?=$langDB['LANG_TITLE'];?>: </span><small><?=$carDetails['TITLE'];?></small> |
                    <span class="carText"><?=$langDB['LANG_BRAND'];?>: </span><small><?=$carDetails['BRAND'];?></small> |
                    <span class="carText"><?=$langDB['LANG_MODEL'];?>: </span><small><?=$carDetails['MODEL'];?></small> |
                    <span class="carText"><?=$langDB['LANG_YEAR'];?>: </span><small><?=$carDetails['YEAR'];?></small> |
                    <span class="carText"><?=$langDB['LANG_MILEAGE'];?>: </span><small><?=$carDetails['MILEAGE'];?></small> |
                    <span class="carText"><?=$langDB['LANG_PRICE'];?>: </span><small><?=$carDetails['PRICE'];?> €</small></p>
                <h5 class="carText"><?=$langDB['LANG_DESCRIPTION'];?>: </h5><small><?=html_entity_decode($carDetails['DESCRIPTION']);?></small>





            </div>
            <hr class="separator">

            <article class="clearfix">
                <h2 class="title-heading"><?=$langDB['LANG_IMAGES'];?></h2>

                <div id="gallery-container" class="gallery-4-columns isotope clearfix">

                    <?php

                    foreach($carQuery as $carQueryShow)
                    {

                        echo'
                    <div class="gallery-item type-gallery-item status-publish hentry gallery-item isotope-item food ">
                        <figure>
                            <a data-lightbox="example-set" href="'.URL.'/uploads/images/'.$carQueryShow['IMAGE'].'" >
                            <img class="img-border" src="'.URL.'/uploads/images/thumb/'.$carQueryShow['THUMBNAIL'].'" >
                            </a>
                        </figure>
                        
                    </div>

                ';
                    }

                    ?>
                </div>
            </article>

                <hr class="separator">

            <section class="page-head">
                <h1>
                    <span><?=$langDB['LANG_OTHER_MODELS'];?></span>
                </h1>
            </section>

            <section id="template-items">
                <ul class="template-items clearfix">

                    <?php
                    $emtpyImage = "no-image-thumbnail.png";

                    $db = new Database();
                    $carQuery = $db->getRows("SELECT car.ID as CARID, car.TITLE as CARTITLE,car.STATUS as CARSTATUS, car.PRICE as CARPRICE, car.BRAND as CARBRAND,car.SLUG as SLUG, image.IMAGE as IMAGE, image.THUMBNAIL as THUMBNAIL FROM ".TABLE_PREFIX."TBL_CARS as car LEFT JOIN ".TABLE_PREFIX."TBL_IMAGES as images ON images.CARID=car.ID LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON image.IMAGESID=images.ID GROUP BY car.TITLE DESC");
                    $db->Disconnect();

                    shuffle($carQuery);
                    try{
                        if ($carQuery !=NULL){

                            foreach ($carQuery as $carQueryshow){
                                if ($carQueryshow !=NULL && $carQueryshow['CARSTATUS']!='N' && $carQueryshow['SLUG'] != $link){
                                    echo '
                                    <li>
                                        <h2><a href="'.URL.'/car/'.$carQueryshow['SLUG'].'.html">'.$carQueryshow['CARTITLE'].'</a></h2>
                                        <figure>
                                            <a href="'.URL.'/car/'.$carQueryshow['SLUG'].'.html"> <img src="'.URL.'/uploads/images/thumb/'.$carQueryshow['THUMBNAIL'].'" alt="'.$carQueryshow['CARTITLE'].'"></a>
                                        </figure>
                                        <h3>'.$langDB['LANG_PRICE'].': €'.$carQueryshow['CARPRICE'].'</h3>
                                        <h3>'.$langDB['LANG_BRAND'].': '.$carQueryshow['CARBRAND'].'</h3>
                                        
                                        <a href="'.URL.'/car/'.$carQueryshow['SLUG'].'.html" class="readmore">'.$langDB['LANG_BTN_MORE'].'</a>
                                    </li>
                                ';
                                }
                            }
                        }else{
                            echo '<li>'.$langDB['LANG_NO_RESULT'].'</li>';
                        }
                    } catch (Exception $e) {
                        die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
                    }


                    ?>



                </ul>
            </section>


        </div><!-- End Main -->

        <div class="container-bottom"></div>

    </div> <!-- End Content-->

</div><!-- End Container -->





