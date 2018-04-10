<?php
if (isset($_POST['submit'])){
    $title      = $_POST['title'];
    $content    = $_POST['content'];
    $slug       = $fonk->sef_link($title);
    $tags       = $_POST['tags'];
    $status     = $_POST['status'];
    $tagexplode = explode(",", $tags);



    $_SESSION['s_title']    = $title;
    $_SESSION['s_content']  = $content;
    $_SESSION['s_tags']     = $tags;

    try{
        if ($title !=NULL && $content !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT SLUG FROM ".TABLE_PREFIX."TBL_NEWS WHERE SLUG=?",[$slug]);

                if ($querySlug !=NULL){
                    echo sweetalert("Bu başlıkla daha önceden haber oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","index.php?page=newsAdd","3000");
                    exit;
                }

            $insertPage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_NEWS SET TITLE=?, CONTENT=?, SLUG=?, ADDDATE=?, STATUS=?",[$title,$content,$slug,$date,$status]);
            $lastID = $db->lastInsertId();

            if ($tags !=NULL){
                $insertTags = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_TAGS SET TAGS=?, SLUG=?, NEWSID=?, ADDDATE=?",[$tags,$slug,$lastID,$date]);
            }

            $message    = 'Haber ekledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=newsEdit&ID='.$lastID.'">'.$title.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_title'],$_SESSION['s_content'],$_SESSION['s_tags']);

            echo sweetalert($langDB['LANG_ADDED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=newsList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_ADDED'],$langDB['LANG_REDIRECTING'],"error","index.php?page=newsAdd","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
 echo'

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2 class="text-danger">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-danger"><a href="index.php">Yönetici Ana Sayfası</a></span> /
            <span class="label label-danger"><a href="index.php?page=newsList">Haberler</a></span> /
            <span class="label label-danger">Haber Ekle</span>
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
                        <form method="POST" class="form-horizontal" action="">

                            <div class="form-group"><label class="col-sm-2 control-label text-danger">Haber Başlığı <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" id="title" placeholder="Örn: Bizden haberler" value="'.@$_SESSION['s_title'].'" required></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-danger">Haber İçeriği <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><textarea class="ckeditor1" name="content" id="editor" rows="10" cols="80" required>'.@$_SESSION['s_content'].'</textarea></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-danger" data-container="body">Etiket</label>
                                <div class="col-sm-10"><input type="text" name="tags" class="form-control" value="'.@$_SESSION['s_tags'].'" placeholder="Örn: bizden haberler, bilgi Not:Etiketleri , ile ayırınız."></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-success" data-container="body"></label>
                                <div class="col-sm-10">
                                    <select class="btn-danger" name="status">
                                        <option value="Y">'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N">'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                    <small> (Bu kısmı değiştirmezseniz haber direkt yayına girer!) </small>
                                </div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                                    <button class="btn btn-danger" name="submit" type="submit">'.$langDB['LANG_BTN_SAVE'].'</button>
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