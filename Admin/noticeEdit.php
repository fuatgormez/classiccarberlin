<?php

@$ID = intval($_GET['ID']);
if ($ID == NULL) {
    echo sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}
//========================================================================================================

if (isset($_POST['submit'])){

    $title      = $_POST['title'];
    $content    = $_POST['content'];
    $slug       = $fonk->sef_link($title);
    $tags       = $_POST['tags'];
    $status     = $_POST['status'];


    try{
        if ($title !=NULL && $content !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT ID,SLUG FROM ".TABLE_PREFIX."TBL_NOTICES WHERE ID=?",[$ID]);

                if ($querySlug['ID'] != $ID){
                    echo sweetalert("Bu başlıkla daha önceden duyuru oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","index.php?page=noticeEdit&ID=$ID","3000");
                    exit;
                }

            $updatePage = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_NOTICES SET TITLE=?, CONTENT=?, SLUG=?, UPDATEDATE=?, STATUS=? WHERE ID=?",[$title,$content,$slug,$date,$status,$ID]);

            $queryTags = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_TAGS WHERE NOTICESID=?",[$ID]);

            if ($tags == NULL){
                if ($queryTags !=NULL){
                    $deleteTags = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_TAGS WHERE NOTICESID=?",[$ID]);
                }
            }else{
                if ($queryTags !=NULL){
                    $updateTags = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, UPDATEDATE=? WHERE NOTICESID=?",[$tags,$slug,$date,$ID]);
                }else{
                    $insertTags = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, NOTICESID=?, ADDDATE=?",[$tags,$slug,$ID,$date]);
                }
            }


            $message    = 'Duyuru güncelledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=noticeEdit&ID='.$ID.'">'.$title.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserserIP,$date]);
            $db->Disconnect();

            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=noticesList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","'.index.php?page=noticeEdit&ID=$ID.'","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
        $db = new Database();
        $queryNotice = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_NOTICES as notices LEFT JOIN ".TABLE_PREFIX."TBL_TAGS as tags ON notices.ID=tags.NOTICESID WHERE notices.ID=?",[$ID]);
        $db->Disconnect();
 echo'
    
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2 class="text-info">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-info"><a href="index.php">Yönetici Ana Sayfası</a></span> /
            <span class="label label-info"><a href="index.php?page=noticesList">Duyurular</a></span> /
            <span class="label label-info">Duyuru Düzenle</span>
        </div>
        <div class="col-lg-4">
            <h2>
                <a href="index.php?page=noticeAdd" class="text-info"><i class="fa fa-plus animated flip"></i> Duyuru Ekle</a>
                <a href="index.php?page=noticeDelete&ID='.$ID.'" class="text-danger"><i class="fa fa-trash animated flip"></i> Duyuruyu Sil</a>
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

                            <div class="form-group"><label class="col-sm-2 control-label text-info">Duyuru Başlığı <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" required="required" placeholder="Örn: Hakkımda" value="'.htmlspecialchars($queryNotice['TITLE']).'" /></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-info">Duyuru İçeriği <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><textarea class="ckeditor1" name="content" id="editor" rows="10" cols="80" required>'.htmlspecialchars_decode($queryNotice['CONTENT']).'</textarea></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-info" data-container="body">Etiket</label>
                                <div class="col-sm-10"><input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput" value="'.htmlspecialchars($queryNotice['TAGS']).'" placeholder="Duyurular, bilgi"></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-info" data-container="body"></label>
                                <div class="col-sm-10">
                                    <select class="btn-info" name="status">
                                        <option value="Y" ';echo $queryNotice['STATUS'] == 'Y' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N" ';echo $queryNotice['STATUS'] == 'N' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                                    <button class="btn btn-info" name="submit" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
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