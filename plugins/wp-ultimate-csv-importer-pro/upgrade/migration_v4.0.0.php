<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
?>
<div align=center style="padding-top:220px;">
	<form name="upgrade_to_latest" method="post">
               <div style ='text-align:center;margin:0;color:red;font-size:smaller;'> <?php echo __('Warning: This is 4.0 version, dont try in live instance and take proper backup to proceed upgrading.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>
		<label style="font-size:2em;" id="step1"><?php echo __('Upgrade to Latest Version 4.0'); ?></label>
		<input type="submit" class="btn btn-primary btn-sm" name="upgrade" id="upgrade" value="<?php echo __('Click Here',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"/>
	</form>
	<form name="goto_plugin_page" method="post" action="admin.php?page=<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/index.php&__module=settings">
		<label style="font-size:2em;display:none;" id='upgrade_state'><?php echo __('Upgrade is inprogress...',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
		<input type="submit" style="display:none;" class="btn btn-success" name="gotopluginpage" id="gotopluginpage" value="<?php echo __('Goto Plugin Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"/>
	</form>
</div>
<?php if (isset($_POST['upgrade'])) { ?>
	<script>
		document.getElementById('step1').style.display = 'none';
		document.getElementById('upgrade').style.display = 'none';
		document.getElementById('upgrade_state').style.display = '';
		document.getElementById('gotopluginpage').style.display = '';
	</script>
	<?php
	global $wpdb;print_r('old');die();
	//settings
	$data = array();
	$old_settings = get_option('wpcsvprosettings');
       	if(array_key_exists('automapping',$old_settings))
               	$data['automapping'] = 'automapping';
       	if(array_key_exists('rcateicons',$old_settings)) 
                $data['rcateicons'] = $old_settings['rcateicons'];
       	if(array_key_exists('rutfsupport',$old_settings))
               	$data['rutfsupport'] = 'rutfsupport';
       	if(array_key_exists('utfsupport',$old_settings))
                $data['utfsupport'] = 'utfsupport';
       	if(array_key_exists('savesettings',$old_settings))
                $data['savesettings'] = 'Save';
       	if(array_key_exists('post',$old_settings))
                $data['post'] = 'enable';
       	if(array_key_exists('page_module',$old_settings))
                $data['page_module'] = 'enable';
       	if(array_key_exists('users',$old_settings))
                $data['users'] = 'enable';
       	if(array_key_exists('comments',$old_settings))
                $data['comments'] = 'enable';
       	if(array_key_exists('custompost',$old_settings))
                $data['custompost'] = 'enable';
       	if(array_key_exists('customtaxonomy',$old_settings))
                $data['customtaxonomy'] = 'enable';
       	if(array_key_exists('categories',$old_settings))
                $data['categories'] = 'enable';
       	if(array_key_exists('rcustomerreviews',$old_settings))
                $data['rcustomerreviews'] = 'enable';
       	if(array_key_exists('rseooption',$old_settings)) 
                $data['rseooption'] = $old_settings['rseooption'];
       	if(array_key_exists('drop_table',$old_settings))
                $data['drop_table'] = $old_settings['drop_table'];
       	if(array_key_exists('debug_mode',$old_settings))
                $data['debug_mode'] = $old_settings['debug_mode'];
	if(array_key_exists('rcustompost', $old_settings)) {
               	if(isset($old_settings['rcustompost']) && $old_settings['rcustompost'] == 'wptypes')
                       	$data['typescustompost'] = 'enable';
               	if(isset($old_settings['rcustompost']) && $old_settings['rcustompost'] == 'cctm')
                        $data['cctmcustompost'] = 'enable';
               	if(isset($old_settings['rcustompost']) && $old_settings['rcustompost'] == 'podspost')
                        $data['podscustompost'] = 'enable';
               	if(isset($old_settings['rcustompost']) && $old_settings['rcustompost'] == 'custompostuitype')
                        $data['cptuicustompost'] = 'enable';   
       	}
       	if(array_key_exists('rcustomfield', $old_settings)) {
               	if(isset($old_settings['rcustomfield']) && $old_settings['rcustomfield'] == 'acf')
                       	$data['acfcustomfield'] = 'enable';
               	if(isset($old_settings['rcustomfield']) && $old_settings['rcustomfield'] == 'cctmcustfields')    
                        $data['cctmcustomfield'] = 'enable';
               	if(isset($old_settings['rcustomfield']) && $old_settings['rcustomfield'] == 'wptypescustfields')
                        $data['typescustomfield'] = 'enable';
               	if(isset($old_settings['rcustomfield']) && $old_settings['rcustomfield'] == 'podscustomfields')
                        $data['podscustomfield'] = 'enable';
       	}
       	if(array_key_exists('rwpmembers',$old_settings))
                $data['rwpmembers'] = 'enable';
       	if(array_key_exists('recommerce',$old_settings))
                $data['recommerce'] = $old_settings['recommerce'];
       	if(isset($old_settings['rcustomfield']) && $old_settings['rcustomfield'] == 'send_log_email')    
               	$data['send_log_email'] = 'enable';
       	if(isset($old_settings['woocomattr']) && $old_settings['woocomattr'] == 'on')
                $data['woocomattr'] = 'enable';
       	if(array_key_exists('wpcustomfields',$old_settings)) {
               	if(isset($old_settings['wpcustomfields']) && ($old_settings['wpcustomfields'] == 'on'))
                       	$data['wpcustomfields'] = 'enable';
       	}
       	delete_option('wpcsvprosettings');
       	update_option('wpcsvprosettings', $data);

	// Creating new tables for this beta release
        $check_table1 = 'wp_ultimate_csv_importer_eventkey_manager';
        if (@mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table1 . "'")) != 1) {
		$create_table_for_eventkey_manager = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_eventkey_manager` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`eventKey` varchar(60) DEFAULT NULL,
			`versioned_csv_name` varchar(60) DEFAULT NULL,
			`status` int(5) DEFAULT '1',
			`manager_id` int(10) NOT NULL,
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_eventkey_manager);
	}
	$check_table2 = 'wp_ultimate_csv_importer_exclusion_lists';
	if (@mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table2 . "'")) != 1) {
		$create_table_for_exclusion_lists = "CREATE TABLE  IF NOT EXISTS `wp_ultimate_csv_importer_exclusion_lists` (
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`eventKey` varchar(100) NOT NULL,
			`templateId` varchar(100) NOT NULL,
			`exclusionLists` blob NOT NULL,
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_exclusion_lists);
        }
        $check_table3 = 'wp_ultimate_csv_importer_log_values';
        if (@mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table3 . "'")) != 1) {
		$create_table_for_log_values = "CREATE TABLE IF NOT EXISTS  `wp_ultimate_csv_importer_log_values` (
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
				) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_log_values);
        }
        $check_table4 = 'wp_ultimate_csv_importer_manageshortcodes';
        if (@mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table4 . "'")) != 1) {
		$create_table_for_manageshortcodes = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_manageshortcodes` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`pID` int(20) DEFAULT NULL,
			`shortcode` varchar(30) DEFAULT NULL,
			`eventkey` varchar(60) DEFAULT NULL,
			`mode_of_code` varchar(20) DEFAULT NULL,
			`module` varchar(20) DEFAULT NULL,
			`populate_status` int(5) DEFAULT '1',
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_manageshortcodes);
        }
        $check_table5 = 'wp_ultimate_csv_importer_shortcodes_statusrel';
        if (@mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $check_table5 . "'")) != 1) {
		$create_table_for_shortcodes_statusrel = "CREATE TABLE IF NOT EXISTS `wp_ultimate_csv_importer_shortcodes_statusrel` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`eventkey` varchar(60) DEFAULT NULL,
			`shortcodes_count` int(20) DEFAULT NULL,
			`shortcode_mode` varchar(20) DEFAULT NULL,
			`current_status` varchar(20) DEFAULT 'Pending',
			PRIMARY KEY (`id`)
				) ENGINE=InnoDB;";
                $wpdb->query($create_table_for_shortcodes_statusrel);
        }

	// Generate data for eventkey manager
	$get_results = $wpdb->get_results('select *from smack_dashboard_manager');
	if(!empty($get_results)) {
		$all_versions = array();
		foreach($get_results as $key => $val) {
			$sdm_id = $val->id;
			$csv_name = explode('.csv', $val->csv_name);
			$all_versions = unserialize($val->version);
			foreach($all_versions as $version_key => $version_file) {
				$versioned_file_name = $csv_name[0] . '-' . $version_key . '.csv';
				$hashKey = hash_hmac('md5', "$versioned_file_name", 'secret');
				$wpdb->insert('wp_ultimate_csv_importer_eventkey_manager', array('eventKey' => $hashKey, 'versioned_csv_name' => $versioned_file_name, 'manager_id' => $sdm_id));
			}
		}
	}

	// Altering tables to migrate 

	// Drop column in mapping template manager
	$check_delimiter = @mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_mappingtemplate` LIKE 'delimiter'");
	$if_column_exists = (@mysql_num_rows($check_delimiter)) ? TRUE : FALSE;
	if ($if_column_exists) {
		$sql1 = "ALTER TABLE `wp_ultimate_csv_importer_mappingtemplate` DROP COLUMN delimiter";
		$wpdb->query($sql1);
	}

	// Add csv name in mapping template manager 
	$check_csvname = @mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_mappingtemplate` LIKE 'csvname'");
	$if_column_exists = (@mysql_num_rows($check_csvname)) ? TRUE : FALSE;
	if (!$if_column_exists) {
		$sql2 = "ALTER TABLE wp_ultimate_csv_importer_mappingtemplate ADD `csvname` varchar(50) DEFAULT NULL;";
		$wpdb->query($sql2);
	}

	// Add evenkey in mapping template manager
	$check_eventKey = @mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_mappingtemplate` LIKE 'eventKey'");
	$if_column_exists = (@mysql_num_rows($check_eventKey)) ? TRUE : FALSE;
	if (!$if_column_exists) {
                $sql3 = "ALTER TABLE wp_ultimate_csv_importer_mappingtemplate ADD `eventKey` VARCHAR(60) DEFAULT NULL;";
                $wpdb->query($sql3);
	}

	// Add import mode in smart schedule manager
	$check_import_mode = @mysql_query("SHOW COLUMNS FROM `wp_ultimate_csv_importer_scheduled_import` LIKE 'import_mode'");
        $if_column_exists = (@mysql_num_rows($check_eventKey)) ? TRUE : FALSE;
        if (!$if_column_exists) {
                $sql4 = "ALTER TABLE wp_ultimate_csv_importer_scheduled_import ADD `import_mode` VARCHAR(100) DEFAULT NULL;";
                $wpdb->query($sql4);
        } 

        //Change the csvname size in dashboard manager
        $check_csvname = $wpdb->query("SHOW COLUMNS FROM `smack_dashboard_manager` LIKE 'csv_name'");
        if ($check_csvname !== 0) {
                $sql6 = "ALTER TABLE `smack_dashboard_manager` MODIFY `csv_name` VARCHAR(100)";
                $wpdb->query($sql6);
        }

	// Converting template process to new grouping concept
	$get_mapping_template_details = $wpdb->get_results("select *from wp_ultimate_csv_importer_mappingtemplate"); 
	if (file_exists(WP_CONST_ULTIMATE_CSV_IMP_DIRECTORY . 'plugins/class.classifyfields.php')) {
		require_once(WP_CONST_ULTIMATE_CSV_IMP_DIRECTORY . 'plugins/class.classifyfields.php');
	} 
	$classifyObj = new WPClassifyFields;
	foreach ($get_mapping_template_details as $key => $val) {
		$template_id = $val->id;
		$module = $val->module;
		$new_mapping = $mapped_values = array();
		$mapped_values = unserialize($val->mapping);
		$get_available_groups = $classifyObj->get_availgroups($module);
		$get_corefields = $classifyObj->WPCoreFields($module);
		$get_core_custfields = $classifyObj->commonMetaFields();
		$get_pods_custfields = $classifyObj->PODSCustomFields();
		$get_cctm_custfields = $classifyObj->CCTMCustomFields();
		$get_types_custfields = $classifyObj->TypesCustomFields();
		$get_acf_custfields = $classifyObj->ACFCustomFields();
		$get_aioseo_fields = $classifyObj->aioseoFields();
		$get_yoastseo_fields = $classifyObj->yoastseoFields();
		$get_terms_taxos = $classifyObj->termsandtaxos($module);
		$get_wpmember_fields = $classifyObj->wpmembersFields();
		$get_ecom_metafields = $classifyObj->ecommerceMetaFields($module);
		$get_wpecom_custfields = $classifyObj->wpecommerceCustomFields();
		
		if(is_array($mapped_values)) {
			foreach($mapped_values as $mkey => $mval) {
				if(in_array('CORE', $get_available_groups)) {
					foreach($get_corefields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('CORECUSTFIELDS', $get_available_groups)) {
					foreach($get_core_custfields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('PODS', $get_available_groups)) {
					foreach($get_pods_custfields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('CCTM', $get_available_groups)) {
					foreach($get_cctm_custfields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('TYPES', $get_available_groups)) {
					foreach($get_types_custfields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('ACF', $get_available_groups)) {
					foreach($get_acf_custfields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('AIOSEO', $get_available_groups)) {
					foreach($get_aioseo_fields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('YOASTSEO', $get_available_groups)) {
					foreach($get_yoastseo_fields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('TERMS', $get_available_groups)) {
					foreach($get_terms_taxos as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('WPMEMBERS', $get_available_groups)) {
					foreach($get_wpmember_fields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('ECOMMETA', $get_available_groups)) {
					foreach($get_ecom_metafields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
				if(in_array('WPECOMMETA', $get_available_groups)) {
					foreach($get_wpecom_custfields as $key => $val) {
						if(array_key_exists($mkey, $val)) {
							$new_mapping[$key][$mval] = $val[$mkey]['name'];
						}
					}
				}
			}
		}
		$new_mapping = serialize($new_mapping);
		$wpdb->update('wp_ultimate_csv_importer_mappingtemplate', array('mapping' => $new_mapping), array('id' => $template_id));
	}
	update_option('ULTIMATE_CSV_IMP_VERSION', '4.0');
	update_option('ULTIMATE_CSV_IMPORTER_UPGRADE_VERSION', '4.0');
	?>
	<script>
		document.getElementById('upgrade_state').innerHTML = 'Upgrade Completed! ';
	</script>
<?php
}
?>
