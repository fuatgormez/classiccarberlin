<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-wisteria"><?=$langDB['LANG_ADMIN_USER_HERE'];?></h2>
        <span class="label label-wisteria"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-wisteria"><a href="index.php?page=activitiesList">Etkinlikler</a></span> /
        <span class="label label-wisteria">Tüm Liste</span>

    </div>
    <div class="col-lg-3">
        <h2 class="text-wisteria"><a href="index.php?page=activityAdd">Yeni Etkinlik Ekle <i class="fa fa-plus"></i></a></h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Tüm etkinliklerin listesini görüntülüyorsunuz...</h5>
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
                            <th>ETKİNLİK BAŞLIĞI</th>
                            <th>EKLENME TARİHİ</th>

                        </tr>
                        </thead>
                        <tbody>

                            <?php
                                $db = new Database();
                                $queryPage = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_PAGES ORDER BY ID DESC");
                                $db->Disconnect();

                                foreach ($queryPage AS $queryPageShow)
                                {
                                    echo'<tr class="gradeX">';
                                    echo'<td>'.$queryPageShow['ID'].'</td>';
                                    echo'<td>'.$queryPageShow['TITLE'].'</td>';
                                    echo'<td>'.$queryPageShow['ADDDATE'].'</td>';
                                    echo'</tr>';
                                }
                            ?>


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>ETKİNLİK BAŞLIĞI</th>
                            <th>EKLENME TARİHİ</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

</div>