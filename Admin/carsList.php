<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-quay"><?=$langDB['LANG_ADMIN_USER_HERE'];?></h2>
        <span class="label label-quay"><a href="index.php"><?=$langDB['LANG_ADMIN_HOMEPAGE']?></a></span> /
        <span class="label label-quay"><a href="index.php?page=carsList"><?=$langDB['LANG_ADMIN_MENU_CARS']?></a></span> /
        <span class="label label-quay"><?=$langDB['LANG_ALL_LIST']?></span>
    </div>
    <div class="col-lg-3">
        <h2 class="text-quay"><a href="index.php?page=carAdd"><?=$langDB['LANG_ADMIN_MENU_CAR_ADD'];?><i class="fa fa-plus animated flip"></i></a></h2>
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
                            <th>BAŞLIK</th>
                            <th>MARKA</th>
                            <th>TARİH</th>
                            <th>İŞLEMLER</th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $message    = 'Araba listesine bakıyor..';
                        $addDate 	= date("Y-m-d H:i:s");

                        $db = new Database();
                        $queryCar = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_CARS ORDER BY ID DESC");
                        $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$addDate]);
                        $db->Disconnect();

                        if($queryCar !=NULL){
                            foreach ($queryCar AS $queryCarShow)
                            {
                                if($queryCarShow['STATUS'] == "Y"){
                                    $statusClass = 'pull-right label label-primary';
                                    $statusText  = '<i class="fa fa-circle label-primary" title="'.$langDB['LANG_BTN_PASSIVE'].'"></i>';
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
                                echo'<tr class="gradeX" id="listID'.$queryCarShow['ID'].'">';
                                echo'<td style="vertical-align:middle;">'.$queryCarShow['ID'].'</td>';
                                echo'<td style="vertical-align:middle;"><a href="index.php?page=carEdit&ID='.$queryCarShow['ID'].'">'.$queryCarShow['TITLE'].'</a> <span class="'.$statusClass.'" id="carStatus'.$queryCarShow['ID'].'">'.$statusText.'</span></td>';
                                echo'<td style="vertical-align:middle;"><a href="index.php?page=carEdit&ID='.$queryCarShow['ID'].'">'.$queryCarShow['BRAND'].'</a> </td>';
                                echo'<td style="vertical-align:middle;">'.$queryCarShow['ADDDATE'].'</td>';
                                echo'<td style="vertical-align:middle;" align="center"><select id="selectedClass'.$queryCarShow['ID'].'" class="'.$selectedClass.'" onchange="carActive_carInactive(this.value,'.$queryCarShow['ID'].')"><option value="Y" '.@$selectedA.'>'.$langDB['LANG_BTN_ACTIVE'].'</option><option value="N" '.@$selectedP.'>'.$langDB['LANG_BTN_PASSIVE'].'</option></select> <button title="'.$langDB['LANG_BTN_DELETE'].'" class="btn btn-primary" onClick="carDelete('.$queryCarShow['ID'].')">'.$langDB['LANG_BTN_DELETE'].'</button>  <a href="index.php?page=carEdit&ID='.$queryCarShow['ID'].'" title="'.$langDB['LANG_BTN_EDIT'].'" class="btn btn-primary">'.$langDB['LANG_BTN_EDIT'].'</a></td>';
                                echo'</tr>';
                            }
                        }else{
                            return sweetalert("Henüz araba eklenmemiş","Yönlendiriliyorsunuz..","warning","index.php","2000");
                            exit();
                        }


                        ?>


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>BAŞLIK</th>
                            <th>MARKA</th>
                            <th>TARİH</th>
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