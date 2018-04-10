<?php
@$ID = intval($_GET['ID']);
if ($ID == NULL)
{
    return sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}
if (isset($_POST['submit'])){
    $categoryName   = $_POST['title'];
    $parentId       = $_POST['parentId'];
    $description    = $_POST['description'];
    $status         = $_POST['status'];
    $slug           = $fonk->sef_link($categoryName);

    $_SESSION['s_catName']    = $categoryName;

    try{
        if ($categoryName !=NULL){
            $db = new Database();
            $querySlug = $db->getRow("SELECT ID,SLUG FROM ".TABLE_PREFIX."TBL_CATEGORIES WHERE ID=?",[$ID]);

                if ($querySlug['ID'] !=$ID){
                    echo sweetalert("Bu isimle daha önceden category oluşturulmuş lütfen bilgilerinizi kontrol ediniz!","Yönlendiriliyorsunuz...","warning","index.php?page=categoriesList","3000");
                    exit;
                }

            $update = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_CATEGORIES SET TITLE=?,DESCRIPTION=?,SLUG=?,PARENTID=?, UPDATEDATE=?, STATUS=? WHERE ID=?",[$categoryName,$description,$slug,$parentId,$date,$status,$ID]);

            $message    = 'Kategori güncelledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=categoryEdit&ID='.$ID.'">'.$categoryName.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_catName']);
            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=categoriesList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","index.php?page=categoryAdd","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else{
        $db = new Database();
        $query = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_CATEGORIES WHERE ID=?",[$ID]);
        if ($query == NULL)
        {
            return sweetalert($langDB['LANG_NO_RESULT'],$langDB['LANG_REDIRECTING'],"warning","index.php?page=categoriesList","2000");
            exit;
        }
        $db->Disconnect();
    echo'

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-9">
            <h2 class="text-quay">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
            <span class="label label-quay"><a href="index.php">'.$langDB['LANG_ADMIN_HOMEPAGE'].'</a></span> /
            <span class="label label-quay"><a href="index.php?page=categoriesList">'.$langDB['LANG_CATEGORIES'].'</a></span> /
            <span class="label label-quay">'.$langDB['LANG_ADMIN_MENU_CATEGORY_ADD'].'</span>
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

                            <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_MAIN_CATEGORY'].'<small class="text-danger">*</small></label>
                            <div class="col-sm-10">
                            <select class="form-control" name="parentId" required><option>'.$langDB['LANG_MAIN_CATEGORY'].'</option>';
                                    $fonk->categoriesList($query['PARENTID']);
                                echo'
                            </select>
                                </div>
                            </div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_CATEGORY_NAME'].' <small class="text-danger">*</small></label>
                                <div class="col-sm-10"><input type="text" name="title" class="form-control" placeholder="Örn. Düğün Salonları" value="'.$query['TITLE'].'" required></div>
                            </div>
                            
                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_DESCRIPTION'].'</label>
                                <div class="col-sm-10"><textarea class="ckeditor1" name="description" id="editor" rows="10" cols="80" >'.$query['DESCRIPTION'].'</textarea></div>
                            </div>

                            <div class="hr-line-dashed"></div>
                            
                            <div class="form-group"><label class="col-sm-2 control-label"></label>
                                   <div class="col-sm-10">
                                        <select class="btn-quay" name="status">
                                            <option value="Y" ';echo $query['STATUS'] == 'Y' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                            <option value="N" ';echo $query['STATUS'] == 'N' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_PASSIVE'].'</option>
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