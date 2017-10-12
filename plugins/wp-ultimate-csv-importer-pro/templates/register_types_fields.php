<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

if(isset($_REQUEST['import_type']))
       $import_type = $_REQUEST['import_type'];
if(isset($_REQUEST['fdname']))
       $fdname = $_REQUEST['fdname'];
if(isset($_REQUEST['fdlabel']))
        $fdlabel = $_REQUEST['fdlabel'];
if(isset($_REQUEST['fdtype']))
        $fdtype = $_REQUEST['fdtype'];
$desc = isset($_REQUEST['desc'])?$_REQUEST['desc'] : '';
$fdreq = isset($_REQUEST['fdreq']) ? $_REQUEST['fdreq'] : 'false';
$remove = isset($_REQUEST['remove']) ? $_REQUEST['remove'] : 'false';
$postlist = isset($_REQUEST['custompost']) ? $_REQUEST['custompost'] : '';
$fdoption = isset($_REQUEST['fdoption']) ? $_REQUEST['fdoption'] : '';
if($remove == 'true'){
types_register::deletefield($import_type,$fdname,$postlist);
}
class types_register{
        static function group_creation($import_type){
		if ($import_type == 'users'){
			$data_array = array('post_title' => 'Types Group for '.$import_type,'post_name' => 'Types Group for '.$import_type, 'post_content'=>'Groups Description','post_status' => 'publish','post_type' => 'wp-types-user-group');
	                $groupid = wp_insert_post($data_array);
			update_post_meta($groupid,'_wp_types_group_showfor',',administrator,');
			return $groupid;
		}
		else {
                $data_array = array('post_title' => 'Types Group for '.$import_type,'post_name' => 'Types Group for '.$import_type, 'post_content'=>'Groups Description','post_status' => 'publish','post_type' => 'wp-types-group');
                $groupid = wp_insert_post($data_array);
                switch($import_type){
                        case 'marketpress' :
                        case 'woocommerce_products' :{
                                $import_type = 'product';
                                break;
                        }
                        case 'wpcommerce' :{
                                $import_type = 'wpsc-product';
                                break;
                        }
			case 'eshop' :{
				$import_type = 'post';
				break;
			}
                        default :{
                                $import_type = $import_type;
                                break;
                        }
                }
                update_post_meta($groupid,'_wp_types_group_post_types',','.$import_type.',');
                return $groupid;
		}
        }
	static function is_group_exist($import_type,$postlist){
		global $wpdb;
		if($import_type == 'custompost'){
			$import_type = $postlist;
		}
		if($import_type != 'users'){
		 $get_types_groups = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type = 'wp-types-group' AND post_name = 'types-group-for-$import_type'");
		}
		else {
		 $get_types_groups = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type = 'wp-types-user-group' AND post_name = 'types-group-for-$import_type'");
		}
                if(!empty($get_types_groups)){
                        $retid = implode("",$get_types_groups);
                        return $retid;
                }
                else{
                        $retid = types_register::group_creation($import_type);
                        return $retid;
                }
	}
        static function field_creation( $group_id,$fdname,$fdlabel,$fdtype,$desc,$fdreq,$import_type,$postlist,$fdoption){
		$req_vd_arr =  array('required' => array('active' => '1','value' => 'true','message' => 'This Field is required'));
                switch($fdtype){
                        case 'checkbox' :{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('set_value' => $fdoption,'save_empty' => 'no','display' => 'db','display_value_not_selected' =>'','display_value_selected' => '' ,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                               break;
				}
				else{
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('set_value' => $fdoption,'save_empty' => 'no','display' => 'db','display_value_not_selected' =>'','display_value_selected' => '' ,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
				break;
				}
                        }
                        case 'checkboxes':{
				$choices = types_register::types_options($fdtype,$fdoption);
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('options'=> $choices,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('options'=> $choices,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
				break;
				}
                        }
                        case 'colorpicker':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
				break;
				}
                        }
                        case 'date':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','date_and_time' => 'and_time','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','date_and_time' => 'and_time','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
				break;
				}
                        }
                        case 'email':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
				break;
				}
                        }
                        case 'embed':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' => array('url' =>array('active' => '1','message' => 'Please enter a valid URL address')),'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' => array('url' =>array('active' => '1','message' => 'Please enter a valid URL address'),$req_vd_arr),'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'file':{
				if($fdreq != 'true') {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'image':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'numeric':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description' => $desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' => array('number' =>array('active' => '1','message' => 'Please enter numeric data')),'disabled_by_type' => 0), 'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description' => $desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' => array('number' =>array('active' => '1','message' => 'Please enter numeric data')),$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'phone':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'radio':{
				$choices = types_register::types_options($fdtype,$fdoption);
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('options'=>$choices,'display'=>'db','disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('options'=>$choices,'display'=>'db','validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'select':{
				$choices = types_register::types_options($fdtype,$fdoption);
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('options'=> $choices,'display'=>'db','disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('options'=> $choices,'display'=>'db','validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'skype':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'textarea':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'textfield':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'conditional_display' => array('relation' => 'AND','custom' => ''),'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
				}
                        }
                        case 'url':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
                        }
                        case 'video':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}

                        }
                        case 'wysiwyg':{
				if($fdreq != 'true'){
                        $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;
				}
				else {
                       $fields_array = array($fdname =>array('id'=>$fdname,'slug'=>$fdname,'type'=>$fdtype,'name'=>$fdname,'description'=>$desc,'data' => array('placeholder' => '','repetitive' => 0,'validate' =>$req_vd_arr,'disabled_by_type' => 0),'meta_key'=>'wpcf-'.$fdname.'','meta_value'=>'postmeta'));
                                break;

				}
                        }
                        default:{
                                echo 'no matches';
                        }
                }
		$duplicate = types_register::isduplicate($import_type,$fdname,$postlist);
		if($duplicate != 'true'){
		if($import_type != 'users'){
			$existing_fd = get_option('wpcf-fields');
			if($existing_fd != ''){
				$existing_fd = array_merge($existing_fd,$fields_array);
			}
			else {
				$existing_fd = $fields_array;
			}
                	update_option('wpcf-fields',$existing_fd);
			$existing_meta = get_post_meta($group_id,'_wp_types_group_fields',true);
			$fdname = $existing_meta . $fdname;
                	update_post_meta($group_id,'_wp_types_group_fields',','.$fdname.',');
                	echo 'Field Added';
			die();
		}
		else {
			$existing_fd = get_option('wpcf-usermeta');
                        if($existing_fd != ''){
                                $existing_fd = array_merge($existing_fd,$fields_array);
                        }
                        else {
                                $existing_fd = $fields_array;
                        }
                        update_option('wpcf-usermeta',$existing_fd);
                        $existing_meta = get_post_meta($group_id,'_wp_types_group_fields',true);
                        $fdname = $existing_meta . $fdname;
                        update_post_meta($group_id,'_wp_types_group_fields',','.$fdname.',');
                        echo 'Field Added';
                        die();
		}
		}
		else {
                	echo 'Field already registered';
                	die();
                }
        }
        static function isduplicate($import_type,$fdname,$postlist){
                global $wpdb;
                $retid = types_register::is_group_exist($import_type,$postlist);
		if($retid != ''){
                $typesfds = get_post_meta($retid,'_wp_types_group_fields',true);
                if($typesfds != ''){
			$typesfds = explode(",",$typesfds);
			if(!empty($typesfds) && !in_array($fdname,$typesfds)){
                        return 'false';
			}
			else{
			return 'true';
			}
                }
                else{
                        return 'false';
		}
		}		
        }
        static function deletefield($import_type,$fdname,$postlist){
                global $wpdb;
                $pt_id = types_register::is_group_exist($import_type,$postlist);
                $typesfds = get_post_meta($pt_id,'_wp_types_group_fields',true);
		if($typesfds != ''){
			$typesfds = explode(",",$typesfds);
                        if(!empty($typesfds) && in_array($fdname,$typesfds)){
			if (($key = array_search($fdname, $typesfds)) !== false) {
 				   unset($typesfds[$key]);
			}
				$typesfds = implode(",",$typesfds);
				update_post_meta($pt_id,'_wp_types_group_fields',$typesfds);
			}
                        print_r('Field Deleted');die();
		}
        }
	static function types_options($fdtype,$fdoption){
		$fdoption = explode(',',$fdoption);
                        $flipoption = array_flip($fdoption);
                        $op = array_combine($fdoption,$fdoption);
		$option_arr = array();
		$i= 0;
		if($fdtype == 'select'){
		foreach($op as $key => $value){
		$ukey = md5(strval(time()).$i);
		$opt_index = 'wpcf-fields-select-option-'.$ukey ; 
		$option_arr[$opt_index] = array('title' => $key,'value' => $value);
		$i++;
		}
			return $option_arr;
		}
		if($fdtype == 'checkboxes'){
			foreach($op as $key => $value){
	                $ukey = md5(strval(time()).$i);
        	        $opt_index = 'wpcf-fields-checkboxes-option-'.$ukey ;
                	$option_arr[$opt_index] = array('title'=> $key,'set_value' => $value,'save_empty' => 'no','display' => 'db','display_value_not_selected' =>'','display_value_selected' => '');
			$i++;
		}
			return $option_arr;
		}
		if($fdtype == 'radio'){
			foreach($op as $key => $value){
                        $ukey = md5(strval(time()).$i);
                        $opt_index = 'wpcf-fields-radio-option-'.$ukey ;
                        $option_arr[$opt_index] = array('title'=> $key,'value' => $value,'display_value' => $value);
                        $i++;
			}
			return $option_arr;
		}
	}
}
$group_id = types_register::is_group_exist($import_type,$postlist);
types_register::field_creation($group_id,$fdname,$fdlabel,$fdtype,$desc,$fdreq,$import_type,$postlist,$fdoption);
?>

