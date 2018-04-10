<?php

@$ID = intval($_GET['ID']);
if ($ID == NULL) {
    echo sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}
//========================================================================================================

if (isset($_POST['submit'])){
    $_POST      = multiDimensionalArrayMap('cleanEvilTags', $_POST);
    $_POST      = multiDimensionalArrayMap('cleanData', $_POST);

    $title      = $_POST['title'];
    $content    = $_POST['content'];
    $slug       = $fonk->sef_link($title);
    $link       = $_POST['link'];
    $tags       = $_POST['tags'];
    $status     = $_POST['status'];



    try{
        if ($title !=NULL && $link !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT ID,SLUG FROM ".TABLE_PREFIX."TBL_VIDEOS WHERE ID=?",[$ID]);

                if ($querySlug['ID'] != $ID){
                    echo sweetalert("Bu başlıkla daha önceden video oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","$callBackUrl","3000");
                    exit;
                }

            $updateVideo = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_VIDEOS SET TITLE=?, CONTENT=?, SLUG=?, LINK=?, UPDATEDATE=?, STATUS=? WHERE ID=?",[$title,$content,$slug,$link,$date,$status,$ID]);

            $queryTags = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_TAGS WHERE VIDEOSID=?",[$ID]);

            if ($tags == NULL){
                if ($queryTags !=NULL){
                    $deleteTags = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_TAGS WHERE VIDEOSID=?",[$ID]);
                }
            }else{
                if ($queryTags !=NULL){
                    $updateTags = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, UPDATEDATE=? WHERE VIDEOSID=?",[$tags,$slug,$date,$ID]);
                }else{
                    $insertTags = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, VIDEOSID=?, ADDDATE=?",[$tags,$slug,$ID,$date]);
                }
            }

            $message    = 'Video güncelledi! <i class="fa fa-arrow-right"></i><a href="index.php?page=videoEdit&ID='.$ID.'"> '.$title.'</a>';
            $insertLog   = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=videosList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","index.php?page=videoEdit&ID=$ID","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
        $db = new Database();
        $queryVideo = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_VIDEOS as videos LEFT JOIN ".TABLE_PREFIX."TBL_TAGS as tags ON videos.ID=tags.VIDEOSID WHERE videos.ID=?",[$ID]);
        $db->Disconnect();
 echo'
    
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2 class="text-warning">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-warning"><a href="index.php">'.$langDB['LANG_ADMIN_HOMEPAGE'].'</a></span> /
            <span class="label label-warning"><a href="index.php?page=videosList">'.$langDB['LANG_VIDEOS'].'</a></span> /
            <span class="label label-warning">'.$langDB['LANG_VIDEO_EDIT'].'</span>
        </div>
        <div class="col-lg-4">
            <h2>
                <a href="index.php?page=videoAdd" class="text-warning"><i class="fa fa-plus animated flip"></i> '.$langDB['LANG_BTN_ADD'].'</a> / 
                <a href="index.php?page=videoDelete&ID='.$ID.'" class="text-danger"><i class="fa fa-trash animated flip"></i> '.$langDB['LANG_BTN_DELETE'].'</a>
            </h2>
        </div>

    </div>

    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5 class="text-danger">(*) '.$langDB['LANG_ADMIN_REQUIRED'].'</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="POST" class="form-horizontal">

                            <div class="form-group"><label class="col-sm-2 control-label text-warning">Video Başlığı <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" required="required" placeholder="Örn: Benim videom" value="'.htmlspecialchars($queryVideo['TITLE']).'" /></div>
                            </div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-warning">Video Linki <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="link" class="form-control" required="required" placeholder="https://www.youtube.com/watch?v=xcbXVjnC-VM" value="'.htmlspecialchars($queryVideo['TITLE']).'" /></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-warning">Video İçeriği</label>
                                <div class="col-sm-10"><textarea class="ckeditor1" name="content" id="editor" rows="10" cols="80" required>'.htmlspecialchars_decode($queryVideo['CONTENT']).'</textarea></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-warning" data-container="body">Etiket</label>
                                <div class="col-sm-10"><input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput" value="'.htmlspecialchars($queryVideo['TAGS']).'" placeholder="video, bilgi"></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-warning" data-container="body"></label>
                                <div class="col-sm-10">
                                    <select class="btn-warning" name="status">
                                        <option value="Y" ';echo $queryVideo['STATUS'] == 'Y' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N" ';echo $queryVideo['STATUS'] == 'N' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                                    <button class="btn btn-warning" name="submit" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
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