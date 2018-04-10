<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <div id="main-content">

            <section class="page-head">
                <h1>
                    <span><marquee behavior="scroll"><?=$langDB['LANG_WELCOME'] ." ". SITE_TITLE;?></marquee></span>
                </h1>
            </section>

            <p><?=$langDB['LANG_HEADER_INFO1'];?></p>

            <section class="page-head">
                <h1>
                    <span><a href="<?=URL;?>/cars"><?=$langDB['LANG_CARS'];?></a></span>
                </h1>
            </section>

            <section id="template-items">
                <ul class="template-items clearfix">

                    <?php
                        $emtpyImage = "no-image-thumbnail.png";

                    $db = new Database();
                    $carQuery = $db->getRows("SELECT car.ID as CARID, car.TITLE as CARTITLE,car.STATUS as CARSTATUS, car.PRICE as CARPRICE, car.BRAND as CARBRAND,car.SLUG as SLUG, image.IMAGE as IMAGE, image.THUMBNAIL as THUMBNAIL FROM ".TABLE_PREFIX."TBL_CARS as car LEFT JOIN ".TABLE_PREFIX."TBL_IMAGES as images ON images.CARID=car.ID LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON image.IMAGESID=images.ID GROUP BY car.TITLE ORDER BY car.ID DESC LIMIT 6");
                    $db->Disconnect();


                    if ($carQuery !=NULL){
                        foreach ($carQuery as $carQueryshow){
                            if ($carQueryshow['IMAGE'] == NULL && $carQueryshow['THUMBNAIL'] == NULL)
                            {
                                $carImageThumb  = "no-car-image.jpg";
                            }else{
                                $carImageThumb = $carQueryshow['THUMBNAIL'];
                            }
                            if ($carQueryshow !=NULL && $carQueryshow['CARSTATUS']!='N'){
                                echo '
                                    <li>
                                        <h2><a href="'.URL.'/car/'.$carQueryshow['SLUG'].'.html">'.$carQueryshow['CARTITLE'].'</a></h2>
                                        <figure>
                                            <a href="'.URL.'/car/'.$carQueryshow['SLUG'].'.html"> <img src="'.URL.'/uploads/images/thumb/'.$carImageThumb.'"></a>
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

            <hr class="separator">

            <div class="home-contanier">

                <section class="home-contanier-content widget">
                    <h3 class="title"><a href="<?=URL;?>/notices"><?=$langDB['LANG_NOTICES'];?></a></h3>
                    <ul>
                        <?php
                            try{
                                $db = new Database();
                                $noticesQuery = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_NOTICES WHERE STATUS=? ORDER BY ID DESC",["Y"]);
                                $db->Disconnect();

                                foreach ($noticesQuery as $noticesQueryShow){
                                    echo '<li><a href="'.URL.'/notice/'.$noticesQueryShow['SLUG'].'.html">'.$noticesQueryShow['TITLE'].'</a></li>';
                                }
                            } catch (Exception $e) {
                                die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
                            }
                        ?>
                    </ul>
                </section>

                <section class="home-contanier-content widget">
                    <h3 class="title"><a href="<?=URL;?>/news"><?=$langDB['LANG_NEWS'];?></a></h3>
                    <ul>
                        <?php
                            try{
                                $db = new Database();
                                $newsQuery = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_NEWS WHERE STATUS=? ORDER BY ID DESC",["Y"]);
                                $db->Disconnect();

                                foreach ($newsQuery as $newsQueryShow){
                                    echo '<li><a href="'.URL.'/news/'.$newsQueryShow['SLUG'].'.html">'.$newsQueryShow['TITLE'].'</a></li>';
                                }
                            } catch (Exception $e) {
                                die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
                            }
                        ?>
                    </ul>
                </section>

                <section class="home-contanier-content widget">
                    <h3 class="title"><a href="<?=URL;?>/videos"><?=$langDB['LANG_VIDEOS'];?></a></h3>
                    <ul>
                        <?php
                            try{
                                $db = new Database();
                                $videosQuery = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_VIDEOS WHERE STATUS=? ORDER BY ID DESC",["Y"]);
                                $db->Disconnect();

                                foreach ($videosQuery as $videosQueryShow){
                                    echo '<li><a href="">'.$videosQueryShow['TITLE'].'</a></li>';
                                }
                            } catch (Exception $e) {
                                die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
                            }
                        ?>
                    </ul>
                </section>


            </div>


            <p></p>

            <section class="flexcarousel">
                <div class="carousel es-carousel-wrapper clearfix">
                    <div class="es-carousel">
                        <ul>
                            <?php

                                try{
                                    $db = new Database();
                                    $queryImages = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_IMAGES");
                                    $db->Disconnect();

                                    foreach ($queryImages as $showImages){
                                        echo'<li>
                                        <figure class="the-tooltip top center full-width sienna">
                                            <a data-lightbox="example-set2" href="'.URL.'/uploads/images/'.$showImages['SLUG'].'">
                                                <img width="89" height="89" src="uploads/images/'.$showImages['SLUG'].'" />
                                            </a>
                                            <figcaption>'.$showImages['TITLE'].'</figcaption>
                                        </figure>
                                        <div class="price">
                                            <span>'.$showImages['CONTENT'].'</span>
                                        </div>
                                    </li>';
                                    }
                                } catch (Exception $e) {
                                    die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
                                }
                            ?>


                        </ul>
                    </div>
                </div>
            </section>



            <blockquote>
                <p>Der Classic Car Service in Berlin ist international anerkannte Erlebniswelt und Kompetenz-Zentrum zum Thema Oldtimer und Liebhaberfahrzeuge. Die ClassicCar waren die ersten derartigen Oldtimerzentren weltweit. Berlin wurde 2017 eröffnet.

                    In anspruchsvoll restaurierter historischer Industriearchitektur finden Sie in einer einzigartigen Atmosphäre Werkstätten, Handels- und Ausstellungsflächen, Glas-Garagen, Shops, Servicebetriebe, Gastronomie und Veranstaltungsflächen für unvergessliche Events.

                    Die ClassicCar ist für Freunde von schönen Fahrzeugen jederzeit attraktiv und sehenswert. Für Veranstaltungen, an die sich Teilnehmer lange erinnern, finden Agenturen und Ausrichter hier den idealen Ort.

                    Sie sind an 365 Tagen im Jahr herzlich willkommen.</p>
                <p class="author">Classic Car Service Berlin</p>
            </blockquote>

        </div><!-- End of Main Content-->

        <div class="container-bottom"></div>

    </div><!-- End Content-->

</div><!-- End Container -->