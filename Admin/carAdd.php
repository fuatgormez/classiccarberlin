<?php
ini_set('memory_limit', '256M');
if (isset($_POST['submit'])){
    $carTitle       = $_POST['title'];
    $carBrand       = $_POST['brand'];
    $carModel       = $_POST['model'];
    $carPrice       = $_POST['price'];
    $carYear        = $_POST['year'];
    $carMileage     = $_POST['mileage'];
    $carColor       = $_POST['color'];
    $carDescription = $_POST['description'];
    $catId          = $_POST['categoryId'];

    $status         = $_POST['status'];

    $images         = $_FILES['images'];

    $slug           = $fonk->sef_link($carTitle);

    $_SESSION['s_title']        = $carTitle;
    $_SESSION['s_brand']        = $carBrand;
    $_SESSION['s_price']        = $carPrice;
    $_SESSION['s_model']        = $carModel;
    $_SESSION['s_year']         = $carYear;
    $_SESSION['s_mileage']      = $carMileage;
    $_SESSION['s_color']        = $carColor;
    $_SESSION['s_description']  = $carDescription;




    $newImageName          = '';
    $newImageThumbnailName = '';

    try{
        if ($carTitle !=NULL){


            $db = new Database();
            $queryUser = $db->getRow("SELECT TITLE FROM ".TABLE_PREFIX."TBL_CARS WHERE TITLE=?",[$carTitle]);

            if ($queryUser !=NULL){
                return sweetalert("Bu isimle kayıt mevcut! Lütfen bilgilerinizi kontrol ediniz.","Yönlendiriliyorsunuz...","warning","index.php?page=carAdd","4000");
                exit;
            }

//========================================================================================================

            $insertCar = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_CARS SET TITLE=?,BRAND=?,PRICE=?,MODEL=?,YEAR=?,MILEAGE=?,COLOR=?,DESCRIPTION=?,CATEGORYID=?,SLUG=?,ADDDATE=?, STATUS=?",[$carTitle,$carBrand,$carPrice,$carModel,$carYear,$carMileage,$carColor,$carDescription,$catId,$slug,$date,$status]);
            $carLastID = $db->lastInsertId();

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

                    if ($file['tmp_name'] !=NULL){

                        $handle = new Upload($file);

                        //$handle->file_max_size = '999999999999'; // 1KB

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
                                $handle->image_y = 220;
                                //$handle->image_ratio_y = true;

                                //$handle->image_watermark = '../image.png';
                                //$handle->image_watermark_position = 'BR';

                                $handle->Process("../uploads/images/thumb/");
                                $newImageThumbnailName = $handle->file_dst_name;

                                if ($handle->processed) {

                                    $insertImages = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGES SET CARID=?, SLUG=?, ADDDATE=?",[$carLastID,$newImageName,$date]);
                                    $imagesLastID = $db->lastInsertId();

                                    $insertImage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGE SET IMAGE=?,THUMBNAIL=?,IMAGESID=?",[$newImageName,$newImageThumbnailName,$imagesLastID]);


                                } else {

                                    $insertImageDelete = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGES WHERE ID=?",[$carLastID]);

                                    return sweetalert($langDB['LANG_ADDED'].$handle->error,$langDB['LANG_REDIRECTING'],"error","index.php?page=carAdd","3000");
                                    exit();
                                }
                            } else {
                                return sweetalert($langDB['LANG_FAILED_ADDED'].$handle->error,$langDB['LANG_REDIRECTING'],"error","index.php?page=carAdd","3000");
                                exit();
                            }

                    unset($handle);
                }
            }


//========================================================================================================


            $message    = 'Araba ekledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=carEdit&ID='.$carLastID.'"> '.$carTitle.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            unset($_SESSION['s_title'],$_SESSION['s_brand'],$_SESSION['s_price'],$_SESSION['s_model'],$_SESSION['s_year'],$_SESSION['s_mileage'],$_SESSION['s_color'],$_SESSION['s_description']);

            echo sweetalert($langDB['LANG_ADDED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=carsList","2000");
            exit;
        }else{
            echo sweetalert($langDB['LANG__FAILED_ADDED'],$langDB['LANG_REDIRECTING'],"error","index.php?page=carAdd","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else {
    echo '

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-quay">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
        <span class="label label-quay"><a href="index.php">'.$langDB['LANG_ADMIN_HOMEPAGE'].'</a></span> /
        <span class="label label-quay"><a href="index.php?page=carsList">'.$langDB['LANG_ADMIN_MENU_CARS'].'</a></span> /
        <span class="label label-quay">'.$langDB['LANG_ADMIN_MENU_CAR_ADD'].'</span>
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
                <form method="POST" class="form-horizontal" action="" enctype="multipart/form-data">
                
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_MAIN_CATEGORY'].'</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="categoryId" required><option>'.$langDB['LANG_SELECT'].'</option>';
                                 $fonk->categoriesList();

                                 echo'</select>
                        </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_TITLE'].'</label>
                        <div class="col-sm-10"><input type="text" name="title" class="form-control" value="'.@$_SESSION['s_title'].'" placeholder="Classic Auto" required></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_BRAND'].'</label>
                        <div class="col-sm-10"><input type="text" name="brand" class="form-control" value="'.@$_SESSION['s_brand'].'" placeholder="'.$langDB['LANG_BRAND'].'" ></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_PRICE'].'</label>
                        <div class="col-sm-10"><input type="text" name="price" class="form-control" value="'.@$_SESSION['s_price'].'" placeholder="'.$langDB['LANG_PRICE'].'" ></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_MODEL'].'</label>
                        <div class="col-sm-10"><input type="text" name="model" class="form-control" value="'.@$_SESSION['s_model'].'" placeholder="'.$langDB['LANG_MODEL'].'" ></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_YEAR'].'</label>
                        <div class="col-sm-10"><input type="number" name="year" class="form-control" value="'.@$_SESSION['s_year'].'" placeholder="'.$langDB['LANG_YEAR'].'" min="1925" max="2018" required></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_MILEAGE'].'</label>
                        <div class="col-sm-10"><input type="number" name="mileage" class="form-control" value="'.@$_SESSION['s_mileage'].'" placeholder="'.$langDB['LANG_MILEAGE'].'"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_COLOR'].'</label>
                        <div class="col-sm-10"><input type="text" name="color" class="form-control" value="'.@$_SESSION['s_color'].'" placeholder="'.$langDB['LANG_COLOR'].'" required></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_DESCRIPTION'].'</label>
                        <div class="col-sm-10"><textarea class="ckeditor1" name="description" id="editor" rows="10" cols="80" >'.@$_SESSION['s_description'].'</textarea></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_ADMIN_MENU_IMAGE_ADD'].'</label>
                                <div class="col-sm-10"><input type="file" multiple name="images[]" class="form-control"></div>
                            </div>

                            
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <select class="btn-quay" name="status" required>
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

</div>';
}