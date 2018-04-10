<?php
if (isset($_POST['submit'])){
    $menuName   = $_POST['menuName'];
    $menuLink   = $_POST['menuLink'];
    $menuList   = $_POST['menuList'];
    $status     = $_POST['status'];

    $_SESSION['s_menuName']    = $menuName;
    $_SESSION['s_menuLink']    = $menuLink;
    $_SESSION['s_menuList']    = $menuList;


    try{
        if ($menuName !=NULL && $menuLink !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT MENUNAME FROM ".TABLE_PREFIX."TBL_MENUS WHERE MENUNAME=?",[$menuName]);

                if ($querySlug !=NULL){
                    echo sweetalert("Bu isimle daha önceden menü oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","index.php?page=menuAdd","3000");
                    exit;
                }

            $insertPage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_MENUS SET MENUNAME=?, LINK=?, LIST=?, ADDDATE=?, STATUS=?",[$menuName,$menuLink,$menuList,$date,$status]);
            $lastID = $db->lastInsertId();


            $message    = 'Menü ekledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=menuEdit&ID='.$lastID.'">'.$menuName.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_menuName'],$_SESSION['s_menuLink'],$_SESSION['s_menuList']);

            echo sweetalert($langDB['LANG_ADDED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=menusList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_ADDED'],$langDB['LANG_REDIRECTING'],"error","index.php?page=menuAdd","2000");
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
            <span class="label label-quay"><a href="index.php">Yönetici Ana Sayfası</a></span> /
            <span class="label label-quay"><a href="index.php?page=menusList">Menüler</a></span> /
            <span class="label label-quay">Menü Ekle</span>
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

                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Menü İsmi <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="menuName" class="form-control" placeholder="Örn: Anasayfa" value="'.@$_SESSION['s_menuName'].'" required></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body">Menü Linki</label>
                                <div class="col-sm-10"><input type="text" name="menuLink" class="form-control" value="'.@$_SESSION['s_menuLink'].'" placeholder="index.php"></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body">Menü Sıra</label>
                                <div class="col-sm-10"><input type="text" name="menuList" class="form-control" value="'.@$_SESSION['s_menuList'].'" placeholder="1"></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body"></label>
                                <div class="col-sm-10">
                                    <select class="btn-quay" name="status">
                                        <option value="Y">'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N">'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                    
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