<?php
/*
 Copyright (c) 2018 [Glacies UG, Berlin, Germany] (http://glacies.de)
 Developer: Thilina Hasantha (http://lk.linkedin.com/in/thilinah | https://github.com/thilinah)
 */

use Classes\AbstractModuleManager;
use Classes\BaseService;
use Classes\LanguageManager;

$moduleName = 'dashboard';
$moduleGroup = 'admin';
define('MODULE_PATH',dirname(__FILE__));
include APP_BASE_PATH.'header.php';
include APP_BASE_PATH.'modulejslibs.inc.php';

$employee_directory_url = CLIENT_BASE_URL.'?g=extension&n=directory|user&m=module_Company';

$moduleManagers = BaseService::getInstance()->getModuleManagers();
$dashBoardList = array();
/** @var AbstractModuleManager $moduleManagerObj */
foreach($moduleManagers as $moduleManagerObj){

    //Check if this is not an admin module
    if($moduleManagerObj->getModuleType() != 'admin'){
        continue;
    }

    $allowed = BaseService::getInstance()->isModuleAllowedForUser($moduleManagerObj);

    if(!$allowed){
        continue;
    }

    $item = $moduleManagerObj->getDashboardItem();
    if(!empty($item)) {
        $index = $moduleManagerObj->getDashboardItemIndex();
        $dashBoardList[$index] = $item;
    }
}

ksort($dashBoardList);

$dashboardList1  =[];
$dashboardList2  =[];
foreach($dashBoardList as $k=>$v){
    if (count($dashboardList1) === 4 ) {
        $dashboardList2[] = $v;
    } else {
        $dashboardList1[] = $v;
    }
}

?><div class="span9">
    <div id="NewsHolder" class="row" style="display: none;margin-bottom: 10px;">
        <div class="col-lg-12 col-xs-12">
            <div id="NewsMessage">
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        foreach($dashboardList1 as $v){
            echo LanguageManager::translateTnrText($v);
        }
        ?>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div id="EmployeeListWrapper" style="display:none;box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);border: none;margin-bottom: 20px; padding: 20px;">
                <h4><?=t('Your Colleagues')?></h4>
                <div id="EmployeeList"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <div id="EmployeeOnlineOfflineChartLoader" style="width:100%;"></div>
            <div id="EmployeeOnlineOfflineChart" style="display:none;box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);border: none;margin-bottom: 20px;"></div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div id="EmployeeDistributionChartLoader" style="width:100%;"></div>
            <div id="EmployeeDistributionChart" style="display:none;box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);border: none;margin-bottom: 20px;"></div>
        </div>
        <div class="col-lg-4 col-xs-12">
            <div id="TaskListLoader" style="width:100%;"></div>
            <div id="TaskListWrap" style="display: none;box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);border: none;margin-bottom: 20px; padding:25px;">
                <h4><?=t('Task List')?></h4>
                <div id="TaskList" style="margin-left: 10px; margin-top: 30px;"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        foreach($dashboardList2 as $v){
            echo LanguageManager::translateTnrText($v);
        }
        ?>
        <?php if (BaseService::getInstance()->isOpenSourceVersion()) {?>
        <div class="col-lg-3 col-xs-12">

            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        <t>IceHrmPro</t>
                    </h3>
                    <p>
                        <t>Purchase IceHrmPro</t>
                    </p>
                </div>
                <div class="icon">
                    <i class="fa fa-store"></i>
                </div>
                <a target="_blank" href="https://icehrm.com/purchase-icehrmpro" class="small-box-footer">
                    <t>Purchase</t> <t>IceHrmPro</t> <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>

</div>
<script>
    var modJsList = [];

    modJsList['tabDashboard'] = new DashboardAdapter('Dashboard','Dashboard');
    modJsList['tabDashboard'].setVersion('<?=VERSION?>');
    modJsList['tabDashboard'].setUser
    var modJs = modJsList['tabDashboard'];

</script>
<?php include APP_BASE_PATH.'footer.php';?>
