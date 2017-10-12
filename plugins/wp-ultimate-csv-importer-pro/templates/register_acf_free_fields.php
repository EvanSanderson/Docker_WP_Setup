<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

                $postlist = $hiddenvalue = '';
		$op = array(); 
                if(isset($_REQUEST['import_type']))
                        $import_type = $_REQUEST['import_type'];
                if(isset($_REQUEST['postlist']) && $_REQUEST['postlist'] != '')
                        $postlist = $_REQUEST['postlist'];
                if(isset($_REQUEST['fdname']))
                        $fdname = $_REQUEST['fdname'];
                if(isset($_REQUEST['fdlabel']))
                        $fdlabel = $_REQUEST['fdlabel'];
                if(isset($_REQUEST['fdtype']))
                        $fdtype = $_REQUEST['fdtype'];
                if(isset($_REQUEST['fdoption']) && $_REQUEST['fdoption'] != ''){
                        $fdoption = $_REQUEST['fdoption'];
                        $fdoption = explode(',',$fdoption);
                        $flipoption = array_flip($fdoption);
                        $op = array_combine($fdoption,$fdoption);
                }
                if(isset($_REQUEST['hdvalue']) && $_REQUEST['hdvalue'] != '')
                        $hiddenvalue = $_REQUEST['hdvalue'];
		$desc = isset($_REQUEST['desc'])?$_REQUEST['desc'] : '';
		$fdreq = isset($_REQUEST['fdreq']) ? $_REQUEST['fdreq'] : 'false';

class append_field{	
	static function creategroup($import_type,$postlist){
		global $wpdb;
		$param = 'post_type';
		$gorderno = 0;
                $date = date("Y-m-d h:i:s");
		switch($import_type){
		case 'users' : {
			$param = 'ef_user';
                        $loc = 'all';
                        break;
                	}
		case 'marketpress' :
		case 'woocommerce' :{
                        $loc = 'product';
                        break;
                        }
                case 'wpcommerce' :{
                        $loc = 'wpsc-product';
                        break;
                        }
		case 'custompost' :{
			$loc = $postlist;
			break;
			}
		case 'customtaxonomy' :{
			$param = 'ef_taxonomy';
			$loc = 'all';
			break;
			}
                default :{
                        $loc = $import_type;
			break;
                        }
		}
		$rule =serialize(array('param' => $param, 'operator' => '==', 'value' => $loc,'order_no' => $gorderno,'group_no' => 0));   
		$meta_data = array('position' => 'normal', 'layout' => 'no_box', 'hide_on_screen' => '','rule' => $rule);
		$data_array = array('post_date' => $date, 'post_date_gmt' => $date, 'post_title' => 'ACF Free: Custom Group for '.$import_type, 'post_status' => 'publish', 'comment_status' => 'closed', 'ping_status' => 'closed', 'post_name' => 'acf_smack_'.$import_type, 'post_type' => 'acf');
		if($import_type == 'custompost'){
		$data_array = array('post_date' => $date, 'post_date_gmt' => $date, 'post_title' => 'ACF Free: Custom Group for '.$postlist, 'post_status' => 'publish', 'comment_status' => 'closed', 'ping_status' => 'closed', 'post_name' => 'acf_smack_'.$postlist, 'post_type' => 'acf');
		}
                $retid = wp_insert_post($data_array);
		foreach($meta_data as $key => $value){
		$sql = "insert into $wpdb->postmeta (post_id,meta_key,meta_value) values('$retid','$key','$value')";
		$wpdb->query($sql);
		}
		return $retid;
	}
	static function is_group_exist($import_type,$postlist){
		global $wpdb;
                $get_acf_groups = array();
                                $get_acf_groups = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type = 'acf' AND post_name = 'acf_smack_$import_type'");
		if(!empty($get_acf_groups)){
			$retid = implode("",$get_acf_groups);
			return $retid;
		}
		else{
			$retid =append_field::creategroup($import_type,$postlist);
			return $retid;
		}

	}
	static function createfield($post_id,$fdname,$fdlabel,$fdtype,$op,$hiddenvalue,$desc,$fdreq){
		global $wpdb;
		$forderno = $wpdb->get_col("select count(post_id) from $wpdb->postmeta where post_id = $post_id and meta_key like 'field_%'");
		$orderno = $forderno[0];
		$fieldkey = uniqid('field_');
		if($fdreq == 'true'){
                        $fdreq = 1;
                }
                else{
                        $fdreq = 0;
                }
		if($fdtype != '--select--'){
			switch($fdtype){
				case 'text' :
				case 'number' :
				case 'password' :
				case 'email' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'order_no' => $orderno));
					break;
				}
				case 'text area' :{
					$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'textarea','instructions' => $desc, 'required' => $fdreq, 'order_no' => $orderno));
					break;
				}
				case 'wysiwyg editor' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'wysiwyg', 'instructions' => $desc, 'required' => $fdreq, 'media_upload' => 'yes', 'toolbar' => 'full', 'order_no' => $orderno));
					break;
				}
				case 'image' :
				case 'file' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'save_format' => 'object', 'library' => 'all', 'order_no' => $orderno));
					break;
				}
				case 'select' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'choices' => $op, 'order_no' => $orderno));
					break;
				}
				case 'checkbox' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'choices' => $op, 'layout' => 'vertical', 'order_no' => $orderno));
					break;
				}
				case 'radio button' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'radio', 'instructions' => $desc, 'required' => $fdreq, 'choices' => $op, 'layout' => 'vertical', 'order_no' => $orderno));
					break;
				}
				case 'true/false' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'true_false', 'instructions' => $desc, 'required' => $fdreq, 'order_no' => $orderno));
					break;
				}
				case 'page link' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'page_link', 'instructions' => $desc, 'required' => $fdreq, 'post_type' => array('all'), 'order_no' => $orderno));
					break;
				}
				case 'post object' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'post_object', 'post_type' => array('all'), 'instructions' => $desc, 'required' => $fdreq, 'taxonomy' => array('all'), 'order_no' => $orderno));
					break;
				}
				case 'relationship' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'return_format' => 'object', 'post_type' => array('all'), 'taxonomy' => array('all'), 'filters' => array('search'), 'result_element' => array('post_type'), 'order_no' => $orderno));
					break;
				}
				case 'taxonomy' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'taxonomy' => 'category', 'field_type' => 'checkbox', 'return_format' => 'id', 'order_no' => $orderno));
					break;
				}
				case 'user' :{
					$hiddenvalue = explode(" ",$hiddenvalue);
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'role' => $hiddenvalue, 'order_no' => $orderno));
					break;
				}
				case 'google map' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'google_map', 'instructions' => $desc, 'required' => $fdreq, 'center_lat' => '', 'center_lng' => '', 'height' => 100, 'order_no' => $orderno));
					break;
				}
				case 'date picker' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'date_picker', 'instructions' => $desc, 'required' => $fdreq, 'date_format' => 'yymmdd', 'display_format' => 'dd/mm/yy', 'first_day' => 1, 'order_no' => $orderno));
					break;
				}
				case 'color picker' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => $fdlabel, 'type' => 'color_picker', 'instructions' => $desc, 'required' => $fdreq, 'order_no' => $orderno));
					break;
				}
				case 'message' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => '', 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'message' => '', 'order_no' => $orderno));
					break;
				}
				case 'tab' :{
$field_meta = serialize(array('key' => $fieldkey, 'label' => $fdname, 'name' => '', 'type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'order_no' => $orderno));
					break;
				}
				default :{
					print_r('This feature is available only in ACF Pro. Please update the ACF Version .');die();
				}
			}
		}
		$sql = "insert into $wpdb->postmeta(post_id,meta_key,meta_value) values('$post_id','$fieldkey','$field_meta')";
		$wpdb->query($sql);
		print_r('Field Added');
}

	static function deletefield($import_type,$postlist,$fdname){
	global $wpdb;
	$i = 0;
	if($import_type == 'custompost')
		$import_type = $postlist;
	$postid = $wpdb->get_col("select id from $wpdb->posts where post_type = 'acf' and post_name = 'acf_smack_$import_type'");
	$meta = $wpdb->get_col("select meta_value from $wpdb->postmeta where post_id = $postid[0] and meta_key like 'field_%'");
	foreach($meta as $value){
		$field[$i] = unserialize($value);
		$i++;
	}
	foreach($field as $value){
		if($value['label'] == $fdname){
	$sql = "Delete from $wpdb->postmeta where post_id = $postid[0] and meta_key = '$value[key]'";
	$wpdb->query($sql);	print_r('Field Deleted');
		break;
		}
	}	
	}
	static function isduplicate($import_type,$postlist,$fdname){
		global $wpdb;
		$i = 0;
		if($import_type == 'custompost')
		$import_type = $postlist;
		$postid = $wpdb->get_col("select id from $wpdb->posts where post_type = 'acf' and post_name = 'acf_smack_$import_type'");
		$meta = $wpdb->get_col("select meta_value from $wpdb->postmeta where post_id = $postid[0] and meta_key like 'field_%'");
		if(!empty($meta)){
			foreach($meta as $value){
	                $field[$i] = unserialize($value);
        	        $i++;
	        } 	
		foreach($field as $val){
			if($val['label'] == $fdname)
				return 'true';
		}
		}
		return 'false';
	}
}
if(isset($_REQUEST['remove'])){
                        $rmvfield = $_REQUEST['remove'];
                        if($rmvfield == 'true'){
                                append_field::deletefield($import_type,$postlist,$fdname);
				die();
			}
                }
$post_id = array();
$post_id = append_field::is_group_exist($import_type,$postlist);
if(!empty($post_id)){
$duplicate = append_field::isduplicate($import_type,$postlist,$fdname);
if($duplicate == 'true'){
print('Field already registered');
die();
}
else{
append_field::createfield($post_id,$fdname,$fdlabel,$fdtype,$op,$hiddenvalue,$desc,$fdreq);
}
}
?>
