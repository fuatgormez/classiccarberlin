<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-quay"><?=$langDB['LANG_ADMIN_USER_HERE'];?></h2>
        <span class="label label-quay"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-quay"><a href="index.php?page=imagesList">Resimler</a></span> /
        <span class="label label-quay">Tüm Liste</span>
    </div>
    <div class="col-lg-3">
        <h2 class="text-quay"><a href="index.php?page=imageAdd">Yeni Resim Ekle <i class="fa fa-plus"></i></a></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">

        <?php
            $message    = 'Resimler listesine bakıyor!';

            $db = new Database();
            $queryImages = $db->getRows("SELECT images.ID,images.USERID,images.ADDDATE,image.ID as IMAGEID, image.THUMBNAIL,image.IMAGE,image.IMAGESID FROM ".TABLE_PREFIX."TBL_IMAGES images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE image ON images.ID=image.IMAGESID WHERE images.USERID=?",['']);
            $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
            $db->Disconnect();

            if ($queryImages  !=NULL){

                foreach ($queryImages AS $queryImageShow)
                {

                    echo'<div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box">
            
                            <div class="product-imitation">
                                <img width="100" height="100" src="'.URL.'/uploads/images/thumb/'.$queryImageShow['THUMBNAIL'].'">
                            </div>
                            <div class="product-desc">
                                            <span class="product-price">
                                                RESİM ID: #'.$queryImageShow['ID'].'
                                            </span>
                                <small class="text-quay">Eklenme Tarihi:</small>
                                <p class="text-quay">'.$queryImageShow['ADDDATE'].'</p>
                                <textarea id="imageID'.$queryImageShow['IMAGEID'].'" rows="1">'.URL.'/uploads/images/'.$queryImageShow['IMAGE'].'</textarea>
            
            
                                <div class="m-t text-righ">
            
                                    <a href="index.php?page=imageDelete&ID='.$queryImageShow['ID'].'&one='.$queryImageShow['IMAGEID'].'" class="btn btn-xs btn-outline btn-primary"> <i class="fa fa-trash"></i> Resmi Sil</a>
                                    <button class="btn btn-xs btn-outline btn-primary" id="imageSelectID" data-clipboard-target="#imageID'.$queryImageShow['IMAGEID'].'" onClick="imageLinkCopy()"><i class="fa fa-copy"></i> Linki Kopyala</button>

                                </div>
                            </div>
                        </div>
                </div>
                </div>';
                }
            }else{
                echo sweetalert("Eklenmiş resim bulunmuyor!","Yönlendiriliyorsunuz.","warning","index.php","2000");
                exit();
            }

        ?>
    </div>
</div>