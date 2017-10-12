<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

global $wpdb;
$mapping_tablename = WP_CONST_ULTIMATE_CSV_IMP_MAPPING_TEMPLATE;
$schedule_tablename = WP_CONST_ULTIMATE_CSV_IMP_SCHEDULED_IMPORT;
$ftp_file_detail_tablename = WP_CONST_ULTIMATE_CSV_IMP_FTP_FILE_DETAILS;
$ext_file_detail_tablename = WP_CONST_ULTIMATE_CSV_IMP_EXT_FILE_DETAILS;
$upload_file_schedule_tablename = WP_CONST_ULTIMATE_CSV_IMP_UPLOAD_FILE_SCHEDULES;

$run_mysql_query1 = "CREATE TABLE IF NOT EXISTS `smackcsv_status_log` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`sdm_id` int(11) NOT NULL,
	`month` varchar(60) DEFAULT NULL,
	`year` varchar(60) DEFAULT NULL,
	`imported_type` varchar(60) DEFAULT NULL,
	`imported_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`inserted` int(11) DEFAULT NULL,
	`skipped` int(11) DEFAULT NULL,
	`updated` int(11) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB;";

$run_mysql_query2 ="CREATE TABLE IF NOT EXISTS `smack_dashboard_manager` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`csv_name` varchar(100) NOT NULL,
	`created_records` longtext NOT NULL,
	`imported_as` varchar(20) NOT NULL,
	`imported_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`keyword` varchar(100) DEFAULT NULL,
	`version` longtext NOT NULL,
	`status` longtext NOT NULL,
	`trashed` int(11) DEFAULT NULL,
	`blog` varchar(10) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB;";

$run_mysql_query3 ="CREATE TABLE IF NOT EXISTS `smack_csv_dashboard` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(255) DEFAULT NULL,
	`value` int(11) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB;";

$run_mysql_query4 ="CREATE TABLE IF NOT EXISTS `$mapping_tablename` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`templatename` varchar(100) NOT NULL,
	`mapping` blob NOT NULL,
	`createdtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`deleted` int(1) DEFAULT '0',
	`templateused` int(10) DEFAULT '0',
	`module` varchar(50) DEFAULT NULL,
	`csvname` varchar(50) DEFAULT NULL,
	`eventKey` varchar(60) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$run_mysql_query5 ="CREATE TABLE IF NOT EXISTS `$schedule_tablename` (
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
	`importbymethod` varchar(60) DEFAULT NULL,
	`import_limit` int(11) DEFAULT '1',
	`import_row_ids` blob default NULL,
	`frequency` int(5) DEFAULT '0',
	`start_limit` int(11) DEFAULT '0',
	`end_limit` int(11) DEFAULT '0',
	`lastrun` datetime DEFAULT '0000-00-00 00:00:00',
	`nexrun` datetime DEFAULT '0000-00-00 00:00:00',
	`scheduled_by_user` varchar(10) DEFAULT '1',
	`cron_status` varchar(15) DEFAULT NULL,
        `import_mode` varchar(100) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$run_mysql_query6 ="CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_filemanager` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`sdm_id` int(11) NOT NULL,
	`imported_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`version_id` int(11) DEFAULT NULL,
	`hash_key` varchar(60) DEFAULT NULL,
	`status` int(11) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB;";

$run_mysql_query7 ="CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_multisite_details` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`sdm_id` int(11) NOT NULL,
	`blog_id` int(11) NOT NULL,
	`version_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$run_mysql_query8 = "CREATE TABLE IF NOT EXISTS `$upload_file_schedule_tablename` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`schedule_id` int(10) NOT NULL,
	`file_path` varchar(120) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$run_mysql_query9 = "CREATE TABLE IF NOT EXISTS `$ext_file_detail_tablename` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`schedule_id` int(10) NOT NULL,
	`file_url` varchar(255) DEFAULT NULL,
	`filename` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB";

$run_mysql_query10 = "CREATE TABLE IF NOT EXISTS `$ftp_file_detail_tablename` (
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

$run_mysql_query11 = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_manageshortcodes` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`pID` int(20) DEFAULT NULL,
	`shortcode` varchar(110) DEFAULT NULL,
	`eventkey` varchar(60) DEFAULT NULL,
	`mode_of_code` varchar(20) DEFAULT NULL,
	`module` varchar(20) DEFAULT NULL,
	`populate_status` int(5) DEFAULT '1',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB";

$run_mysql_query12 = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_shortcodes_statusrel` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`eventkey` varchar(60) DEFAULT NULL,
	`shortcodes_count` int(20) DEFAULT NULL,
	`shortcode_mode` varchar(20) DEFAULT NULL,
	`current_status` varchar(20) DEFAULT 'Pending',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB";

$run_mysql_query13 = "CREATE TABLE IF NOT EXISTS  `wp_ultimate_csv_importer_log_values` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
	  `eventKey` varchar(50) NOT NULL,
	  `recordId` int(10) NOT NULL,
	  `module` varchar(50) NOT NULL,
	  `method_of_import` varchar(50) NOT NULL,
	  `log_message` blob NOT NULL,
	  `imported_time` varchar(100) NOT NULL,
	  `mode_of_import` varchar(100) NOT NULL,
	  `sequence` varchar(100) NOT NULL,
	  `status` varchar(100) NOT NULL,
	  `assigned_user_id` int(10) NOT NULL,
	  `imported_by` int(100) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB";

$run_mysql_query14 = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_eventkey_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventKey` varchar(60) DEFAULT NULL,
  `versioned_csv_name` varchar(60) DEFAULT NULL,
  `status` int(5) DEFAULT '1',
  `manager_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB";

$run_mysql_query15 = "CREATE TABLE  IF NOT EXISTS `wp_ultimate_csv_importer_exclusion_lists` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `eventKey` varchar(100) NOT NULL,
  `templateId` varchar(100) NOT NULL,
  `exclusionLists` blob NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB";

$run_mysql_query16 = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_acf_fields` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `groupId` varchar(100) NOT NULL,
        `fieldId` varchar(100) NOT NULL,
        `fieldLabel` varchar(100) NOT NULL,
        `fieldName` varchar(100) NOT NULL,
        `fieldType` varchar(60) NOT NULL,
        `fdOption` varchar(100) DEFAULT NULL,
        PRIMARY KEY (`id`)
) ENGINE=InnoDB";

$run_mysql_query17 = "CREATE TABLE IF NOT EXISTS `smack_field_types` (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `choices` varchar(160) NOT NULL,
        `fieldType` varchar(100) NOT NULL,
        `groupType` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
) ENGINE=InnoDB";

$wpdb->query($run_mysql_query1);
$wpdb->query($run_mysql_query2);
$wpdb->query($run_mysql_query3);
$wpdb->query($run_mysql_query4);
$wpdb->query($run_mysql_query5);
$wpdb->query($run_mysql_query6);
$wpdb->query($run_mysql_query7);
$wpdb->query($run_mysql_query8);
$wpdb->query($run_mysql_query9);
$wpdb->query($run_mysql_query10);
$wpdb->query($run_mysql_query11);
$wpdb->query($run_mysql_query12);
$wpdb->query($run_mysql_query13);
$wpdb->query($run_mysql_query14);
$wpdb->query($run_mysql_query15);
$wpdb->query($run_mysql_query16);
$wpdb->query($run_mysql_query17);

$acf_choices = array('Basic'=>array('Text','Text Area','Number','Email','Url','Password'),
                     'Content'=>array('Wysiwyg Editor','oEmbed','Image','File','Gallery'),
                     'Choice'=>array('Select','Checkbox','Radio Button','True/False'),
                     'Relational'=>array('Post Object','Page Link','Relationship','Taxonomy','User'),
                     'jQuery'=>array('Google Map','Date Picker','Color picker'),
                     'Layout'=>array('Message','Tab','Repeater','Flexible Content'));
foreach($acf_choices as $key=>$val){
        $val = serialize($val);
        $sql = "insert into smack_field_types(choices,fieldType,groupType)select * from (select '$val','$key','acf-field-type')as tmp where not exists(select groupType from smack_field_types where groupType = 'acf-field-type' and fieldType = '$key')";
        $wpdb->query($sql);
}

$pods_choices = array('Text' => array('Plain Text','Website','Phone','Email','Password'),
		      'Paragraph' => array('Plain Paragraph Text','WYSIWYG (Visual Editor)','Code (Syntax Highlighting)'),
		      'Date/Time' => array('Date/Time','Date','Time'),
		      'Number' => array('Plain Number','Currency'),
		      'Relationships/Media' => array('File/Image/Video','Relationship'),
		      'Other' => array('Yes/No','Color Picker'));
foreach($pods_choices as $key=>$val){
	$val = serialize($val);
	$sql = "insert into smack_field_types(choices,fieldType,groupType)select * from (select '$val','$key','pods-field-type')as tmp where not exists(select groupType from smack_field_types where groupType = 'pods-field-type' and fieldType = '$key')";
	$wpdb->query($sql); 
}

$types_choices = array('Text'=> array('Textfield','Textarea','Numeric','Phone','Email','Url'),
		       'Content' => array('Wysiwyg','Embed','Image','File','Video','Skype'),
		       'Choice' => array('Select','Checkbox','Checkboxes','Radio'),
		       'jQuery' => array('Colorpicker','Date'));
foreach($types_choices as $key=>$val){
        $val = serialize($val);
        $sql = "insert into smack_field_types(choices,fieldType,groupType)select * from (select '$val','$key','types-field-type')as tmp where not exists(select groupType from smack_field_types where groupType = 'types-field-type' and fieldType = '$key')";
        $wpdb->query($sql);
}


$importedTypes = array('Post', 'Comments', 'Category', 'Tags', 'wpsc-product', 'Users', 'eshop-product', 'Custom Taxonomy', 'Custom Post', 'Page', 'woocommerce-product', 'marketpress-product', 'Customer-Reviews');
foreach ($importedTypes as $importedType) {
	$querycheck = $wpdb->get_results("select *from smack_csv_dashboard where type = \"{$importedType}\"");
	if (count($querycheck) == 0) {
		$sql4 = "insert into smack_csv_dashboard (type,value) values(\"$importedType\",0)";
		$wpdb->query($sql4);
	}
}

update_option('ULTIMATE_CSV_IMP_VERSION', '4.3.0');
update_option('ULTIMATE_CSV_IMPORTER_UPGRADE_VERSION', '4.3.0');
$get_result = array();
$get_status = array();
$get_result['cctmcustompost'] = getpluginstatus('custom-content-type-manager/index.php');
$get_result['cptuicustompost'] = getpluginstatus('custom-post-type-ui/custom-post-type-ui.php');
$get_result['typescustompost'] = getpluginstatus('types/wpcf.php');
$get_result['podscustompost'] = getpluginstatus('pods/init.php');
$get_result['rwpmembers'] = getpluginstatus('wp-members/wp-members.php');
$get_result['wpcustomfields'] = getpluginstatus('wp-e-commerce-custom-fields/custom-fields.php');
$get_result['cctmcustomfield'] = getpluginstatus('custom-content-type-manager/index.php');
$get_result['typescustomfield'] = getpluginstatus('types/wpcf.php');
$get_result['podscustomfield'] = getpluginstatus('pods/init.php');
$get_result['acfcustomfield'] = getpluginstatus('ACF');
$get_result['rcustomerreviews'] = getpluginstatus('wp-customer-reviews/wp-customer-reviews.php');
$get_result['rcateicons'] =    getpluginstatus('category-icons/category_icons.php');
$get_result['recomm-eshop'] = getpluginstatus('eshop');
$get_result['recomm-woocommerce'] = getpluginstatus('woocommerce');
$get_result['recomm-wpcommerce'] = getpluginstatus('wpcommerce');
$get_result['recomm-marketpress'] = getpluginstatus('marketpress');	
$get_result['rseo-aioseo'] =   getpluginstatus('aioseo');
$get_result['rseo-yoastseo'] =  getpluginstatus('yoastseo');
if($get_result['cctmcustompost'] == 'pluginActive'){
	$get_status['cctmcustompost'] = 'enable';
}
if($get_result['cptuicustompost'] == 'pluginActive'){	
	$get_status['cptuicustompost'] = 'enable';
}
if($get_result['typescustompost'] == 'pluginActive'){
	$get_status['typescustompost'] = 'enable';
}
if($get_result['podscustompost'] == 'pluginActive'){
	$get_status['podscustompost'] = 'enable';
}
if($get_result['rwpmembers'] == 'pluginActive'){
	$get_status['rwpmembers'] = 'enable';
}
if($get_result['wpcustomfields'] == 'pluginActive'){
	$get_status['wpcustomfields'] = 'enable';
}
if($get_result['cctmcustomfield'] == 'pluginActive'){
	$get_status['cctmcustomfield'] = 'enable';
}
if($get_result['typescustomfield'] == 'pluginActive'){
	$get_status['typescustomfield'] = 'enable';
}
if($get_result['podscustomfield'] == 'pluginActive'){
	$get_status['podscustomfield'] = 'enable';
}
if($get_result['acfcustomfield'] == 'pluginActive'){
	$get_status['acfcustomfield'] = 'enable';
}
if($get_result['rcustomerreviews'] == 'pluginActive'){
       $get_status['rcustomerreviews'] = 'enable';
}
if($get_result['rcateicons'] == 'pluginActive'){
        $get_status['rcateicons'] = 'enable';
}
if($get_result['recomm-eshop'] == 'pluginActive'){
	$get_status['recommerce'] = 'eshop';
}
if($get_result['recomm-woocommerce'] == 'pluginActive'){
	$get_status['recommerce'] = 'woocommerce';
}
if($get_result['recomm-wpcommerce'] == 'pluginActive'){
	$get_status['recommerce'] = 'wpcommerce';
}
if($get_result['recomm-marketpress'] == 'pluginActive'){
	$get_status['recommerce'] = 'marketpress';
}
if($get_result['rseo-aioseo'] == 'pluginActive'){
	$get_status['rseooption'] = 'aioseo';
}
if($get_result['rseo-yoastseo'] == 'pluginActive'){
	$get_status['rseooption'] = 'yoastseo';
}		
function getpluginstatus($plugin) {
	$state = 'pluginAbsent';
	if (PluginPresent($plugin)) {
		$state = 'pluginPresent';
	}
	if (PluginActive($plugin)) {
		$state = 'pluginActive';
	}
	return $state;
}
function PluginPresent($plugin) {
	$pluginName = array();
	$plugins = get_plugins();
	foreach ($plugins as $plug => $key) {
		$pluginName[] = $plug;
	}
	if (in_array($plugin, $pluginName)) {
		return true;
	} else {
		if($plugin == 'ACF' && (in_array('advanced-custom-fields/acf.php', $pluginName) || in_array('advanced-custom-fields-pro/acf.php', $pluginName))) {
			return true;
		}
		if($plugin == 'eshop' && in_array('eshop/eshop.php', $pluginName)){
			return true;
		}
		if($plugin == 'woocommerce' && in_array('woocommerce/woocommerce.php' ,$pluginName)){
			return true;	
		}
		if($plugin == 'wpcommerce' && in_array('wp-e-commerce/wp-shopping-cart.php' ,$pluginName)){
			return true;
		}
		if($plugin == 'marketpress' && in_array('wordpress-ecommerce/marketpress.php' ,$pluginName)){
			return true;
		}
		if($plugin == 'aioseo' && in_array('all-in-one-seo-pack/all_in_one_seo_pack.php' ,$pluginName)){
			return true;
		}
		if($plugin == 'yoastseo' && in_array('wordpress-seo/wp-seo.php' ,$pluginName)){
			return true;
		}

		return false;
	}
}
function PluginActive($plugin) {
	$activeplug = array();
	$activeplug = get_option('active_plugins');
	//echo '<pre>'; print_r( $activeplug); echo '</pre>';die('jj');
	if (in_array($plugin, $activeplug)) {
		return true;
	} else {
		if($plugin == 'ACF' && (in_array('advanced-custom-fields/acf.php', $activeplug) || in_array('advanced-custom-fields-pro/acf.php', $activeplug))) {
			return true;
		}
		if($plugin == 'eshop' && in_array('eshop/eshop.php', $activeplug)){
			return true;
		}
		if($plugin == 'woocommerce' && in_array('woocommerce/woocommerce.php' ,$activeplug)){
			return true;
		}
		if($plugin == 'wpcommerce' && in_array('wp-e-commerce/wp-shopping-cart.php' ,$activeplug)){
			return true;
		}
		if($plugin == 'marketpress' && in_array('wordpress-ecommerce/marketpress.php' ,$activeplug)){
			return true;
		}
		if($plugin == 'aioseo' && in_array('all-in-one-seo-pack/all_in_one_seo_pack.php' ,$activeplug)){
			return true;
		}
		if($plugin == 'yoastseo' && in_array('wordpress-seo/wp-seo.php' ,$activeplug)){
			return true;
		}

		return false;
	}
}
//echo '<pre>'; print_r( $get_status); echo '</pre>';die('jj');
$settingstable = get_option('wpcsvprosettings');
if ($settingstable == '') {
	$options = Array('automapping' => 'automapping', 'recommerce' => 'nonerecommerce', 'rutfsupport' => 'utfsupport', 'rcustompost' => 'nonercustompost', 'savesettings' => 'Save', 'rseooption' => 'nonerseooption', 'rcateicons' => 'disable','drop_table' => 'off', 'send_log_email' => 'none', 'debug_mode' => 'enable', 'post' => 'enable', 'page_module' => 'enable', 'custompost' => 'enable',);
	update_option('wpcsvprosettings', $options);
}
$existing_enabled_pluginlist = get_option('wpcsvprosettings');
foreach($existing_enabled_pluginlist as $existing_option_key => $existing_option_value) {
	$updated_list[$existing_option_key] = $existing_option_value;
}
foreach($get_status as $new_activelist_key => $new_activelist_value) {
	$updated_list[$new_activelist_key] = $new_activelist_value;
#	update_option('wpcsvprosettings', $get_status);
}
update_option('wpcsvprosettings', $updated_list);
# cron
wp_schedule_event(time(), 'wp_ultimate_csv_importer_ten_minute_cron', 'wordpress_ultimate_csv_importer_scheduler_run');
