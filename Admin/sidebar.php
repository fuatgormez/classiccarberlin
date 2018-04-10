<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">

                        <span>
                            <img alt="image" class="message-avatar" src="../uploads/images/users/<?=$loginUserImage !=NULL ? $loginUserImage : 'man-avatar.png';?>" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"><?=$langDB['LANG_ADMIN_WELCOME'];?>, <strong class="font-bold"><?=$loginUsername;?></strong>
                             </span>  </a>


                </div>
                <div class="logo-element">
                    CAR
                </div>
            </li>
            <li >
                <a href="index.php"><i class="fa fa-home"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_HOMEPAGE'];?></span></a>
            </li>


            <li <?php echo @$page == 'categoriesList' || @$page == 'categoryAdd' ? 'class="active"' : null; ?> id="menu_link-quay">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_CATEGORIES'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=categoryAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_CATEGORY_ADD'];?></a></li>
                    <li><a href="index.php?page=categoriesList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_CATEGORIES'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'carsList' || @$page == 'carAdd' ? 'class="active"' : null; ?> id="menu_link-quay">
                <a href="#"><i class="fa fa-car"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_CARS'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=carAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_CAR_ADD'];?></a></li>
                    <li><a href="index.php?page=carsList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_CARS'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'usersList' || @$page == 'userAdd' ? 'class="active"' : null; ?> id="menu_link-primary">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_USERS'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=userAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_USER_ADD'];?></a></li>
                    <li><a href="index.php?page=usersList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_USERS'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'pagesList' || @$page == 'pageAdd' ? 'class="active"' : null; ?> id="menu_link-success">
                <a href="#"><i class="fa fa-external-link"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_PAGES'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=pageAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_PAGE_ADD'];?></a></li>
                    <li><a href="index.php?page=pagesList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_PAGES'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'newsList' || @$page == 'newsAdd' ? 'class="active"' : null; ?> id="menu_link-danger">
                <a href="#"><i class="fa fa-newspaper-o"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_NEWS'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=newsAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_NEWS_ADD'];?></a></li>
                    <li><a href="index.php?page=newsList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_NEWS'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'noticesList' || @$page == 'noticeAdd' ? 'class="active"' : null; ?> id="menu_link-info">
                <a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_NOTICES'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=noticeAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_NOTICE_ADD'];?></a></li>
                    <li><a href="index.php?page=noticesList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_NOTICES'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'videosList' || @$page == 'videoAdd' ? 'class="active"' : null; ?> id="menu_link-warning">
                <a href="#"><i class="fa fa-video-camera"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_VIDEOS'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=videoAdd"><i class="fa fa-plus-square"></i><?=$langDB['LANG_ADMIN_MENU_VIDEO_ADD'];?></a></li>
                    <li><a href="index.php?page=videosList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_VIDEOS'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'activitiesList' || @$page == 'activityAdd' ? 'class="active"' : null; ?> id="menu_link-wisteria">
                <a href="#"><i class="fa fa-calendar"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_ACTIVITIES'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=activityAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_ACTIVITY_ADD'];?></a></li>
                    <li><a href="index.php?page=activitiesList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_ACTIVITIES'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'surveysList' || @$page == 'surveyAdd' ? 'class="active"' : null; ?> id="menu_link-alizarin">
                <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_SURVEYS'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=surveyAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_SURVEY_ADD'];?></a></li>
                    <li><a href="index.php?page=surveysList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_SURVEYS'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'imagesList' || @$page == 'imageAdd' ? 'class="active"' : null; ?> id="menu_link-quay">
                <a href="#"><i class="fa fa-file-image-o"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_IMAGES'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=imageAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_IMAGE_ADD'];?></a></li>
                    <li><a href="index.php?page=imagesList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_IMAGES'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'menusList' || @$page == 'menuAdd' ? 'class="active"' : null; ?> id="menu_link-quay">
                <a href="#"><i class="fa fa-file-image-o"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_MENUS'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=menuAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_MENU_ADD'];?></a></li>
                    <li><a href="index.php?page=menusList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_MENUS'];?></a></li>

                </ul>
            </li>

            <li <?php echo @$page == 'languagesList' || @$page == 'languageAdd' ? 'class="active"' : null; ?> id="menu_link-quay">
                <a href="#"><i class="fa fa-language"></i> <span class="nav-label"><?=$langDB['LANG_ADMIN_MENU_LANGUAGES'];?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="index.php?page=languageAdd"><i class="fa fa-plus-square"></i> <?=$langDB['LANG_ADMIN_MENU_LANGUAGE_ADD'];?></a></li>
                    <li><a href="index.php?page=languagesList"><i class="fa fa-angle-double-right"></i> <?=$langDB['LANG_ADMIN_MENU_LANGUAGES'];?></a></li>

                </ul>
            </li>

        </ul>

    </div>
</nav>