<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
?>
<div align=center style="padding-top:220px;">
	<form name="upgrade_to_latest" method="post">
		<label style="font-size:2em;" id="step1"><?php echo __('Upgrade to Latest Version 3.5.3',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
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

        //Change the csvname size in dashboard manager
        $check_csvname = $wpdb->query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'csv_name'");
        if ($check_csvname !== 0) {
                $sql4 = "ALTER TABLE `smack_dashboard_manager` MODIFY `csv_name` VARCHAR(100)";
                $wpdb->query($sql4);
        }

	$check_blog = mysql_query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'blog'");
	$if_column_exists = (mysql_num_rows($check_blog)) ? TRUE : FALSE;
	if (!$if_column_exists) {
		$sql1 = "ALTER TABLE smack_dashboard_manager ADD blog VARCHAR(60) DEFAULT 1;";
		$wpdb->query($sql1);
	}
	$check_import_type = $wpdb->get_results("select *from `smack_csv_dashboard` where type = 'marketpress-product';");
	if (count($check_import_type) == 0) {
		$sql2 = "insert into smack_csv_dashboard (type,value) values('marketpress-product',0);";
		$wpdb->query($sql2);
	}
	$check_table1 = 'wp_ultimate_csv_importer_multisite_details';
	if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table1 . "'")) != 1) {
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
				$sql3 = "insert into wp_ultimate_csv_importer_multisite_details (sdm_id,blog_id,version_id,user_id) values ($managerID,1,$versionID,$userID);";
				$wpdb->query($sql3);
			}
		}
	}
	update_option('ULTIMATE_CSV_IMP_VERSION', '3.5.3');
	update_option('ULTIMATE_CSV_IMPORTER_UPGRADE_VERSION', '3.5.3');
	?>
	<script>
		document.getElementById('upgrade_state').innerHTML = 'Upgrade Completed! ';
	</script>
<?php
}
?>
