<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
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
                    <ul class="list-group">
                        <?php
                        $logs = array();
                        $db = new Database();
                        $queryLogs = $db->getRows("SELECT * FROM ".TABLE_PREFIX."TBL_LOGS ORDER BY ID DESC");
                        $db->Disconnect();
                            foreach (array_slice($queryLogs,0,5) as $queryLogsShow)
                                {
                                    echo'
                                <li class="list-group-item" id="logs">
                                    <p><a class="text-info" href="#">@'.$queryLogsShow['USERNAME'].'</a> '.$queryLogsShow['MESSAGE'].'</p>
                                    <small class="block text-muted"><i class="fa fa-clock-o"></i> '.$queryLogsShow['ADDDATE'].'</small>
                                </li>                       
                                 ';
                                }
                        ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>