<?php
@$ID = intval($_GET['ID']);
if ($ID == NULL)
{
    echo sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}
//========================================================================================================

ini_set('memory_limit', '256M');

if (isset($_POST['submitCarImage']))
{

    $images         = $_FILES['images'];

    $newImageName          = '';
    $newImageThumbnailName = '';

    try{

//========================================================================================================

$db = new Database();

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

                            $insertImages = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGES SET CARID=?, SLUG=?, ADDDATE=?",[$ID,$newImageName,$date]);
                            $imagesLastID = $db->lastInsertId();

                            $insertImage = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_IMAGE SET IMAGE=?,THUMBNAIL=?,IMAGESID=?",[$newImageName,$newImageThumbnailName,$imagesLastID]);


                        } else {

                            $insertImageDelete = $db->deleteRow("DELETE FROM ".TABLE_PREFIX."TBL_IMAGES WHERE ID=?",[$ID]);

                            return sweetalert("Bir sorun oluştu $handle->error","Yönlendiriliyorsunuz...","error","index.php?page=carEdit&ID=$ID","3000");
                            exit();
                        }
                    } else {
                        return sweetalert("Bir sorun oluştu $handle->error","Yönlendiriliyorsunuz...","error","index.php?page=carEdit&ID=$ID","3000");
                        exit();
                    }


                    unset($handle);
                }
            }


//========================================================================================================

            $db->Disconnect();


            echo sweetalert("Resim(ler) Eklendi","","success","index.php?page=carEdit&ID=$ID","2000");
            exit;



    } catch (Exception $e) {
        die ('Bir sorun var: ' . $e->getMessage());
    }


}

if (isset($_POST['submit'])){
    $carTitle       = $_POST['title'];
    $carBrand       = $_POST['brand'];
    $carPrice       = $_POST['price'];
    $carModel       = $_POST['model'];
    $carYear        = $_POST['year'];
    $carMileage     = $_POST['mileage'];
    $carColor       = $_POST['color'];
    $carDescription = $_POST['description'];
    $catId          = $_POST['categoryId'];

    $status         = $_POST['status'];



    $slug           = $fonk->sef_link($carTitle);



    try{
        if ($carTitle !=NULL && $carBrand !=NULL && $carModel !=NULL)
        {
            $db = new Database();
            $queryCar = $db->getRow("SELECT ID,TITLE FROM ".TABLE_PREFIX."TBL_CARS WHERE TITLE=?",[$carTitle]);

            if ($queryCar !=NULL && $queryCar['ID'] !=$ID ){
                return sweetalert("Bu isimle kayıt mevcut! Lütfen bilgilerinizi kontrol ediniz.","Yönlendiriliyorsunuz...","warning","index.php?page=carEdit","4000");
                exit;
            }

//========================================================================================================

            $updateCar = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_CARS SET TITLE=?,BRAND=?,PRICE=?,MODEL=?,YEAR=?,MILEAGE=?,COLOR=?,DESCRIPTION=?,CATEGORYID=?,UPDATEDATE=?, STATUS=?,SLUG=? WHERE ID=?",[$carTitle,$carBrand,$carPrice,$carModel,$carYear,$carMileage,$carColor,$carDescription,$catId,$date,$status,$slug,$ID]);



            $message    = 'Araba ekledi! <i class="fa fa-arrow-right"></i> <a href="index.php?page=carEdit&ID='.$ID.'"> '.$carTitle.'</a>';
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();


            echo sweetalert($langDB['LANG_UPDATED'],$langDB['LANG_REDIRECTING'],"success","index.php?page=carsList","2000");
            exit;
        }else {
            echo sweetalert($langDB['LANG_FAILED_UPDATE'],$langDB['LANG_REDIRECTING'],"error","index.php?page=carEdit&ID=$ID","2000");
            exit;
        }


    } catch (Exception $e) {
        die ($langDB['LANG_CATCH_PROBLEM']." ". $e->getMessage());
    }


}else {
        $db = new Database();
        $carQuery = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_CARS WHERE ID=?",[$ID]);
        $catQuery = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_CATEGORIES WHERE ID=?",[$carQuery['CATEGORYID']]);
        $carImage = $db->getRows("SELECT images.ID,images.CARID,image.ID as IMAGEID,image.IMAGE,image.THUMBNAIL,image.IMAGESID FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON images.ID=image.IMAGESID WHERE images.CARID=? ",[$ID]);
        if ($carQuery ==NULL){
            echo sweetalert("Kayıt bulunamadı","Yönlendiriliyorsunuz","warning","index.php?page=carsList","2000");
            exit;
        }
        $db->Disconnect();
    echo '

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2 class="text-quay">'.$langDB['LANG_ADMIN_USER_HERE'].'</h2>
        <span class="label label-quay"><a href="index.php">'.$langDB['LANG_ADMIN_HOMEPAGE'].'</a></span> /
        <span class="label label-quay"><a href="index.php?page=carsList">'.$langDB['LANG_ADMIN_MENU_CARS'].'</a></span> /
        <span class="label label-quay">'.$langDB['LANG_ADMIN_MENU_CAR_EDIT'].'</span>
    </div>
    <div class="col-lg-4">
            <h2>
                <a href="index.php?page=carAdd" class="text-quay"><i class="fa fa-plus animated flip"></i> Araba Ekle</a>
                <a href="index.php?page=carDelete&ID='.$ID.'" class="text-danger"><i class="fa fa-trash animated flip"></i> Arabayı Sil</a>
            </h2>
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
            
            <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">'.$langDB['LANG_CAR_INFORMATION'].'</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2">'.$langDB['LANG_IMAGES'].'</a></li>
                        </ul>
                        
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                        
                <form method="POST" class="form-horizontal" action="">
                
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_CATEGORY'].'</label>
                        <div class="col-sm-10">
                            
                            <select class="form-control" name="categoryId">';


                                 $fonk->categoriesList($catQuery['ID']);

                                    echo'
                            </select>
                        </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_TITLE'].'</label>
                        <div class="col-sm-10"><input type="text" name="title" class="form-control" value="'.$carQuery['TITLE'].'" placeholder="Classic Auto"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_BRAND'].'</label>
                        <div class="col-sm-10"><input type="text" name="brand" class="form-control" value="'.$carQuery['BRAND'].'" placeholder="Marka"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_PRICE'].'</label>
                        <div class="col-sm-10"><input type="text" name="price" class="form-control" value="'.$carQuery['PRICE'].'" placeholder="Fiyat"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_MODEL'].'</label>
                        <div class="col-sm-10"><input type="text" name="model" class="form-control" value="'.$carQuery['MODEL'].'" placeholder="Model"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_YEAR'].'</label>
                        <div class="col-sm-10"><input type="number" name="year" class="form-control" value="'.$carQuery['YEAR'].'" min="1925" max="2018" placeholder="Yıl"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_MILEAGE'].'</label>
                        <div class="col-sm-10"><input type="number" name="mileage" class="form-control" value="'.$carQuery['MILEAGE'].'" placeholder="Kilometre"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_COLOR'].'</label>
                        <div class="col-sm-10"><input type="text" name="color" class="form-control" value="'.$carQuery['COLOR'].'" placeholder="Renk"></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group"><label class="col-sm-2 control-label text-quay">'.$langDB['LANG_DESCRIPTION'].'</label>
                        <div class="col-sm-10"><textarea class="ckeditor1" name="description" id="editor" rows="10" cols="80" >'.htmlspecialchars_decode($carQuery['DESCRIPTION']).'</textarea></div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    
                    
                    
                    <div class="form-group"><label class="col-sm-2 control-label"></label>
                           <div class="col-sm-10">
                                <select class="btn-quay" name="status">
                                    <option value="Y" ';echo $carQuery['STATUS'] == 'Y' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_ACTIVE'].'</option>
                                    <option value="N" ';echo $carQuery['STATUS'] == 'N' ? 'selected' : null; echo'>'.$langDB['LANG_BTN_PASSIVE'].'</option>
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
                
                
                
                
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    
                                   <form method="POST" class="form-horizontal" action="" enctype="multipart/form-data">
                                    
                                    <div class="form-group"><label class="col-sm-2 control-label text-quay">Bild(er) hinzufügen</label>
                                        <div class="col-sm-10"><input type="file" name="images[]" multiple class="form-control"></div>
                                    </div>
                                          
                                     <div class="form-group">
                                            <div class="col-sm-12 col-sm-offset-2">
                                                <button class="btn btn-quay" name="submitCarImage" type="submit">'.$langDB['LANG_BTN_SAVE'].'</button>
                                            </div>
                                     </div>      
                                    
                                    </form>
                                    
                                    <div class="hr-line-dashed"></div>
                                   
                                    
                                    <div class="form-group"><label class="col-sm-2 control-label text-quay">Bild(er)</label>
                                        <div class="col-sm-10" id="emptyCarImage">';

                                            foreach ($carImage as $queryCarImage){
                                                if ($queryCarImage !=NULL){
                                                    echo '<label id="listID'.$queryCarImage['IMAGEID'].'" class="lightBoxGallery"><a  data-lightbox="example-set" href="'.URL.'/uploads/images/'.$queryCarImage['IMAGE'].'" ><img width="100" height="100" src="'.URL.'/uploads/images/thumb/'.$queryCarImage['THUMBNAIL'].'"></a><br /><button title="'.$langDB['LANG_BTN_DELETE'].'" class="btn btn-quay" onClick="imageDelete('.$queryCarImage['IMAGEID'].')">'.$langDB['LANG_BTN_DELETE'].'</button></label>';
                                                }else{
                                                    echo '<label>Henüz resim eklenmemiş</label>';
                                                }
                                            }


                                        echo'</div>
                
                                      
                                        
                                    </div>       
                                </div>
                            </div>
                         
                
                </div><!-- end/tab content -->
                
                </div>
            </div>
        </div>
    </div>
</div>

</div>';
}