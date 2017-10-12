<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

$data = $exclusion_list = array();
if(!empty($_REQUEST['eventdoneby']) && $_REQUEST['eventdoneby'] == 'check') {
	$name = $_REQUEST['result'];
	foreach($name as $nkey => $nval) {
		$data[$nval] = 'enable';
	}
}
else if(!empty($_REQUEST['eventdoneby']) && $_REQUEST['eventdoneby'] == 'uncheck') {
	$name = $_REQUEST['result'];
	foreach($name as $nkey => $nval) {
                $data[$nval] = 'disable';
        }
}
else {
	$exclusion_name = $_POST['postdata'][0]['exclusion_node'];
	$exclusion_status = $_POST['postdata'][0]['exclusion_status'];
	$export_module_name = $_POST['postdata'][0]['export_module'];
	$cust_type = $_POST['postdata'][0]['customposts_type'];
	$taxo_type = $_POST['postdata'][0]['taxonomies'];
	if($export_module_name == 'custompost'){
		$export_module_name = $cust_type;
	}
	if($export_module_name == 'customtaxonomy'){
		$export_module_name = $taxo_type;
	}
	$get_export_exclusions = get_option('wp_ultimate_csv_importer_export_exclusion');
	if(!empty($get_export_exclusions)) {
		foreach($get_export_exclusions as $key => $value) {
			foreach($value as $fkey => $fval) {
				$exclusion_list[$key][$fkey] = $fval;
			}
		}
	}
	$exclusion_list[$export_module_name][$exclusion_name] = $exclusion_status;
	update_option('wp_ultimate_csv_importer_export_exclusion', $exclusion_list);
#print('<pre>'); print_r($exclusion_list); print('</pre>'); die;
#print_r($exclusion_list);
}
if(!empty($data)) {
	$export_module_name = $_POST['export_module'];
	if($export_module_name == 'custompost'){
		$export_module_name = $_REQUEST['cust_posts_type'];
	}
	if($export_module_name == 'customtaxonomy'){
		$export_module_name = $_REQUEST['taxo_type'];
	}
	$get_export_exclusions = get_option('wp_ultimate_csv_importer_export_exclusion');
	if(!empty($get_export_exclusions)) {
		foreach($get_export_exclusions as $key => $value) {
			foreach($value as $fkey => $fval) {
				$exclusion_list[$key][$fkey] = $fval;
			}
		}
	}
	foreach($data as $dkey => $dval) {
		$exclusion_list[$export_module_name][$dkey] = $dval;
	}
#print('<pre>'); print_r($exclusion_list); print('</pre>'); #die;
	update_option('wp_ultimate_csv_importer_export_exclusion', $exclusion_list);
}
?>
