<?php
if (isset($_POST['submit'])){
    $title      = $_POST['title'];
    $content    = $_POST['content'];
    $slug       = $fonk->sef_link($title);

    $tags       = $_POST['tags'];
    $status     = $_POST['status'];
    $tagexplode = explode(",", $tags);

    $images     = $_FILES['images'];

    $message    = 'Bir resim ekledi! <i class="fa fa-arrow-right"></i> '.$title;

    $_SESSION['s_title']    = $title;
    $_SESSION['s_content']  = $content;
    $_SESSION['s_tags']     = $tags;

    $newImageName          = '';
    $newImageThumbnailName = '';

    try{

        if ($title !=NULL && $images !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT SLUG FROM ".TABLE_PREFIX."TBL_IMAGES WHERE SLUG=?",[$slug]);
            $db->Disconnect();
                if ($querySlug !=NULL){
                    echo sweetalert($langDB['LANG_FAILED_ADDED'],$langDB['LANG_REDIRECTING'],"warning","index.php?page=imageAdd","3000");
                    exit;
                }
        }else{
            echo sweetalert($langDB['LANG_FAILED_ADDED'],$langDB['LANG_REDIRECTING'],"error","index.php?page=imagesList","2000");
            exit;
        }
//========================================================================================================
        $db = new Database();
        $insertText = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGES SET TITLE=?, CONTENT=?, SLUG=?, ADDDATE=?, STATUS=?",[$title,$content,$slug,$date,$status]);
        $lastID = $db->lastInsertId();
        $db->Disconnect();
//========================================================================================================
    $files = array();
    foreach ($images as $k => $l) {
        foreach ($l as $i => $v) {
            if (!array_key_exists($i, $files))
                $files[$i] = array();
            $files[$i][$k] = $v;
        }
    }
//========================================================================================================
    foreach ($files as $file) {

        $handle = new Upload($file);

        if ($handle->uploaded) {
            $handle->allowed = array('image/*');
            $handle->file_new_name_body = substr(base64_encode(uniqid(true)), 0, 20);

            //$handle->image_watermark = '../image.png';
            //$handle->image_watermark_position = 'BR';

            //$yeniAd = $handle->file_dst_name;
            $handle->Process("../uploads/images/");
            $newImageName = $handle->file_dst_name;

            //Generate thumbnail
            $handle->allowed = array('image/*');
            $handle->image_resize = true;
            $handle->image_src_type;
            $handle->file_new_name_body = substr(base64_encode(uniqid(true)), 0, 20);

            $handle->image_ratio_crop = true;
            $handle->image_x = 220;
            $handle->image_ratio_y = true;

            //$handle->image_watermark = '../image.png';
            //$handle->image_watermark_position = 'BR';

            $handle->Process("../uploads/images/thumb/");
            $newImageThumbnailName = $handle->file_dst_name;

            if ($handle->processed) {
                $db = new Database();
                $insertImage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGE SET IMAGESID=?, IMAGE=?, THUMBNAIL=?",[$lastID,$newImageName,$newImageThumbnailName]);
                $db->Disconnect();
            } else {
                $db = new Database();
                $insertImageDelete = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGES WHERE ID=?",[$lastID]);
                $db->Disconnect();
                return sweetalert($langDB['LANG_FAILED_ADDED'].$handle->error,$langDB['LANG_REDIRECTING'],"error","index.php?page=imageAdd","3000");
                exit();
            }
        } else {
            return sweetalert($langDB['LANG_FAILED_ADDED'].$handle->error,$langDB['LANG_REDIRECTING'],"error","index.php?page=imageAdd","3000");
            exit();
        }
        unset($handle);
    }
//========================================================================================================

            $db = new Database();
                if($tags !=NULL){
                    $insertTags = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, IMAGESID=?, ADDDATE=?",[$tags,$slug,$lastID,$date]);
                }
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_title'],$_SESSION['s_content'],$_SESSION['s_tags']);

            echo sweetalert($langDB['LANG_ADDED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=imagesList","2000");
            exit;



    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
 echo'

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2 class="text-quay">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-quay"><a href="index.php">Yönetici Ana Sayfası</a></span> /
            <span class="label label-quay"><a href="index.php?page=imagesList">Resimler</a></span> /
            <span class="label label-quay">Resim Ekle</span>
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
                        <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="">

                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Resim Başlığı <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" id="title" placeholder="Örn: Benim resmin" value="'.@$_SESSION['s_title'].'" required></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Resim Ekle <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="file" name="images[]" multiple class="form-control" id="title" required></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Resim Açıklaması</label>
                                <div class="col-sm-10"><textarea class="ckeditor1" name="content" id="editor" rows="10" cols="80" >'.@$_SESSION['s_content'].'</textarea></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body">Etiket</label>
                                <div class="col-sm-10"><input type="text" name="tags" class="form-control" value="'.@$_SESSION['s_tags'].'" placeholder="Örn: Resimlerim, bilgi Not:Etiketleri , ile ayırınız."></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body"></label>
                                <div class="col-sm-10">
                                    <select class="btn-quay" name="status">
                                        <option value="Y">'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N">'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                    <small> (Bu kısmı değiştirmezseniz resim direkt yayına girer!) </small>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                                    <button class="btn btn-quay" name="submit" type="submit">'.$langDB['LANG_BTN_SAVE'].'</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>



';
}