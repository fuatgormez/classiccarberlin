<?php

@$ID = intval($_GET['ID']);
if ($ID == NULL) {
    echo sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}
//========================================================================================================

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

            $queryMenuName = $db->getRow("SELECT ID,MENUNAME FROM ".TABLE_PREFIX."TBL_MENUS WHERE ID=?",[$ID]);

                if ($queryMenuName['ID'] != $ID){
                    echo sweetalert("Bu isimle daha önceden menü oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","index.php?page=menuEdit&ID=$ID","3000");
                    exit;
                }

            $updateMenu = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_MENUS SET MENUNAME=?, LINK=?, LIST=?, UPDATEDATE=?, STATUS=? WHERE ID=?",[$menuName,$menuLink,$menuList,$date,$status,$ID]);


            $message    = 'Menü güncelledi! <i class="fa fa-arrow-right"></i><a href="index.php?page=menuEdit&ID='.$ID.'">'.$menuName.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_menuName'],$_SESSION['s_menuLink'],$_SESSION['s_menuList']);

            return sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=menusList","2000");
            exit;
        }else{
            return sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","index.php?page=menuEdit&ID=$ID","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
        $db = new Database();
        $queryMenu = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_MENUS WHERE ID=?",[$ID]);
        $db->Disconnect();
 echo'
    
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8">
            <h2 class="text-quay">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-quay"><a href="index.php">Yönetici Ana Sayfası</a></span> /
            <span class="label label-quay"><a href="index.php?page=menusList">Menüler</a></span> /
            <span class="label label-quay">Menü Düzenle</span>
        </div>
        <div class="col-lg-4">
            <h2>
                <a href="index.php?page=menuAdd" class="text-quay"><i class="fa fa-plus animated flip"></i> Menü Ekle</a>
                <a href="index.php?page=menuDelete&ID='.$ID.'" class="text-danger"><i class="fa fa-trash animated flip"></i> Menüyü Sil</a>
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

                            <div class="form-group"><label class="col-sm-2 control-label text-quay">Menü İsmi <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="menuName" class="form-control" required="required" placeholder="Örn: Anasayfa" value="'.htmlspecialchars($queryMenu['MENUNAME']).'" /></div>
                            </div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body">Meni Linki</label>
                                <div class="col-sm-10"><input type="text" name="menuLink" class="form-control" data-role="tagsinput" value="'.htmlspecialchars($queryMenu['LINK']).'" placeholder="index.php"></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>

                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body">Meni Sıra</label>
                                <div class="col-sm-10"><input type="text" name="menuList" class="form-control" data-role="tagsinput" value="'.htmlspecialchars($queryMenu['LIST']).'" placeholder="index.php"></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay" data-container="body"></label>
                                <div class="col-sm-10">
                                    <select class="btn-quay" name="status">
                                        <option value="Y" ';echo $queryMenu['STATUS'] == 'Y' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                        <option value="N" ';echo $queryMenu['STATUS'] == 'N' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_PASSIVE'].'</option>
                                    </select>
                                </div>
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