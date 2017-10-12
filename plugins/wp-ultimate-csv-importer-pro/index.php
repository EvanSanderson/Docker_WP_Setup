<?php
/******************************************************************************************
 *
 * Plugin Name: WP Ultimate CSV Importer PRO
 * Description: A plugin that helps to import the data's from a CSV file.
 * Version: 4.3.0
 * Author: smackcoders.com
 * Plugin URI: https://www.smackcoders.com/store/wp-ultimate-csv-importer-pro.html
 * Author URI: https://www.smackcoders.com/store/wp-ultimate-csv-importer-pro.html
 *
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

//echo '<pre>'; bloginfo('version'); echo '</pre>'; die();
/* error_reporting(E_ALL);
ini_set("display_errors", 1); */

$get_debug_mode = get_option('wpcsvprosettings');
if(isset($get_debug_mode['debug_mode']) && $get_debug_mode['debug_mode'] != 'enable_debug') {
     error_reporting(0);
     ini_set('display_errors', 'On');
}


ob_start();

if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( is_plugin_active('wp-ultimate-csv-importer/index.php') ){
        function wp_ultimate_csv_importer_notice(){
                ?>
                <div class = 'error'><p>
                <?php printf('Please de-activate and remove the free version of WP Ultimate CSV Importer before activating the paid version.');
                ?>
                </p></div>
                <?php
                deactivate_plugins( plugin_basename( __FILE__ ) );
        }
        add_action('admin_notices', 'wp_ultimate_csv_importer_notice');
}
else{
define('WP_CONST_ULTIMATE_CSV_IMP_URL', 'http://www.smackcoders.com/store/wp-ultimate-csv-importer-pro.html');
define('WP_CONST_ULTIMATE_CSV_IMP_NAME', 'Ultimate CSV Importer PRO');
define('WP_CONST_ULTIMATE_CSV_IMP_SLUG', 'wp-ultimate-csv-importer-pro');
define('WP_CONST_ULTIMATE_CSV_IMP_SETTINGS', 'Wp Ultimate CSV Importer PRO');

define('WP_CONST_ULTIMATE_CSV_IMP_DIR', WP_PLUGIN_URL . '/' . WP_CONST_ULTIMATE_CSV_IMP_SLUG . '/');
define('WP_CONST_ULTIMATE_CSV_IMP_DIRECTORY', plugin_dir_path(__FILE__));
define('WP_PLUGIN_BASE', WP_CONST_ULTIMATE_CSV_IMP_DIRECTORY);
define('WP_CONST_ULTIMATE_CSV_IMP_MAPPING_TEMPLATE', 'wp_ultimate_csv_importer_mappingtemplate');
define('WP_CONST_ULTIMATE_CSV_IMP_SCHEDULED_IMPORT', 'wp_ultimate_csv_importer_scheduled_import');
define('WP_CONST_ULTIMATE_CSV_IMP_DASH_MANAGER', 'smack_dashboard_manager');
define('WP_CONST_ULTIMATE_CSV_IMP_FTP_FILE_DETAILS', 'wp_ultimate_csv_importer_ftp_schedules');
define('WP_CONST_ULTIMATE_CSV_IMP_EXT_FILE_DETAILS', 'wp_ultimate_csv_importer_external_file_schedules');
define('WP_CONST_ULTIMATE_CSV_IMP_UPLOAD_FILE_SCHEDULES', 'wp_ultimate_csv_importer_uploaded_file_schedules');

$plugin_version = get_option('ULTIMATE_CSV_IMP_VERSION');
if ($plugin_version) {
        define('WP_CONST_ULTIMATE_CSV_IMP_VERSION', $plugin_version);
        update_option('ULTIMATE_CSV_IMP_VERSION', $plugin_version);
}

if (!class_exists('SkinnyControllerWPCsvPro')) {
	require_once('lib/skinnymvc/controller/SkinnyController.php');
}
if ( empty( $GLOBALS['wp_rewrite'] ) )
	$GLOBALS['wp_rewrite'] = new WP_Rewrite();

// For inline graph showed in filemanager
if(isset($_REQUEST['graphdata'])){
require_once('modules/dashboard/actions/chartone.php');
die();
}

require_once('includes/smackLogging.php');
require_once('plugins/class.inlineimages.php');
require_once('plugins/class.dboptimizer.php');
require_once('plugins/class.acf.php');
require_once('plugins/class.cctm.php');
require_once('plugins/class.types.php');
require_once('plugins/class.pods.php');
require_once('plugins/class.aioseo.php');
require_once('plugins/class.yoastseo.php');
require_once('plugins/class.wpmembers.php');
require_once('includes/WPImporter_includes_helper.php');
require_once('includes/schedulehelper.php');
require_once('includes/Importer.php');
require_once('includes/ImportLib.php');
require_once('includes/XML2Array.php');
require_once('plugins/class.classifyfields.php');
require_once('includes/WPUltimateCSVImporter.php');
require_once('includes/csv_woocommerce_support.php');

add_action('plugins_loaded','load_lang_files');

function load_lang_files(){
$csv_importer_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
load_plugin_textdomain( 'wp-ultimate-csv-importer-pro', false, $csv_importer_dir);
}

# Activation & Deactivation 
register_activation_hook(__FILE__, array('WPImporter_includes_helper', 'smack_csv_importer_activate'));
register_deactivation_hook(__FILE__, array('WPImporter_includes_helper', 'smack_csv_importer_deactivate'));

function action_csv_imp_admin_menu() {
	if(!function_exists('wp_get_current_user')) {
		include(ABSPATH . "wp-includes/pluggable.php");
	}
	if(is_multisite()) {
                if ( current_user_can( 'administrator' ) ) {
                        add_menu_page(WP_CONST_ULTIMATE_CSV_IMP_SETTINGS, WP_CONST_ULTIMATE_CSV_IMP_NAME, 'manage_options', __FILE__, array('WPImporter_includes_helper', 'output_fd_page'), WP_CONST_ULTIMATE_CSV_IMP_DIR . "images/faviconWT16.png");
                }
                else if ( current_user_can( 'author') || current_user_can('editor') ) {
                        $HelperObj = new WPImporter_includes_helper();
                        $settings = $HelperObj->getSettings();
                        if(isset($settings['enable_plugin_access_for_author']) && $settings['enable_plugin_access_for_author'] == 'enable') {
                                add_menu_page(WP_CONST_ULTIMATE_CSV_IMP_SETTINGS, WP_CONST_ULTIMATE_CSV_IMP_NAME, '2', __FILE__, array('WPImporter_includes_helper', 'output_fd_page'), WP_CONST_ULTIMATE_CSV_IMP_DIR . "images/faviconWT16.png");
                        }
                }
	}
	else {
                if ( current_user_can( 'author') || current_user_can('editor') ) {
                        $HelperObj = new WPImporter_includes_helper();
                        $settings = $HelperObj->getSettings();
                        if(isset($settings['enable_plugin_access_for_author']) && $settings['enable_plugin_access_for_author'] == 'enable') {
                                add_menu_page(WP_CONST_ULTIMATE_CSV_IMP_SETTINGS, WP_CONST_ULTIMATE_CSV_IMP_NAME, '2', __FILE__, array('WPImporter_includes_helper', 'output_fd_page'), WP_CONST_ULTIMATE_CSV_IMP_DIR . "images/faviconWT16.png");
                        } else if ( current_user_can( 'administrator' ) ) {
                                add_menu_page(WP_CONST_ULTIMATE_CSV_IMP_SETTINGS, WP_CONST_ULTIMATE_CSV_IMP_NAME, 'manage_options', __FILE__, array('WPImporter_includes_helper', 'output_fd_page'), WP_CONST_ULTIMATE_CSV_IMP_DIR . "images/faviconWT16.png");
                        }
                }
                else if ( current_user_can( 'administrator' ) ) {
                        add_menu_page(WP_CONST_ULTIMATE_CSV_IMP_SETTINGS, WP_CONST_ULTIMATE_CSV_IMP_NAME, 'manage_options', __FILE__, array('WPImporter_includes_helper', 'output_fd_page'), WP_CONST_ULTIMATE_CSV_IMP_DIR . "images/faviconWT16.png");
                } else {
                        add_menu_page(WP_CONST_ULTIMATE_CSV_IMP_SETTINGS, WP_CONST_ULTIMATE_CSV_IMP_NAME, 'manage_options', __FILE__, array('WPImporter_includes_helper', 'output_fd_page'), WP_CONST_ULTIMATE_CSV_IMP_DIR . "images/faviconWT16.png");
                }
	}
}
add_action("admin_menu" , "action_csv_imp_admin_menu") ; 

// Move Pages above Media
function smackcsvpro_change_menu_order( $menu_order ) {
   return array(
       'index.php',
       'edit.php',
       'edit.php?post_type=page',
       'upload.php',
       'wp-ultimate-csv-importer-pro/index.php',
   );
}
add_filter( 'custom_menu_order', '__return_true' );
add_filter( 'menu_order', 'smackcsvpro_change_menu_order' );

function action_csv_imp_pro_admin_init() {
	if (isset($_REQUEST['page']) && ($_REQUEST['page'] == 'wp-ultimate-csv-importer-pro/index.php' || $_REQUEST['page'] == 'page')) {
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-style', plugins_url('css/jquery-ui.css', __FILE__));
		wp_register_script('ultimate-importer-js', plugins_url('js/ultimate-importer-pro.js', __FILE__));
		wp_enqueue_script('ultimate-importer-js');
		wp_register_script('ultimate-dashchart-js', plugins_url('js/dashchart.js', __FILE__));
		wp_enqueue_script('ultimate-dashchart-js');
		wp_register_script('ultimate-importer-button', plugins_url('js/buttons.js', __FILE__));
		wp_enqueue_script('ultimate-importer-button');
		wp_enqueue_style('ultimate_importer_font_awesome', plugins_url('css/font-awesome.css', __FILE__));
		wp_register_script('jquery-min', plugins_url('js/jquery.js', __FILE__));
		wp_enqueue_script('jquery-min');
		wp_register_script('jquery-widget', plugins_url('js/jquery.ui.widget.js', __FILE__));
		wp_enqueue_script('jquery-widget');
		wp_register_script('jquery-iframe-transport', plugins_url('js/jquery.iframe-transport.js', __FILE__));
		wp_enqueue_script('jquery-iframe-transport');
		wp_register_script('jquery-fileupload', plugins_url('js/jquery.fileupload.js', __FILE__));
		wp_enqueue_script('jquery-fileupload');
		wp_register_script('bootstrap-collapse', plugins_url('js/bootstrap-collapse.js', __FILE__));
		wp_enqueue_script('bootstrap-collapse');
		wp_enqueue_style('style', plugins_url('css/style.css', __FILE__));
		wp_enqueue_style('jquery-fileupload', plugins_url('css/jquery.fileupload.css', __FILE__));
		wp_enqueue_script('high_chart', plugins_url('js/highcharts.js', __FILE__));
		wp_enqueue_script('export_module', plugins_url('js/exporting.js', __FILE__));
		wp_enqueue_script('pie_chart', plugins_url('js/highcharts-3d.js', __FILE__));
		wp_enqueue_script('drilldown', plugins_url('js/drilldown.js', __FILE__));
		wp_enqueue_script('data', plugins_url('js/data.js', __FILE__));
		wp_enqueue_script('filetree', plugins_url('js/jqueryFileTree.js', __FILE__));
        wp_enqueue_script('pop-up',plugins_url('js/modal.js',__FILE__));
        wp_enqueue_script('dropdown',plugins_url('js/dropdown.js',__FILE__));

		wp_enqueue_style('fancybox', plugins_url('css/jquery.fancybox.css', __FILE__));
		wp_enqueue_style('bootstrap-css', plugins_url('css/bootstrap.css', __FILE__));
		wp_enqueue_style('ultimate-importer-css', plugins_url('css/main.css', __FILE__));
		wp_enqueue_style('filetree-css', plugins_url('css/jqueryFileTree.css', __FILE__));
               
		wp_register_script('fancybox', plugins_url('js/jquery.fancybox.pack.js', __FILE__));
		wp_enqueue_script('fancybox');
		wp_register_script('sparkline', plugins_url('js/jquery.sparkline.js', __FILE__));
		wp_enqueue_script('sparkline');
		wp_register_script('jquery-flot-min', plugins_url('js/jquery.flot.min.js', __FILE__));
		wp_enqueue_script('jquery-flot-min');
		wp_register_script('flot-pie', plugins_url('js/jquery.flot.pie.min.js', __FILE__));
		wp_enqueue_script('flot-pie');
		wp_register_script('jquery-knob', plugins_url('js/jquery.knob.js', __FILE__));
		wp_enqueue_script('jquery-knob');
	}
}

add_action('admin_init', 'action_csv_imp_pro_admin_init');
require_once('includes/smackcsv_importer_helper.php');
require_once('templates/jqueryFileTree.php');
add_action('wp_ajax_filetree_upload', 'filetree_upload');
}
