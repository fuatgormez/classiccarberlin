<?php
if (isset($_POST['submit'])){
    $title   = $_POST['title'];
    $de      = $_POST['de'];
    $en      = $_POST['en'];
    $tr      = $_POST['tr'];

    $_SESSION['s_languageTitle']    = $title;
    $_SESSION['s_languageDE']       = $de;
    $_SESSION['s_languageEN']       = $en;
    $_SESSION['s_languageTR']       = $tr;



    try{
        if ($title !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT TITLE FROM ".TABLE_PREFIX."TBL_LANGUAGE WHERE TITLE=?",[$title]);

                if ($querySlug !=NULL){
                    return sweetalert($langDB['LANG_ERROR_NAME'],$langDB['LANG_REDIRECTING'],"warning","index.php?page=languageAdd","3000");
                    exit;
                }

            $insertLanguage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LANGUAGE SET TITLE=?, DE=?, EN=?, TR=?, DATE=?",[$title,$de,$en,$tr,$date]);
            $lastID = $db->lastInsertId();


            $message    = 'Kelime ekledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=languageEdit&ID='.$lastID.'">'.$title.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_languageTitle'],$_SESSION['s_languageDE'],$_SESSION['s_languageEN'],$_SESSION['s_languageTR']);

            return sweetalert($langDB['LANG_ADDED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=languagesList","2000");
            exit;
        }else{
            return sweetalert($langDB['LANG_FAILED_ADDED'],$langDB['LANG_REDIRECTING'],"error","index.php?page=languageAdd","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
 echo'

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2 class="text-quay">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-quay"><a href="index.php">'.$langDB['LANG_ADMIN_HOMEPAGE'].'</a></span> /
            <span class="label label-quay"><a href="index.php?page=languagesList">'.$langDB['LANG_LANGUAGES'].'</a></span> /
            <span class="label label-quay">'.$langDB['LANG_LANGUAGE_ADD'].'</span>
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

                            <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_KEYWORD'].' <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" placeholder="LANG_HOMEPAGE" value="'.@$_SESSION['s_languageTitle'].'" required></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_GERMAN'].'</label>
                                <div class="col-sm-10"><input type="text" name="de" class="form-control" placeholder="Startseite" value="'.@$_SESSION['s_languageDE'].'" ></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_ENGLISH'].'</label>
                                <div class="col-sm-10"><input type="text" name="en" class="form-control" placeholder="Homepage" value="'.@$_SESSION['s_languageEN'].'" ></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_TURKISH'].'</label>
                                <div class="col-sm-10"><input type="text" name="tr" class="form-control" placeholder="Örn: Anasayfa" value="'.@$_SESSION['s_languageTR'].'" ></div>
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