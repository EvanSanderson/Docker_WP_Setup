<?php
if(!defined('ABSPATH'))
        die('Your requested url were wrong! Please contact your admin.');
$newobj = new WPImporter_includes_helper();
$mappingcount = $_REQUEST['mappingcount'];
$filename = $_REQUEST['filename'];
$postdata = $newobj->csv_file_data($filename,',','');
$core_count = $_REQUEST['count'];
$prefix = $_REQUEST['prefix'];
$url = $_REQUEST['url'];
$slug = $_REQUEST['slug'];
$import= isset($_REQUEST['import_type']) ? $_REQUEST['import_type'] : '';
$register_data = isset($_REQUEST['register'])?$_REQUEST['register']:'false';
add_customrow_for_register_field($mappingcount, $postdata, $core_count, $prefix,$url,$slug,$import,$register_data);

function add_customrow_for_register_field($mappingcount, $postdata, $core_count, $prefix,$url,$slug,$import,$register_data) {

               if($prefix =='CORECUSTFIELDS'){
                       add_corecustomfields($mappingcount,$postdata,$core_count,$prefix,$url,$slug);
               }
               else {
	$get_available_plugin_lists = get_option('active_plugins');
                if(in_array('advanced-custom-fields-pro/acf.php', $get_available_plugin_lists)) {
                        $findacf = 'pro';
                }
                else if(in_array('advanced-custom-fields/acf.php',$get_available_plugin_lists)){
                        $findacf = 'free';
                }
                else
                        $findacf = 'none';
if($register_data != 'true'){
$result = "<tr class='addrow_row'><td colspan = '5' align ='center' id='".$prefix."newrow$core_count'>";
} else {
$result = "<tr class='addrow_row'><td colspan = '5' align ='center' id='newrow'>";
}
$result .= "<div class = 'addrow_div'><div style='align:center'><table class='table'><tr>
       <th colspan = '2' class='addrow_head' >Basic Information for Field Registration<label style = 'color:red;float:right;' > <p id = '".$prefix."close_fd$mappingcount' class='fa fa-times'  onclick = close_ui(this.id,'".$core_count."','".$prefix."')></p></label> </th>
       
        <tr><td class='addrow_column'><label class='wpfields' name='".$prefix."ui_CustomFieldLabel' id='".$mappingcount."ui_CustomFieldLabel'>Label</label></td>
        <td class='addrow_column'><input class = 'addrow_fds' id='".$prefix."ui__CustomFieldLabel$mappingcount' type='text' name='".$prefix."ui__CustomFieldLabel$mappingcount' value='' size=50 onblur = check_fieldempty(this.id,'".$mappingcount."','".$prefix."') ></td></tr>
        <tr class = 'tboddcolor'>
        <td class='addrow_column'><label class='wpfields' name='".$prefix."ui_CustomFieldName' id='".$mappingcount."ui_CustomFieldName'>Name</label></td>
        <td class='addrow_column'><input class = 'addrow_fds' id = '".$prefix."ui__CustomFieldName$mappingcount' type='text' name='".$prefix."ui__CustomFieldName$mappingcount' value='' size=50 onblur = check_fieldempty(this.id,'".$mappingcount."','".$prefix."') /></td></tr>
        <tr>
        <td class='addrow_column'><label class='wpfields'>Description</label></td>
        <td class='addrow_column'><input class = 'addrow_fds' id = '".$prefix."ui__CustomFieldDesc$mappingcount' type='text' name='".$prefix."ui__CustomFieldDesc$mappingcount' value='' size=50/></td></tr>";
       if($prefix == 'PODS'){
               $group_type = 'pods-field-type';
	}
       else if($prefix == 'ACF'){
               $group_type = 'acf-field-type';
       }
       else if($prefix == 'TYPES'){
               $group_type = 'types-field-type';
       }
        $result .= "<tr class = 'tboddcolor'>
        <td class='addrow_column'><label class='wpfields'>Field Type</label></td>
        <td class='addrow_column'>";
        $result .="<span id='".$prefix."_type".$core_count."' style='padding-bottom:10px;' >";
       if($prefix != 'ACF')
        $result .= "<div id='".$prefix."_selectdiv'><select class = 'addrow_select' name='".$prefix."_datatype_$mappingcount' id='".$prefix."_datatype_$mappingcount' onchange = validate_types(this.id,'".$prefix."','".$mappingcount."')>";
       else
        $result .= "<div id='".$prefix."_selectdiv'><select class = 'addrow_select' name='".$prefix."_datatype_$mappingcount' id='".$prefix."_datatype_$mappingcount' onchange = validate_types(this.id,'".$prefix."','".$mappingcount."') onclick = disable_acf_fieldtype(this.id,'".$findacf."')>";
        global $wpdb;
        $fd_type = $wpdb->get_results("select fieldType,choices from smack_field_types where groupType = '".$group_type."'");
        $head = $type = $option = array();
	$k=0;
        $result .= "<option class = 'addrow_option' value='--select--'>". __('--Select--',WP_CONST_ULTIMATE_CSV_IMP_SLUG)."</option>";
        foreach($fd_type as $key){
               $head[$key->fieldType] = $key->fieldType;
               $type[$k] = $key->choices;
               $k++;
               $result .="<b><optgroup class = 'addrow_optgrp' style='font-size:14px;line-height:15px;' label='".$head[$key->fieldType]."' ></optgroup></b>";
               foreach($type as $val){
                       $option = unserialize($val);
               }
               foreach ($option as $v){
                       $result .= "<option class = 'addrow_option' style='line-height:5px;' value='".strtolower($v)."'>$v</option>";
               }
        }
        $result .= "</select></div></span>";
	$result .= "</td></tr>";
        if($prefix == 'ACF'){
        $result .= "<tr style='display:none' id='".$prefix."_trchoice".$mappingcount."'>
                <td class='addrow_column'><label class='wpfields'>Choices</label></td>
                <td class='addrow_column'>";
        $result .="<textarea rows='3' cols='48' name='type_options' id='".$prefix."_type_options".$mappingcount."' onblur=validate_options('".$prefix."','".$mappingcount."') ></textarea>";
        $result .= "<p style='margin-top:10px;width:90%;border-radius:4px;border:1px solid #ddd;padding:10px;'>HINT: Specify the CHOICES with COMMA operator.<br /> Example: Red,Green,Blue</p>";
        $result .="</td></tr>";
        $result .= "<tr style='display:none' id='".$prefix."_truser".$mappingcount."'>
                <td class='addrow_column'><label class='wpfields'>User Role</label></td>
                <td class='addrow_column'>";
        $result .= "<select class = 'addrow_select' name = '".$prefix."_role".$mappingcount."' id = '".$prefix."_role".$mappingcount."' onchange= validate_types(this.id,'".$prefix."','".$mappingcount."') >
                <option class = 'addrow_option' style='line-height:5px;' value='--select--'>--Select--</option>
                <option class = 'addrow_option' style='line-height:5px;' value='administrator'>Administrator</option>
                <option class = 'addrow_option' style='line-height:5px;' value='editor'>Editor</option>
                <option class = 'addrow_option' style='line-height:5px;' value='author'>Author</option>
                <option class = 'addrow_option' style='line-height:5px;' value='subscriber'>Subscriber</option>
                <option class = 'addrow_option' style='line-height:5px;' value='contributor'>Contributor</option>
                </select></td></tr>";
        $result .= "<tr style='display:none' id='".$prefix."_trmsg".$mappingcount."'>
                <td class='addrow_column'><label class='wpfields'>Message</label></td>
                <td class='addrow_column'>";
        $result .="<textarea rows='3' cols='48' name='".$prefix."_msg".$mappingcount."' id='".$prefix."_msg".$mappingcount."' onblur= check_fieldempty(this.id,'".$mappingcount."','".$prefix."') ></textarea>";
        $result .="</td></tr>";
        }
        if($prefix == 'TYPES'){
                $result .= "<tr style='display:none' id='".$prefix."_trchoice".$mappingcount."'>
                <td class='addrow_column'><label class='wpfields'>Choices</label></td>
                <td class='addrow_column'>";
        $result .="<textarea rows='3' cols='48' name='type_options' id='".$prefix."_type_options".$mappingcount."' onblur=validate_options('".$prefix."','".$mappingcount."') ></textarea>";
        $result .= "<p style='margin-top:10px;width:90%;border-radius:4px;border:1px solid #ddd;padding:10px;'>HINT: Specify the CHOICES with COMMA operator.<br /> Example: Red,Green,Blue</p>";
        $result .="</td></tr>";
$result .= "<tr style='display:none;' id = '".$prefix."_ckbox".$mappingcount."'>
        <td><label class='wpfields'>Choices</label></td>
        <td><input class = 'addrow_fds' id='".$prefix."chck_op$mappingcount' type='text' name='".$prefix."chck_op$mappingcount' value='' size=50 onblur = check_fieldempty(this.id,'".$mappingcount."','".$prefix."')></td></tr>";
        }
        if($prefix == 'PODS'){
        $pods_relfd = array('Custom'=> array('custom'=>'Simple (custom defined list)'),
                            'Post Types'=> array('page'=>'Pages (page)','post'=>'Posts (post)'),
                            'Taxonomies' => array('category'=>'Categories (category)','linkcategory'=>'Link Categories (link_category)','tags'=>'Tags (post_tag)'),
                            'Other WP Objects' => array('user'=>'Users','user_role'=>'User Roles','user_capability'=>'User Capabilities','media'=>'Media','comment'=>'Comments','image_size'=>'Image Sizes','navigation'=>'Navigation Menus','post_format'=>'Post Formats','post_status'=>'Post Status'),
                            'Predefined Lists' => array('country'=>'Countries','us_status'=>'US States','calender_week'=>'Calendar - Days of Week','calender_year'=>'Calendar - Months of Year'));
$result .= "<tr style='display:none' id = '".$prefix."_reltofd".$mappingcount."'>
        <td class='addrow_column'><label class='wpfields'>Related To</label></td>
        <td class='addrow_column'>";
$result .= "<select class = 'addrow_select' name='".$prefix."_relatedtype_$mappingcount' id='".$prefix."_relatedtype_$mappingcount' onchange = validate_types(this.id,'".$prefix."','".$mappingcount."','".$import."')>";
        $rel_head = $rel_type = $rel_option = array();
        $i = 0;
        $result .= "<option class = 'addrow_option' style='line-height:5px;' value='--select--'>--Select--</option>";
        foreach($pods_relfd as $key=>$val){
                $result.= "<b><optgroup class = 'addrow_optgrp' style='font-size:14px;line-height:15px;' label='".$key."'></optgroup></b>";
                foreach($val as $key1=>$value)
                $result .= "<option class = 'addrow_option' style='line-height:5px;' value='".$key1."'>$value</option>";
                }
        $custompost = pick_custompost();
        $result.= "<b><optgroup class = 'addrow_optgrp' style='font-size:14px;line-height:15px;' label='Others ..'></optgroup></b>";
        foreach($custompost as $posttypes) {
                        $result .= "<option class = 'addrow_option' style='line-height:5px;' value='".$posttypes."'>$posttypes</option>";
                }
        $wpfds = new WPClassifyFields();
        if(!$wpfds->getallTaxonomies()) {
                        foreach($wpfds->getallTaxonomies() as $taxoKey => $taxoArr) {
                                foreach($taxoArr as $taxoname => $taxovalue) {
                                        $result .= "<option class = 'addrow_option' style='line-height:5px;' value='".$taxoname."'>$taxoname</option>";
                                }
                        }
                }
$result .= "</select>";
$result .= "</tr>";
$result .= "<tr style='display:none;' id = '".$prefix."_CDOfd".$mappingcount."'>
        <td><label class='wpfields'>Custom Defined Options</label></td>
        <td><textarea rows='3' cols='55'></textarea></tr>";
$result .="<tr style='display:none' id = '".$prefix."_bidirecfd".$mappingcount."'>
        <td><label class='wpfields'>Bi-directional Field</label></td>
        <td><select class='addrow_select' name='".$prefix."_bidirec".$mappingcount."' id='".$prefix."_bidirec".$mappingcount."'>
        <option id = '".$prefix."_bidirec_op".$mappingcount."'>No Related Fields Found</option>
        </select></td></tr>";
        }
$result .= "<tr class = 'tboddcolor'>
        <td class='addrow_column'><label class='wpfields'>Options</label></td>
        <td class='addrow_column'><input type='checkbox' id = '".$prefix."ui__CustomFieldOption$mappingcount' name='".$prefix."ui__CustomFieldOption$mappingcount' />Required</td></tr>";
        if($prefix == 'PODS'){
$result .= "<tr>
        <td colspan=2><input type='button' disabled value='Register' id='$prefix".'Register'."$mappingcount' style='float:right;margin-top:25px;margin-bottom:10px;' class='btn btn-success' onclick=register_podscustomfield(this.id,'".$import."','".$prefix."','".$mappingcount."','".$core_count."')>";
$result .="</td></tr>";
        }
        if($prefix == 'ACF'){
$result .= "<tr>
        <td colspan=2><input type='button' disabled value='Register' id='$prefix".'Register'."$mappingcount' style='float:right;margin-top:25px;margin-bottom:10px;' class='btn btn-success' onclick=register_acfcustomfield(this.id,'".$import."','".$prefix."','".$mappingcount."','".$core_count."','".$findacf."')> ";
$result .="</td></tr>";
        }
        if($prefix == 'TYPES'){
$result .= "<tr>";
$result .= "<td colspan=2><input type='button' disabled value='Register' id='$prefix".'Register'."$mappingcount' style='float:right;margin-top:25px;margin-bottom:10px;' class='btn btn-success' onclick=register_typescustomfield(this.id,'".$import."','".$prefix."','".$mappingcount."','".$core_count."')> ";
$result .= "</td></tr>";
        }
        $result .= "</tr></table></div></div></td></tr>";
        //print_r($result);
        //die();
//}
//else{
	$realfilenm = isset($_REQUEST['realfilenm']) ? $_REQUEST['realfilenm'] : '';
        $result .= "<tr style='display:none;' id='".$prefix."_tr_count".$core_count."'>";
        $result .= "<td id='".$prefix."_tdc_count".$core_count."' style='width:10%;padding:15px;'>";
        $result .= "<input type='hidden' id='hduser".$mappingcount."' name='hduser".$mappingcount."' value='' />";
        $result .= "<input type='hidden' id='hdmsg".$mappingcount."' name='hdmsg".$mappingcount."' value='' />";
        $result .= "<input type='hidden' id='hdtitle".$mappingcount."' name='hdtitle".$mappingcount."' value='' />";
        $result .= "<input type = 'hidden' value = '' id = '".$prefix.$mappingcount."name'>";
        $result .= "</td>";
	if($register_data != 'true'){
        $result .= "<td id='".$prefix."_tdg_count".$core_count."' class='left_align' style='width:20%;padding-top:1.3%;display:none;'>";
	}
	else {
	$result .= "<td id='".$prefix."_tdg_count".$core_count."' class='left_align' style='width:20%;padding-top:1.3%;'>";
	}
        $result .= "<label class='wpfields' name='".$prefix."_CustomField' id='".$mappingcount."_CustomField'><input type='textbox' id='".$prefix."__CustomField".$mappingcount."' name='".$prefix."__CustomField".$mappingcount."' value='' onblur=valid_fieldname(this.id,$mappingcount,$prefix)></label><br><label id='CustomField$mappingcount' class='samptxt' for = 'bbb'>[Name: CustomField$mappingcount]</label></td>";
	
	$result .= " <input type='hidden' name='".$prefix."req__fieldname". $mappingcount."' id='".$prefix."req__".$mappingcount."' value = '' class='req_hiddenclass'/>";
	if($register_data != 'true'){
        $result .= "<td id='".$prefix."_tdh_count".$core_count."' class='left_align' style='width:20%;display:none;'>";
	}
	else {
	$result .= "<td id='".$prefix."_tdh_count".$core_count."' class='left_align' style='width:20%;'>";
	}
        $result .= "<span id='".$prefix."__mapping_span$mappingcount' >";
        $result .="<div id='selectdiv'><select name='".$prefix."__mapping$mappingcount' id='".$prefix."__mapping$mappingcount' class='uiButton'>";        
                        $filenm_arr = explode('.xml',$realfilenm);
                        $xml_data = array();
                        if(count($filenm_arr) == 2){
					$filename = $_REQUEST['filename'];
                                        $name = '';
                                        $newobj = new WPImporter_includes_helper();
                                        $uploadDir = wp_upload_dir();
                                        $uploadxml_file = $uploadDir['basedir'] . '/' . 'ultimate_importer' . '/' . $filename;
					$xml_file = fopen($uploadxml_file,'r');
					$xml_read = fread($xml_file , filesize($uploadxml_file));
					fclose($xml_file);
                                        $xml_object = new XML2Array();
                                        $xml_arr = $xml_object->createArray($xml_read);
//echo '<pre>';print_r($xml_arr);echo '</pre>';
                                        $newobj->xml_file_data($xml_arr,$xml_data);
                                        $reqarr = $newobj->xml_reqarr($xml_data);
                                        $getrecords = $newobj->xml_importdata($xml_data);
					$result .= $newobj->xml_mappingbox($getrecords,$name,$prefix,$core_count);
                         }
                
	else {
	foreach($postdata as $key => $value){
		$mappedarr = $value;
	}
	$result .="<option id='select'>-- Select --</option>";
        foreach ($mappedarr as $key => $value) {
                $result .="<option value='$key'>$key</option>";
        }
	$result .= "<option value='header_manip'>Header Manipulation</option>";
	}
        $result .="</select></div></span></td>";
        $result .="<td style='width:20%'></td>";
	if($register_data != 'true'){
	$result .="<td id='".$prefix."_tdi_count".$core_count."' class='left_align' style='width:30%;display:none;'>";
	}
	else {
	$result .="<td id='".$prefix."_tdi_count".$core_count."' class='left_align' style='width:30%;'>";
	}
	$result .="<span title='Static' style='margin-right:15px;' id='".$prefix."_staticbutton_mapping$mappingcount' onclick=static_button(this.id,'".$prefix."','".$mappingcount."')><img src='".$url."/plugins/".$slug."/images/static.png' width='24' height='24' /></span>";
	$result .="<span title='Formula' style='margin-right:15px;' id='".$prefix."_formulabutton_mapping$mappingcount' onclick=formula_button(this.id,'".$prefix."','".$mappingcount."')><img src='".$url."/plugins/".$slug."/images/formula.png' width='24' height='24' /></span>";
	$result .="<div  id='".$prefix."_customdispdiv_mapping$mappingcount' style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>";
                if($prefix == 'PODS')
               $result .="<input type='button'  value='Delete' id='$prefix".'Delete'."$mappingcount' style='float:right;margin-top:25px;margin-right:25px;margin-bottom:10px;display:none;' class='btn btn-danger' onclick=delete_podscustomfield(this.id,'".$import."','".$prefix."','".$mappingcount."','".$core_count."')> ";
                else if($prefix == 'ACF')
               $result .="<input type='button'  value='Delete' id='$prefix".'Delete'."$mappingcount' style='float:right;margin-top:25px;margin-right:25px;margin-bottom:10px;display:none;' class='btn btn-danger' onclick=delete_acfcustomfield(this.id,'".$import."','".$prefix."','".$mappingcount."','".$core_count."','".$findacf."')> ";
                else if($prefix == 'TYPES')
               $result .="<input type='button'  value='Delete' id='$prefix".'Delete'."$mappingcount' style='float:right;margin-top:25px;margin-right:25px;margin-bottom:10px;display:none;' class='btn btn-danger' onclick=delete_typescustomfield(this.id,'".$import."','".$prefix."','".$mappingcount."','".$core_count."')> ";
                else
               $result .="<input type='button'  value='Delete' id='$prefix".'Delete'."$mappingcount' style='float:right;margin-top:25px;margin-right:25px;margin-bottom:10px;display:none;' class='btn btn-danger' onclick=delete_podscustomfield(this.id,'".$import."','".$prefix."','".$mappingcount."','".$core_count."')> ";
        $result .="</div>";
        $result .= "</td></tr>";
	print_r($result);
	die;
//}
}
}
function pick_custompost(){
        $wpfds = new WPClassifyFields();
        $wpcsvsettings = get_option('wpcsvprosettings');
        global $wpdb;
        $cust_post_list_count = 0;
        $allPostTypes = array();
        $pods_post_arr = array();
        $cctm_post_arr = array();
        $cpt_post_arr = array();
        $pods_others = array('post','page','user','comment','wpsc-product','product','product-variation','shop_order','shop_order_refund','shop_coupon','wpsc_product_file','mp_order');
        foreach (get_post_types() as $key => $value) {
                if(isset($wpcsvsettings['cptuicustompost']) &&( $wpcsvsettings['cptuicustompost'] == 'enable') && !in_array($value, $allPostTypes)) {
                                foreach($wpfds->getCPTPosts() as $cptKey) {
                                        $allPostTypes[$cptKey] = $cptKey;
                                }
                        } if(isset($wpcsvsettings['cctmcustompost']) &&( $wpcsvsettings['cctmcustompost'] == 'enable') && !in_array($value, $allPostTypes)) {
                                foreach($wpfds->getCCTMPosts() as $cctmKey) {
                                        $allPostTypes[$cctmKey] = $cctmKey;
                                }
                        } if(isset($wpcsvsettings['podscustompost']) &&( $wpcsvsettings['podscustompost'] == 'enable')&& !in_array($value, $allPostTypes)) {
                                foreach($wpfds->getPODSPosts() as $podsKey) {
                                        if(!in_array($podsKey,$pods_others))
                                        $allPostTypes[$podsKey] = $podsKey;
                                }
                        } if(isset($wpcsvsettings['typescustompost']) &&( $wpcsvsettings['typescustompost'] == 'enable')&& !in_array($value, $allPostTypes)) {
                                foreach($wpfds->getTypesPosts() as $typesKey) {
                                        $allPostTypes[$typesKey] = $typesKey;
                                }
                        }
                if(!in_array($value, $wpfds->getCPTPosts()) && !in_array($value, $wpfds->getCCTMPosts()) &&  !in_array($value, $wpfds->getPODSPosts()) && !in_array($value, $wpfds->getTypesPosts()) && ($value != 'featured_image') && ($value != 'attachment') && ($value != 'wpsc-product') && ($value != 'wpsc-product-file') && ($value != 'revision') && ($value != 'nav_menu_item') && ($value != 'post') && ($value != 'page') && ($value != 'wp-types-group') && ($value != 'wp-types-user-group') && ($value != 'product') && ($value != 'product_variation') && ($value != 'shop_order') && ($value != 'shop_coupon') && ($value != 'acf') && ($value != 'acf-field') && ($value != 'acf-field-group') && ($value != '_pods_pod') && ($value != '_pods_field') && ($value != 'shop_order_refund') && ($value != 'shop_webhook') && !in_array($value, $allPostTypes)) {
                                $allPostTypes[$value] = $value;
                        }
        }
        return $allPostTypes;
}                      
function add_corecustomfields($mappingcount,$postdata,$core_count,$prefix,$url,$slug){
	$realfilenm = isset($_REQUEST['realfilenm']) ? $_REQUEST['realfilenm'] : '';
        $result = "<tr id='".$prefix."_tr_count".$core_count."'>";
        $result .= "<td id='".$prefix."_tdc_count".$core_count."' style='width:10%;padding:15px;'>";
       $result .= "<input type='hidden' id='hdtitle".$mappingcount."' name='hdtitle".$mappingcount."' value='' />";
       $result .= "</td>";
        $result .= "<td id='".$prefix."_tdg_count".$core_count."' class='left_align' style='width:20%'>";
        $result .= "<label class='wpfields' name='".$prefix."_CustomField' id='".$mappingcount."_CustomField'><input type='textbox' id='".$prefix."__CustomField$mappingcount' name='".$prefix."__CustomField$mappingcount' value='' onblur= valid_fieldname(this.id,'".$mappingcount."','".$prefix."')></label><br><label id = 'CustomField$mappingcount' class='samptxt'>[Name: CustomField$mappingcount]</label></td>";
        $result .= " <input type='hidden' name='".$prefix."req__fieldname". $mappingcount."' id='".$prefix."req__".$mappingcount."' value = '' class='req_hiddenclass'/>";
        $result .= "<td id='".$prefix."_tdh_count".$core_count."' class='left_align' style='width:20%'>";
        $result .= "<span id='".$prefix."_mapping$mappingcount' >";
        $result .="<div id='selectdiv'><select name='".$prefix."__mapping$mappingcount'  id='".$prefix."__mapping$mappingcount' class='uiButton' disabled onchange=register_corefields(this.id,'".$prefix."','".$mappingcount."','".$core_count."')>";
                        $filenm_arr = explode('.xml',$realfilenm);
                        $xml_data = array();
                        if(count($filenm_arr) == 2){
                                        $filename = $_REQUEST['filename'];
                                        $name = '';
                                        $newobj = new WPImporter_includes_helper();
                                        $uploadDir = wp_upload_dir();
                                        $uploadxml_file = $uploadDir['basedir'] . '/' . 'ultimate_importer' . '/' . $filename;
                                        $xml_file = fopen($uploadxml_file,'r');
                                        $xml_read = fread($xml_file , filesize($uploadxml_file));
                                        fclose($xml_file);
                                        $xml_object = new XML2Array();
                                        $xml_arr = $xml_object->createArray($xml_read);
//echo '<pre>';print_r($xml_arr);echo '</pre>';
                                        $newobj->xml_file_data($xml_arr,$xml_data);
                                        $reqarr = $newobj->xml_reqarr($xml_data);
                                        $getrecords = $newobj->xml_importdata($xml_data);
                                        $result .= $newobj->xml_mappingbox($getrecords,$name,$prefix,$core_count);
                         }
        else {

        $result .="<option id='select'>-- Select --</option>";
        foreach($postdata as $key => $value){
                $mappedarr = $value;
        }
        foreach ($mappedarr as $key => $value) {
                $result .="<option value='$key'>$key</option>";
        }
	$result .= "<option value='header_manip'>Header Manipulation</option>";
	}
        $result .="</select></div></span></td>";
        $result .= "<td id='".$prefix."_tdd_count".$core_count."' class='left_align' style='width:20%'>";
       $result .= "</td>";
        $result .="<td id='".$prefix."_tdi_count".$core_count."' class='left_align' style='width:30%'>";
        $result .="<span title='Static' style='margin-right:15px;' id='".$prefix."_staticbutton_mapping$mappingcount' onclick=static_button(this.id,'".$prefix."','".$mappingcount."')><img src='".$url."/plugins/".$slug."/images/static.png' width='24' height='24' /></span>";
        #$result .="<span title='Dynamic' style='margin-right:15px;' id='".$prefix."_dynamicbutton_mapping$mappingcount' onclick=dynamic_button(this.id,'".$prefix."','".$mappingcount."')><img src='".$url."/plugins/".$slug."/images/dynamic.png' width='24' height='24' /></span>";
        $result .="<span title='Formula' style='margin-right:15px;' id='".$prefix."_formulabutton_mapping$mappingcount' onclick=formula_button(this.id,'".$prefix."','".$mappingcount."')><img src='".$url."/plugins/".$slug."/images/formula.png' width='24' height='24' /></span>";
        $result .="<div  id='".$prefix."_customdispdiv_mapping$mappingcount' style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>";
        $result .="</td></tr>";
        print_r($result);
        die;
}

