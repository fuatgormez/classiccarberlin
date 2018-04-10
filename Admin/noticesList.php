<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-info"><?=$langDB['LANG_ADMIN_USER_HERE'];?></h2>
        <span class="label label-info"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-info"><a href="index.php?page=noticesList">Duyurular</a></span> /
        <span class="label label-info">Tüm Liste</span>

    </div>
    <div class="col-lg-3">
        <h2 class="text-info"><a href="index.php?page=noticeAdd">Yeni Duyuru Ekle <i class="fa fa-plus animated flip"></i></a></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5><?=$langDB['LANG_ALL_LIST_LOOK']?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>

                </div>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>DUYURU BAŞLIĞI</th>
                            <th>EKLENME TARİHİ</th>
                            <th>İŞLEMLER</th>

                        </tr>
                        </thead>
                        <tbody>

                            <?php
                                $message    = 'Duyurular listesine bakıyor..';

                                $db = new Database();
                                $queryNotice = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_NOTICES ORDER BY ID DESC");
                                $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
                                $db->Disconnect();

                                if($queryNotice !=NULL){
                                    foreach ($queryNotice AS $queryNoticeShow)
                                    {
                                        if($queryNoticeShow['STATUS'] == "Y"){
                                            $statusClass = 'pull-right label label-primary';
                                            $statusText  = '<i class="fa fa-circle label-primary" title="'.$langDB['LANG_BTN_ACTIVE'].'"></i>';
                                            $selectedA   = 'selected';
                                            $selectedClass = 'btn text-navy';

                                            unset($selectedP);
                                        }else{
                                            $statusClass = 'pull-right label label-danger';
                                            $statusText  = '<i class="fa fa-circle label-danger" title="'.$langDB['LANG_BTN_PASSIVE'].'"></i>';
                                            $selectedP   = 'selected';
                                            $selectedClass = 'btn text-danger';

                                            unset($selectedA);
                                        }
                                        echo'<tr class="gradeX" id="listID'.$queryNoticeShow['ID'].'">';
                                        echo'<td style="vertical-align:middle;">'.$queryNoticeShow['ID'].'</td>';
                                        echo'<td style="vertical-align:middle;"><a href="index.php?page=noticeEdit&ID='.$queryNoticeShow['ID'].'">'.$queryNoticeShow['TITLE'].'</a> <span class="'.$statusClass.'" id="noticeStatus'.$queryNoticeShow['ID'].'">'.$statusText.'</span></td>';
                                        echo'<td style="vertical-align:middle;">'.$queryNoticeShow['ADDDATE'].'</td>';
                                        echo'<td style="vertical-align:middle;" align="center"><select id="selectedClass'.$queryNoticeShow['ID'].'" class="'.$selectedClass.'" onchange="noticeActive_noticeInactive(this.value,'.$queryNoticeShow['ID'].')"><option value="Y" '.@$selectedA.'>'.$langDB['LANG_BTN_ACTIVE'].'</option><option value="N" '.@$selectedP.'>'.$langDB['LANG_BTN_PASSIVE'].'</option></select> <button title="'.$langDB['LANG_BTN_DELETE'].'" class="btn btn-info" onClick="noticeDelete('.$queryNoticeShow['ID'].')">'.$langDB['LANG_BTN_DELETE'].'</button>  <a href="index.php?page=noticeEdit&ID='.$queryNoticeShow['ID'].'" title="'.$langDB['LANG_BTN_EDIT'].'" class="btn btn-info">'.$langDB['LANG_BTN_EDIT'].'</a></td>';
                                        echo'</tr>';
                                    }
                                }else{
                                    return sweetalert("Henüz duyuru eklenmemiş","Yönlendiriliyorsunuz..","warning","index.php","2000");
                                    exit();
                                }


                            ?>


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>DUYURU BAŞLIĞI</th>
                            <th>EKLENME TARİHİ</th>
                            <th>İŞLEMLER</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

</div>