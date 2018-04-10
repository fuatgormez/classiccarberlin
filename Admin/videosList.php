<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-warning"><?=$langDB['LANG_ADMIN_USER_HERE'];?></h2>
        <span class="label label-warning"><a href="index.php"><?=$langDB['LANG_ADMIN_HOMEPAGE']?></a></span> /
        <span class="label label-warning"><a href="index.php?page=videosList"><?=$langDB['LANG_VIDEOS']?></a></span> /
        <span class="label label-warning"><?=$langDB['LANG_ALL_LIST']?></span>

    </div>
    <div class="col-lg-3">
        <h2 class="text-warning"><a href="index.php?page=videoAdd">Yeni Video Ekle <i class="fa fa-plus animated flip"></i></a></h2>
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
                            <th>VİDEO BAŞLIĞI</th>
                            <th>EKLENME TARİHİ</th>
                            <th>İŞLEMLER</th>

                        </tr>
                        </thead>
                        <tbody>

                            <?php
                                $message    = 'Videolar listesine bakıyor..';

                                $db = new Database();
                                $queryVideo = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_VIDEOS ORDER BY ID DESC");
                                $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
                                $db->Disconnect();

                                if($queryVideo !=NULL){
                                    foreach ($queryVideo AS $queryVideoShow)
                                    {
                                        if($queryVideoShow['STATUS'] == "Y"){
                                            $statusClass = 'pull-right label label-primary';
                                            $statusText  = '<i class="fa fa-circle label-primary" title="Video Aktif"></i>';
                                            $selectedA   = 'selected';
                                            $selectedClass = 'btn text-navy';

                                            unset($selectedP);
                                        }else{
                                            $statusClass = 'pull-right label label-danger';
                                            $statusText  = '<i class="fa fa-circle label-danger" title="Video Pasif"></i>';
                                            $selectedP   = 'selected';
                                            $selectedClass = 'btn text-danger';

                                            unset($selectedA);
                                        }
                                        echo'<tr class="gradeX" id="listID'.$queryVideoShow['ID'].'">';
                                        echo'<td style="vertical-align:middle;">'.$queryVideoShow['ID'].'</td>';
                                        echo'<td style="vertical-align:middle;"><a href="index.php?page=videoEdit&ID='.$queryVideoShow['ID'].'">'.$queryVideoShow['TITLE'].'</a> <span class="'.$statusClass.'" id="videoStatus'.$queryVideoShow['ID'].'">'.$statusText.'</span></td>';
                                        echo'<td style="vertical-align:middle;">'.$queryVideoShow['ADDDATE'].'</td>';
                                        echo'<td style="vertical-align:middle;" align="center"><select id="selectedClass'.$queryVideoShow['ID'].'" class="'.$selectedClass.'" onchange="videoActive_videoInactive(this.value,'.$queryVideoShow['ID'].')"><option value="Y" '.@$selectedA.'>'.$langDB['LANG_BTN_ACTIVE'].'</option><option value="N" '.@$selectedP.'>'.$langDB['LANG_BTN_PASSIVE'].'</option></select> <button title="'.$langDB['LANG_BTN_DELETE'].'" class="btn btn-warning" onClick="videoDelete('.$queryVideoShow['ID'].')">'.$langDB['LANG_BTN_DELETE'].'</button>  <a href="index.php?page=videoEdit&ID='.$queryVideoShow['ID'].'" title="'.$langDB['LANG_BTN_EDIT'].'" class="btn btn-warning">'.$langDB['LANG_BTN_EDIT'].'</a></td>';
                                        echo'</tr>';
                                    }
                                }else{
                                    return sweetalert("Henüz video eklenmemiş","Yönlendiriliyorsunuz..","warning","index.php","2000");
                                    exit();
                                }


                            ?>


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>VİDEO BAŞLIĞI</th>
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