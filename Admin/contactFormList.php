
<?php

$db = new Database();
$queryContactMessage = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_CONTACTFORM ORDER BY ID DESC");

$message    = 'Mesajları görüntülüyor! <i class="fa fa-arrow-right"></i>';
$insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
$db->Disconnect();

?>


        <div class="wrapper wrapper-content">
            <div class="row">

                <div class="col-lg-12 animated fadeInRight">
                    <div class="mail-box-header">
                        <h2><?=$langDB['LANG_TOTAL_MESSAGES']?> (<?=count($queryContactMessage);?>)</h2>
                    </div>
                    <div class="mail-box">

                        <table class="table table-hover table-mail">
                            <tbody>

                            <?php

                                    if ($queryContactMessage !=NULL){
                                        foreach ($queryContactMessage AS $contactMessageShow){

                                            if ($contactMessageShow['READED'] !='Y'){
                                                $readClass = 'unread';
                                                $readButton = '<span class="label label-danger pull-right">'.$langDB['LANG_MESSAGE_UNREAD'].'</span>';
                                            }else{
                                                $readClass = 'read';
                                                $readButton = '<span class="label label-info pull-right">'.$langDB['LANG_MESSAGE_READ'].'</span>';
                                            }

                                            echo'<tr class="'.$readClass.'" id="listID'.$contactMessageShow['ID'].'">
                                                    <td class="delete-mail"><a title="Sil" onClick="contactMessageDelete('.$contactMessageShow['ID'].')"><i class="fa fa-trash-o"></i></a></td>
                                                    <td class="mail-ontact"><a href="index.php?page=contactFormDetail&ID='.$contactMessageShow['ID'].'">'.$contactMessageShow['NAME'].'</a> </td>
                                                    <td class="mail-subject"><a href="index.php?page=contactFormDetail&ID='.$contactMessageShow['ID'].'">'.$contactMessageShow['SUBJECT'].'</a></td>
                                                    <td class="">'.$readButton.'</td>
                                                    <td class="text-right mail-date">'.$contactMessageShow['ADDDATE'].'</td>
                                                </tr>';
                                        }
                                    }else{
                                        return sweetalert("Mesaj kutusu boş!","Yönlendiriliyorsunuz..","warning","index.php","2000");
                                        exit();
                                    }


                            ?>



                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>


