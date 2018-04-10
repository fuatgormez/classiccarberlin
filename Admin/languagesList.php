<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2 class="text-quay"><?=$langDB['LANG_ADMIN_USER_HERE']?></h2>
        <span class="label label-quay"><a href="index.php"><?=$langDB['LANG_ADMIN_HOMEPAGE']?></a></span> /
        <span class="label label-quay"><a href="index.php?page=languagesList"><?=$langDB['LANG_LANGUAGES']?></a></span> /
        <span class="label label-quay"><?=$langDB['LANG_ALL_LIST']?></span>

    </div>
    <div class="col-lg-3">
        <h2><a href="index.php?page=languageAdd"><?=$langDB['LANG_ADMIN_MENU_LANGUAGE_ADD']?> <i class="fa fa-plus animated flip"></i></a></h2>
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
                            <th>TITLE</th>
                            <th>TR</th>
                            <th>EN</th>
                            <th>DE</th>
                            <th>FORTSCHRIFTT</th>

                        </tr>
                        </thead>
                        <tbody>

                            <?php
                                $message    = 'Language listesine bakıyor..';

                                $db = new Database();
                                $queryLanguage = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_LANGUAGE");
                                $insertLog  = $db->insertRow("INSERT INTO ".TABLE_PREFIX."TBL_LOGS SET MESSAGE=?,USERNAME=?,IP=?,ADDDATE=?",[$message,$loginUsername,$loginUserIP,$date]);
                                $db->Disconnect();

                                if($queryLanguage !=NULL){
                                    foreach ($queryLanguage AS $queryLanguageShow)
                                    {

                                        echo'<tr class="gradeX" id="listID'.$queryLanguageShow['ID'].'" style="text-align:center;">';
                                        echo'<td style="vertical-align:middle;">'.$queryLanguageShow['ID'].'</td>';
                                        echo'<td style="vertical-align:middle;"><a href="index.php?page=languageEdit&ID='.$queryLanguageShow['ID'].'">'.$queryLanguageShow['TITLE'].'</a> </td>';
                                        echo'<td style="vertical-align:middle;">'.$queryLanguageShow['tr'].'</td>';
                                        echo'<td style="vertical-align:middle;">'.$queryLanguageShow['en'].'</td>';
                                        echo'<td style="vertical-align:middle;">'.$queryLanguageShow['de'].'</td>';

                                        echo'<td style="vertical-align:middle;" align="center"> <button title="'.$langDB['LANG_BTN_DELETE'].'" class="btn btn-quay" onClick="languageDelete('.$queryLanguageShow['ID'].')">'.$langDB['LANG_BTN_DELETE'].'</button>  <a href="index.php?page=languageEdit&ID='.$queryLanguageShow['ID'].'" title="'.$langDB['LANG_BTN_EDIT'].'" class="btn btn-quay">'.$langDB['LANG_BTN_EDIT'].'</a></td>';
                                        echo'</tr>';
                                    }
                                }else{
                                    return sweetalert("Henüz dil eklenmemiş","Yönlendiriliyorsunuz..","warning","index.php","2000");
                                    exit();
                                }


                            ?>


                        </tbody>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>TR</th>
                            <th>EN</th>
                            <th>DE</th>
                            <th>FORTSCHRIFTT</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

</div>