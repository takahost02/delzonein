<?php

use Classes\GoogleUserDataManager;
use Classes\SettingsManager;
use Utils\InputCleaner;

$googleConfigFound = !empty(trim(SettingsManager::getInstance()->getSetting('System: Google Client Secret Path')));
$isGoogleConnected = GoogleUserDataManager::isConnected(\Classes\BaseService::getInstance()->getCurrentUser());
$userDomain = explode('@', $user->email)[1];
?>
</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
		<script type="text/javascript">



		for (var prop in modJsList) {
			if(modJsList.hasOwnProperty(prop)){
				modJsList[prop].setTranslations(<?=\Classes\LanguageManager::getTranslations()?>);
				modJsList[prop].setPermissions(<?=json_encode($modulePermissions['perm'])?>);
				modJsList[prop].setFieldTemplates(<?=json_encode($fieldTemplates)?>);
				modJsList[prop].setTemplates(<?=json_encode($templates)?>);
				modJsList[prop].setCustomTemplates(<?=json_encode($customTemplates)?>);
				<?php if(isset($emailTemplates)){?>
				modJsList[prop].setEmailTemplates(<?=json_encode($emailTemplates)?>);
				<?php } ?>
				modJsList[prop].setUser(<?=json_encode(\Classes\BaseService::getInstance()->cleanUpUser($user))?>);
                modJsList[prop].initSourceMappings();
				modJsList[prop].setBaseUrl('<?=BASE_URL?>');
				modJsList[prop].setClientUrl('<?=CLIENT_BASE_URL?>');
				modJsList[prop].setCurrentProfile(<?=json_encode($activeProfile)?>);
				modJsList[prop].setInstanceId('<?=\Classes\BaseService::getInstance()->getInstanceId()?>');
				modJsList[prop].setGoogleAnalytics(ga);
				modJsList[prop].setNoJSONRequests('<?=SettingsManager::getInstance()->getSetting("System: Do not pass JSON in request")?>');
			}

	    }


		//Other static js objects
        var timeUtils = setupTimeUtils('<?=$diffHoursBetweenServerTimezoneWithGMT?>');
        var notificationManager = setupNotifications('<?=CLIENT_BASE_URL?>service.php');

		<?php
			$notificationTemplates = array();
			$notificationTemplates['notification'] = file_get_contents(APP_BASE_PATH."/templates/notifications/notification.html");
			$notificationTemplates['notifications'] = file_get_contents(APP_BASE_PATH."/templates/notifications/notifications.html");
		?>
		notificationManager.setTemplates(<?=json_encode($notificationTemplates)?>);

		//-----------------------


		$(document).ready(function() {
			$('#modTab a').click(function (e) {
                if($(this).hasClass('dropdown-toggle')){
                    return;
                }
				e.preventDefault();
				$(this).tab('show');
				modJs = modJsList[$(this).attr('id')];
                modJs.get([]);

                // Do not load master data for new types of tables
				if (!modJs.isV2) {
                  if(modJs.initialFilter != null){
                    modJs.initFieldMasterData(null,modJs.setFilterExternal);
                  } else {
                    modJs.initFieldMasterData();
                  }
                }

				var helpLink = modJs.getHelpLink();
				if(helpLink != null && helpLink != undefined){
					$('.helpLink').attr('href',helpLink);
					$('.helpLink').show();
				}else{
					$('.helpLink').hide();
				}
			});

			for (var modName in modJsList) {
              modJsList[modName].setApiUrl('<?=$restApiBase?>');
              modJsList[modName].setupApiClient($('#jt').attr('t'));
            }

			var tabName = window.location.hash.substr(1);

			if(tabName!= undefined && tabName != "" && modJsList[tabName] != undefined && modJsList[tabName] != null){
				$("#"+tabName).click();
			}else{
                <?php if(!isset($_REQUEST['action'])){?>
				modJs.get([]);
                <?php } ?>
			}

			notificationManager.getNotifications();

			$("#delegationDiv").on('click', "#notifications", function(e) {
				$(this).find('.label-danger').remove();
				notificationManager.clearPendingNotifications();

			});

			$("#switch_emp").select2();

			var helpLink = modJs.getHelpLink();
			if(helpLink != null && helpLink != undefined){
				$('.helpLink').attr('href',helpLink);
				$('.helpLink').show();
			}else{
				$('.helpLink').hide();
			}

          $(this).scrollTop(0);

		});

        if (!modJs.isV2) {
          if(modJs.initialFilter != null){
            modJs.initFieldMasterData(null,modJs.setFilterExternal);
          } else {
            modJs.initFieldMasterData();
          }
        }

		var clientUrl = '<?=CLIENT_BASE_URL?>';

        var modulesInstalled = <?=json_encode(\Classes\BaseService::getInstance()->getModuleManagerNames())?>;

		$(document).ready(function() {

			$(".dataTables_paginate ul").addClass("pagination");

			var refId = "";
			<?php if(empty($_REQUEST['m'])){?>
				<?php if($user->user_level == 'Admin'){?>
					refId = '<?="admin_".str_replace(" ", "_", $adminModules[0]['name'])?>';
					$("[ref = '"+refId+"'] a").first().click();
				<?php }else{?>
					refId = '<?="module_".str_replace(" ", "_", $userModules[0]['name'])?>';
					$("[ref = '"+refId+"'] a").first().click();
				<?php }?>
			<?php } else{?>
				refId = '<?=InputCleaner::escape($_REQUEST['m'])?>';
				$("[ref = '"+refId+"'] a").first().click();
			<?php }?>

			<?php if(!isset($proVersion) && isset($moduleName) && $moduleName == 'dashboard' && $user->user_level == 'Admin' && !\Classes\BaseService::getInstance()->validateInstance()){?>
			$("#verifyModel").modal({
				  backdrop: 'static'
			});
			<?php } elseif (($moduleName === 'leaves' || $moduleName === 'candidates')  && !$isGoogleConnected && $googleConfigFound) {?>
              // Show google connect only when verify modal is not shown
              modJs.checkIfUserEmailIsGoogleDomain('<?=$userDomain?>');
            <?php }?>

		});

	</script>
	<?php
        include 'popups.php';
    ?>
    <script src="<?=BASE_URL?>js/bootstrap-datatable.js"></script>
    <div id="jt" t="<?=$jwtService->create(3600)?>"></div>
    </body>
</html>
