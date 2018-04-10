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


    $_SESSION['s_title']    = $title;
    $_SESSION['s_content']  = $content;
    $_SESSION['s_tags']     = $tags;


    try{
        if ($title !=NULL && $content !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT ID,SLUG FROM ".TABLE_PREFIX."TBL_PAGES WHERE ID=?",[$ID]);

                if ($querySlug['ID'] != $ID){
                    echo sweetalert("Bu başlıkla daha önceden sayfa oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","index.php?page=pageEdit&ID=$ID","3000");
                    exit;
                }

            $updatePage = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_PAGES SET TITLE=?, CONTENT=?, SLUG=?, UPDATEDATE=?, STATUS=? WHERE ID=?",[$title,$content,$slug,$date,$status,$ID]);


            $queryTags = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_TAGS WHERE PAGESID=?",[$ID]);

            if ($tags == NULL){
                if ($queryTags !=NULL){
                    $deleteTags = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_TAGS WHERE PAGESID=?",[$ID]);
                }
            }else{
                if ($queryTags !=NULL){
                    $updateTags = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, UPDATEDATE=? WHERE PAGESID=?",[$tags,$slug,$date,$ID]);
                }else{
                    $insertTags = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, PAGESID=?, ADDDATE=?",[$tags,$slug,$ID,$date]);
                }
            }

            $message    = 'Sayfa güncelledi! <i class="fa fa-arrow-right"></i><a href="index.php?page=pageEdit&ID='.$ID.'">'.$title.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_title'],$_SESSION['s_content'],$_SESSION['s_tags']);

            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=pagesList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATED'],$langDB['LANG_REDIRECTING'],"error","'.index.php?page=pageEdit&ID=$ID.'","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
        $db = new Database();
        $queryPage = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_PAGES as pages LEFT JOIN ".TABLE_PREFIX."TBL_TAGS as tags ON pages.ID=tags.PAGESID WHERE pages.ID=?",[$ID]);
        $db->Disconnect();
 echo'
    
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2 class="text-success">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-success"><a href="index.php">Yönetici Ana Sayfası</a></span> /
            <span class="label label-success"><a href="index.php?page=pagesList">Sayfalar</a></span> /
            <span class="label label-success">Sayfa Düzenle</span>
        </div>
        <div class="col-lg-4">
            <h2>
                <a href="index.php?page=pageAdd" class="text-success"><i class="fa fa-plus animated flip"></i> Sayfa Ekle</a>
                <a href="index.php?page=pageDelete&ID='.$ID.'" class="text-danger"><i class="fa fa-trash animated flip"></i> Sayfayı Sil</a>
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

                            <div class="form-group"><label class="col-sm-2 control-label text-success">Sayfa Başlığı <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" required="required" placeholder="Örn: Hakkımda" value="'.htmlspecialchars($queryPage['TITLE']).'" /></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-success">Sayfa İçeriği <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><textarea class="ckeditor1" name="content" id="editor" rows="10" cols="80" required>'.htmlspecialchars_decode($queryPage['CONTENT']).'</textarea></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-success" data-container="body">Etiket</label>
                                <div class="col-sm-10"><input type="text" id="tags" name="tags" class="form-control" data-role="tagsinput" value="'.htmlspecialchars($queryPage['TAGS']).'" placeholder="sayfa, hakkımda, bilgi"></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-success" data-container="body"></label>
                                <div class="col-sm-10">
                                    <select class="btn-success" name="status">
                                        <option value="Y" ';echo $queryPage['STATUS'] == 'Y' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N" ';echo $queryPage['STATUS'] == 'N' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>


                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                                    <button class="btn btn-success" name="submit" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
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