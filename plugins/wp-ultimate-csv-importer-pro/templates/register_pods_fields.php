<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

class append_podsfield{
	static function creategroup($import_type,$postlist){
		global $wpdb;
		$type = 'post_type';
		$pt_name = str_replace(' ','_',append_podsfield::convert_importtype($import_type));
		$storage_val = 'meta';
                if($import_type == 'custompost')
                $pt_name = $import_type = $postlist;
		switch($import_type){
			case 'users' :{
					      $type = 'user';
					      break;
				      }
			case 'comments' :{
						 $type = 'comment';
						 break;
					 }
					   /*        case 'customtaxonomy' :{
						     $import_type = '';
						     $type = 'taxonomy';
						     $storage_val = 'table';
						     break;
						     }
						     case 'custompost' :{
						     $import_type = '';
						     $type = '';
						     break;
						     }
						     case 'categories' :{
						     $import_type = '';
						     break;
						     }
					    */
		}
		$data_array = array('post_title' => $import_type,'post_name' => $pt_name,'post_status' => 'publish','post_type' => '_pods_pod');
		$retid = wp_insert_post($data_array);
		
		$meta_data = array('storage' => $storage_val,'type' => $type,'object' => $pt_name,'old_name' => $pt_name);
		if($import_type == 'custompost' || $import_type == 'customtaxonomy') 
			$meta_data = array('storage' => $storage_val,'type' => $type,'old_name' => $pt_name); 

		foreach($meta_data as $key=>$value){
			$sql = "insert into $wpdb->postmeta (post_id,meta_key,meta_value) values('$retid','$key','$value')";
			$wpdb->query($sql);
		}
		return $retid;
	}
	static function is_group_exist($import_type,$postlist){
		global $wpdb;
		$pt_name = str_replace(' ','_',append_podsfield::convert_importtype($import_type));

                if($import_type == 'custompost'){
                        $pt_name = $postlist;
                }
		$get_pods_groups = array();
		$get_pods_groups = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type = '_pods_pod' AND post_name = '$pt_name'");
		if(!empty($get_pods_groups)){
			$retid = implode("",$get_pods_groups);
			return $retid;
		}
		else{
			$retid =append_podsfield::creategroup($import_type,$postlist);
			return $retid;
		}
	}
	static function createfield($post_id,$fdname,$fdlabel,$fdtype,$desc,$fdreq,$relto,$bidir){
		global $wpdb;
		$data_array = array('post_content' => $desc,'post_title' => $fdlabel,'post_name'=> $fdname,'post_status' => 'publish','post_parent' => $post_id,'post_type' => '_pods_field');
		$retid = wp_insert_post($data_array);
		if($fdreq == 'true'){
			$fdreq = 1;
		}
		else{
			$fdreq = 0;
		}
		if($fdtype != '--select--'){
			switch($fdtype){
				case 'plain text':{
							  $field_meta = array('type' => 'text', 'text_max_length' => '255','required'=>$fdreq);
							  break;
						  }
				case 'website':{
						       $field_meta = array('type' => 'website', 'website_format' => 'normal', 'website_max_length' => '255','required'=>$fdreq);
						       break;
					       }
				case 'phone':{
						     $field_meta = array('type' => 'phone', 'phone_max_length' => '25', 'phone_enable_phone_extension' => '1', 'phone_format' => '999-999-9999 x999','required'=>$fdreq);

						     break;
					     }
				case 'e-mail':{
						      $field_meta = array('type' => 'email', 'email_max_length' => '255','required'=>$fdreq);
						      break;
					      }
				case 'password':{
							$field_meta = array('type' => 'password', 'password_max_length' => '255','required'=>$fdreq);
							break; 
						}
				case 'date/time':{
							 $field_meta = array('type' => 'datetime', 'datetime_allow_empty' => '1','datetime_format_24' => 'hh_mm', 'datetime_time_format' => 'h_mma', 'datetime_time_type' => '12', 'datetime_format' => 'mdy','required'=>$fdreq);
							 break;
						 }
				case 'date':{
						    $field_meta = array('type' => 'date', 'date_allow_empty' => '1', 'date_format' => 'mdy','required'=>$fdreq);
						    break;
					    }
				case 'time':{
						    $field_meta = array('type' => 'time', 'time_format' => 'h_mma','time_type' => '12','required'=>$fdreq);
						    break;
					    }
				case 'plain paragraph text':{
								    $field_meta = array('type' => 'paragraph', 'paragraph_convert_chars' => '1', 'paragraph_wptexturize' => '1', 'paragraph_allow_html' => '1', 'paragraph_max_length' => '255','paragraph_convert_chars' => '1','required'=>$fdreq);
								    break;
							    }
				case 'wysiwyg (visual editor)':{
								       $field_meta = array('type' => 'wysiwyg', 'wysiwyg_editor' => 'tinymce','wysiwyg_wpautop' => '1', 'wysiwyg_convert_chars' => '1', 'wysiwyg_wptexturize' => '1','wysiwyg_media_buttons' => '1','required'=>$fdreq);
								       break;
							       }
				case 'code (syntax highlighting)':{
									  $field_meta = array('type' => 'code','required'=>$fdreq);
									  break;
								  }
				case 'plain number':{
							    $field_meta = array('type' => 'number', 'number_max' => '100', 'number_min' => '0', 'number_max_length' => '12', 'number_format_type' => 'number', 'number_format' => 'i18n', 'number_step' => '1','required'=>$fdreq); 
							    break;
						    }
				case 'currency':{
							$field_meta = array('type' => 'currency', 'currency_max_length' => '12', 'currency_max' => '1000', 'currency_min' => '0', 'currency_step' => '1', 'currency_decimals' => '2', 'currency_format' => 'i18n', 'currency_format_placement' => 'before', 'currency_format_sign' => 'usd', 'currency_format_type' => 'number','required'=>$fdreq);
							break; 
						}
				case 'file/image/video':{
								$field_meta = array('type' => 'file', 'file_modal_add_button' => 'Add File', 'file_modal_title' => 'Attach a file', 'file_add_button' => 'Add File', 'file_type' => 'images', 'file_restrict_filesize' => '10MB', 'file_attachment_tab' => 'upload', 'file_edit_title' => '1','file_uploader' => 'attachment', 'file_format_type' => 'single','required'=>$fdreq);
								break;  
							}
				case 'relationship':{
							if($relto == 'post' || $relto == 'page')
								$postobj = 'post_type';
							else if($relto == 'category' || $relto == 'linkcategory' || $relto == 'tags')											$postobj = 'taxonomy';
                                                        else if($relto == 'user_role')
                                                                $postobj = 'role';
                                                        else if($relto == 'user_capability')
                                                                $postobj = 'capability';
                                                        else if($relto == 'image_size')
                                                                $postobj = 'image-size';
                                                        else if($relto == 'navigation')
                                                                $postobj = 'nav_menu';
                                                        else if($relto == 'us_status')
                                                                $postobj = 'country';
                                                        else if($relto == 'calender_week')
                                                                $postobj = 'days_of_week';
                                                        else if($relto == 'calender_year')
                                                                $postobj = 'months_of_year';
							else
								$postobj = $relto;
							if($bidir != ''){
								global $wpdb;
								$sisid = $wpdb->get_col("SELECT id FROM $wpdb->posts where post_type = '_pods_field' and post_title = '$bidir'");
								$sisid =  implode("",$sisid);
								if($relto == 'page' || $relto == 'post' || $relto == 'category'){
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_val' => $relto, 'pick_object' => $postobj,'required'=>$fdreq,'sister_id'=>$sisid);
								break;
								}
								else if($relto == 'linkcategory'){
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_val' => 'link_category', 'pick_object' => $postobj,'required'=>$fdreq,'sister_id'=>$sisid);
                                                                break;
								}
								else if($relto == 'tags'){
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_val' => 'post_tag', 'pick_object' => $postobj,'required'=>$fdreq,'sister_id'=>$sisid);
                                                                break;
								}
								else {
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_object' => $postobj,'required'=>$fdreq,'sister_id'=>$sisid);
                                                                break;
								}
							}
							else{
								if($relto == 'page' || $relto == 'post' || $relto == 'category'){
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_val' => $relto, 'pick_object' => $postobj,'required'=>$fdreq);
                                                                break;
                                                                }
                                                                else if($relto == 'linkcategory'){
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_val' => 'link_category', 'pick_object' => $postobj,'required'=>$fdreq);
                                                                break;
                                                                }
                                                                else if($relto == 'tags'){
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_val' => 'post_tag', 'pick_object' => $postobj,'required'=>$fdreq);
                                                                break;
                                                                }
                                                                else {
                                                            $field_meta = array('type' => 'pick','pick_format_multi' => 'checkbox', 'pick_format_single' => 'dropdown','pick_format_type' => 'single','pick_object' => $postobj,'required'=>$fdreq);
                                                                break;
                                                                }
							}
						    }
				case 'yes/no':{
						      $field_meta = array('type' => 'boolean','boolean_format_type' => 'checkbox', 'boolean_yes_label' => 'Yes', 'boolean_no_label' => 'No','required'=>$fdreq);
						      break;
					      }
				case 'color picker':{
							    $field_meta = array('type' => 'color','required'=>$fdreq);
							    break;
						    }
			}
		}
		foreach($field_meta as $key=>$val){
			$sql = "insert into $wpdb->postmeta (post_id,meta_key,meta_value) values('$retid','$key','$val')";
			$wpdb->query($sql);
		}
		print('Field Added');
		die();
	}
	static function isduplicate($import_type,$fdlabel,$postlist){
		global $wpdb;
		$row = 'false';
		//		if($import_type == 'custompost')
		//			$import_type = $postlist;
		$retid = append_podsfield::is_group_exist($import_type,$postlist);
		$row = $wpdb->get_col("select id from $wpdb->posts where post_type = '_pods_field' and post_title = '$fdlabel' and post_parent = '$retid'");
		if(!empty($row)){
			return 'true';
		}
		else
			return 'false';
	}
        static function deletefield($import_type,$fdlabel,$postlist){
                global $wpdb;
                $pt_id = append_podsfield::is_group_exist($import_type,$postlist);
		$retid = $wpdb->get_col("select id from $wpdb->posts where post_type = '_pods_field' and post_title = '$fdlabel' and post_parent = '$pt_id'");
		$sql = "DELETE FROM $wpdb->postmeta WHERE POST_ID = '$retid[0]' ";
		$wpdb->query($sql);
                $sql = "DELETE FROM $wpdb->posts WHERE POST_TITLE = '$fdlabel' AND POST_PARENT = '$pt_id'";
                $wpdb->query($sql);
                print_r('Field Deleted');
        }
	static function convert_importtype($import_type){
		switch($import_type){
			case 'eshop' :{
				$import_type = 'post';
				return $import_type;
				break;
			}
        		case 'users' :{
	                	$import_type = 'user';
				return $import_type;
        		        break;
	       		}
		        case 'comments' :{
	        	        $import_type = 'comment';
				return $import_type;
        	        	break;
		        }
		        case 'marketpress' :
		        case 'woocommerce_products' :{
		                $import_type = 'product';
				return $import_type;
		                break;
		        }
		        case 'woocommerce_variations' :{
                		$import_type = 'Product Variation';
				return $import_type;
                		break;
		        }
		        case 'woocommerce_orders' :{
                		$import_type = 'Shop Order';
				return $import_type;
		                break;
		        }
		        case 'woocommerce_refunds' :{
                		$import_type = 'Shop Order Refund';
				return $import_type;
		                break;
		        }	
		        case 'woocommerce_coupons' :{
		                $import_type = 'Shop Coupon';
				return $import_type;
		                break;
			        }
		        case 'wpcommerce' :{
		                $import_type = 'wpsc-product';
				return $import_type;
		                break;
		        }
/*		        case 'customtaxonomy' :{
		                $import_type = '';
				return $import_type;
		                break;
		        }
		        case 'custompost' :{
                		$import_type = '';
				return $import_type;
		                break;
		        }
		        case 'categories' :{
		                $import_type = '';
				return $import_type;
		                break;
		        }
*/
		}
		return $import_type;
	}
}
$postlist = "";
if(isset($_REQUEST['import_type']))
$import_type = $_REQUEST['import_type'];
            if(isset($_REQUEST['custompost']) && $_REQUEST['custompost'] != '')
                        $postlist = $_REQUEST['custompost'];
if(isset($_REQUEST['fdname']))
$fdname = $_REQUEST['fdname'];
if(isset($_REQUEST['fdlabel']))
$fdlabel = $_REQUEST['fdlabel'];
if(isset($_REQUEST['fdtype']))
$fdtype = $_REQUEST['fdtype'];
$desc = isset($_REQUEST['desc'])?$_REQUEST['desc'] : '';
$fdreq = isset($_REQUEST['fdreq']) ? $_REQUEST['fdreq'] : 'false';
$relto = isset($_REQUEST['relto']) ? $_REQUEST['relto'] : '';
$bidir = isset($_REQUEST['bidir']) ? $_REQUEST['bidir'] : '';
if(isset($_REQUEST['remove'])){
                        $rmvfield = $_REQUEST['remove'];
                        if($rmvfield == 'true'){
                                append_podsfield::deletefield($import_type,$fdlabel,$postlist);
                                die();
                        }
                }
$post_id = array();
$post_id = append_podsfield::is_group_exist($import_type,$postlist);
if(!empty($post_id)){
	$duplicate = append_podsfield::isduplicate($import_type,$fdlabel,$postlist);
	if($duplicate == 'true'){
		print('Field already registered');
		die();
	}
	else{
		append_podsfield::createfield($post_id,$fdname,$fdlabel,$fdtype,$desc,$fdreq,$relto,$bidir);
	}
}
?>
