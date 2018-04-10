<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$langDB['LANG_PAGE_CARS'];?></span>
            </h1>
        </section>

        <!-- Main -->
        <div id="main-content">

            <div class="post-content">


                <section id="template-items">
                    <ul class="template-items clearfix">

                        <?php
                        $emtpyImage = "no-image-thumbnail.png";

                        $db = new Database();
                        $carQuery = $db->getRows("SELECT car.ID as CARID, car.TITLE as CARTITLE,car.STATUS as CARSTATUS, car.PRICE as CARPRICE, car.BRAND as CARBRAND,car.SLUG as SLUG, image.IMAGE as IMAGE, image.THUMBNAIL as THUMBNAIL FROM ".TABLE_PREFIX."TBL_CARS as car LEFT JOIN ".TABLE_PREFIX."TBL_IMAGES as images ON images.CARID=car.ID LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON image.IMAGESID=images.ID GROUP BY car.TITLE ORDER BY car.ID DESC");
                        $db->Disconnect();


                        if ($carQuery !=NULL){
                            foreach ($carQuery as $carQueryshow){
                                if ($carQueryshow['IMAGE'] == NULL && $carQueryshow['THUMBNAIL'] == NULL)
                                {
                                    $carImageThumb  = "no-car-image.jpg";
                                    $carImage       = "no-car-image.jpg";
                                }else{
                                    $carImageThumb = $carQueryshow['THUMBNAIL'];
                                    $carImage       = $carQueryshow['IMAGE'];
                                }
                                if ($carQueryshow !=NULL && $carQueryshow['CARSTATUS']!='N'){
                                    echo '
                                    <li>
                                        <h2><a href="'.URL.'/car/'.$carQueryshow['SLUG'].'.html">'.$carQueryshow['CARTITLE'].'</a></h2>
                                        <figure>
                                            <a data-lightbox="example-set1" href="'.URL.'/uploads/images/'.$carImage.'"> <img src="'.URL.'/uploads/images/thumb/'.$carImageThumb.'" alt="'.$carQueryshow['CARTITLE'].'"></a>
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


                        ?>



                    </ul>
                </section>


            </div>

        </div><!-- End Main -->

        <div class="container-bottom"></div>

    </div> <!-- End Content-->

</div><!-- End Container -->





