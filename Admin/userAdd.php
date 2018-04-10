<?php
if (isset($_POST['submit'])){
    $namesurname    = $_POST['namesurname'];
    $reusername     = $fonk->trLower($_POST['username']);
    $password       = $_POST['password'];
    $repassword     = $_POST['repassword'];
    $email          = $_POST['email'];
    $status         = $_POST['status'];
    $rank           = intval($_POST['rank']);

    $images         = $_FILES['images'];

    $slug           = $reusername;



    $_SESSION['s_namesurname'] = $namesurname;
    $_SESSION['s_username']    = $reusername;
    $_SESSION['s_password']    = $password;
    $_SESSION['s_repassword']  = $repassword;
    $_SESSION['s_email']       = $email;

    $newImageName   = '';

    try{
        if ($reusername !=NULL && $password !=NULL && $email !=NULL){

            if ($password != $repassword){
                return sweetalert("Şifreler uyuşmuyor","Yönlendiriliyorsunuz...","warning","index.php?page=userAdd","3000");
                exit;
            } elseif (!$fonk->charactersControl($namesurname)){
                return sweetalert("Adınızda özel karakter ve rakam kullanmayınız türkçe karakter kullanabilirsiniz", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userAdd", "4000");
                exit;
            } elseif (!$fonk->usernameControl($reusername)){
                return sweetalert("Kullanıcı adınızda boşluk, özel karakter ve rakam kullanmayınız türkçe karakter kullanabilirsiniz", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userAdd", "4000");
                exit;
            } elseif (!$fonk->emailControl($email)) {
                return sweetalert("Geçersiz eposta! Bilgilerinizi gözden geçirin", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userAdd", "3000");
                exit;
            } elseif (!$fonk->passwordControl($password)){
                return sweetalert("Parolanız sadece harflerden ve rakamlardan olusabilir", "Yönlendiriliyorsunuz...", "warning", "index.php?page=userAdd", "3000");
                exit;
            }

            $db = new Database();
            $queryUser = $db->getRow("SELECT USERNAME,EMAIL FROM ".TABLE_PREFIX."TBL_USERS WHERE USERNAME=? OR EMAIL=?",[$reusername,$email]);

            if ($queryUser !=NULL){
                return sweetalert("Bu kullanıcı adı ya da email kullanılıyor! Lütfen başka bir kullanıcı adı ya da email giriniz.","Yönlendiriliyorsunuz...","warning","index.php?page=userAdd","4000");
                exit;
            }



            $insertUser = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_USERS SET USERNAME=?, NAMESURNAME=?, EMAIL=?, PASSWORD=?, SLUG=?, RANK=?, ADDDATE=?, STATUS=?",[$reusername,$namesurname,$email,sha1($password),$fonk->sef_link($slug),$rank,$date,$status]);
            $userLastID = $db->lastInsertId();

//========================================================================================================

            if($images['tmp_name'] !=NULL){
                $handle = new Upload($images);

                if ($handle->uploaded !=NULL) {

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

                        $insertImages = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGES SET USERID=?, ADDDATE=?",[$userLastID,$date]);
                        $imagesLastID = $db->lastInsertId();

                        $insertImage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGE SET IMAGE=?, IMAGESID=?",[$newImageName,$imagesLastID]);

                    } else {
                        $handle = false;
                        return sweetalert("Bir sorun oluştu $handle->error","Yönlendiriliyorsunuz...","error","index.php?page=imageAdd","3000");
                        exit();
                    }

                } else {
                    return sweetalert("Bir sorun oluştu $handle->error","Yönlendiriliyorsunuz...","error","index.php?page=userAdd","3000");
                    exit();
                }
                unset($handle);
            }

//========================================================================================================


            $message    = 'Üye ekledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=userEdit&ID='.$userLastID.'"> '.$reusername.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_namesurname'],$_SESSION['s_username'],$_SESSION['s_password'],$_SESSION['s_repassword'],$_SESSION['s_email']);

            echo sweetalert($langDB['LANG_ADDED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=usersList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_ADDED'],$langDB['LANG_REDIRECTING'],"error","index.php?page=userAdd","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else {
    echo '

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-navy">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
        <span class="label label-primary"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-primary"><a href="index.php?page=usersList">Üyeler</a></span> /
        <span class="label label-primary">Üye Ekle</span>
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
                <form method="POST" class="form-horizontal" action="" enctype="multipart/form-data">
                    <div class="form-group"><label class="col-sm-2 control-label text-navy">Ad Soyad</label>

                        <div class="col-sm-10"><input type="text" name="namesurname" class="form-control" value="'.@$_SESSION['s_namesurname'].'" placeholder="Örn: Mahmut Tuncer"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label text-navy">Kullanıcı Adı <small class="text-danger">*</small></label>

                        <div class="col-sm-10"><input type="text" name="username" class="form-control" value="'.@$_SESSION['s_username'].'" placeholder="Örn: morfi" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label text-navy">Şifre <small class="text-danger">*</small></label>

                        <div class="col-sm-10"><input type="password" class="form-control" name="password" value="'.@$_SESSION['s_password'].'" pattern=".{0}|.{5,10}" required title="(Şifre uzunluğu 5 ila 20 arasında olmalıdır!)"></div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label text-navy">Şifre Tekrar <small class="text-danger">*</small></label>

                        <div class="col-sm-10"><input type="password" class="form-control" name="repassword" value="'.@$_SESSION['s_repassword'].'" pattern=".{0}|.{5,10}" required title="(Şifre uzunluğu 5 ila 20 arasında olmalıdır!)"></div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label text-navy">Eposta <small class="text-danger">*</small></label>

                        <div class="col-sm-10"><input type="email" class="form-control" name="email" value="'.@$_SESSION['s_email'].'" placeholder="Örn: morfi@morfi.com" required></div>
                    </div>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group"><label class="col-sm-2 control-label text-navy">Üye Rütbesi <small class="text-danger">*</small></label>
                        <div class="col-sm-2">
                            <select class="form-control" name="rank" required>
                                        <option value="6">Normal Üye</option>
                                        <option value="5">Gümüş Üye</option>
                                        <option value="4">Bronz Üye</option>
                                        <option value="3">Altın Üye</option>
                                        <option value="2">Yönetici</option>
                                        <option value="1">Genel Yönetici</option>
                                    </select>
                                    
                        </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-navy">Üye Resmi Ekle</label>
                                <div class="col-sm-10"><input type="file" name="images" class="form-control"></div>
                            </div>

                            
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <select class="btn-primary" name="status">
                                        <option value="Y">'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N">'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                    
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                            <button class="btn btn-primary" name="submit" type="submit">'.$langDB['LANG_BTN_SAVE'].'</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>';
}