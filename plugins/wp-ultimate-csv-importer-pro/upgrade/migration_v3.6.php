<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
?>
<div align=center style="padding-top:220px;">
	<form name="upgrade_to_latest" method="post">
		<label style="font-size:2em;" id="step1"><?php echo __('Upgrade to Latest Version 3.6',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
		<input type="submit" class="btn btn-primary btn-sm" name="upgrade" id="upgrade" value="<?php echo __('Click Here',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"/>
	</form>
	<form name="goto_plugin_page" method="post"
		  action="admin.php?page=<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/index.php&__module=settings">
		<label style="font-size:2em;display:none;" id='upgrade_state'><?php echo __('Upgrade is inprogress...',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
		<input type="submit" style="display:none;" class="btn btn-success" name="gotopluginpage" id="gotopluginpage"
			   value="<?php echo __('Goto Plugin Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"/>
	</form>
</div>
<?php
if (isset($_POST['upgrade'])) {
	?>
	<script>
		document.getElementById('step1').style.display = 'none';
		document.getElementById('upgrade').style.display = 'none';
		document.getElementById('upgrade_state').style.display = '';
		document.getElementById('gotopluginpage').style.display = '';
	</script>
	<?php
	global $wpdb;
	$month_array = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
	$check_month = mysql_query("SHOW COLUMNS FROM `smackcsv_status_log` LIKE 'month'");
	$if_column_month_exists = (mysql_num_rows($check_month)) ? TRUE : FALSE;
	if (!$if_column_month_exists) {
		$sql1 = "ALTER TABLE smackcsv_status_log ADD month VARCHAR(60) DEFAULT NULL after sdm_id;";
		$wpdb->query($sql1);
	}
	$check_year = mysql_query("SHOW COLUMNS FROM `smackcsv_status_log` LIKE 'year'");
        $if_column_year_exists = (mysql_num_rows($check_year)) ? TRUE : FALSE;
	if (!$if_column_year_exists) {
                $sql2 = "ALTER TABLE smackcsv_status_log ADD year VARCHAR(60) DEFAULT NULL after month;";
                $wpdb->query($sql2);
	}
	$check_imported_type = mysql_query("SHOW COLUMNS FROM `smackcsv_status_log` LIKE 'imported_type'");
        $if_column_importedtype_exists = (mysql_num_rows($check_imported_type)) ? TRUE : FALSE;
        if (!$if_column_importedtype_exists) {
                $sql3 = "ALTER TABLE smackcsv_status_log ADD imported_type VARCHAR(60) DEFAULT NULL after year;";
                $wpdb->query($sql3);
        }

        //Change the csvname size in dashboard manager
        $check_csvname = $wpdb->query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'csv_name'");
        if ($check_csvname !== 0) {
                $sql15 = "ALTER TABLE `smack_dashboard_manager` MODIFY `csv_name` VARCHAR(100)";
                $wpdb->query($sql15);
        }

	$get_imported_on = $wpdb->get_results("SELECT id, sdm_id, imported_on FROM smackcsv_status_log;");
	foreach($get_imported_on as $importedLogData) {
		$importedDateTime = $importedLogData->imported_on;
		$SDMID = $importedLogData->sdm_id;
		$logID = $importedLogData->id;
		$month = date("m",strtotime($importedDateTime));
		if(array_key_exists($month, $month_array)) {
			$set_month = $month_array[$month];
		}
		$set_year = date("Y",strtotime($importedDateTime));
		$updateQuery1 = "update smackcsv_status_log set month = '$set_month', year = '$set_year' where id = $logID";
		$wpdb->query($updateQuery1);
		$get_imported_as = $wpdb->get_results("SELECT imported_as FROM smack_dashboard_manager where id = $logID");
		foreach($get_imported_as as $importedAs) {
			$get_importedAs = $importedAs->imported_as;
			$updateQuery2 = "update smackcsv_status_log set imported_type = '$get_importedAs' where id = $SDMID";
			$wpdb->query($updateQuery2);
		}
	}

        $check_importbymethod = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'importbymethod'");
        $if_column_importbymethod_exists = (mysql_num_rows($check_importbymethod)) ? TRUE : FALSE;
        if (!$if_column_importedtype_exists) {
                $sql4 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD importbymethod VARCHAR(60) DEFAULT NULL after imported_as;";
                $wpdb->query($sql4);
        }
        $check_import_limit = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'import_limit'");
        $if_column_import_limit_exists = (mysql_num_rows($check_import_limit)) ? TRUE : FALSE;
        if (!$if_column_import_limit_exists) {
                $sql5 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD import_limit int(11) default 1 after importbymethod;";
                $wpdb->query($sql5);
        }
	$check_import_row_ids = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'import_row_ids'");
	$if_column_import_row_ids_exists = (mysql_num_rows($check_import_row_ids)) ? TRUE : FALSE;
	if (!$if_column_import_row_ids_exists) {
		$sql6 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD import_row_ids blob default NULL after import_limit;";
		$wpdb->query($sql6);
	}
	$check_frequency = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'frequency'");
	$if_column_frequency_exists = (mysql_num_rows($column_frequency)) ? TRUE : FALSE;
	if (!$if_column_frequency_exists) {
		$sql7 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD frequency int(5) default 0 after import_row_ids;";
		$wpdb->query($sql7);
	}
	$check_start_limit = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'start_limit'");
	$if_column_start_limit_exists = (mysql_num_rows($check_start_limit)) ? TRUE : FALSE;
	if(!$if_column_start_limit_exists) {
		$sql8 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD start_limit int(11) default 0;";
		$wpdb->query($sql8);
	}
	$check_end_limit = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'end_limit'");
	$if_column_end_limit_exists = (mysql_num_rows($check_end_limit)) ? TRUE : FALSE;
	if(!$if_column_end_limit_exists) {
		$sql9 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD end_limit int(11) default 0;";
		$wpdb->query($sql9);
	}
	$check_lastrun = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'lastrun'");
	$if_column_lastrun_exists = (mysql_num_rows($check_lastrun)) ? TRUE : FALSE;
	if(!$if_column_lastrun_exists) {
		$sql10 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD lastrun datetime default '0000-00-00 00:00:00';";
		$wpdb->query($sql10);
	}
	$check_nextrun = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'nexrun'");
	$if_column_nextrun_exists = (mysql_num_rows($check_nextrun)) ? TRUE : FALSE;
	if(!$if_column_nextrun_exists) {
		$sql11 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD nexrun datetime default '0000-00-00 00:00:00';";
		$wpdb->query($sql11);
	}
	$check_scheduled_by_user = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'scheduled_by_user'");
	$if_column_scheduled_by_user_exists = (mysql_num_rows($check_scheduled_by_user)) ? TRUE : FALSE;
	if(!$if_column_scheduled_by_user_exists) {
		$add_column_scheduled_by_user = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD scheduled_by_user varchar(10) DEFAULT '1';";
		$wpdb->query($add_column_scheduled_by_user);
	}
        $check_cron_status = mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'cron_status'");
        $if_column_cron_status_exists = (mysql_num_rows($check_cron_status)) ? TRUE : FALSE;
        if(!$if_column_cron_status_exists) {
                $add_column_cron_status = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD `cron_status` varchar(15) DEFAULT NULL;";
                $wpdb->query($add_column_cron_status);
        }
        $check_blog = mysql_query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'blog'");
        $if_column_exists = (mysql_num_rows($check_blog)) ? TRUE : FALSE;
        if (!$if_column_exists) {
                $sql12 = "ALTER TABLE smack_dashboard_manager ADD blog VARCHAR(60) DEFAULT 1;";
                $wpdb->query($sql12);
        }
        $check_import_type = $wpdb->get_results("select *from `smack_csv_dashboard` where type = 'marketpress-product';");
        if (count($check_import_type) == 0) {
                $sql13 = "insert into smack_csv_dashboard (type,value) values('marketpress-product',0);";
                $wpdb->query($sql13);
        }

	$check_table1 = 'wp_ultimate_csv_importer_external_file_schedules';
	$check_table2 = 'wp_ultimate_csv_importer_uploaded_file_schedules';
	$check_table3 = 'wp_ultimate_csv_importer_ftp_schedules';
        $check_table4 = 'wp_ultimate_csv_importer_multisite_details';
	if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table1 . "'")) != 1) {
		$create_external_file_schedules = "CREATE TABLE `$check_table1` (
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`schedule_id` int(10) NOT NULL,
			`file_url` varchar(255) DEFAULT NULL,
			`filename` varchar(255) DEFAULT NULL,
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB";
		$wpdb->query($create_external_file_schedules);
	}
	if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table2 . "'")) != 1) {
		$create_uploaded_file_schedules = "CREATE TABLE `$check_table2` (
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`schedule_id` int(10) NOT NULL,
			`file_path` varchar(120) DEFAULT NULL,
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1";
		$wpdb->query($create_uploaded_file_schedules);
	}
	if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table3 . "'")) != 1) {
		$create_ftp_schedules = "CREATE TABLE `$check_table3` (
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`schedule_id` int(10) NOT NULL,
			`hostname` varchar(110) DEFAULT NULL,
			`username` varchar(110) DEFAULT NULL,
			`password` varchar(110) DEFAULT NULL,
			`initial_path` varchar(225) DEFAULT NULL,
			`filename` varchar(110) DEFAULT NULL,
			`port_no` int(5) DEFAULT '22',
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB";
		$wpdb->query($create_ftp_schedules);
	}
        if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table4 . "'")) != 1) {
                $create_table_for_multisite_details = "CREATE TABLE `wp_ultimate_csv_importer_multisite_details` (
                                `id` int(11) NOT NULL AUTO_INCREMENT,
                                `sdm_id` int(11) NOT NULL,
                                `blog_id` int(11) NOT NULL,
                                `version_id` int(11) NOT NULL,
                                `user_id` int(11) NOT NULL,
                                PRIMARY KEY (`id`)
                                        ) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_multisite_details);
                $get_userID = $wpdb->get_results("SELECT $wpdb->users.ID FROM $wpdb->users WHERE (SELECT $wpdb->usermeta.meta_value FROM $wpdb->usermeta WHERE $wpdb->usermeta.user_id = $wpdb->users.ID AND $wpdb->usermeta.meta_key = 'wp_user_level') >= 8;");
                $userID = $get_userID[0]->ID;
                $get_all_manager_records = $wpdb->get_results("select *from smack_dashboard_manager;");
                foreach ($get_all_manager_records as $Key => $Values) {
                        $managerID = $Values->id;
                        $get_all_versions = unserialize($Values->version);
                        foreach ($get_all_versions as $versionID => $versionedFiles) {
                                $sql14 = "insert into wp_ultimate_csv_importer_multisite_details (sdm_id,blog_id,version_id,user_id) values ($managerID,1,$versionID,$userID);";
                                $wpdb->query($sql14);
                        }
                }
        }

	update_option('ULTIMATE_CSV_IMP_VERSION', '3.6');
	update_option('ULTIMATE_CSV_IMPORTER_UPGRADE_VERSION', '3.6');
	?>
	<script>
		document.getElementById('upgrade_state').innerHTML = 'Upgrade Completed! ';
	</script>
<?php
}
?>
