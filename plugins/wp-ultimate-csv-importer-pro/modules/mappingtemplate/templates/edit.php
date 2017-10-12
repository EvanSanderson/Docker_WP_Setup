<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

$skinnycontroller = new SkinnyControllerWPCsvPro();
$mapping_info = $skinnyData['mapping'];
$templatename = $skinnyData['templatename'];
$event_key = $skinnyData['event_key'];
$helperObj = new WPImporter_includes_helper();
$curr_action = $skinnyData['module'];
$uploadfilename = $skinnyData['filename'];
#$imploded_array = implode(',', array_keys($mapping));
#$h1_count = count($impCE->defCols) + 2;
#$h2_count = count($mapping);
# generate help tooltip
$mapping_helpcontent = "Give a name for your custom field.";
$mapping_style = 'padding-left:8px;padding-top:8px;float:left';
$help_tooltip = $helperObj->smack_generatehelp_tooltip($mapping_helpcontent, $mapping_style);
$wpcsvsettings = array();
$wpcsvsettings = get_option('wpcsvprosettings');
$activeplugins = get_option('active_plugins');
# generate tooltop ends here

/*
$showmapping = "<form name = 'update_mappingtemplate' id = '' action = 'admin.php?page=" . WP_CONST_ULTIMATE_CSV_IMP_SLUG . "/index.php&__module=mappingtemplate&__action=savetemplate' method = 'POST'>";
$showmapping .= "<input type = 'hidden' name = 'h1' id = 'h1' value = '{$h1_count}'>";
$showmapping .= "<input type = 'hidden' name = 'h2' id = 'h2' value = '{$h2_count}'>";
$showmapping .= "<input type = 'hidden' name = 'templateid' id = 'templateid' value = '{$skinnyData['templateid']}'>";
$showmapping .= "<input type = 'hidden' name='selectedImporter' id = 'selectedImporter' value = 'post'/>
   		<input type = 'hidden' id = 'prevoptionindex' name = 'prevoptionindex' value = ''  />
   		<input type = 'hidden' id = 'prevoptionvalue' name = 'prevoptionvalue' value = ''  />
   		<input type = 'hidden' id = 'current_record'  name = 'current_record'  value = '0' />
   		<input type = 'hidden' id = 'imploded_header' name = 'imploded_array' value = '{$imploded_array}'>";

$showmapping .= "<table class = 'table table-condensed'>";
 */ ?>
<div style="width:98%;"> 
<form name ="update_mappingtemplate" id ="" action ="admin.php?page=<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/index.php&__module=mappingtemplate&__action=savetemplate" method ="POST">
<!-- <input type ="hidden" name ="h1" id ="h1" value ="<?php //echo $h1_count; ?>">
<input type ="hidden" name ="h2" id ="h2" value ="<?php //echo $h2_count; ?>"> -->
<input type ="hidden" name ="templateid" id ="templateid" value ="<?php echo $skinnyData['templateid']; ?>">
<input type ="hidden" name="selectedImporter" id ="selectedImporter" value ="post"/>
<input type ="hidden" id ="prevoptionindex" name ="prevoptionindex" value =""  />
<input type ="hidden" id ="prevoptionvalue" name ="prevoptionvalue" value =""  />
<input type ="hidden" id ="current_record"  name ="current_record"  value ="0" />
<?php
$i = 0;
#print('Module: ' . $curr_action);
$classifyObj = new WPClassifyFields;
$xml_object = new XML2Array();
$get_available_groups = $classifyObj->get_availgroups($curr_action);
//$headers = $helperObj->csv_file_data($event_key, '', 'headers');
$uploadDir = wp_upload_dir();
$upload_file = $uploadDir['basedir'] . '/' . 'ultimate_importer' . '/' . $event_key;
$file_extension = pathinfo($uploadfilename,PATHINFO_EXTENSION);
if($file_extension == 'xml'){
	$xml_file = fopen($upload_file,'r');
        $xml_read = fread($xml_file , filesize($upload_file));
        fclose($xml_file);
        $xml_arr = $xml_object->createArray($xml_read);
	$xml_data = array();
	$helperObj->xml_file_data($xml_arr,$xml_data);
	$reqarr = $helperObj->xml_reqarr($xml_data);
        $headers = $helperObj->xml_importdata($xml_data);
}else{
	$headers = $helperObj->csv_file_data($upload_file, '', 'headers');
}
$mappingcount = 0;
?>
<!--<div class="panel-group" id="accordion" style = "width:98.3%;margin-top:-5px;">-->
<div id = 'temp' style="width:98%;border: 1px solid #d1d1d1;background-color:#fff;padding: 20px 20px 20px 0;">
<?php
foreach($get_available_groups as $groupKey) {
	if($groupKey == 'CORE') { ?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#Core_Fields" data-parent="#accordion">
                <div id= "corehead" class="panel-title"> <b> <?php echo __("WordPress Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-minus-circle pull-right' id = 'Core_Fields_h_span'> </span> </div>
		</div>
		<div id="Core_Fields" style="height:auto;">
		<div class="grouptitlecontent " id="corefields_content">
		<table class="table table-striped mappingtemplate" style="font-size: 12px;" id="CORE_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php 	$CORE_count = 0;
		$prefix = $groupKey;
		$coreFields = $classifyObj->WPCoreFields($curr_action);
#print('<pre>'); print_r($coreFields); print('</pre>');
		foreach($coreFields[$groupKey] as $key => $val) { 
        	        $label = $val['label'];
	                $name = $val['name'];
		?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($CORE_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($CORE_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($CORE_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$CORE_count);
                        }else{?>
                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php echo __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected > <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }}?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$CORE_count++;
	                $mappingcount++;
		} ?> 
		</tbody>
		</table>
		<input type='hidden' id='CORE_count' value= '<?php echo $CORE_count; ?>'>
		</div>
		</div>
		</div>
	<?php } else if($groupKey == 'ACF') { ?>
        <?php if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress' || $curr_action == 'users' || $curr_action == 'customtaxonomy') {
        if(isset($wpcsvsettings['acfcustomfield']) && $wpcsvsettings['acfcustomfield'] == 'enable') { 
	if(in_array('advanced-custom-fields/acf.php',$activeplugins) || in_array('advanced-custom-fields-pro/acf.php',$activeplugins)){
	?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#acf_addcustom_panel" data-parent="#accordion">
                <div id = "acfhead" class="panel-title"> <b> <?php echo __("ACF CUSTOM Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'acf_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="acf_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id="acffields_content">
		<table class="table table-striped" style="font-size: 12px;" id="ACF_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $ACF_count =0;
		$prefix = $groupKey;
		$acfFields = $classifyObj->ACFCustomFields($curr_action);
		if(!empty($acfFields)) {
                foreach($acfFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($ACF_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($ACF_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($ACF_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$ACF_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$ACF_count++;
	                $mappingcount++;
                }
		} ?>
		</tbody>
		</table>
		<input type='hidden' id='ACF_count' value= '<?php echo $ACF_count; ?>'>
		<!-- Add Custom field button-->
		<!--<div class = ''>
		<input id="acf_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="acf_addcustom" onclick='disp(ACF_table, <?php echo $ACF_count; ?>, "ACF",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
	<?php } else if($groupKey == 'RF') { ?>
		<?php if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress') {
if(isset($wpcsvsettings['acfcustomfield']) && $wpcsvsettings['acfcustomfield'] == 'enable') { 
if(in_array('advanced-custom-fields-pro/acf.php',$activeplugins)){ ?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#rffield" data-parent="#accordion">
		<div id="rfhead" class="panel-title"> <b> <?php echo __("RF CUSTOM Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'rffield_h_span'> </span> </div>
		</div>
		<div id="rffield" style="height:auto;">
		<div class="grouptitlecontent " id="acfrf_content">
		<table class="table table-striped" style="font-size: 12px;" id="RF_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $RF_count =0;
		$prefix = $groupKey;
		$acfFields = $classifyObj->ACFCustomFields($curr_action);
		if(!empty($acfFields) && isset($acfFields[$groupKey])) {
                foreach($acfFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($RF_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($RF_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($RF_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$RF_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$RF_count++;
	                $mappingcount++;
                }
		} ?>
		</tbody>
		</table>
		<input type='hidden' id='RF_count' value= '<?php echo $RF_count; ?>'>
		<!-- Add Custom field button-->
		<!--<div class = ''>
		<input id="acf_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="acf_addcustom" onclick='disp(ACF_table, <?php// echo $RF_count; ?>, "ACF",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
	<?php } else if($groupKey == 'PODS') { ?>
        <?php  if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress') {
        if(isset($wpcsvsettings['podscustomfield']) && $wpcsvsettings['podscustomfield'] == 'enable') { 
	if(in_array('pods/init.php',$activeplugins)){
?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#pods_addcustom_panel" data-parent="#accordion">
		<div id="podshead" class="panel-title"> <b> <?php echo __("PODS Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'pods_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="pods_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id="podsfield_content">
		<table class="table table-striped" style="font-size: 12px;" id="PODS_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $PODS_count=0;
		$prefix = $groupKey;
                $podsFields = $classifyObj->PODSCustomFields($curr_action);
		if(!empty($podsFields)) {
                foreach($podsFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($PODS_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($PODS_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($PODS_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$PODS_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$PODS_count++;
	                $mappingcount++;
                }
		} ?>
		</tbody>
		</table>
		<input type='hidden' id='PODS_count' value= '<?php echo $PODS_count; ?>'>
		<!-- Add Custom field button-->
		<!--<div class = ''>
		<input id="pods_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="pods_addcustom" onclick='disp(PODS_table, <?php echo $PODS_count; ?>, "PODS",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
        <?php } else if($groupKey == 'TYPES') { ?>
		<?php if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress' || $curr_action == 'users') {
        if(isset($wpcsvsettings['typescustomfield']) && $wpcsvsettings['typescustomfield'] == 'enable') { 
	if(in_array('types/wpcf.php',$activeplugins)){
?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#types_addcustom_panel" data-parent="#accordion">
		<div id="typeshead" class="panel-title"> <b> <?php echo __("TYPES Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'types_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="types_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id="typesfield_content">
		<table class="table table-striped" style="font-size: 12px;" id="TYPES_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $TYPES_count = 0;
		$prefix = $groupKey;
                $typesFields = $classifyObj->TypesCustomFields($curr_action);
		if(!empty($typesFields)) {
                foreach($typesFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($TYPES_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($TYPES_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($TYPES_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$TYPES_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$TYPES_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='TYPES_count' value= '<?php echo $TYPES_count; ?>'>
		<!-- Add Custom field button-->
		<!--<div class = ''>
		<input id="types_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="types_addcustom" onclick='disp(TYPES_table, <?php echo $TYPES_count; ?>, "TYPES",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
        <?php } else if($groupKey == 'CCTM') { ?>
		<?php if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress') {
if(isset($wpcsvsettings['cctmcustomfield']) && $wpcsvsettings['cctmcustomfield'] == 'enable') { 
	if(in_array('custom-content-type-manager/index.php',$activeplugins)){
		?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading"  data-target="#cctm_addcustom_panel" data-parent="#accordion">
<div id="cctmhead" class="panel-title"> <b> <?php echo __("CCTM Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'cctm_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="cctm_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id="cctmfield_content">
		<table class="table table-striped" style="font-size: 12px;" id="CCTM_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $CCTM_count = 0;
		$prefix = $groupKey;
                $CCTMFields = $classifyObj->CCTMCustomFields($curr_action);
		if(!empty($CCTMFields)) {
                foreach($CCTMFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($CCTM_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($CCTM_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($CCTM_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$CCTM_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$CCTM_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='CCTM_count' value= '<?php echo $CCTM_count; ?>'>
		<!-- Add Custom field button-->
		<!-- <div class = ''>
		<input id="cctm_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="cctm_addcustom" onclick='disp(CCTM_table, <?php echo $CCTM_count; ?>, "CCTM",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php } 
		}
		} ?>
        <?php } else if($groupKey == 'AIOSEO') { ?>
        <?php if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress') {
        if(isset($wpcsvsettings['rseooption']) && $wpcsvsettings['rseooption'] == 'aioseo') { 
	if(in_array('all-in-one-seo-pack/all_in_one_seo_pack.php',$activeplugins)){
	?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#aiofield" data-parent="#accordion">
		<div id="aiohead" class="panel-title"> <b> <?php echo __("All-in-One SEO Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'aiofield_h_span'> </span> </div>
		</div>
		<div id="aiofield" style="height:auto;">
		<div class="grouptitlecontent " id="aiofields_content">
		<table class="table table-striped" style="font-size: 12px;" id="AIOSEO_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $AIOSEO_count=0;
		$prefix = $groupKey;
                $aioseoFields = $classifyObj->aioseoFields();
		if(!empty($aioseoFields)) {
                foreach($aioseoFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($AIOSEO_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($AIOSEO_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($AIOSEO_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$AIOSEO_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$AIOSEO_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='AIOSEO_count' value= '<?php echo $AIOSEO_count; ?>'>
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
        <?php } else if($groupKey == 'YOASTSEO') { ?>
<?php if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress') {
        if(isset($wpcsvsettings['rseooption']) && $wpcsvsettings['rseooption'] == 'yoastseo') { 
	if(in_array('wordpress-seo/wp-seo.php',$activeplugins)){?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#yoastfield" data-parent="#accordion">
		<div id="yoasthead" class="panel-title"> <b> <?php echo __("YOAST SEO Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'yoastfield_h_span'> </span> </div>
		</div>
		<div id="yoastfield" style="height:auto;">
		<div class="grouptitlecontent " id="yoastfield_content">
		<table class="table table-striped" style="font-size: 12px;" id="YOASTSEO_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $YOASTSEO_count = 0;
		$prefix = $groupKey;
                $yoastseoFields = $classifyObj->yoastseoFields();
		if(!empty($yoastseoFields)) {
                foreach($yoastseoFields[$groupKey] as $key => $val) {
                        $label = $val['label'];
			$name = $val['name'];
		?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($YOASTSEO_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($YOASTSEO_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($YOASTSEO_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$YOASTSEO_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$YOASTSEO_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='YOASTSEO_count' value= '<?php echo $YOASTSEO_count; ?>'>
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
        <?php } else if($groupKey == 'WPMEMBERS') { ?>
                <?php if($curr_action == 'users') {
                if(isset($wpcsvsettings['rwpmembers']) && $wpcsvsettings['rwpmembers'] == 'enable') { 
		if(in_array('wp-members/wp-members.php',$activeplugins)){?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#wpmembers_addcustom_panel" data-parent="#accordion">
		<div id="wpmembershead" class="panel-title"> <b> <?php echo __("WP-Members Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'wpmembers_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="wpmembers_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id="wpmemfield_content">
		<table class="table table-striped" style="font-size: 12px;" id="WPMEMBERS_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $WPMEMBERS_count = 0;
		$prefix = $groupKey;
                $wpmembersFields = $classifyObj->wpmembersFields();
		if(!empty($wpmembersFields)) {
                foreach($wpmembersFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($WPMEMBERS_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($WPMEMBERS_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($WPMEMBERS_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$WPMEMBERS_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$WPMEMBERS_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='WPMEMBERS_count' value= '<?php echo $WPMEMBERS_count; ?>'>
		<!-- Add Custom field button-->
		<!-- <div class = ''>
		<input id="wpmembers_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="wpmembers_addcustom" onclick='disp(WPMEMBERS_table, <?php echo $WPMEMBERS_count; ?>, "WPMEMBERS",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
        <?php } else if($groupKey == 'WPECOMMETA') { ?>
                <?php  if($curr_action == 'wpcommerce') {
                if(isset($wpcsvsettings['rwpmembers']) && $wpcsvsettings['rwpmembers'] == 'enable') { 
		if(in_array('wp-e-commerce-custom-fields/custom-fields.php',$activeplugins)){?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#wpecom_addcustom_panel" data-parent="#accordion">
		<div id="wpecomhead" class="panel-title"> <b> <?php echo __("WP-eCommerce Custom Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'wpecom_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="wpecom_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id="wpcustfield_content">
		<table class="table table-striped" style="font-size: 12px;" id="WPECOM_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $WPECOM_count = 0;
		$prefix = $groupKey;
                $wpecommerceCustomFields = $classifyObj->wpecommerceCustomFields();
		if(!empty($wpecommerceCustomFields)) {
                foreach($wpecommerceCustomFields[$groupKey] as $key => $val) {
                        $label = $val['label'];
			$name = $val['name'];
		?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($WPECOM_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($WPECOM_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($WPECOM_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$WPECOM_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$WPECOM_count++;
	                $mappingcount++;
		}
                } ?> 
		</tbody>
		</table>
		<input type='hidden' id='WPECOMMETA_count' value= '<?php echo $WPECOM_count; ?>'>
		<!-- Add Custom field button-->
		<!-- <div class = ''>
		<input id="wpecom_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="wpecom_addcustom" onclick='disp(WPECOM_table, <?php echo $WPECOM_count; ?>, "WPECOMMETA",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php }
		}
		} ?>
        <?php } else if($groupKey == 'ECOMMETA') { ?>
                <?php if($curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'woocommerce_variations' || $curr_action == 'woocommerce_coupons' || $curr_action == 'woocommerce_orders' || $curr_action == 'woocommerce_refunds' || $curr_action == 'eshop' || $curr_action == 'marketpress') { 
if(in_array('wp-e-commerce-custom-fields/custom-fields.php',$activeplugins) || in_array('woocommerce/woocommerce.php',$activeplugins) || in_array('eshop/eshop.php',$activeplugins) || in_array('wordpress-ecommerce/marketpress.php',$activeplugins)){
?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#ecom_addcustom_panel" data-parent="#accordion">
		<div id="ecomhead" class="panel-title"> <b> <?php echo __("eCommerce Meta Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'ecom_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="ecom_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id ="ecommetfield_content">
		<table class="table table-striped" style="font-size: 12px;" id="ECOM_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $ECOM_count=0; 
		$prefix = $groupKey;
                $ecommerceMetaFields = $classifyObj->ecommerceMetaFields($curr_action);
		if(!empty($ecommerceMetaFields)) {
                foreach($ecommerceMetaFields[$groupKey] as $key => $val) {
			$label = $val['label'];
			$name = $val['name'];
                ?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($ECOM_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($ECOM_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($ECOM_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$ECOM_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$ECOM_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='ECOMMETA_count' value= '<?php echo $ECOM_count; ?>'>
		<!-- Add Custom field button-->
		<!--<div class = ''>
		<input id="ecom_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="ecom_addcustom" onclick='disp(ECOM_table, <?php echo $ECOM_count; ?>, "ECOMMETA",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php } 
		}?>
        <?php } else if($groupKey == 'CORECUSTFIELDS') { ?>
		 <?php if($curr_action == 'post' || $curr_action == 'page' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress') { ?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#cust_addcustom_panel" data-parent="#accordion">
		<div id="custhead" class="panel-title"> <b> <?php echo __("WordPress Custom Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'cust_addcustom_panel_h_span'> </span> </div>
		</div>
		<div id="cust_addcustom_panel" style="height:auto;">
		<div class="grouptitlecontent " id="corecustfield_content" >
		<table class="table table-striped" style="font-size: 12px;" id="CUST_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $CUST_count=0; 
		$prefix = $groupKey;
                $commonMetaFields = $classifyObj->commonMetaFields();
		if(!empty($commonMetaFields)) {
                foreach($commonMetaFields[$groupKey] as $key => $val) {
                        $label = $val['label'];
			$name = $val['name'];
		?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($CUST_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($CUST_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($CUST_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$CUST_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$CUST_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='CORECUSTFIELDS_count' value= '<?php echo $CUST_count; ?>'>
		<!-- Add Custom field button-->
		<!-- <div class = ''>
		<input id="cust_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="cust_addcustom" onclick='disp(CUST_table, <?php echo $CUST_count; ?>, "CORECUSTFIELDS",this.id)' style="margin-left:20px;margin-bottom:15px;">
		</div> -->
		</div>
		</div>
		</div>
		<?php } ?>
        <?php } else if($groupKey == 'TERMS') { ?>
<?php  if($curr_action == 'post' || $curr_action == 'custompost' || $curr_action == 'eshop' || $curr_action == 'wpcommerce' || $curr_action == 'woocommerce_products' || $curr_action == 'marketpress') { ?>
		<div class="panel panel-default edit-template">
		<div class="panel-heading" data-target="#termstaxfield" data-parent="#accordion">
		<div id="termshead" class="panel-title"> <b> <?php echo __("Terms / Taxonomies Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'termstaxfield_h_span'> </span> </div>
		</div>
		<div id="termstaxfield" style="height:auto;">
		<div class="grouptitlecontent " id="termtax_content">
		<table class="table table-striped" style="font-size: 12px;" id="TERMS_table">
		<tbody>
		<tr>
		<td class='columnheader'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		<td class='columnheader'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
		</tr>
	<?php $TERMS_count=0; 
		$prefix = $groupKey;
                $termsandtaxos = $classifyObj->termsandtaxos($curr_action);
		if(!empty($termsandtaxos)) {
                foreach($termsandtaxos[$groupKey] as $key => $val) {
                	$label = $val['label'];
			$name = $val['name'];
		?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($TERMS_count); ?>'>
			<td id='<?php print($prefix); ?>_tdg_count<?php print($TERMS_count); ?>' class="left_align">
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label>
			<input type='hidden' name='<?php echo $groupKey . '__fieldname' . $mappingcount; ?>' id='<?php echo $groupKey . '__' . $name; ?>' value='<?php echo $name; ?>' />
			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($TERMS_count); ?>" class="left-align">
			<span id="<?php echo $key; ?>__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                        <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>

                                <?php echo $helperObj->xml_mappingbox($headers,$name,$prefix,$TERMS_count);
                        }else{?>

                        <?php if(!in_array('post_status', $headers ) && $name == 'post_status') { ?>
                               <?php foreach ($headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?>
                               <?php } ?>
                               <option id= 'publish' value="publish"><?php __('publish',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> <?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
                                <?php foreach ($headers as $csvkey => $csvheader) { 
                                        if (!empty($mapping_info[$groupKey])) {
                                                $csvheader = trim($csvheader);
                                                $mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_info[$groupKey])) {
                                                        $mapping_selected = $mapping_info[$groupKey][$csvheader];
                                                        if($name == $mapping_info[$groupKey][$csvheader]) { ?>
                                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                        <?php } else { ?>
                                                                <option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
                                                        <?php }
                                                } else { ?>
                                                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                                <?php }
                                        } else {
                                                if ($name == $csvheader && isset($wpcsvsettings['automapping']) && ($wpcsvsettings['automapping'] == 'automapping')) { ?>
                                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                                <?php } else { ?>
                                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                                <?php }
                                        }
                                }
                        }} ?>
                        </select></div></span>
                	</td>
	                </tr>
        	        <?php
                	$TERMS_count++;
	                $mappingcount++;
		}
                } ?>
		</tbody>
		</table>
		<input type='hidden' id='TERMS_count' value= '<?php echo $TERMS_count; ?>'>
		</div>
		</div>
		</div>
		<?php } ?>
        <?php }
}
$corefields = $classifyObj->WPCoreFields($curr_action);
#print_r($corefields);
#print_r($get_available_groups);
#print_r($mapping); 
#print('</pre>'); #die; 
/*
$showmapping .= "</table> <br>";
$showmapping .= "<div class = 'col-sm-4'> <label class = 'col-sm-4'> Template Name </label>
			<span class = 'col-sm-8'> <input type = 'text' class = 'form-control' name = 'templatename' id = 'templatename' value = '$templatename'> </span> 
		</div> 
		 <div class = 'col-sm-3'> <button type = 'submit' class = 'btn btn-primary' name = 'update' id = 'update' onclick = 'return checktemplatename_edit(this.form)'> Update </button> </div>";
$showmapping .= "</form>";
echo $showmapping; */
?>
<div style="padding:20px;">
<table style="width:100%;">
<tr>
<td>
<div style="width:60%;">
<div style='width:22%; float:left; font-size: 1.2em; font-weight: bold; margin-top:3px;'> <label> <?php echo __('Template Name',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label> </div>
<div style='width:50%; float:left;'> <input type='text' class='form-control' name='templatename' id='templatename' value="<?php echo $templatename; ?>"> </div>
<button type='submit' class='btn btn-primary' name='update' id='update' style="margin-left:10px;" onclick='return checktemplatename_edit(this.form)'> <?php echo __('Update',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </button>
</td>
</tr>
</table>
<!--<div class = 'col-sm-8'> <label class = 'col-sm-4'> Template Name </label>
<span class = 'col-sm-8'> <input type = 'text' class = 'form-control' name = 'templatename' id = 'templatename' value = '$templatename'> </span>
</div>
<div class = 'col-sm-3'> <button type = 'submit' class = 'btn btn-primary' name = 'update' id = 'update' onclick = 'return checktemplatename_edit(this.form)'> Update </button> </div>-->
</div>
</div>
</form>
</div>
<script type = 'text/javascript'>
 jQuery(document).ready(function()
 {    
       /* jQuery('#Core_Fields').on('hidden.bs.collapse', function ()
        {
                jQuery("#Core_Fields_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });

        jQuery('#Core_Fields').on('show.bs.collapse', function ()
        {
                jQuery("#Core_Fields_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });

        jQuery('#cctm_addcustom_panel').on('hidden.bs.collapse', function ()
        {
                jQuery("#cctm_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });

        jQuery('#cctm_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#cctm_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });

        jQuery('#types_addcustom_panel').on('hidden.bs.collapse', function ()
        {
                jQuery("#types_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });

        jQuery('#types_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#types_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
	jQuery('#acf_addcustom_panel').on('hidden.bs.collapse', function ()
        {
                jQuery("#acf_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#acf_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#acf_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#rffield').on('hidden.bs.collapse', function ()
        {
                jQuery("#rffield_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#rffield').on('show.bs.collapse', function ()
        {
                jQuery("#rffield_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#pods_addcustom_panel').on('hidden.bs.collapse', function ()
        {
                jQuery("#pods_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#pods_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#pods_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#aiofield').on('hidden.bs.collapse', function ()
        {
                jQuery("#aiofield_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#aiofield').on('show.bs.collapse', function ()
        {
                jQuery("#aiofield_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#yoastfield').on('hidden.bs.collapse', function ()
        {
                jQuery("#yoastfield_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#yoastfield').on('show.bs.collapse', function ()
	{
                jQuery("#yoastfield_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#wpmembers_addcustom_panel').on('hidden.bs.collapse', function ()
        {
                jQuery("#wpmembers_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#wpmembers_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#wpmembers_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#termstaxfield').on('hidmen.bs.collapse', function ()
        {
                jQuery("#termstaxfield_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#termstaxfield').on('show.bs.collapse', function ()
        {
                jQuery("#termstaxfield_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#wpecom_addcustom_panel').on('hidden.bs.collapse', function ()
        {
                jQuery("#wpecom_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#wpecom_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#wpecom_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#ecom_addcustom_panel').on('hidden.bs.collapse', function ()
        {
                jQuery("#ecom_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#ecom_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#ecom_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
        jQuery('#cust_addcustom_panel').on('hidden.bs.collapse', function ()
	{
                jQuery("#cust_addcustom_panel_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#cust_addcustom_panel').on('show.bs.collapse', function ()
        {
                jQuery("#cust_addcustom_panel_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });
	*/
        $('#corehead').click(function(){
                  //$("span",this).toggleClass("icon-circle-arrow-up");
                //$(".prod-ico", this).toggleClass("glyphicon-minus-sign").toggleClass("glyphicon-plus-sign");          
                $('#Core_Fields').toggle();
                $("#Core_Fields_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#cctm_addcustom_panel").hide();
        $('#cctmhead').click(function(){
                $('#cctm_addcustom_panel').toggle();
                $("#cctm_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#types_addcustom_panel").hide();
        $('#typeshead').click(function(){
                $('#types_addcustom_panel').toggle();
                $("#types_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#acf_addcustom_panel").hide();
        $('#acfhead').click(function(){
                $('#acf_addcustom_panel').toggle();
                $("#acf_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
/*        $("#rffield").hide();
        $('#rfhead').click(function(){
                $('#rffield').toggle();
                $("#rffield_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });*/
        $("#pods_addcustom_panel").hide();
        $('#podshead').click(function(){
                $('#pods_addcustom_panel').toggle();
                $("#pods_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#aiofield").hide();
        $('#aiohead').click(function(){
                $('#aiofield').toggle();
                $("#aiofield_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#yoastfield").hide();
        $('#yoasthead').click(function(){
                $('#yoastfield').toggle();
                $("#yoastfield_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#wpmembers_addcustom_panel").hide();
        $('#wpmembershead').click(function(){
                $('#wpmembers_addcustom_panel').toggle();
                $("#wpmembers_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#wpecom_addcustom_panel").hide();
        $('#wpecomhead').click(function(){
                $('#wpecom_addcustom_panel').toggle();
                $("#wpecom_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#ecom_addcustom_panel").hide();
        $('#ecomhead').click(function(){
                $('#ecom_addcustom_panel').toggle();
                $("#ecom_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#termstaxfield").hide();
        $('#termshead').click(function(){
                $('#termstaxfield').toggle();
                $("#termstaxfield_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $("#rffield").hide();
        $('#rfhead').click(function(){
                $('#rffield').toggle();
                $("#rffield_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
        $('#cust_addcustom_panel').hide();
        $('#custhead').click(function(){
                $('#cust_addcustom_panel').toggle();
                $('#cust_addcustom_panel_h_span',this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });

 });
 </script>
