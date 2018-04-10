<!-- Start Container -->
<div id="container">

    <!-- Content -->
    <div class="content full-width clearfix">

        <div class="container-top"></div>

        <section class="page-head">
            <h1>
                <span><?=$langDB['LANG_PAGE_GALLERY'];?></span>
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
                        $imageQuery = $db->getRows("SELECT image.IMAGE as IMAGE, image.THUMBNAIL as THUMBNAIL FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON image.IMAGESID=images.ID");
                        $db->Disconnect();


                        if ($imageQuery !=NULL){

                            foreach ($imageQuery as $imageQueryshow){
                                if ($imageQueryshow !=NULL){
                                    echo '
                                    <li>
                                        
                                        <figure>
                                            <a data-lightbox="example-set1" href="'.URL.'/uploads/images/'.$imageQueryshow['IMAGE'].'"> <img src="'.URL.'/uploads/images/thumb/'.$imageQueryshow['THUMBNAIL'].'" ></a>
                                        </figure>
                                        
                                    </li>
                                ';
                                }
                            }
                        }else{
                            echo '<li>Henuz resim eklenmemis</li>';
                        }


                        ?>



                    </ul>
                </section>


            </div>


                <hr class="separator">



        </div><!-- End Main -->

        <div class="container-bottom"></div>

    </div> <!-- End Content-->

</div><!-- End Container -->





