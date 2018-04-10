<?php

@$ID = intval($_GET['ID']);
if ($ID == NULL) {
    echo sweetalert("Böyle bir kayıt bulunamadı!","Yönlendiriliyorsunuz..","error","index.php","2000");
    exit;
}

    $db = new Database();
    $queryMessageDetail = $db->getRow("SELECT * FROM ".TABLE_PREFIX."TBL_CONTACTFORM WHERE ID=?",[$ID]);
    $queryMessageUpdate = $db->updateRow("UPDATE ".TABLE_PREFIX."TBL_CONTACTFORM SET READED=? WHERE ID=?",['Y',$ID]);

    $message    = 'Mesajı görüntülüyor! <i class="fa fa-arrow-right"></i><a href="index.php?page=contactFormDetail&ID='.$ID.'">'.$queryMessageDetail['SUBJECT'].'</a>';
    $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
    $db->Disconnect();
?>



        <div class="wrapper wrapper-content">
        <div class="row">

            <div class="col-lg-12 animated fadeInRight">
            <div class="mail-box-header">

                <h2><?=$langDB['LANG_ADMIN_CONTACT_MESSAGE']?></h2>
                <div class="mail-tools tooltip-demo m-t-md">


                    <h3>
                        <span class="font-noraml text-quay"><?=$langDB['LANG_TOPIC']?>: </span> <?=$queryMessageDetail['SUBJECT'];?>
                    </h3>
                    <h3>
                        <small class="pull-right font-noraml"><?=$queryMessageDetail['ADDDATE'];?></small>
                        <span class="font-noraml text-quay"><?=$langDB['LANG_SENDER']?>: </span><?=$queryMessageDetail['NAME'];?>
                    </h3>
                    <h3><span class="font-noraml text-quay"><?=$langDB['LANG_EMAIL']?>: </span> <?=$queryMessageDetail['EMAIL'];?></h3>
                    <h3><span class="font-noraml text-quay"><?=$langDB['LANG_TELEPHONE']?>: </span> <?=$queryMessageDetail['TELEFONNUMBER'];?></h3>
                </div>
            </div>
                <div class="mail-box">


                <div class="mail-body">
                    <h3 class="text-quay"><?=$langDB['LANG_CONTENT']?></h3>
                    <p><?=$queryMessageDetail['MESSAGE'];?></p>
                </div>





                </div>
            </div>
        </div>
        </div>






