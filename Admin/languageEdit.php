<?php

@$ID = intval($_GET['ID']);
if ($ID == NULL) {
    echo sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}

//========================================================================================================

if (isset($_POST['submit'])){
    $title   = $_POST['title'];
    $de      = $_POST['de'];
    $en      = $_POST['en'];
    $tr      = $_POST['tr'];



    try{
        if ($title !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT ID,TITLE FROM ".TABLE_PREFIX."TBL_LANGUAGE WHERE ID=?",[$ID]);

            if ($querySlug['ID'] !=$ID){
                echo sweetalert("Bu isimle daha önceden dil oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","index.php?page=languagesList","3000");
                exit;
            }

            $updateLanguage = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_LANGUAGE SET TITLE=?, de=?, en=?, tr=?, DATE=? WHERE ID=?",[$title,$de,$en,$tr,$date,$ID]);
            //$lastID = $db->lastInsertId();


            $message    = 'Kelime ekledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=languageEdit&ID='.$ID.'">'.$title.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();



            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=languagesList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","index.php?page=languageAdd","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
    $db = new Database();
    $queryLanguage = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_LANGUAGE WHERE ID=?",[$ID]);
    $db->Disconnect();
    echo'

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2 class="text-quay">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-quay"><a href="index.php">Yönetici Ana Sayfası</a></span> /
            <span class="label label-quay"><a href="index.php?page=languagesList">Diller</a></span> /
            <span class="label label-quay">Sprachen aktualisieren</span>
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

                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Kelime <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" placeholder="Örn: Anasayfa" value="'.$queryLanguage['TITLE'].'" required></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Deutsch</label>
                                <div class="col-sm-10"><input type="text" name="de" class="form-control" placeholder="Örn: Startseite" value="'.$queryLanguage['de'].'" ></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Englisch</label>
                                <div class="col-sm-10"><input type="text" name="en" class="form-control" placeholder="Örn: Homepage" value="'.$queryLanguage['en'].'" ></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Türkçe</label>
                                <div class="col-sm-10"><input type="text" name="tr" class="form-control" placeholder="Örn: Anasayfa" value="'.$queryLanguage['tr'].'" ></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            

                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="index.php" class="btn btn-white">'.$langDB['LANG_BTN_CANCEL'].'</a>
                                    <button class="btn btn-quay" name="submit" type="submit">'.$langDB['LANG_BTN_UPDATE'].'</button>
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