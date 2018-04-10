<?php
    if (isset($_POST['submit'])){

        if($_POST['captcha'] != $_SESSION['rand_code'])
        {
            return sweetalert($langDB['LANG_WRONG_CODE'],$langDB['LANG_REDIRECTING'],"warning","contact","3000");
            die;
        }

        $name           = $_POST['name'];
        $telefonnumber  = $_POST['telefonnumber'];
        $email          = $_POST['email'];
        $message        = $_POST['message'];
        $subject        = $_POST['subject'];

        try{

            if ($name !=NULL && $telefonnumber !=NULL && $email !=NULL && $message !=NULL && $subject !=NULL){

                $db = new Database();
                $insertMessage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_CONTACTFORM SET NAME=?, TELEFONNUMBER=?, EMAIL=?, MESSAGE=?, SUBJECT=?",[$name,$telefonnumber,$email,$message,$subject]);
                $db->Disconnect();

                if ($insertMessage){
                    return sweetalert($langDB['LANG_CONTACT_SENT_SUCCESFULL'],$langDB['LANG_REDIRECTING'],"success","index.html","3000");
                }else{
                    return sweetalert($langDB['LANG_CONTACT_SENT_ERROR'],$langDB['LANG_REDIRECTING'],"error","contact","3000");
                }

            }else{
                return sweetalert($langDB['LANG_CONTACT_REQUIRED'],$langDB['LANG_REDIRECTING'],"warning","contact","3000");
            }

        } catch (Exception $e) {
            die ($langDB['LANG_CATCH_PROBLEM'] ." ". $e->getMessage());
        }


    }
?>
    
        <!-- Start wrap -->
        <div id="page-content-wrap">


            <!-- Start Container -->
            <div id="container">

                <!-- Content -->
                <div class="content full-width clearfix">

                    <div class="container-top"></div>

                    <section class="page-head">
                        <h1>
                            <span><?=$langDB['LANG_PAGE_CONTACT'];?></span>
                        </h1>
                    </section>

                    <!-- Main -->
                    <div id="main-content">

                        <article id="post-107" class="post-107 page type-page status-publish hentry clearfix">
                            <p><?=$langDB['LANG_CONTACT_INFO3'];?></p>
                            <address>
                                <p class="contactTxt"><?=SITE_ADRESS;?></p>
                                <p class="contactTxt">Email: <?=SITE_EMAIL;?></p>
                                <p class="contactTxt">TEL: <?=SITE_TEL1 . " - " . SITE_TEL2;?></p>
                            </address>
                        </article>
                        <div class="full-width clearfix video-container">

                            <?=html_entity_decode(SITE_MAPS);?>

                        </div>

                        <!-- separator -->
                        <hr class="separator">

                        <section >

                            <h2 class="form-heading"><?=$langDB['LANG_CONTACT_INFO1'];?>!</h2>

                            <p><?=$langDB['LANG_CONTACT_INFO2'];?></p>

                            <form class="contact-form clearfix" action="" method="post" >

                                <p class="adjust">
                                    <label for="name"><?=$langDB['LANG_CONTACT_NAME'];?> <span>*</span> </label>
                                    <input type="text" name="name"  placeholder="<?=$langDB['LANG_CONTACT_NAME_VALUE'];?>" required>
                                </p>

                                <p>
                                    <label for="pn"><?=$langDB['LANG_CONTACT_TEL_NUMBER'];?> <span>*</span></label>
                                    <input type="text" name="telefonnumber" placeholder="<?=$langDB['LANG_CONTACT_TEL_NUMBER_VALUE'];?>" required>
                                </p>

                                <p class="adjust">
                                    <label for="email"><?=$langDB['LANG_CONTACT_EMAIL'];?> <span>*</span></label>
                                    <input type="text" name="email" placeholder="<?=$langDB['LANG_CONTACT_EMAIL_VALUE'];?>" required>
                                </p>

                                <p>
                                    <label for="reason"><?=$langDB['LANG_CONTACT_SUBJECT'];?> <span>*</span></label>
                                    <input type="text" name="subject" placeholder="<?=$langDB['LANG_CONTACT_SUBJECT_VALUE'];?>" required>
                                </p>


                                <label for="message"><?=$langDB['LANG_CONTACT_MESSAGE'];?> <span>*</span> </label>
                                <textarea name="message" placeholder="<?=$langDB['LANG_CONTACT_MESSAGE_VALUE'];?>" required></textarea>

                                <div class="captcha-container">
                                    <label><?=$langDB['LANG_CONTACT_CODE'];?></label>
                                    <img class="captcha-img" src="<?=THEME_URL;?>/captcha/captcha.php" alt="">
                                    <input type="text" name="captcha" maxlength="5" placeholder="<?=$langDB['LANG_CONTACT_CODE_VALUE'];?>!" required>
                                </div>

                                <input type="submit" name="submit" value="<?=$langDB['LANG_BTN_SEND_MESSAGE'];?>" class="submit">
                                <img src="<?=THEME_URL;?>/images/ajax-loader.gif" id="contact-loader" alt="Loading...">



                            </form>

                            <div class="error-container"></div>


                        </section>

                    </div><!-- End Main -->




                    <div class="container-bottom"></div>

                </div> <!-- End Content-->

            </div><!-- End Container -->

            <!-- Start Footer -->

        
        </div><!-- End Page wrap -->





