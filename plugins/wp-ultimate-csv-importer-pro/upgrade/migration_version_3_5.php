<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
//require_once(dirname(__FILE__) . '/../../../wp-config.php');
//require_once(dirname(__FILE__) . '/../../../wp-load.php');

global $wpdb;
$upload_dir = wp_upload_dir();
$new_dir_name = "backup_csv_importer";
$uploadsLoc = $upload_dir['basedir'];
if (!is_dir($uploadsLoc . '/' . $new_dir_name)) {
	wp_mkdir_p($uploadsLoc . '/' . $new_dir_name);
}

// Function for Back up All Files
function BackupAllFileswithDB() {
	$files = scandir(plugin_dir_path(__FILE__));
	$db_name = DB_NAME;
	$db_user = DB_USER;
	$db_pass = DB_PASSWORD;
	$db_host = DB_HOST;
	$upload_dir = wp_upload_dir();
	$new_dir_name = "backup_csv_importer";
	$uploadsLoc = $upload_dir['basedir'];
	$path = $upload_dir ['basedir'];
	if (!is_dir($path . '/db_backup')) {
		wp_mkdir_p($path . '/db_backup');
	}

	$file_name = $path . "/db_backup/" . $db_name . "_" . time() . ".sql";

	// Backup the tables
	exec("mysqldump -u$db_user -p$db_pass $db_name smack_csv_dashboard smack_dashboard_manager smackcsv_status_log > $file_name");


	// Identify directories
	/*        $source = plugin_dir_path(__FILE__);
			$destination = $uploadsLoc . '/' . $new_dir_name . '/';
			// Cycle through all source files
			foreach ($files as $file) {
					if (in_array($file, array(".","..","migration_version_3_5_new.php"))) continue;
					// If we copied this successfully, mark it for deletion
					$sourceFile = $source.$file;
					$destnFile = $destination.$file;
					if (exec("cp -r $sourceFile $destnFile")) {
							$delete[] = $sourceFile;
							exec("rm -rf $sourceFile");
					}
			} */
	return "BACKUP SUCCESSFULLY!";
}

// Function for upgrading csv importer to version 3.5
function UpgradetoThreePointFive() {
	global $wpdb;
	$get_upgrade_version = get_option('ULTIMATE_CSV_IMPORTER_UPGRADE_VERSION');
	if ($get_upgrade_version != 3.5) {
		BackupAllFileswithDB();
		$upload_dir = wp_upload_dir();
		$check_keyword = mysql_query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'keyword'");
		$keyword_exists = (mysql_num_rows($check_keyword)) ? TRUE : FALSE;
		if (!$keyword_exists) {
			$sql5 = "ALTER TABLE smack_dashboard_manager ADD keyword VARCHAR(60) AFTER modified_on;";
			$wpdb->query($sql5);
		}
        //Change the csvname size in dashboard manager
        $check_csvname = $wpdb->query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'csv_name'");
        if ($check_csvname !== 0) {
                $sql1 = "ALTER TABLE `smack_dashboard_manager` MODIFY `csv_name` VARCHAR(100)";
                $wpdb->query($sql1);
        }
		$check_table1 = 'wp_ultimate_csv_importer_filemanager';
		$check_table2 = 'wp_ultimate_csv_importer_mappingtemplate';
		$check_table3 = 'wp_ultimate_csv_importer_scheduled_import';
		if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table1 . "'")) != 1) {
			$create_hash_fileManager = "CREATE TABLE `wp_ultimate_csv_importer_filemanager` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`sdm_id` int(11) NOT NULL,
				`imported_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				`version_id` int(11) DEFAULT NULL,
				`hash_key` varchar(60) DEFAULT NULL,
				`status` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
					) ENGINE=InnoDB;";
			$wpdb->query($create_hash_fileManager);
		}
		if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table2 . "'")) != 1) {
			$create_mapping_template = "CREATE TABLE `wp_ultimate_csv_importer_mappingtemplate` (
                                `id` int(10) NOT NULL AUTO_INCREMENT,
                                `templatename` varchar(100) NOT NULL,
                                `mapping` blob NOT NULL,
                                `createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `deleted` int(1) DEFAULT '0',
                                `templateused` int(10) DEFAULT '0',
                                `module` varchar(50) DEFAULT NULL,
                                `delimiter` varchar(5) NOT NULL,
                                PRIMARY KEY (`id`)
                                        ) ENGINE=InnoDB;";
			$wpdb->query($create_mapping_template);
		}
		if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table3 . "'")) != 1) {
			$create_scheduled_import = "CREATE TABLE `wp_ultimate_csv_importer_scheduled_import` (
                                `id` int(10) NOT NULL AUTO_INCREMENT,
                                `templateid` int(10) NOT NULL,
                                `importid` int(10) NOT NULL,
                                `createdtime` datetime NOT NULL,
                                `updatedtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                `isrun` int(1) DEFAULT '0',
                                `scheduledtimetorun` varchar(10) NOT NULL,
                                `scheduleddate` date NOT NULL,
                                `module` varchar(100) NOT NULL,
                                `response` blob,
                                `version` varchar(10) DEFAULT NULL,
                                `imported_as` varchar(100) DEFAULT NULL,
                                PRIMARY KEY (`id`)
                                        ) ENGINE=InnoDB;";
			$wpdb->query($create_scheduled_import);
		}
		$Resuts = $wpdb->get_results("select id,csv_name,created_records,imported_as,imported_on,modified_on,version from smack_dashboard_manager;");
		foreach ($Resuts as $data) {
			$getcount = unserialize($data->created_records);
			$get_csv_name = $data->csv_name;
			$explode_hypen = explode('-', $get_csv_name);
			$csv_name = '';
			$get_csv_name_cnt = (count($explode_hypen)) - 1;
			for ($n = 0; $n < $get_csv_name_cnt; $n++) {
				$get_csvname .= $explode_hypen[$n] . '-';
			}
			$get_csvname = substr($get_csvname, 0, -1);
			$csv_name = $get_csvname . '.csv';
			$get_module = explode('.csv', $explode_hypen[$get_csv_name_cnt]);
			$moduleName = $get_module[0];
			$getFiles = unserialize($data->version);
			if ($getFiles) {
				$version = '';
				foreach ($getFiles as $fversion => $fileloc) {
					$get_file_name = explode('/', $fileloc);
					$cnt = (count($get_file_name)) - 1;
					for ($i = 0; $i <= $cnt; $i++) {
						if ($i == 0) {
							$versionedFile = $get_file_name[$i] . "/";
						} elseif ($i == $cnt) {
							$orig_name = $get_file_name[$i];
							$orig_name_loc = $upload_dir ['basedir'] . "/ultimate_importer/" . $orig_name;
							$gen_hash_file_name = $get_csvname . '-' . $moduleName . '-' . $fversion . '.csv';
							$hash_file_name = hash_hmac('md5', "$gen_hash_file_name", 'secret');
							$hash_name_loc = $upload_dir ['basedir'] . "/ultimate_importer/" . $hash_file_name;
							$versionedFile .= $hash_file_name;
						} else {
							$versionedFile .= $get_file_name[$i] . "/";
						}
					}
					if (file_exists($orig_name_loc)) {
						exec("cp -r $orig_name_loc $hash_name_loc");
						unlink($orig_name_loc);
					}
					$updateQuery3 = "insert into wp_ultimate_csv_importer_filemanager (sdm_id,imported_on,version_id,hash_key,status) values ($data->id, \"$data->imported_on\", $fversion, \"$hash_file_name\", 1)";
					$wpdb->query($updateQuery3);
					$version[$fversion] = $versionedFile;
				}
			}
			$get_csvname = null;
			$version = serialize($version);
			//$updateQuery1 = "update smack_dashboard_manager set csv_name = '$csv_name' where id = $data->id";
			$updateQuery2 = "update smack_dashboard_manager set version = '$version' where id = $data->id";
			//$wpdb->query($updateQuery1);
			$wpdb->query($updateQuery2);
		}
		update_option('ULTIMATE_CSV_IMPORTER_UPGRADE_VERSION', 3.5);
		// Update option to use latest csv importer
		$get_active_plugins = get_option('active_plugins');
		$pluginArr = array();
		foreach ($get_active_plugins as $plugin) {
			if ($plugin == 'wp-ultimate-csv-importer-pro/wp_ultimate_csv_importer.php') {
				$pluginArr[] = 'wp-ultimate-csv-importer-pro/index.php';
			} else {
				$pluginArr[] = $plugin;
			}
		}
		update_option('active_plugins', $pluginArr);
		return "<label class='upgrade-status-msg'>SUCCESSFULLY UPGRADED TO VERSION 3.5</label>";
	} else {
		return "<label class='upgrade-warning'>ALREADY UPGRADED TO VERSION 3.5</label>";
	}
}

?>

<html>
<head>
	<style type="text/css">
		.csv-imp-btn {
			margin-right: 10px;
			display: inline-block;
			padding: 6px 12px;
			margin-bottom: 0;
			font-size: 14px;
			font-weight: normal;
			line-height: 1.428571429;
			text-align: center;
			white-space: nowrap;
			vertical-align: middle;
			cursor: pointer;
			border: 1px solid transparent;
			border-radius: 4px;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			-o-user-select: none;
			user-select: none;
		}

		.backup-btn {
			color: #ffffff;
			background-color: #428bca;
			border-color: #357ebd;
		}

		.upgrade-btn {
			color: #ffffff;
			background-color: #f0ad4e;
			border-color: #eea236;
		}

		.upgrade-status {
			text-transform: uppercase;
			color: green;
		}

		.upgrade-warning {
			color: red;
		}

		.upgrade-status-msg {
			color: green;
		}

		.upg-label {
			cursor: pointer;
		}

		.upgradetolatest {
			height: 300px;
			border: 1px solid #F2F2F2;
			margin-left: 30%;
			margin-right: 30%;
			margin-top: 150px;
			text-align: center;
			background: #FEFEFE;
		}
	</style>
	<script>
		function check_backup_option() {
			if (document.getElementById('backup_importer_table').checked == true) {
				document.getElementById('upgrade_progress').style.display = '';
				document.getElementById('upgrade_status').innerHTML = '';
				return true;
			}
			else {
				document.getElementById('upgrade_status').style.display = 'none';
				alert('Please check "BACKUP IMPORTER TABLES" before upgrade.');
				return false;
			}
		}
	</script>
</head>
<div style="width:100%;height:auto;">
	<div algin="center" class="upgradetolatest">
		<div style="margin-top:50px;">
			<a href="http://www.smackcoders.com/" title="Smackcoders Products" class="logo"><img
					src="http://www.smackcoders.com/skin/frontend/default/megashop/images/logo.png"
					alt="Smackcoders Products"></a><br><br>
			<b>WP ULTIMATE CSV IMPORTER PRO 3.5</b>
		</div>
		<div style="margin-top:20px;">
			<form name="upgrade_to_next_version" method="post" onsubmit="return check_backup_option();">
				<label class="upg-label"><input type="checkbox" name="backup_importer_table" id="backup_importer_table"
												value="backup_importer_table"/> BACKUP IMPORTER TABLES. </label><br><br>
				<!--<input type="submit" name="back_all_importer_files" id="back_all_importer_files" value="Backup All Files" class="csv-imp-btn backup-btn"/>-->
				<input type="submit" name="upgrade_to_next_version" id="upgrade_to_next_version" value="Upgrade to V3.5"
					   class="csv-imp-btn upgrade-btn"/>
			</form>
		</div>
		<div id="upgrade_progress" style="display:none;">
			<?php echo "<label class='upgrade-status-msg'>UPGRADE IS IN PROCESS...</label>"; ?>
		</div>
		<div id="upgrade_status" style="">
			<?php
			if (isset($_POST['back_all_importer_files'])) {
				//	echo "<label>STATUS: </label><label class='upgrade-status'>" . BackupAllFileswithDB() . "</label>";
			}
			if (isset($_POST['upgrade_to_next_version'])) {
				echo "<label>STATUS: </label>" . UpgradetoThreePointFive();
			}
			?>
		</div>
	</div>
</div>

