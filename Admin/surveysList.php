<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-alizarin"><?=$langDB['LANG_ADMIN_USER_HERE'];?></h2>
        <span class="label label-alizarin"><a href="index.php">Yönetici Ana Sayfası</a></span> /
        <span class="label label-alizarin"><a href="index.php?page=surveysList">Anketler</a></span> /
        <span class="label label-alizarin">Tüm Liste</span>
    </div>
    <div class="col-lg-3">
        <h2 class="text-alizarin"><a href="index.php?page=surveyAdd">Yeni Anket Ekle <i class="fa fa-plus"></i></a></h2>
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
                            <th>ANKET BAŞLIĞI</th>
                            <th>EKLENME TARİHİ</th>

                        </tr>
                        </thead>
                        <tbody>

                            <?php
                                $db = new Database();
                                $querySurveys = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_SURVEYS ORDER BY ID DESC");
                                $db->Disconnect();

                                foreach ($querySurveys AS $querySurveysShow)
                                {
                                    echo'<tr class="gradeX">';
                                    echo'<td>'.$querySurveysShow['ID'].'</td>';
                                    echo'<td>'.$querySurveysShow['TITLE'].'</td>';
                                    echo'<td>'.$querySurveysShow['ADDDATE'].'</td>';
                                    echo'</tr>';
                                }
                            ?>


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>ANKET BAŞLIĞI</th>
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