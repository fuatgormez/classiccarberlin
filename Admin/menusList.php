<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-quay"><?=$langDB['LANG_ADMIN_USER_HERE'];?></h2>
        <span class="label label-quay"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-quay"><a href="index.php?page=pagesList">Menüler</a></span> /
        <span class="label label-quay">Tüm Liste</span>

    </div>
    <div class="col-lg-3">
        <h2><a href="index.php?page=menuAdd">Yeni Menü Ekle <i class="fa fa-plus animated flip"></i></a></h2>
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
                            <th>MENÜ İSMİ</th>
                            <th>SIRA</th>
                            <th>MENÜ LİNKİ</th>
                            <th>İŞLEMLER</th>

                        </tr>
                        </thead>
                        <tbody>

                            <?php
                                $message    = 'Menüler listesine bakıyor..';

                                $db = new Database();
                                $queryMenu = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_MENUS");
                                $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
                                $db->Disconnect();

                                if($queryMenu !=NULL){
                                    foreach ($queryMenu AS $queryMenuShow)
                                    {
                                        if($queryMenuShow['STATUS'] == "Y"){
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
                                        echo'<tr class="gradeX" id="listID'.$queryMenuShow['ID'].'" style="text-align:center;">';
                                        echo'<td style="vertical-align:middle;">'.$queryMenuShow['ID'].'</td>';
                                        echo'<td style="vertical-align:middle;"><a href="index.php?page=menuEdit&ID='.$queryMenuShow['ID'].'">'.$queryMenuShow['MENUNAME'].'</a> <span class="'.$statusClass.'" id="menuStatus'.$queryMenuShow['ID'].'">'.$statusText.'</span> <br><small>'.$queryMenuShow['ADDDATE'].'</small></td>';
                                        echo'<td style="vertical-align:middle;">'.$queryMenuShow['LIST'].'</td>';
                                        echo'<td style="vertical-align:middle;">'.$queryMenuShow['LINK'].'</td>';
                                        echo'<td style="vertical-align:middle;" align="center"><select id="selectedClass'.$queryMenuShow['ID'].'" class="'.$selectedClass.'" onchange="menuActive_menuInactive(this.value,'.$queryMenuShow['ID'].')"><option value="Y" '.@$selectedA.'>'.$langDB['LANG_BTN_ACTIVE'].'</option><option value="N" '.@$selectedP.'>'.$langDB['LANG_BTN_PASSIVE'].'</option></select> <button title="Sil" class="btn btn-quay" onClick="menuDelete('.$queryMenuShow['ID'].')">'.$langDB['LANG_BTN_DELETE'].'</button>  <a href="index.php?page=menuEdit&ID='.$queryMenuShow['ID'].'" title="'.$langDB['LANG_BTN_EDIT'].'" class="btn btn-quay">'.$langDB['LANG_BTN_EDIT'].'</a></td>';
                                        echo'</tr>';
                                    }
                                }else{
                                    return sweetalert("Henüz menü eklenmemiş","Yönlendiriliyorsunuz..","warning","index.php","2000");
                                    exit();
                                }


                            ?>


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>MENÜ İSMİ</th>
                            <th>SIRA</th>
                            <th>MENÜ LİNKİ</th>
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