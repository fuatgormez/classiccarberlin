<?php
//========================================================================================================
if (isset($_POST['submitContactSettings'])){

    $reemail    = $_POST['email'];
    $tel1       = $_POST['tel1'];
    $tel2       = $_POST['tel2'];
    $tel3       = $_POST['tel3'];
    $fax1       = $_POST['fax1'];
    $fax2       = $_POST['fax2'];
    $fax3       = $_POST['fax3'];
    $adress     = $_POST['adress'];
    $maps       = html_entity_decode($_POST['maps']);

    try{

        if (!$fonk->emailControl($reemail)){
            echo sweetalert("Geçersiz email adresi girdiniz!","","warning","index.php?page=webSettings","2000");
            exit;
        }

        $db = new Database();
        $contactSetting = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_SETTINGS SET EMAIL=?,TEL1=?,TEL2=?,TEL3=?,FAX1=?,FAX2=?,FAX3=?,ADRESS=?,MAPS=? WHERE ID=?",[$reemail,$tel1,$tel2,$tel3,$fax1,$fax2,$fax3,$adress,$maps,intval(1)]);
        $db->Disconnect();

        if (!$contactSetting){
            return sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=webSettings","2000");
            exit;
        }else{
            return sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"","error","index.php?page=webSettings","2000");
            exit;
        }

    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }
}
//========================================================================================================
elseif (isset($_POST['submitSocialSettings'])){

    $facebook       = $_POST['facebook'];
    $twitter        = $_POST['twitter'];
    $youtube        = $_POST['youtube'];
    $instagram      = $_POST['instagram'];
    $googleplus     = $_POST['google'];
    $linkedin       = $_POST['linkedin'];
    $flickr         = $_POST['flickr'];


    try{

        $db = new Database();
        $socialSetting = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_SETTINGS SET FACEBOOK=?,TWITTER=?,YOUTUBE=?,INSTAGRAM=?,GOOGLE=?,LINKEDIN=?,FLICKR=? WHERE ID=?",[$facebook,$twitter,$youtube,$instagram,$googleplus,$linkedin,$flickr,intval(1)]);
        $db->Disconnect();

        if (!$socialSetting){
            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=webSettings","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"","error","index.php?page=webSettings","2000");
            exit;
        }

    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }
}
//========================================================================================================
elseif (isset($_POST['submitLogo'])){
    $images         = $_FILES['images'];

    $newLogoName   = '';

    try{

        $db = new Database();
        $siteLogo = $db->getRow("SELECT LOGO FROM ".TABLE_PREFIX."TBL_SETTINGS WHERE ID=?",[intval(1)]);

        if ($siteLogo !=NULL){ @unlink('../uploads/logo/'.$siteLogo['LOGO']);}


        if ($images !=NULL){
            $handle = new Upload($images);

            if ($handle->uploaded) {

                //Generate thumbnail
                $handle->allowed = array('image/*');
                $handle->image_resize = true;
                $handle->image_src_type;
                $handle->file_new_name_body = substr(base64_encode(uniqid(true)), 0, 20);

                $handle->image_ratio_crop = true;
                $handle->image_x = 220;
                $handle->image_ratio_y = true;


                $handle->Process("../uploads/logo/");
                $newLogoName = $handle->file_dst_name;


                if ($handle->processed) {

                    $updateLogo = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_SETTINGS SET LOGO=? WHERE ID=?",[$newLogoName,intval(1)]);

                    return sweetalert($langDB['LANG_ADDED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=webSettings","2000");
                    exit;

                } else {
                    $handle = false;
                    return sweetalert($langDB['LANG_FAILED_UPDATE'] . $handle->error ,$langDB['LANG_REDIRECTING'],"error","index.php?page=webSettings","3000");
                    exit();
                }

            } else {
                return sweetalert($langDB['LANG_FAILED_UPDATE'] . $handle->error,$langDB['LANG_REDIRECTING'],"error","index.php?page=webSettings","3000");
                exit();
            }
            unset($handle);
        }

        $db->Disconnect();

    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}
//========================================================================================================
elseif (isset($_POST['submit'])){
    $url            = $fonk->trLower($_POST['url']);
    $title          = $_POST['title'];
    $description    = $_POST['description'];
    $keywords       = $_POST['keywords'];
    $status         = $_POST['status'];
    $statusMessage  = $_POST['statusMessage'];
    $impressum      = $_POST['impressum'];
    $agb            = $_POST['agb'];
    $theme          = $_POST['theme'];

    try{
        if ($url !=NULL && $title !=NULL && $status !=NULL && $theme !=NULL){

            $db = new Database();
            $updateSettings = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_SETTINGS SET URL=?, TITLE=?, DESCRIPTION=?, KEYWORDS=?,STATUS=?, STATUSMESSAGE=?, IMPRESSUM=?, AGB=?,  THEME=? WHERE ID=?",[$url,$title,$description,$keywords,$status,$statusMessage,$impressum,$agb,$theme,intval(1)]);

            $message    = 'Web sitesi bilgilerini güncelledi! <i class="fa fa-arrow-right"></i>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();


            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=webSettings","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","index.php?page=webSettings","2000");
            exit;
        }


    } catch (Exception $e) {
        die ('Bir sorun var: ' . $e->getMessage());
    }


}else {

    $db = new Database();
    $querySettings = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_SETTINGS");
    $db->Disconnect();
//========================================================================================================
    echo '

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2 class="text-navy">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
        <span class="label label-primary"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-primary"><a href="index.php?page=webSettings">Websitesi Ayarları</a></span> /
        <span class="label label-primary">Ayarları Düzenle</span>
    </div>
    

</div>

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5 class="text-danger">(*) '.$langDB['LANG_ADMIN_REQUIRED'].' </h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">
            
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-cog"></i>'.$langDB['LANG_WEBSITE_SETTINGS'].'</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-image"></i>'.$langDB['LANG_LOGO'].'</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-phone"></i>'.$langDB['LANG_CONTACT_INFORMATION'].'</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-slideshare"></i>'.$langDB['LANG_SOCIAL_NETWORKS'].'</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="POST" class="form-horizontal" action="">
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Site Adresi <small class="text-danger">*</small></label>
                    
                                            <div class="col-sm-10"><input type="text" name="url" class="form-control" value="'.$querySettings['URL'].'" placeholder="http://siteadresi.com" required></div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Site Başlık <small class="text-danger">*</small></label>
                                            <div class="col-sm-10"><input type="text" name="title" class="form-control" value="'.$querySettings['TITLE'].'" placeholder="Sitenizin başlığını giriniz!" required></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Meta Açıklama <small class="text-danger">*</small></label>
                                            <div class="col-sm-10"><input type="text" name="description" class="form-control" value="'.$querySettings['DESCRIPTION'].'" placeholder="Siteniz hakkında kısa bir açıklama giriniz!" required></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Meta Kelime <small class="text-danger">*</small></label>
                                            <div class="col-sm-10"><input type="text" name="keywords" class="form-control" value="'.$querySettings['KEYWORDS'].'" placeholder="Siteniz hakkında kelimeler giriniz, virgül ile ayırınız!" required></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                    
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Site Durumu <small class="text-danger">*</small></label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="status" required>
                                                            <option value="Y" ';echo $querySettings['STATUS'] == 'Y' ? 'selected' : null; echo'>Site Açık</option>
                                                            <option value="N" ';echo $querySettings['STATUS'] == 'N' ? 'selected' : null; echo'>Site Kapalı</option>
                                                            
                                                        </select>
                                                        
                                            </div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Site Tema <small class="text-danger">*</small></label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="theme" required>'; $fonk->directoryList();echo'</select>
                                                        
                                            </div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Site durum mesajı</label>
                                            <div class="col-sm-10"><textarea class="ckeditor1" id="editor" name="statusMessage"  rows="10" cols="80" >'; echo $querySettings['STATUSMESSAGE'] !=NULL ? htmlspecialchars_decode($querySettings['STATUSMESSAGE']) : @$_SESSION['s_statusMessage']; echo'</textarea></div>
                                        </div>
            
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Impressum</label>
                                            <div class="col-sm-10"><textarea class="ckeditor1" id="editor2" name="impressum"  rows="10" cols="80" >'; echo $querySettings['IMPRESSUM'] !=NULL ? htmlspecialchars_decode($querySettings['IMPRESSUM']) : @$_SESSION['s_impressum']; echo'</textarea></div>
                                        </div>
            
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">AGB</label>
                                            <div class="col-sm-10"><textarea class="ckeditor1" id="editor3" name="agb"  rows="10" cols="80" >'; echo $querySettings['AGB'] !=NULL ? htmlspecialchars_decode($querySettings['AGB']) : @$_SESSION['s_agb']; echo'</textarea></div>
                                        </div>
            
                                        <div class="hr-line-dashed"></div>
                    
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                                                <button class="btn btn-primary" name="submit" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                            
                            
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                
                                 <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="">       
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy"><img width="100px" src="../uploads/logo/'; echo $querySettings['LOGO'] != NULL ? $querySettings['LOGO'] :'no-image.png'; echo'"></label>
                                            <div class="col-sm-10"><p class="text-navy">Web sitesi için bir resim yükleyiniz!</p></div>
                                            <div class="col-sm-10"><input type="file" name="images" class="form-control" required></div>
                                        </div>
                                        
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" name="submitLogo" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
                                            </div>
                                        </div>
                                        
                                  </form>
                                        
                                </div>
                            </div>
                            
                            
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                
                                 <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="">       
                                        
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">E-Posta</label>
                                            <div class="col-sm-10"><input type="text" name="email" class="form-control" value="'.$querySettings['EMAIL'].'" placeholder="adiniz@siteniz.com" ></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Telefon 1</label>
                                            <div class="col-sm-4"><input type="text" name="tel1" class="form-control" value="'.$querySettings['TEL1'].'" placeholder="0364 224 5719" ></div>
                                            <label class="col-sm-2 control-label text-navy">FAX 1</label>
                                            <div class="col-sm-4"><input type="text" name="fax1" class="form-control" value="'.$querySettings['FAX1'].'" placeholder="0364 224 5719" ></div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Telefon 2</label>
                                            <div class="col-sm-4"><input type="text" name="tel2" class="form-control" value="'.$querySettings['TEL2'].'"  ></div>
                                            <label class="col-sm-2 control-label text-navy">FAX 2</label>
                                            <div class="col-sm-4"><input type="text" name="fax2" class="form-control" value="'.$querySettings['FAX2'].'"  ></div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Telefon 3</label>
                                            <div class="col-sm-4"><input type="text" name="tel3" class="form-control" value="'.$querySettings['TEL3'].'"  ></div>
                                            <label class="col-sm-2 control-label text-navy">FAX 3</label>
                                            <div class="col-sm-4"><input type="text" name="fax3" class="form-control" value="'.$querySettings['FAX3'].'"  ></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Adress</label>
                                            <div class="col-sm-10"><input type="text" name="adress" class="form-control" value="'.$querySettings['ADRESS'].'" ></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Harita</label>
                                            <div class="col-sm-10"><textarea type="text" name="maps" id="editor1" class="form-control" placeholder="Harita embed kodunu buraya yapıştırın.">'.$querySettings['MAPS'].'</textarea></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" name="submitContactSettings" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
                                            </div>
                                        </div>
                                        
                                  </form>
                                        
                                </div>
                            </div>
                            
                            
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                
                                 <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="">       
                                        
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Facebook</label>
                                            <div class="col-sm-10"><input type="text" name="facebook" class="form-control" value="'.$querySettings['FACEBOOK'].'" placeholder="Facebook profil linkini buraya yapıştırın." ></div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Twitter</label>
                                            <div class="col-sm-10"><input type="text" name="twitter" class="form-control" value="'.$querySettings['TWITTER'].'" placeholder="Twitter profil linkini buraya yapıştırın." ></div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Youtube</label>
                                            <div class="col-sm-10"><input type="text" name="youtube" class="form-control" value="'.$querySettings['YOUTUBE'].'" placeholder="Youtube profil linkini buraya yapıştırın." ></div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">İnstagram</label>
                                            <div class="col-sm-10"><input type="text" name="instagram" class="form-control" value="'.$querySettings['INSTAGRAM'].'" placeholder="İnstagram profil linkini buraya yapıştırın." ></div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Google Plus</label>
                                            <div class="col-sm-10"><input type="text" name="google" class="form-control" value="'.$querySettings['GOOGLE'].'" placeholder="Google Plus profil linkini buraya yapıştırın." ></div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">LinkedIn</label>
                                            <div class="col-sm-10"><input type="text" name="linkedin" class="form-control" value="'.$querySettings['LINKEDIN'].'" placeholder="LinkedIn profil linkini buraya yapıştırın." ></div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Flickr</label>
                                            <div class="col-sm-10"><input type="text" name="flickr" class="form-control" value="'.$querySettings['FLICKR'].'" placeholder="Flickr profil linkini buraya yapıştırın." ></div>
                                        </div>
                                       
                                        <div class="hr-line-dashed"></div>
                                        
                                        
                                        
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" name="submitSocialSettings" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
                                            </div>
                                        </div>
                                        
                                  </form>
                                        
                                </div>
                            </div>
                            
                            
                        </div>


                    </div>
            
            
                
            </div>
        </div>
    </div>
</div>

</div>';
}