<?php
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
class append_acf{
        function __construct(){
                $postlist = '';
                if(isset($_REQUEST['import_type']))
                        $import_type = $_REQUEST['import_type'];
                if(isset($_REQUEST['postlist']) && $_REQUEST['postlist'] != '')
                        $postlist = $_REQUEST['postlist'];
                if(isset($_REQUEST['fdname']))
                        $fdname = $_REQUEST['fdname'];
                if(isset($_REQUEST['remove'])){
                        $rmvfield = $_REQUEST['remove'];
                        if($rmvfield == 'true')
                           $this->deleteacf_field($import_type,$fdname);
                }
                else{
                        if(isset($_REQUEST['fdlabel']))
                                $fdlabel = $_REQUEST['fdlabel'];
                        if(isset($_REQUEST['fdtype']))
                                $fdtype = $_REQUEST['fdtype'];
                        if(isset($_REQUEST['fdoption']))
                                $fdoption = $_REQUEST['fdoption'];
                        if(isset($fdoption) && $fdoption != ''){
                                $fdoption = explode(',',$fdoption);
                                $flipoption = array_flip($fdoption);
                                $op = array_combine($fdoption,$fdoption);
                        }
	                $desc = isset($_REQUEST['desc'])?$_REQUEST['desc'] : '';
	                $fdreq = isset($_REQUEST['fdreq']) ? $_REQUEST['fdreq'] : 'false';
                        if(isset($_REQUEST['hdvalue']) && $_REQUEST['hdvalue'] != '')
                                $hiddenvalue = $_REQUEST['hdvalue'];
			if($fdreq == 'true'){
                        	$fdreq = 1;
                	}
                	else{
                        	$fdreq = 0;
                	}

                        if($fdtype != '--select--')
                        {
                                switch($fdtype){
                                        case 'radio button' :{
               	                                              $post_cont = array('type' =>'radio', 'instructions' => $desc, 'required' => $fdreq, 'choices' => $op,'layout' => 'vertical' );
       	                                                      break;
                                                             }
                                        case 'text area' :{
                                                              $post_cont = array('type' => 'textarea', 'instructions' => $desc, 'required' => $fdreq, );
                                                              break;
                                                          }
                                        case 'image' :
                                        case 'file' :{
                                                              $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'return_format' => 'url','preview_size' => 'thumbnail','library' => 'all');
                                                              break;
                                                     }
                                        case 'wysiwyg editor' :{
                                                              $post_cont = array('type' => 'wysiwyg', 'instructions' => $desc, 'required' => $fdreq, 'tabs' => 'all','toolbar' => 'basic','media_upload' => 1);
                                                              break;
                                                               }
                                        case 'oembed':{
                                                              $this->check_acfversion();
                                                              $post_cont = array('type' => 'oembed', 'instructions' => $desc, 'required' => $fdreq, 'width' => 100,'height' => 100);
                                                              break;
                                                      }
                                        case 'gallery':{
                                                              $this->check_acfversion();
                                                              $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'min' => '10','max' => '20','preview_size' => 'thumbnail','library' => 'uploadedTo');
                                                              break;
                                                       }
                                        case 'true/false' :{
                                                              $post_cont = array('type' => 'true_false', 'instructions' => $desc, 'required' => $fdreq, 'default_value' => '1');
                                                              break;
                                                           }
                                        case 'post object' :{
                                                              $post_cont = array('type' => 'post_object', 'instructions' => $desc, 'required' => $fdreq, 'post_type' => array('post'),'return_format' => 'object','ui' => 1);
                                                              break;
                                                            }
                                        case 'page link' :{
                                                              $post_cont = array('type' => 'page_link', 'instructions' => $desc, 'required' => $fdreq, 'post_type' => array('post'));
                                                              break;
                                                          }
                                        case 'relationship' :{
                                                              $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'return_format' => 'object');
                                                              break;
                                                             }
                                        case 'taxonomy' :{
                                                              $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'taxonomy' => 'category','return_format' => 'id');
                                                              break;
                                                         }
                                        case 'user' :{
                                                              $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'role' => array($hiddenvalue));
                                                              break;
                                                     }
                                        case 'google map':{
                                                              $post_cont = array('type' => 'google_map', 'instructions' => $desc, 'required' => $fdreq, 'center_lat' => '','center_lng' => '','zoom' =>'','height' => '100');
                                                              break;
                                                          }
                                        case 'date picker':{
                                                              $post_cont = array('type' => 'date_picker', 'instructions' => $desc, 'required' => $fdreq, 'display_format' => 'd/m/y','return_format' => 'd/m/y','first_day' => '1');
                                                              break;
                                                           }
                                        case 'color picker':{
                                                              $post_cont = array('type' => 'color_picker', 'instructions' => $desc, 'required' => $fdreq);
                                                              break;
                                                            }
                                        case 'message':{
                                                              $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq,);
                                                              break;
                                                       }
                                        case 'url':{
                                                              $this->check_acfversion();
                                                              $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq);
                                                              break;
                                                   }
                                        case 'text':
                                        case 'number':
                                        case 'password':
                                        case 'email':
                                        case 'tab':{
                                                             $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq);
                                                             break;
                                                   }
                                        case 'repeater':{
                                                             $this->check_acfversion();
                                                             $post_cont = array('type' => $fdtype, 'instructions' => $desc, 'required' => $fdreq, 'min' => '10','max' => '20','layout' =>'table','button_label' => 'Add Row');
                                                             break;
                                                        }
                                        case 'flexible content':{
                                                             $this->check_acfversion();
                                                             $post_cont = array('type' => 'flexible_content', 'instructions' => $desc, 'required' => $fdreq, 'button_label' => 'Add Row','min' => '10','max' => '20');
                                                             break;
                                                                }
                                         default :{
                                                             $post_cont = array('type' =>$fdtype, 'instructions' => $desc, 'required' => $fdreq, 'choices' => $op,'layout' => 'vertical' );
                                                             break;
                                                }
                                }
                        }
                        else{
                                print_r('Enter the field type');die();
                        }
                        $this->register_fields($import_type,$fdlabel,$fdname,$fdtype,$post_cont,$postlist/*,$custompost*/);
                }
        }

        // Register the acf group and fields
        function register_fields($import_type,$fdlabel,$fdname,$fdtype,$post_cont,$postlist/*,$custompost*/)
        {
                global $wpdb;
                $parent_id = 0;
                $field_group = uniqid('group_smack_'.$import_type);
                $date = date("Y-m-d h:i:s");
                $field_id=uniqid('field_smack_');
                $post_type_grp= 'acf-field-group';
                $post_type_fd= 'acf-field';
                $post_cont= serialize($post_cont);
                $acf_id= $this->is_group_exist($import_type);
                $parent_id= $acf_id[0];
                $group_id= $acf_id[1];

                // Insert the acf fields if group exist
                if($parent_id){
                        $check_duplicate = $this->is_duplicate($fdname,$parent_id);
                        if($check_duplicate == 'false'){
				if($fdtype != 'message')
                                $data_array = array('post_date' => $date, 'post_date_gmt' => $date, 'post_content' => $post_cont, 'post_title' => $fdname, 'post_excerpt' => $fdlabel, 'post_status' => 'publish', 'post_name' => $field_id,'post_parent' => $parent_id, 'post_type' => $post_type_fd);
				else
				$data_array = array('post_date' => $date, 'post_date_gmt' => $date, 'post_content' => $post_cont, 'post_title' => $fdname, 'post_status' => 'publish', 'post_name' => $field_id,'post_parent' => $parent_id, 'post_type' => $post_type_fd);
                                $retid = wp_insert_post($data_array);
                                if($group_id){
                                        $wpdb->insert('wp_ultimate_csv_importer_acf_fields',array('groupId'=>$group_id,'fieldId' => $field_id, 'fieldLabel' =>$fdlabel, 'fieldName' => $fdname, 'fieldType' => $fdtype, 'fdOption' => $post_cont));
                                }
                                else{
                                        print_r("Group doesn't exist:".$group_id);
                                }
                        }
                        else{
                                print_r("Field already registered");die();
                        }
                        print_r("Field Added");die();
                }
                // Insert the acf group if not exist
                else{
                        $param = 'post_type';

                        switch($import_type)
                        {
                         	case 'customtaxonomy' : {
								$param = 'taxonomy';	
								$loc = 'all';
								break;
							}
			        case 'users' : {
                                                       $param = 'user_role';
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
                                default :{
                                                 $loc = $import_type;

                                         }
                        }
                        // Insert acf group

                        $count = 0;
                        $post_cont_g = serialize(array('location' => array(array(array('param' => $param ,'operator' => '==', 'value' => $loc))),'position' => 'normal','style' => 'default','label_placement' => 'top','instructon_placement' =>  'label','hide_on_screen' => ''));

                        if($import_type == 'custompost'){
                                foreach($postlist as $list){
                                        $grouplocation[0] = array('param' => $param,'operator' => '==','value' => $list);
                                        $postloc[$count] = $grouplocation;
                                        $count++;
                                }
                                $post_cont_g = serialize(array('location' => $postloc,'position' => 'normal','style' => 'default','label_placement' => 'top','instructon_placement' =>  'label','hide_on_screen' => ''));
                        }
                        $data_array = array('post_date' => $date, 'post_date_gmt' => $date, 'post_content' => $post_cont_g, 'post_title' => 'ACF Pro: Custom Group for '.$import_type, 'post_excerpt' =>'group_smack_'.$import_type, 'post_status' => 'publish', 'comment_status' => 'closed', 'post_name' => $field_group, 'post_type' => $post_type_grp);
                        $retid = wp_insert_post($data_array);
                        $acf_id = $this->is_group_exist($import_type);
                        $parent_id = $acf_id[0];
                        // Insert acf field
                        $data_array = array('post_date' => $date, 'post_date_gmt' => $date, 'post_content' => $post_cont, 'post_title' => $fdname, 'post_excerpt' => $fdlabel,'post_status' => 'publish', 'post_name' => $field_id,'post_parent' => $parent_id, 'post_type' => $post_type_fd);
                        $retid = wp_insert_post($data_array);
                        $wpdb->insert('wp_ultimate_csv_importer_acf_fields',array('groupId'=>$field_group,'fieldId' => $field_id, 'fieldLabel' =>$fdlabel, 'fieldName' => $fdname, 'fieldType' => $fdtype, 'fdOption' => $post_cont));
                        print_r("Field Added");die();
                }

        }

        // Check duplicate acf field
        function is_duplicate($post_title,$post_parent){
                global $wpdb;
                $row = 'false';
                $row = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_title = '$post_title' AND post_parent = '$post_parent' ");
                if(!empty($row)){
                        return 'true';
                }
                else{
                        return 'false';
                }
        }

        // Check acf group is exist or not
        function is_group_exist($import_type){
                global $wpdb;
                $get_acf_groups = 0;
                $group = $wpdb->get_col("SELECT POST_NAME FROM $wpdb->posts where post_type = 'acf-field-group'");
                $type_length = strlen($import_type);
                $group_length = $type_length + 12;
                foreach($group as $group_key){
                        if(substr($group_key, 0,$group_length ) === 'group_smack_'.$import_type ){
                                $group = $group_key;
                                $get_acf_groups = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_type = 'acf-field-group' AND post_name = '$group_key'");
                                break;
                        }
                        else{
                                $group=0;
                        }

                }
                $id = array($get_acf_groups[0],$group);
                return $id;
        }

        // Check acf version
        function check_acfversion(){
                $activeplugins = array();
                $version = '';
                $activeplugins = get_option('active_plugins');
                $plugins = get_plugins();
                $acf_path = 'advanced-custom-fields/acf.php';
                foreach ($plugins as $plug => $key) {
                        if(($plug == $acf_path) && in_array($acf_path,$activeplugins))
                                $version = $key['Version'];
                }
                if($version == '4.3.8' || $version == '4.3.9' || $version == '4.4.0'){
                        print_r("This feature is available only in ACF Pro. Please update the ACF Version .");die();
                }
        }
	// Delete acf field
        function deleteacf_field($import_type,$fdname){
                global $wpdb;
                $row = $this->is_group_exist($import_type);
                $parent = $row[0];
                $group_key = $row[1];
                $sql = "DELETE FROM wp_ultimate_csv_importer_acf_fields WHERE groupid = '$group_key' AND fieldName = '$fdname'";
                $wpdb->query($sql);
                $sql = "DELETE FROM $wpdb->posts WHERE POST_TITLE = '$fdname' AND POST_PARENT = '$parent'";
                $wpdb->query($sql);
                print_r('Field Deleted');
        }
}

new append_acf();
?>
