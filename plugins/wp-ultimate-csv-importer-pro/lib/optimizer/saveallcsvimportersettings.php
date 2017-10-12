<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

$data = array();
$tableseo = get_option('wpcsvprosettings');
$active_plugin = get_option('active_plugins');
$customerreview_plug = 'wp-customer-reviews/wp-customer-reviews.php';
if(isset($_REQUEST['eventdoneby']) && ($_REQUEST['eventdoneby'] == 'checkall')) {
	$data['post'] = 'enable';
	$data['page_module'] = 'enable';
	$data['users'] = 'enable';
	$data['comments'] = 'enable';
	$data['custompost'] = 'enable';
	$data['customtaxonomy'] = 'enable';
	$data['categories'] = 'enable';
	if (in_array($customerreview_plug, $active_plugin))
	$data['rcustomerreviews'] = 'enable';
} else if(isset($_REQUEST['eventdoneby']) && ($_REQUEST['eventdoneby'] == 'uncheckall')) {
	$data['post'] = 'disable';
	$data['page_module'] = 'disable';
	$data['users'] = 'disable';
	$data['comments'] = 'disable';
	$data['custompost'] = 'disable';
	$data['customtaxonomy'] = 'disable';
	$data['categories'] = 'disable';
	$data['rcustomerreviews'] = 'disable';
} else if(isset($_REQUEST['eventdoneby']) && ($_REQUEST['eventdoneby'] == 'reset')) {
	$data['rwpmembers'] = 'disable';
	$data['wpcustomfields'] = 'disable';
	$data['acfcustomfield'] = 'disable';
	$data['cctmcustomfield'] = 'disable';
	$data['typescustomfield'] = 'disable';
	$data['podscustomfield'] = 'disable';
} else {
	$csvprosettings = get_option('wpcsvprosettings');
	$option = $_REQUEST['option'];
	$value = $_REQUEST['value'];
	foreach ($csvprosettings as $key => $val) {
		$settings[$key] = $val;
	}
	$settings[$option] = $value;
	update_option('wpcsvprosettings', $settings);
        }
if(!empty($data)) {
	$csvprosettings = get_option('wpcsvprosettings');
	foreach ($csvprosettings as $key => $val) {
		$settings[$key] = $val;
	}
	foreach ($data as $dkey => $dval) {
		$settings[$dkey] = $dval;
		update_option('wpcsvprosettings', $settings);
	}
}
?>
