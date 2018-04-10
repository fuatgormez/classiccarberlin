<?php
@$ID = intval($_GET['ID']);
if ($ID == NULL) {
    echo sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}elseif ($ID == 1 && $loginUserID != 1){
    echo sweetalert("Bu kullanıcıyı düzenleme yetkiniz bulunmuyor!","Yönlendiriliyorsunuz..","warning","index.php","2000");
    exit;
}
//========================================================================================================
if (isset($_POST['submitPassword'])){
    $password       = $_POST['password'];
    $repassword     = $_POST['repassword'];


    try{
        if ($password !=NULL){

            if ($password != $repassword){
                return sweetalert("Şifreler uyuşmuyor","Yönlendiriliyorsunuz...","warning","index.php?page=userEdit&ID=$ID","3000");
                exit;
            } elseif (!$fonk->passwordControl($password)){
                return sweetalert("Parolanız sadece harflerden ve rakamlardan olusabilir", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userEdit&ID=$ID", "3000");
                exit;
            }

            $db = new Database();
            $updatePassword = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_USERS SET PASSWORD=? WHERE ID=?",[sha1($password),$ID]);
            $db->Disconnect();



            echo sweetalert("Şifre güncellendi","","success","index.php?page=usersList","2000");
            exit;
        }else{
            echo sweetalert("Şifre Güncellenemedi!","","error","index.php?page=userEdit&ID=$ID","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }

}


if (isset($_POST['submitImage'])){
    $images         = $_FILES['images'];

    $newImageName   = '';

    try{

        $db = new Database();
        $userImage = $db->getRow("SELECT images.ID,images.USERID,image.IMAGE,image.IMAGESID FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON images.ID=image.IMAGESID WHERE images.USERID=? ",[$ID]);

        if ($userImage !=NULL){
            @unlink('../uploads/images/users/'.$userImage['IMAGE']);

            $userImages = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGES WHERE USERID=?",[$ID]);
        }


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


                $handle->Process("../uploads/images/users/");
                $newImageName = $handle->file_dst_name;


                if ($handle->processed) {

                    $insertImages = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGES SET USERID=?, ADDDATE=?",[$ID,$date]);
                    $imagesLastID = $db->lastInsertId();

                    $insertImage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGE SET IMAGE=?, IMAGESID=?",[$newImageName,$imagesLastID]);

                    return sweetalert("Resim Eklendi","Yönlendiriliyorsunuz..","success","index.php?page=userEdit&ID=$ID","1000");
                    exit;

                } else {
                    $handle = false;
                    return sweetalert("Bir sorun oluştu $handle->error","Yönlendiriliyorsunuz...","error","index.php?page=imageAdd","3000");
                    exit();
                }

            } else {
                return sweetalert("Bir sorun oluştu $handle->error","Yönlendiriliyorsunuz...","error","index.php?page=userEdit&ID=$ID","3000");
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
if (isset($_POST['submit'])){
    $namesurname    = $_POST['namesurname'];
    $reusername     = $fonk->trLower($_POST['username']);
    $about          = $_POST['about'];

    $email          = $_POST['email'];
    $status         = $_POST['status'];
    $rank           = intval($_POST['rank']);

    $updateDate 	= date("Y-m-d H:i:s");
    $slug           = $reusername;
    $IP             = $_SERVER['REMOTE_ADDR'];

    $_SESSION['s_namesurname'] = $namesurname;
    $_SESSION['s_username']    = $reusername;
    $_SESSION['s_email']       = $email;
    $_SESSION['s_about']       = $about;

    try{
        if ($reusername !=NULL && $email !=NULL){

            if (!$fonk->charactersControl($namesurname)){
                return sweetalert("Adınızda özel karakter ve rakam kullanmayınız! Türkçe karakter kullanabilirsiniz", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userEdit&ID=$ID", "4000");
                exit;
            } elseif (!$fonk->usernameControl($reusername)){
                return sweetalert("Kullanıcı adınızda boşluk, özel karakter ve rakam kullanmayınız! Türkçe karakter kullanabilirsiniz", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userEdit&ID=$ID", "4000");
                exit;
            } elseif (!$fonk->emailControl($email)) {
                return sweetalert("Geçersiz eposta! Bilgilerinizi gözden geçirin", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userEdit&ID=$ID", "3000");
                exit;
            }

            $db = new Database();
            $queryUser = $db->getRow("SELECT ID,USERNAME,EMAIL FROM ".TABLE_PREFIX."TBL_USERS WHERE USERNAME=? OR EMAIL=?",[$reusername,$email]);

            if ($queryUser !=NULL && $queryUser['ID'] !=$ID ){
                return sweetalert("Bu kullanıcı adı ya da email kullanılıyor! Lütfen başka bir kullanıcı adı ya da email giriniz.","Yönlendiriliyorsunuz...","warning","index.php?page=userEdit&ID=$ID","4000");
                exit;
            }

            $update = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_USERS SET USERNAME=?, NAMESURNAME=?, EMAIL=?, ABOUT=?, SLUG=?, RANK=?, UPDATEDATE=?, STATUS=? WHERE ID=?",[$reusername,$namesurname,$email,$about,$fonk->sef_link($slug),$rank,$updateDate,$status,$ID]);

            $message    = 'Üye bilgilerini güncelledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=userEdit&ID='.$ID.'">'.$reusername.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_namesurname'],$_SESSION['s_username'],$_SESSION['s_email'],$_SESSION['s_about']);

            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=usersList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","index.php?page=usersList","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else {

    $db = new Database();
    $queryUser = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_USERS WHERE ID=?",[$ID]);
    $userImage = $db->getRow("SELECT images.ID,images.USERID,image.IMAGE,image.IMAGESID FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON images.ID=image.IMAGESID WHERE images.USERID=? ",[$ID]);
    $db->Disconnect();

    echo '

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2 class="text-navy">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
        <span class="label label-primary"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-primary"><a href="index.php?page=usersList">Üyeler</a></span> /
        <span class="label label-primary">Üye Düzenle</span>
    </div>
    <div class="col-lg-4">
            <h2>
                <a href="index.php?page=userAdd" class="text-navy"><i class="fa fa-plus animated flip"></i> Üye Ekle</a> / 
                <a href="index.php?page=userDelete&ID='.$ID.'" class="text-danger"><i class="fa fa-trash animated flip"></i> Üyeyi Sil</a>
            </h2>
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
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Üye İşlemleri</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">Şifre İşlemleri</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3">Üye Resmi</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="POST" class="form-horizontal" action="">
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Ad Soyad</label>
                    
                                            <div class="col-sm-10"><input type="text" name="namesurname" class="form-control" value="'.$queryUser['NAMESURNAME'].'" placeholder="Örn: Mahmut Tuncer"></div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Kullanıcı Adı <small class="text-danger">*</small></label>
                                            <div class="col-sm-10"><input type="text" name="username" class="form-control" value="'.$queryUser['USERNAME'].'" placeholder="Örn: morfi" required></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Eposta <small class="text-danger">*</small></label>
                                            <div class="col-sm-10"><input type="email" class="form-control" name="email" value="'.$queryUser['EMAIL'].'" placeholder="Örn: morfi@morfi.com" required></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                    
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Üye Rütbesi <small class="text-danger">*</small></label>
                                            <div class="col-sm-2">
                                                <select class="form-control" name="rank" required>
                                                            <option value="6" ';echo $queryUser['RANK'] == 6 ? 'selected' : null; echo'>Normal Üye</option>
                                                            <option value="5" ';echo $queryUser['RANK'] == 5 ? 'selected' : null; echo'>Gümüş Üye</option>
                                                            <option value="4" ';echo $queryUser['RANK'] == 4 ? 'selected' : null; echo'>Bronz Üye</option>
                                                            <option value="3" ';echo $queryUser['RANK'] == 3 ? 'selected' : null; echo'>Altın Üye</option>
                                                            <option value="2" ';echo $queryUser['RANK'] == 2 ? 'selected' : null; echo'>Yönetici</option>
                                                            <option value="1" ';echo $queryUser['RANK'] == 1 ? 'selected' : null; echo'>Genel Yönetici</option>
                                                        </select>
                                                        
                                            </div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label"></label>
                                            <div class="col-sm-10">
                                                <select class="btn-primary" name="status">
                                                            <option value="Y" ';echo $queryUser['STATUS'] == 'Y' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                                            <option value="N" ';echo $queryUser['STATUS'] == 'N' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                                        </select>
                                                        
                                            </div>
                                        </div>
                    
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Üye Hakkında</label>
                                            <div class="col-sm-10"><textarea class="ckeditor1" name="about" id="editor" rows="10" cols="80" >'; echo $queryUser['ABOUT'] !=NULL ? htmlspecialchars_decode($queryUser['ABOUT']) : @$_SESSION['s_about']; echo'</textarea></div>
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
                                
                                 <form method="POST" class="form-horizontal" action="">       
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Yeni Şifre <small class="text-danger">*</small></label>
                                            <div class="col-sm-10"><input type="password" class="form-control" name="password" value="'.@$_SESSION['s_password'].'" pattern=".{0}|.{5,20}" required title="(Şifre uzunluğu 5 ila 20 arasında olmalıdır!)"></div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label text-navy">Yeni Şifre Tekrar <small class="text-danger">*</small></label>
                                            <div class="col-sm-10"><input type="password" class="form-control" name="repassword" value="'.@$_SESSION['s_repassword'].'" pattern=".{0}|.{5,20}" required title="(Şifre uzunluğu 5 ila 20 arasında olmalıdır!)"></div>
                                        </div>
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" name="submitPassword" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
                                            </div>
                                        </div>
                                        
                                  </form>
                                        
                                </div>
                            </div>
                            
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                
                                 <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="">       
                                        <div class="form-group"><label class="col-sm-4 control-label text-navy">
                                        <img width="100px" src="../uploads/images/users/'; echo $userImage['IMAGE'] != NULL ? $userImage['IMAGE'] :'man-avatar.png'; echo'"></label>
                                        
                                            <div class="col-sm-8"><p class="text-navy">Üye için bir resim yükleyiniz!</p></div>
                                            <div class="col-sm-8"><input type="file" name="images" class="form-control" ></div>
                                        </div>
                                        
                                        
                                        <div class="hr-line-dashed"></div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-4">
                                                <button class="btn btn-primary" name="submitImage" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
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