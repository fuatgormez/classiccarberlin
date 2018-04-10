<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <!-- website settings -->
        <div class="col-lg-6">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <a href="index.php?page=webSettings" class="btn btn-primary m-r-sm" title="<?=$langDB['LANG_UPDATE_SETTINGS']?>">
                            <i class="fa fa-cog fa-5x"></i>
                        </a>
                    </div>

                    <div class="col-xs-8 text-right">
                        <span><?=$langDB['LANG_ADMIN_WEBSETTINGS']?></span>
                        <h2 class="font-bold"><a href="index.php?page=webSettings" class="btn btn-danger m-r-sm"><?=$langDB['LANG_UPDATE_SETTINGS']?></a></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- /website settings -->

        <!-- manager settings -->
        <div class="col-lg-6">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <a href="" class="btn btn-primary m-r-sm" title="<?=$langDB['LANG_UPDATE_SETTINGS']?>">
                            <i class="fa fa-user fa-5x"></i>
                        </a>
                    </div>

                    <div class="col-xs-8 text-right">
                        <span><?=$langDB['LANG_ADMIN_MANAGER_SETTINGS']?></span>
                        <h2 class="font-bold"><a href="" class="btn btn-info m-r-sm"><?=$langDB['LANG_UPDATE_SETTINGS']?></a></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- /manager settings -->
    </div>

    <div class="row">
        <!-- logs -->
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?=$langDB['LANG_ADMIN_LOGS']?></h5>

                    <div class="ibox-tools">
                        <small><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>
                <div class="ibox-content no-padding">
                    <ul class="list-group" id="logs">

                    </ul>
                </div>
            </div>

        </div>
        <!-- /logs -->
    </div>

    <div class="row">
        <!-- users -->
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary"><a href="index.php?page=usersList" title="Tüm üyeleri göster"> <i class="fa fa-users"></i> <?=strtoupper($langDB['LANG_ADMIN_MENU_USERS'])?> </a></span>
                    <span class="label label-primary"> <a href="index.php?page=userAdd" title="Yeni Üye Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-navy"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content">
                    <?php
                        $db = new Database();
                        $queryUsers = $db->getRows("SELECT ID,USERNAME,ADDDATE FROM ".TABLE_PREFIX."TBL_USERS");
                        $db->Disconnect();
                        echo'<span class="label label-primary pull-right">'.count($queryUsers).'</span>
                            <small>'.$langDB['LANG_TOTAL_MEMBERS'].'</small><hr />';

                        foreach (array_slice($queryUsers,0,5) as $queryUsersShow)
                        {
                            echo'<p><a href="index.php?page=userEdit&ID='.$queryUsersShow['ID'].'" class="text-navy"> <i class="fa fa-caret-right text-navy"></i> '.$queryUsersShow['USERNAME'].'<small class="pull-right">Kayıt Tarihi: '.date('d/m/Y',strtotime($queryUsersShow['ADDDATE'])).'</small></a></p>
                                    <div class="hr-line-dashed"></div>';
                        }
                    ?>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=usersList" class="ibox-footer-home-a-primary"><i class="fa fa-users"></i> Tüm Üyeleri Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /users -->

        <!-- pages -->
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success"><a href="index.php?page=pagesList" title="Tüm sayfaları göster"> <i class="fa fa-external-link"></i> <?=strtoupper($langDB['LANG_ADMIN_MENU_PAGES'])?> </a></span>
                    <span class="label label-success"> <a href="index.php?page=pageAdd" title="Yeni Sayfa Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-success"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content">
                    <?php
                    $db = new Database();
                    $queryPage = $db->getRows("SELECT ID,TITLE,ADDDATE FROM ".TABLE_PREFIX."TBL_PAGES");
                    $db->Disconnect();
                    echo'<span class="label label-success pull-right">'.count($queryPage).'</span>
                            <small>'.$langDB['LANG_TOTAL_PAGES'].'</small><hr>';

                    foreach (array_slice($queryPage,0,5) as $queryPagesShow)
                    {
                        echo'<p><a href="index.php?page=pageEdit&ID='.$queryPagesShow['ID'].'" class="text-success" title="'.htmlspecialchars($queryPagesShow['TITLE']).'"><i class="fa fa-caret-right text-success"></i> '.$queryPagesShow['TITLE'].'<small class="pull-right">Kayıt Tarihi: '.date('d/m/Y',strtotime($queryPagesShow['ADDDATE'])).'</small></a></p>
                              <div class="hr-line-dashed"></div>';
                    }
                    ?>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=pagesList" class="ibox-footer-home-a-success"><i class="fa fa-external-link"></i> Tüm Sayfaları Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /pages -->

        <!-- news -->
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger"><a href="index.php?page=newsList" title="Tüm haberleri göster"> <i class="fa fa-newspaper-o"></i> <?=strtoupper($langDB['LANG_ADMIN_MENU_NEWS'])?> </a></span>
                    <span class="label label-danger"> <a href="index.php?page=newsAdd" title="Yeni Haber Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-danger"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content">
                    <?php
                        $db = new Database();
                        $queryNews = $db->getRows("SELECT ID,TITLE,ADDDATE FROM ".TABLE_PREFIX."TBL_NEWS");
                        $db->Disconnect();
                        echo'<span class="label label-danger pull-right">'.count($queryNews).'</span>
                        <small>'.$langDB['LANG_TOTAL_NEWS'].'</small><hr />';

                        foreach (array_slice($queryNews,0,5) as $queryNewsShow)
                        {
                            echo'<p><a href="index.php?page=newsEdit&ID='.$queryNewsShow['ID'].'" class="text-danger" title="'.htmlspecialchars($queryNewsShow['TITLE']).'"><i class="fa fa-caret-right text-danger"></i> '.$queryNewsShow['TITLE'].'<small class="pull-right">Kayıt Tarihi: '.date('d/m/Y',strtotime($queryNewsShow['ADDDATE'])).'</small></a></p>
                                <div class="hr-line-dashed"></div>';
                        }
                    ?>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=newsList" class="ibox-footer-home-a-danger"><i class="fa fa-newspaper-o"></i> Tüm Haberleri Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /news -->

        <!-- notices -->
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <span class="label label-info"><a href="index.php?page=noticesList" title="Tüm duyuruları göster"> <i class="fa fa-bullhorn"></i> <?=strtoupper($langDB['LANG_ADMIN_MENU_NOTICES'])?> </a></span>
                    <span class="label label-info"> <a href="index.php?page=noticeAdd" title="Yeni Duyuru Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-info"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content">
                    <?php
                        $db = new Database();
                        $queryNotices = $db->getRows("SELECT ID,TITLE,ADDDATE FROM ".TABLE_PREFIX."TBL_NOTICES");
                        $db->Disconnect();
                        echo'<span class="label label-info pull-right">'.count($queryNotices).'</span>
                            <small>'.$langDB['LANG_TOTAL_NOTICES'].'</small><hr />';

                        foreach (array_slice($queryNotices,0,5) as $queryNoticesShow)
                        {
                            echo'<p><a href="index.php?page=noticeEdit&ID='.$queryNoticesShow['ID'].'" class="text-info" title="'.htmlspecialchars($queryNoticesShow['TITLE']).'"><i class="fa fa-caret-right text-info"></i> '.$queryNoticesShow['TITLE'].'<small class="pull-right">Kayıt Tarihi: '.date('d/m/Y',strtotime($queryNoticesShow['ADDDATE'])).'</small></a></p>
                                <div class="hr-line-dashed"></div>';
                        }
                    ?>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=noticesList" class="ibox-footer-home-a-info"><i class="fa fa-bullhorn"></i> Tüm Duyuruları Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /notices -->

        <!-- videos -->
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning"><a href="index.php?page=videosList" title="Tüm videoları göster"> <i class="fa fa-video-camera"></i> <?=strtoupper($langDB['LANG_ADMIN_MENU_VIDEOS'])?> </a></span>
                    <span class="label label-warning"> <a href="index.php?page=videoAdd" title="Yeni Video Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-warning"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content-home">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>VİDEO BAŞLIK</th>
                            <th>EKLENME TARİHİ</th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php
                    $db = new Database();
                    $queryVideos = $db->getRows("SELECT ID,TITLE,ADDDATE FROM ".TABLE_PREFIX."TBL_VIDEOS");
                    $db->Disconnect();
                    echo'<span class="label label-warning pull-right">'.count($queryVideos).'</span>
                            <small>'.$langDB['LANG_TOTAL_VIDEOS'].'</small><hr />';

                    foreach (array_slice($queryVideos,0,5) as $queryVideosShow)
                    {
                        echo'
                            
                                <tr>
                                    <td>'.$queryVideosShow['ID'].'</td>
                                    <td> '.$queryVideosShow['TITLE'].'</td>
                                    <td> '.$queryVideosShow['ADDDATE'].'</td>
                                </tr>
        
                                ';
                    }

                    ?>

                        </tbody>
                    </table>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=videosList" class="ibox-footer-home-a-warning"><i class="fa fa-video-camera"></i> Tüm Videoları Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /videos -->

        <!-- images -->
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-quay"><a href="index.php?page=imagesList" title="Tüm resimleri göster"> <i class="fa fa-file-image-o"></i> <?=strtoupper($langDB['LANG_ADMIN_MENU_IMAGES'])?> </a></span>
                    <span class="label label-quay"> <a href="index.php?page=imageAdd" title="Yeni Resim Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-quay"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content-home">
                    <?php
                        $db = new Database();
                        $queryImages = $db->getRows("SELECT images.ID,image.IMAGE,image.THUMBNAIL,image.IMAGESID FROM ".TABLE_PREFIX."TBL_IMAGES as images LEFT JOIN ".TABLE_PREFIX."TBL_IMAGE as image ON images.ID=image.IMAGESID");
                        $db->Disconnect();
                        echo'<span class="label label-quay pull-right">'.count($queryImages).'</span>
                            <small>'.$langDB['LANG_TOTAL_IMAGES'].'</small><hr />';
                        echo'<div class="lightBoxGallery">';

                        foreach (array_slice($queryImages,0,5) AS $queryImageShow)
                        {
                            echo'<a href="'.URL.'/uploads/images/thumb/'.$queryImageShow['IMAGE'].'" title="Image from Unsplash" data-lightbox="images"><img width="50" src="'.URL.'/uploads/images/thumb/'.$queryImageShow['THUMBNAIL'].'"></a>';
                        }
                        echo '<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
                            <div id="blueimp-gallery" class="blueimp-gallery">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>
                        </div>';
                    ?>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=imagesList" class="ibox-footer-home-a-quay"><i class="fa fa-file-image-o"></i> Tüm Resimleri Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /images -->

        <!-- activities -->
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <span class="label label-wisteria"><a href="index.php?page=activitiesList" title="Tüm etkinlikleri göster"> <i class="fa fa-calendar"></i> ETKİNLİKLER </a></span>
                    <span class="label label-wisteria"> <a href="index.php?page=activityAdd" title="Yeni Etkinlik Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-wisteria"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content">
                    <?php
                    $db = new Database();
                    $queryActivities = $db->getRows("SELECT ID,TITLE,ADDDATE FROM ".TABLE_PREFIX."TBL_ACTIVITIES LIMIT 15");
                    $db->Disconnect();
                    echo'<span class="label label-wisteria pull-right">'.count($queryActivities).'</span>
                            <small>Toplam Etkinlikler</small><hr />';

                    foreach (array_slice($queryActivities,0,5) as $queryActivitiesShow)
                    {
                        echo'<p><a href="index.php?page=activityEdit&ID='.$queryActivitiesShow['ID'].'" class="text-wisteria" title="'.htmlspecialchars($queryActivitiesShow['TITLE']).'"><i class="fa fa-caret-right text-wisteria"></i> '.$queryActivitiesShow['TITLE'].'<small class="pull-right">Kayıt Tarihi: '.date('d/m/Y',strtotime($queryActivitiesShow['ADDDATE'])).'</small></a></p>
                            <div class="hr-line-dashed"></div>';
                    }
                    ?>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=activitiesList" class="ibox-footer-home-a-wisteria"><i class="fa fa-bullhorn"></i> Tüm Etkinlikleri Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /activities -->

        <!-- surveys -->
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <span class="label label-alizarin"><a href="index.php?page=surveysList" title="Tüm üyeleri göster"> <i class="fa fa-list-alt"></i> ANKETLER </a></span>
                    <span class="label label-alizarin"> <a href="index.php?page=surveyAdd" title="Yeni Anket Ekle"><i class="fa fa-plus"></i></a> </span>
                    <small class="pull-right text-alizarin"><?=$langDB['LANG_RECENTLY_ADDED']?> (5)</small>
                </div>
                <div class="ibox-content">
                    <?php
                    $db = new Database();
                    $querySurveys = $db->getRows("SELECT ID,TITLE,ADDDATE FROM ".TABLE_PREFIX."TBL_SURVEYS");
                    $db->Disconnect();
                    echo'<span class="label label-alizarin pull-right">'.count($querySurveys).'</span>
                            <small>Toplam Anketler</small><hr />';

                    foreach (array_slice($querySurveys,0,5) as $querySurveysShow)
                    {
                        echo'<p><a href="index.php?page=surveyEdit&ID='.$querySurveysShow['ID'].'" class="text-alizarin" title="'.htmlspecialchars($querySurveysShow['TITLE']).'"><i class="fa fa-caret-right text-alizarin"></i> '.$querySurveysShow['TITLE'].'<small class="pull-right">Kayıt Tarihi: '.date('d/m/Y',strtotime($querySurveysShow['ADDDATE'])).'</small></a></p>
                            <div class="hr-line-dashed"></div>';
                    }
                    ?>
                </div>

                <div class="ibox-footer-home pull-right">
                    <small><a href="index.php?page=surveysList" class="ibox-footer-home-a-alizarin"><i class="fa fa-list-alt"></i> Tüm Anketleri Göster</a></small>
                </div>

            </div>
        </div>
        <!-- /surveys -->

    </div>

</div>
