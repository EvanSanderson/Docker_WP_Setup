<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

$impCE = new WPImporter_includes_helper();
$wpfieldsObj = new WPClassifyFields();
$xml_object = new XML2Array();
$mapping_template_id = isset($skinnyData['templateinfo']['mapping_template_id']) ? $skinnyData['templateinfo']['mapping_template_id'] : '';
$mapping_templatename = isset($skinnyData['templateinfo']['mapping_templatename']) ? $skinnyData['templateinfo']['mapping_templatename'] : '';
$mapping_templatename_edit = isset($skinnyData['templateinfo']['mapping_templatename_edit']) ? $skinnyData['templateinfo']['mapping_templatename_edit'] : '';
$mapping_templatename_checked = isset($skinnyData['templateinfo']['mapping_templatename_checked']) ? $skinnyData['templateinfo']['mapping_templatename_checked'] : '';
$mapping_template_mapping_info = isset($skinnyData['templateinfo']['mapping_template_mapping_info']) ? $skinnyData['templateinfo']['mapping_template_mapping_info'] : '';
#print_r($_POST); #print_r($_SESSION);
/* Set event key for each event */
if(isset($_REQUEST['eventKey'])){ 
	if(isset($skinnyData['mapping'])){
	$mapping_template_mapping_info = $skinnyData['mapping']; }?>
	<input type="hidden" id="csvimporter_eventkey" name="csvimporter_eventkey" value="<?php echo $_REQUEST['eventKey']; ?>" />
<?php } else if(isset($_POST['session_key'])) { ?>
	<input type="hidden" id="csvimporter_eventkey" name="csvimporter_eventkey" value="<?php echo $_POST['session_key']; ?>" />
<?php } ?>
<div id="importsect" style="width:98%;border: 1px solid #d1d1d1;background-color:#fff;">
<div id="accordion">
<table class="table-importer">
<tr>
<td>
<!-- Import Screen -->
<div id='sec-one' <?php if (isset($_REQUEST['step']) && $_REQUEST['step'] != 'uploadfile') { ?> style='display:none;' <?php } ?>style='border-style:none;'>
<?php if (is_dir($impCE->getUploadDirectory('default'))) { ?>
	<input type='hidden' id='is_uploadfound' name='is_uploadfound' value='found'/>
<?php } else { ?>
	<input type='hidden' id='is_uploadfound' name='is_uploadfound' value='notfound'/>
<?php } ?>
<div class="warning" id="warning" name="warning" style="display:none;margin: 4% 0 4% 22%;"></div>
<form action='<?php echo admin_url() . 'admin.php?page=' . WP_CONST_ULTIMATE_CSV_IMP_SLUG . '/index.php&__module=' . $_REQUEST['__module'] . '&import_type=' . $_REQUEST['import_type'] . '&step=templatelist' ?>' id='browsefile' method='post' name='browsefile' enctype="multipart/form-data" >
    <div align="center">
       <div style="margin-top:20px;"><span style="font-weight:bold;font-size:16px;"><?php echo __("Import Module:",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </span><span class="moduledisplay"><?php echo $_REQUEST['import_type']; ?></span>
       </div>
       <div id="displayname" style="display:none;">
	       <span style="font-weight:bold;font-size:16px;"><?php echo __("File Name: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></span><span id="filenamedisplay"></span>
       </div>
    </div>
    <div class="container">
<!-- Function call to show available import methods -->
	<?php echo $impCE->smack_csv_import_method(); ?>
	<input type='hidden' id='importbymethod' name='importbymethod' value ='uploadfilefromcomputer'/>
	<input type='hidden' id='pluginurl' value='<?php echo WP_CONTENT_URL; ?>'>
	<input type='hidden' id='slug' value='<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>'>
	<?php $uploadDir = wp_upload_dir(); ?>
	<input type="hidden" id="uploaddir" value="<?php echo $uploadDir['basedir']; ?>">
	<input type="hidden" id="uploadFileName" name="uploadfilename" value="">
	<input type='hidden' id='uploadedfilename' name='uploadedfilename' value=''>
	<input type='hidden' id='upload_csv_realname' name='upload_csv_realname' value=''>
	<input type='hidden' id='current_file_version' name='current_file_version' value=''>
	<input type='hidden' id='current_module' name='current_module' value='<?php echo $_REQUEST['__module']; ?>'>
	<input type='hidden' id='current_imptype' name='current_imptype' value='<?php echo $_REQUEST['import_type']; ?>' />

<!--<div class="warning" id="warning" name="warning" style="display:none"></div> -->
<!-- The container for the uploaded files -->
	    <div id="files" class="files"></div> 
	<!-- Code Added For POP UP  Starts here -->
	    <div class='modal fade' id = 'modal_zip' tabindex='-1' role='dialog' aria-labelledby='mymodallabel' aria-hidden='true'>
		<div class='modal-dialog'>
		    <div class='modal-content'>
			<div class='modal-header'>
			   <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			   <h4 class='modal-title' id='mymodallabel'> <?php echo __("Zip File Info",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </h4>
			</div>
			<div class='modal-body' id = 'choose_file'>
				...
			</div>
			<div class='modal-footer'>
		 <!--<button type='button' class='btn btn-default' data-dismiss='modal'>close</button>  -->
				<button type='button' class='btn btn-primary' data-dismiss='modal'><?php echo __("Close",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></button>
			</div>
		    </div>
		</div>
	    </div>
    </div>
 <!-- POP UP Ends Here -->
    <br>
    <?php
    $blog_id = 1;
    if (is_multisite()) {
	global $current_blog;
	$blog_id = $current_blog->blog_id;
    } ?>
    <input type="hidden" name="cur_blogid" id="cur_blogid" value="<?php echo 'blog' . $blog_id; ?>"/>
    </div>
<!-- Script to proceed the import/update process -->
    <script>
	var check_upload_dir = document.getElementById('is_uploadfound').value;
	if (check_upload_dir == 'notfound') {
		document.getElementById('browsefile').style.display = 'none';
		jQuery('#defaultpanel').css('visibility', 'hidden');
		jQuery('#helpnotify').css('visibility', 'hidden');
		jQuery('<p/>').text("").appendTo('#warning');
		jQuery("#warning").empty();
		jQuery('#warning').css('display', 'inline');
		jQuery('<p/>').text("Warning:   Sorry. There is no uploads directory Please create it with write permission.").appendTo('#warning');
		jQuery('#warning').css('color', 'red');
		jQuery('#warning').css('font-weight', 'bold');
		jQuery('#progress .progress-bar').css('visibility', 'hidden');
	}
	else {
		//jQuery('#helpnotify').css('visibility', '');
		jQuery(function () {
			'use strict';
			var uploadPath = document.getElementById('uploaddir').value;
                        var url = (document.getElementById('pluginurl').value+'/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/modules/default/templates/index.php');
                        var filesdata;
                        var blogid = 'blog' + <?php echo $blog_id; ?> 
                        function prepareUpload(event){
                        filesdata = event.target.files;
                        var curraction = '<?php echo $_REQUEST['__module']; ?>';
                        var curr_imptype = '<?php echo $_REQUEST['import_type']; ?>';
                        var frmdata = new FormData();
                        var uploadfile_data = jQuery('#fileupload').prop('files')[0];
                        frmdata.append('files', uploadfile_data);
                        frmdata.append('action','handleuploadedfile');
                        frmdata.append('curr_action', curraction);
                        frmdata.append('current_imptype',curr_imptype);
                        frmdata.append('uploadPath', uploadPath);
                        frmdata.append('blog_id', blogid);
                        jQuery.ajax({
                                url : ajaxurl,
                                type : 'post',
                                data : frmdata,
                                cache: false,
                                contentType : false,
                                processData: false,

                        success : function(data) {
                                        var fileobj =JSON.parse(data);
                                        jQuery.each(fileobj,function(objkey,objval){
                                                        jQuery.each(objval,function(o_key,file){
                                                                document.getElementById('uploadFileName').value=file.name;
                                                                var filewithmodule = file.uploadedname.split(".");
                                                                var check_file = filewithmodule[filewithmodule.length - 1];
                                                                if(check_file != "csv" && check_file != "zip" && check_file != "xml" && check_file != "txt") {
                                                                        alert('Un Supported File Format');
                                                                }
                                                                if(check_file == 'zip') {
                                                                        var real_name = file.name;
                                                                        var doaction  = new Array({real_name:real_name,import_method:'uploadfilefromcomputer' }); 
                                                                        jQuery.ajax({
                                                                                type: 'POST',
                                                                                url: ajaxurl,
                                                                                data: {
                                                                                'action': 'smack_csv_importer_zipfile_handler',
                                                                                'postdata': doaction,
                                                                                 },
                                                                                success: function (data) {
                                                                                        data = JSON.parse(data);
                                                                                        document.getElementById('choose_file').innerHTML =data['data'];
                                                                                        jQuery('#modal_zip').modal('show');
                                                                                        var path = data['path'];
                                                                                        document.getElementById('filedir').value = path;
                                                                                 },
                                                                                error: function (errorThrown) {
                                                                                        console.log(errorThrown);
                                                                                }
                                                                         });
                                                                 }
                                                                var uploaded_real_csv_name = file.uploadedname;
                                                                 if(check_file == "csv"){
                                                                        var filenamecsv = file.uploadedname.split(".csv");
                                                                        file.uploadedname = filenamecsv[0] + "-<?php echo $_REQUEST['import_type']; ?>" + "-blog<?php echo $blog_id; ?>.csv";
                                                                 }
                                                                else if(check_file == "xml"){
                                                                        var filenamexml = file.uploadedname.split(".xml");
                                                                        file.uploadedname = filenamexml[0] + "-<?php echo $_REQUEST['import_type']; ?>" + "-blog<?php echo $blog_id; ?>.xml";
                                                                }
                                                                else if(check_file == "txt"){
                                                                        var filenametxt = file.uploadedname.split(".txt");
                                                                        file.uploadedname = filenametxt[0] + "-<?php echo $_REQUEST['import_type']; ?>" + "-blog<?php echo $blog_id; ?>.txt";                                   
                                                                }
                                                                document.getElementById('upload_csv_realname').value = file.uploadedname;
                                                                var get_version1 = file.name.split("-<?php echo $_REQUEST['import_type']; ?>");
                                                                if(check_file == "csv"){
                                                                  var get_version2 = get_version1[1].split(".csv");
                                                                }else if(check_file == "xml"){
                                                                  var get_version2 = get_version1[1].split(".xml");
                                                                }
                                                                else if(check_file == "txt"){
                                                                  var get_version2 = get_version1[1].split(".txt");
                                                                }
								else if(check_file == 'zip'){
								 var get_version2 = get_version1[1].split(".zip");
								}
                                                                var get_version3 = get_version2[0].split("-");
                                                                document.getElementById('current_file_version').value = get_version3[2];
                                                                jQuery('#uploadedfilename').val(file.uploadedname);
                                                                jQuery("#filenamedisplay").empty();
                                                                if (file.size > 1024 && file.size < (1024 * 1024)) {
                                                                var fileSize = (file.size / 1024).toFixed(2) + ' kb';
                                                                }
                                                                else if (file.size > (1024 * 1024)) {
                                                                var fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' mb';
                                                                }
                                                                else {
                                                                var fileSize = (file.size) + ' byte';
                                                                }
                                                                document.getElementById('displayname').style.display = '';
                                                                jQuery('<label/>').text((uploaded_real_csv_name) + ' - ' + fileSize).appendTo('#filenamedisplay');      
                                                                jQuery('#importfile').attr('disabled', false);
                                                                jQuery('#updatefile').attr('disabled', false);
                                                                jQuery('#dwnldextrfile').attr('disabled', true);
                                                                jQuery('#dwnldftpfile').attr('disabled', true);
                                                                jQuery('#useuploadedfile').attr('disabled', true);
                                                                 jQuery('#fileupload').prop('disabled', !jQuery.support.fileInput)
                                                                .parent().addClass(jQuery.support.fileInput ? undefined : 'disabled');

                                                        });
                                        });
                        }
                        });
                        }
                        jQuery('#fileupload').on('change', prepareUpload);
                        jQuery('#fileupload').fileupload({
                                url : url,
                                progressall: function (e, data) {
                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                 jQuery('#progress .progress-bar').css('width', progress + '%' );
                        }
                         });
                        });
	}
    </script>
    <input type='hidden' name='importid' id='importid'/>
</form>
</div>
</div>
</td>
</tr>
<tr>
<td>
<?php #print('<pre>'); print_r($_POST); print('</pre>'); //die;
// Create & Assign the event key for each event
$sessionKey = '';
if($_REQUEST['step'] == 'importoptions'){
	$versionedfilenm = isset($_REQUEST['versionedfilename']) ? $_REQUEST['versionedfilename'] : '';
        $sessionKey = $impCE->convert_string2hash_key($versionedfilenm);
//	echo '<pre>'; print_r($_REQUEST); echo '</pre>';
//	echo '<pre>'; print_r($sessionKey); echo '</pre>'; echo 'raj';
}
else if(isset($_REQUEST['eKey']) && isset($_REQUEST['step'])){ 
	$sessionKey = $_REQUEST['eKey']; 
}
else if(!isset($_REQUEST['eventKey']) && ($_REQUEST['step'] == 'mapping_settings' || $_REQUEST['step'] == 'templatelist')){
       if(isset($_REQUEST['uploadfilename']) && ($_REQUEST['uploadfilename'])){
	 $sessionKey = $impCE->convert_string2hash_key($_REQUEST['uploadfilename']);
//	echo '<pre>'; print_r($_REQUEST); echo '</pre>';
	}
}
else if(isset($_REQUEST['eventKey'])){
	$sessionKey = $_REQUEST['eventKey'];
}

#print($sessionKey); die('aaa');
if(isset($_REQUEST['paged']) && ($_REQUEST['paged'] != '')){
	$sessionKey = $_REQUEST['eventKey'];
}
// Writing a event file while leading to update process when step is not in templatelist
if(!isset($_REQUEST['eventKey']) && !isset($_REQUEST['freshupdate']) && $_REQUEST['step'] != 'templatelist') {
	$_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'] = $_POST;
	$impCE->writing_event_file_for_every_process($sessionKey, $_POST);
}
if((isset($_POST['proceedtoprocess']) && ($_POST['proceedtoprocess'] == 'Update')) || $_REQUEST['step'] == 'templatelist') { 
	// Writing a event file while leading to update process when event key is not present in query string
//die('aaaaa');
	if(!isset($_REQUEST['eventKey']) && !isset($_REQUEST['freshupdate'])) {
		$_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'] = $_POST;
		$impCE->writing_event_file_for_every_process($sessionKey, $_POST);
		$impCE->save_option_file_details($_POST);
	}
?>
<!--<form method ='post'>-->
<input type = "hidden" id = 'session_key' value= "<?php echo $sessionKey; ?>" name = 'session_key'/>

<!-- Second screen, Show all template as list with pagination and filters -->
<?php #die('sssss'); ?>
<style> #ui-datepicker-div {
                display: none
        } </style>
<?php
if ($skinnyData['templatecount'] == 0) {
        $this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span>'. __('No Templates Generated yet',WP_CONST_ULTIMATE_CSV_IMP_SLUG) . '</span> </b>';
        $this->notificationclass = 'alert alert-info';
        $skinnyData['page'] = 0;
} else {
        if ($skinnyData['page'] > $skinnyData['lastpage']) {
                $this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span>'. __('Enter page number correctly',WP_CONST_ULTIMATE_CSV_IMP_SLUG) . '</span> </b>';
                $this->notificationclass = 'alert alert-warning';
        }
}

if (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 4) {
        ?>
        <div id="deletesuccess"><p class="alert alert-success"><?php echo __("Template has been saved successfully!",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></p></div>
        <script type="text/javascript">
                $(document).ready(function () {
                        $('#deletesuccess').delay(5000).fadeOut();
                });
        </script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 5) {
        ?>
        <div id="ShowMsg" class="alert alert-warning"><?php echo __("Error while saving template.",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></div>
        <script type="text/javascript">
                $(document).ready(function () {
                        $('#ShowMsg').delay(5000).fadeOut();
                });
        </script>
<?php
}
$error = '';
# adding filter to page
$targetpage = admin_url() . 'admin.php?page=' . WP_CONST_ULTIMATE_CSV_IMP_SLUG . '/index.php&__module=' . $_REQUEST['__module'] . '&import_type=' . $_REQUEST['import_type'] . '&step=mapping_settings'; 

$pagination = $skinnyData['filter'];
$pagination .= "<div class = 'form-group'>";
$pagination .= "<div style = 'width:28%;margin-top:-5.9%;margin-left:57%; float:right;'> <ul class='pagination pagination-lg' style='margin-top:-4px;'>";
# previous button
if ($skinnyData['page'] > 1) {
        $pagination .= "<li> <a href='{$skinnyData['targetpage']}&paged=1'> <span class = 'fa fa-angle-double-left'> </span> </a> </li> <li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['prev']}'> <span class = 'fa fa-angle-left'> </span> </a> </li>";
} else {
        $pagination .= "<li class = 'disabled'> <a> <span class = 'fa fa-angle-double-left'> </span> </a> </li> <li class = 'disabled'> <a> <span class = 'fa fa-angle-left'> </span> </a> </li>";
}

# page text box
$pagination .= '<li> <span class="paging-input"> <input class="current-page" style = "width:40px;" type="text" value="' . $skinnyData['page'] . '" name="saiob_queue_page" id = "saiob_queue_page" title="Current page"> of <span class="total-pages"> ' . $skinnyData["lastpage"] . '</span> </span> </li>';

#next button
if ($skinnyData['page'] < $skinnyData['lastpage']) {
        $pagination .= "<li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['next']}'> <span class = 'fa fa-angle-right'> </span> </a> </li> <li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['lastpage']}'> <span class = 'fa fa-angle-double-right'> </span> </a> </li>";
} else {
        $pagination .= "<li class='disabled'> <a> <span class = 'fa fa-angle-right'> </span> </a> </li> <li class = 'disabled'> <a> <span class = 'fa fa-angle-double-right'> </span> </a> </li>";
}

$pagination .= "</ul> </div><span></span></div> </div>";
$pagination .= "<script> jQuery('#saiob_queue_page').keypress(function (e) {
var key = e.which;
if(key == 13)
{
        var paged = jQuery('#saiob_queue_page').val();
        var reg=/^-?[0-9]+$/;
        if(reg.test(paged))     {
                window.location.href = '" . $skinnyData['targetpage'] . "&paged='+paged;
                return false;
        }
        var msg = 'Kindly enter Number';
        shownotification(msg, 'danger');
}
}); </script>";

?>
<div class="form-group"> <?php echo $error; ?> </div>
<?php echo $pagination; ?>
<!-- Fresh Update feature -->
<input type='button' class='btn btn-success freshupdate' value='<?php echo __('Fresh Update',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>'  onclick="window.location.href = '<?php echo $targetpage; ?>&freshupdate=<?php echo $sessionKey; ?>&uploadfilename=<?php if(isset($_REQUEST['uploadfilename'])) { echo $_REQUEST['uploadfilename']; } ?>&csv_name=<?php if(isset($_REQUEST['csv_name'])) { echo $_REQUEST['csv_name']; } ?>&version=<?php if(isset($_REQUEST['version'])) {  echo $_REQUEST['version']; } else{ echo $_REQUEST['current_file_version'];}?>'"><br><br>
<table class="table table-bordered" id='log' style="margin-top:-4.5%;margin-left:10px;margin-bottom:15px;">
        <tr id="innertitle">
                <th class='updatehead'> <?php echo __("#",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
                <th class='updatehead'> <?php echo __("Template Name",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
                <!--<th> Template Used </th>-->
		<th class='updatehead'><?php echo __("File Name",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
                <th class='updatehead'> <?php echo __("Module",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
                <th class='updatehead'> <?php echo __("Created Time",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
                <th class='updatehead'> <?php echo __("Action",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
        </tr>
        <?php
        foreach ($skinnyData['templatelist'] as $singletemplate) {
                $id = $singletemplate->id;
                ?>
                <tr>
                        <td class="updatetemplatelist;"> <?php echo $id; ?></td>
                        <td class="updatetemplatelist;"> <?php echo $singletemplate->templatename; ?> </td>
                        <!--<td> <?php echo $singletemplate->templateused; ?></td>-->
			<td class="updatetemplatelist;"> <?php echo $singletemplate->csvname; ?> </td>
                        <td class="updatetemplatelist;"> <?php echo $singletemplate->module; ?> </td>
                        <td class="updatetemplatelist;"> <?php echo $singletemplate->createdtime; ?> </td>
                        <td style='width:150px;'>
			<!-- Update button, To proceed with the selected template details -->
			<span class='col-sm-1' style='height:25px;margin-left:5px;'>
                           <button type='submit' style='padding: 2px 7px;margin-left:16px;' name='updateform' id='update_<?php echo $id; ?>' class="btn btn-success " title="Update" onclick="window.location.href = '<?php echo $targetpage; ?>&templateId=<?php echo $id; ?>&eventKey=<?php echo $sessionKey;  ?>&uploadfilename=<?php if(isset($_REQUEST['uploadfilename'])) { echo $_REQUEST['uploadfilename']; } ?>&csv_name=<?php if(isset($_REQUEST['csv_name'])) { echo $_REQUEST['csv_name']; } ?>&version=<?php if(isset($_REQUEST['version'])) {  echo $_REQUEST['version']; } ?>'"><?php echo __("Update",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>     
                           </button>
                        </span>
                        </td>
                </tr>
        <?php } ?>
</table>
         <?php   $listcount = count($skinnyData['templatelist']) ;
                  if($listcount == 0) { ?>
                      <p style = "color:red;font-size:14px;margin-left:400px;"><?php echo __("No Results Found",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></p>
                 <?php  }?>
<script type='text/javascript'>
        jQuery(document).ready(function () {
                jQuery('#fromdate').datepicker({
                        dateFormat: 'yy-mm-dd'
                });
        });

        jQuery(document).ready(function () {
                jQuery('#todate').datepicker({
                        dateFormat: 'yy-mm-dd'
                });
        });
</script>
<!-- </form> -->
<!-- Second screen, Ends Here -->
<?php } else {
//die('bb');
	if(isset($_REQUEST['eventKey']) || isset($_REQUEST['freshupdate'])){
		if(isset($_REQUEST['eventKey']))
			$eventKey = $_REQUEST['eventKey'];
		if(isset($_REQUEST['freshupdate']))
			$eventKey = $_REQUEST['freshupdate'];
		$proceed_status = 'Update';
		// Get event details from the event file
		$uploadDir = wp_upload_dir();
		$session_file = $uploadDir['basedir'] . '/' . 'ultimate_session_files' . '/' . $eventKey . '.txt';
		$myfile = fopen($session_file, "r") or die("Unable to open file!");
		$getfile = fgets($myfile);
		//fclose($myfile);
		$filedirRecords = unserialize($getfile);

		fclose($myfile);
	}
#print('<pre>'); print_r($filedirRecords);
#print('from mapping settings'); #print_r($_REQUEST);
#print('sessionKey: ' .$sessionKey); 
#print_r($_SESSION);
if(isset($_REQUEST['step']) && $_REQUEST['step'] == 'mapping_settings') {?>

<!-- Third screen, Starts Here -->
<?php
$querystring = '';
if(isset($_REQUEST['eventKey'])) {
	$querystring = '&templateId=' . $_REQUEST['templateId'] . '&eventKey=' . $_REQUEST['eventKey'];
} 
if(isset($_REQUEST['freshupdate'])) {
	$querystring = '&freshupdate=' . $_REQUEST['freshupdate'];
}
?>
<form action='<?php echo admin_url() . 'admin.php?page=' . WP_CONST_ULTIMATE_CSV_IMP_SLUG . '/index.php&__module=' . $_REQUEST['__module'] . '&import_type=' . $_REQUEST['import_type'] . '&step=importoptions' . $querystring  ?>' id='browsefile' method='post' name='browsefile' enctype="multipart/form-data" onsubmit="return import_csvrecords();" >
<div class='msg' id='showMsg' style='display:none;'></div>
<?php
$sessionKey = '';
$logfilename = '';
if(isset($_REQUEST['step']) && $_REQUEST['step'] == 'importoptions'){
	$sessionKey = $impCE->convert_string2hash_key($_REQUEST['versionedfilename']);
}
else if((isset($_REQUEST['eventKey']) && $_REQUEST['step'] == 'mapping_settings') || isset($_REQUEST['freshupdate'])){
      if(isset($_REQUEST['uploadfilename']) && ($_REQUEST['uploadfilename']))
	$sessionKey = $impCE->convert_string2hash_key($_REQUEST['uploadfilename']);
	//$sessionKey = $_REQUEST['freshupdate'];
}
else if(isset($_REQUEST['eventKey'])){
	$sessionKey = $_REQUEST['eventKey'];
}

if(isset($_REQUEST['templateId'])) {
	$templateId = $_REQUEST['templateId'];
} else {
	$templateId = "";
}
#print('<br><br> SessionKey: ' . $sessionKey . '<br><br>'); die;
?>
<input type = "hidden" id = 'session_key' value= "<?php echo $sessionKey; ?>" name = 'session_key'/>
<input type = "hidden" id = 'templateID' value= "<?php echo $templateId; ?>" name = 'temp_id'/>
<?php $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'] = $_POST; 
$get_upload_url = wp_upload_dir();
$uploaded_file_name = '';
$uploadLogURL = $get_upload_url['baseurl'] . "/" . $impCE->exportDir;
if(isset($_POST['uploadedFile']))
{
	$uploaded_file_name = $_POST['uploadedFile'];
}
$logfilename = $uploadLogURL . "/" . $sessionKey . ".log"; ?>
<input type="hidden" id="logfilename" name="logfilename" value="<?php echo $logfilename; ?>" />

<?php if (isset($_POST['mydelimeter'])) {
	$_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['delim'] = $_POST['mydelimeter'];
}
$wpcsvsettings = array();
$custom_key = array();
$wpcsvsettings = get_option('wpcsvprosettings');
$impCE->save_option_file_details($_POST);
?>
<div id='sec-two' <?php if (isset($_REQUEST['step']) && $_REQUEST['step'] != 'mapping_settings') { ?> style='display:block;' <?php } ?> style='border-style:none;'>
<?php if(isset($_FILES['inlineimages']['name']) && ($_FILES['inlineimages']['name'] != '')) {
	if(isset($_POST['uploadfilename']) && $_POST['uploadfilename'] != ''){
                         $get_file_name = $_POST['uploadfilename'];
                         $filehashkey = $impCE->convert_string2hash_key($get_file_name);
                 }	
	$uploaded_compressedFile = $_FILES['inlineimages']['tmp_name'];
	$get_basename_zipfile = explode('.', $_FILES['inlineimages']['name']);
	$basename_zipfile = $get_basename_zipfile[0];
	$location_to_extract = $uploadDir['basedir'] . '/smack_inline_images/' . $filehashkey;
	$extracted_image_location = $uploadDir['baseurl'] . '/smack_inline_images/' . $filehashkey;

	$zip = new ZipArchive;
	if ($zip->open($uploaded_compressedFile) === TRUE) {
		$zip->extractTo($location_to_extract);
		$zip->close();
		$extracted_status = 1;
	} else {
		$extracted_status = 0;
	}
} ?>
<?php
$allcustomposts = '';
$mFieldsArr = '';
$delimeter = '';
$filename = '';
$updaterename = 0;
$file_extension = '';
#print('for getting session file values <br>'); #print_r($filedirRecords);
if(isset($_POST['importbymethod']) && $_POST['importbymethod'] != ''  ) {
	$import_method = $_POST['importbymethod'];
}
if(isset($_POST['filename']) && $_POST['filename'] !='' ) {
	$local_file = $_POST['filename'];
}
if(isset($_POST['filedir']) && $_POST['filedir'] !='') {
	$file_dir = $_POST['filedir'];
}
if(isset($_POST['select_templatename']) && $_POST['select_templatename'] !='') {
	$temp_name = $_POST['select_templatename'];
}
if (isset($_POST['uploadfilename']) && $_POST['uploadfilename'] != '') {
	$file_name = $_POST['uploadfilename'];
	$file_extension = pathinfo($file_name,PATHINFO_EXTENSION);
	$filename = $impCE->convert_string2hash_key($file_name);
}
if (isset($_POST['mydelimeter']) && $_POST['mydelimeter'] != '') {
	$delimeter = $_POST['mydelimeter'];
}
if (isset($_POST['upload_csv_realname']) && $_POST['upload_csv_realname'] != '') {
	$uploaded_csv_name = $_POST['upload_csv_realname'];
}
if (isset($_POST['current_file_version']) && $_POST['current_file_version'] != '') {
	$currentfileversion = $_POST['current_file_version'];
}
if (isset($_POST['updaterenamefile']) && $_POST['updaterenamefile'] != '' && $_POST['updaterenamefile'] == 'update') {
	$updaterename = 1;
}
if (isset($_POST['updatewithposttitle']) && $_POST['updatewithposttitle'] != '') {
	$updatewithposttitle = $_POST['updatewithposttitle'];
}
if (isset($_POST['updatewithpostid']) && $_POST['updatewithpostid'] != '') {
	$updatewithpostid = $_POST['updatewithpostid'];
}
#print_r($_REQUEST); print_r($_POST); print($filename); die('smack');
if(isset($_REQUEST['eventKey']) || isset($_REQUEST['freshupdate']))
{
        if(isset($filedirRecords['uploadfilename']) ) {  
                $file_name = $filedirRecords['uploadfilename'];
		$file_extension = pathinfo($file_name,PATHINFO_EXTENSION); 
		if(isset($_REQUEST['freshupdate'])){
			$filename = $_REQUEST['freshupdate'];
		}else if(isset($_REQUEST['eventKey'])){
			$filename = $_REQUEST['eventKey'];
		}
		else{
			$filename = $impCE->convert_string2hash_key($file_name);
		}
		$currentfileversion = $filedirRecords['current_file_version'];
		$versionedfilename = $filedirRecords['uploadfilename'];
		$uploaded_csv_name = $filedirRecords['upload_csv_realname'];
		$import_method =  $filedirRecords['importbymethod'];
//echo '<pre>'; print_r($filedirRecords); echo '</pre>';
//	$proceed_status = $filedirRecords['proceedtoprocess'];
        }
        else if(isset($_REQUEST['uploadfilename'])) {
                 $file_name = $_REQUEST['uploadfilename'];
		 $file_extension = pathinfo($file_name,PATHINFO_EXTENSION);
	         $currentfileversion = $_REQUEST['version'];
	         $versionedfilename = $_REQUEST['csv_name'];
	         $uploaded_csv_name = $_REQUEST['uploadfilename'];
//		 $proceed_status = $filedirRecords['proceedtoprocess'];
		 if(isset($_REQUEST['freshupdate'])){
			$filename = $_REQUEST['freshupdate'];
		 }else if(isset($_REQUEST['eventKey'])){
                        $filename = $_REQUEST['eventKey'];
                 }
		 else{
			$filename = $impCE->convert_string2hash_key($file_name);
		 }

		 //$filename =  $_REQUEST['eventKey'];

		/* if($file_extension == 'xml'){
			$filename = $_REQUEST['freshupdate'];
		 }*/
        }
}
/*if(isset($import_method) && $import_method == 'useuploadedfile' ) {
	$getrecords = $impCE->csv_file_localdata($local_file, $file_dir ,$delimeter);
}else {*/
	$getrecords = $impCE->csv_file_data($filename, $delimeter,'');
//}

$uploadxml_file = $uploadDir['basedir'] . '/' . 'ultimate_importer' . '/' . $filename;

if($file_extension == 'xml'){
	$xml_file = fopen($uploadxml_file,'r');
	$xml_read = fread($xml_file , filesize($uploadxml_file));
	fclose($xml_file);

	$xml_arr = $xml_object->createArray($xml_read);
	$xml_data = array();
	$impCE->xml_file_data($xml_arr,$xml_data);
	$reqarr = $impCE->xml_reqarr($xml_data);
	$getrecords = $impCE->xml_importdata($xml_data);
}
$getcustomposts = get_post_types();
if (isset($getcustomposts)) {
	foreach ($getcustomposts as $keys => $value) {
		if (($value != 'featured_image') && ($value != 'attachment') && ($value != 'wpsc-product') && ($value != 'wpsc-product-file') && ($value != 'revision') && ($value != 'nav_menu_item') && ($value != 'post') && ($value != 'page') && ($value != 'wp-types-group') && ($value != 'wp-types-user-group')) {
			$allcustomposts .= $value . ',';
		}
	}
}
?>

<?php //$cnt = count($impCE->defCols) + 2;
#print_r($_REQUEST);
if( isset($_REQUEST['eventKey']) ) {
#        $getrecords = $impCE->csv_file_data($_REQUEST['eventKey'], '');
        $record = count($getrecords);
	$sessionKey_filename = $_REQUEST['eventKey'];
}
else{
	if($file_extension == 'xml'){
		$cnt1 = count($impCE->xmlheaders) ;
		$record = count($getrecords);
	        if(isset($_REQUEST['uploadfilename']) && ($_REQUEST['uploadfilename'])){	
			if(isset($_REQUEST['freshupdate'])){
				$sessionKey_filename = $_REQUEST['freshupdate'];
			}
			else{
				$sessionKey_filename = $filename;
			}
		}
	        //$sessionKey_filename = $impCE->convert_string2hash_key($_REQUEST['uploadfilename']);
	}
	else {
		$cnt1 = count($impCE->headers);
		$record = count($getrecords);
		if(isset($_REQUEST['uploadfilename']) && ($_REQUEST['uploadfilename'])){
			if(isset($_REQUEST['freshupdate'])){
				$sessionKey_filename = $_REQUEST['freshupdate'];
			}
			else{ 
				$sessionKey_filename = $filename;
			}
		}
		//$sessionKey_filename = $impCE->convert_string2hash_key($_REQUEST['uploadfilename']);
	}
}
$imploaded_array = implode(',', $impCE->headers);
?>
<input type="hidden" id='session_key_filename' value="<?php if(isset($sessionKey_filename)){ echo $sessionKey_filename; }?>" name='session_key_filename'/>
<input type="hidden" id='session_key' value="<?php if(isset($sessionKey_filename)){ echo $sessionKey_filename; }?>" name='session_key'/>
<input type='hidden' id='file_dir' name='file_dir' value='<?php if(isset($file_dir)) { echo $file_dir;  }?>'>
<input type='hidden' id='import_method' name='import_method' value = '<?php if(isset($import_method)) { echo $import_method; } ?>'>
<input type='hidden' id='select_templatename' name='select_templatename' value = '<?php if(isset($temp_name)) { echo $temp_name; } ?>'>

<input type='hidden' id='imploded_header' name='imploded_array' value='<?php if (isset($imploaded_array)) { echo $imploaded_array; } ?>'>
<!--<input type='hidden' id='h1' name='h1' value='<?php if (isset($cnt)) {      echo $cnt; } ?>'/>-->
<input type='hidden' id='h2' name='h2' value='<?php if (isset($cnt1)) { echo $cnt1; } ?>'/>
<input type='hidden' name='selectedImporter' id='selectedImporter' value='<?php if (isset($_REQUEST['import_type'])) { echo $_REQUEST['import_type']; } else { echo '1'; } ?>'/>
<input type='hidden' id='prevoptionindex' name='prevoptionindex' value=''/>
<input type='hidden' id='prevoptionvalue' name='prevoptionvalue' value=''/>
<input type='hidden' id='current_record' name='current_record' value='0'/>
<input type='hidden' id='totRecords' name='totRecords' value='<?php if (isset($record)) { echo $record; } ?>'/>
<input type='hidden' id='tmpLoc' name='tmpLoc' value='<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>'/>
<input type='hidden' id='uploadedFile' name='uploadedFile' value="<?php if (isset($filename)) { echo $filename; } ?>"/>
<!-- real uploaded filename -->
<input type='hidden' id='uploaded_csv_name' name='uploaded_csv_name' value="<?php if (isset($uploaded_csv_name)) { echo $uploaded_csv_name; } ?>"/>
<!-- current file version -->
<!--<input type='hidden' id='updaterename' name='updaterename' value="<?php if (isset($updaterename)) { echo $updaterename; } ?>"/>-->
<?php if(isset($_REQUEST['eventKey']) || isset($_REQUEST['freshupdate'])){ ?>
<input type='hidden' id='versionedfilename' name='versionedfilename' value="<?php if(isset($versionedfilename)){ echo $versionedfilename; } ?>" />
<input type ='hidden' id='proceedstatus' name='proceedstatus' value="<?php if(isset($proceed_status)) { echo $proceed_status; }?>" >
<?php } else {?>
<input type='hidden' id='versionedfilename' name='versionedfilename' value="<?php if(isset($_POST['uploadfilename'])) { echo $_POST['uploadfilename']; } ?>" />
<?php }?>
<!--<input type='hidden' id='updatewithpostid' name='updatewithpostid' value="<?php if (isset($updatewithpostid)) { echo $updatewithpostid; } ?>"/>-->
<!--<input type='hidden' id='updatewithposttitle' name='updatewithposttitle' value="<?php if (isset($updatewithposttitle)) { echo $updatewithposttitle; } ?>"/>-->
<input type='hidden' id='currentfileversion' name='currentfileversion' value="<?php if (isset($currentfileversion)) { echo $currentfileversion; } ?>"/>
<!--<input type='hidden' id='select_delimeter' name='select_delimeter' value="<?php if (isset($delimeter)) { echo $delimeter; } ?>"/>-->
<input type='hidden' id='stepstatus' name='stepstatus' value='<?php if (isset($_REQUEST['step'])) { echo $_REQUEST['step']; } ?>'/>
<input type='hidden' id='mappingArr' name='mappingArr' value=''/>
<input type='hidden' id='inline_image_location' name='inline_image_location' value='<?php if(isset($extracted_image_location)){ echo $extracted_image_location; } ?>' />
<input type="hidden" name="cur_blogid" id="cur_blogid" value="<?php if (isset($blog_id)) { echo 'blog' . $blog_id; } ?>"/>

<?php 
$mappingcount = 0; 
//echo '<pre>'; print_r($proceed_status); echo '</pre>';
?>

<div class="panel-group" id="accordion" style = "width:98.3%;margin-top:-5px;padding-bottom: 20px;">
<!-- Display mapping Section - Core Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'users' || $_REQUEST['import_type'] == 'customtaxonomy' || $_REQUEST['import_type'] == 'customerreviews' || $_REQUEST['import_type'] == 'comments' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'woocommerce_variations' || $_REQUEST['import_type'] == 'woocommerce_coupons' || $_REQUEST['import_type'] == 'woocommerce_orders'|| $_REQUEST['import_type'] == 'woocommerce_refunds' || $_REQUEST['import_type'] == 'marketpress' || $_REQUEST['import_type'] == 'categories') { ?>
<div align="center">
       <div style="margin-top:20px;"><span style="font-weight:bold;font-size:16px;"><?php echo __("Import Module:",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </span><span class="moduledisplay"><?php echo $_REQUEST['import_type']; ?></span>
       </div>
</div>
<?php if($_REQUEST['import_type'] == 'custompost') { ?>
	<div style="margin-bottom:-30px"><label class="mapoption"><?php echo __('Choose anyone of the post type:',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></label></label><span style ='position:relative;top:7px;' class="mandatory"> * </span><?php echo $wpfieldsObj->getallCustomPosts(); ?></div>
<?php } else if($_REQUEST['import_type'] == 'categories') { ?>
        <div style="margin-bottom:-30px"><label class="mapoption"><?php echo __('Choose anyone of the term:',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></label></label><span style ='position:relative;top:7px;' class="mandatory"> * </span><?php echo $wpfieldsObj->getallTerms(); ?></div>
        <!--<div style="position:relative;top:33px;"><label class="mapoption"><?php echo __('Choose anyone of the post type:',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></label></label><span style ='position:relative;top:7px;' class="mandatory">  </span><?php echo $wpfieldsObj->getallCustomPosts(); ?></div>-->
<?php } else if($_REQUEST['import_type'] == 'customtaxonomy') { ?>
        <div style="margin-bottom:-30px;"><label class="mapoption"><?php echo __('Choose anyone of the taxonomy:',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </label></label><span style ='position:relative;top:7px;' class="mandatory"> * </span><?php echo $wpfieldsObj->getallCustomTaxonomies(); ?></div>
<?php } ?>
<div class="panel panel-default">
	<div class="panel-heading" data-target="#Core_Fields" data-parent="#accordion">
        	<div id='corehead' class="panel-title"> <b> <?php echo __("WordPress Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-minus-circle pull-right' id = 'Core_Fields_h_span'> </span> </div>
        </div>
        <div id="Core_Fields" style="height:auto;">
<div class="grouptitlecontent " id="corefields_content"> 
<?php $CORE_count = 0; ?>
<table class="table table-striped" style="font-size: 12px;" id="CORE_table">
<tbody>
<tr>
<td style='width:10%;padding:15px;'>
<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
<input type="checkbox" name="nameCORE" id="nameCORE" onClick="selectAll(this.id,'CORE')"><label style ='position:relative;top:-19px;'><?php $helptext = __('Select a row to map and update import',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo  $impCE->helpnotes($helptext); }?></label> </td>
<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td style='width:20%;'></td><td style='width:30%;'></td>
</tr>

<?php
$corefields =$wpfieldsObj->WPCoreFields($_REQUEST['import_type']);

foreach ($corefields as $key => $value) {
	$prefix = $key;
	foreach ($value as $key1 => $value1) {
		$label = $value1['label'];
		$name = $value1['name']; ?>
		<tr id='<?php print($prefix); ?>_tr_count<?php print($CORE_count); ?>'>
		<td id='<?php print($prefix); ?>_tdc_count<?php print($CORE_count); ?>' style='width:10%;padding:15px;'>
        	<input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
		<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          	<input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $CORE_count; ?>'> <?php }?></td>
		<td id='<?php print($prefix); ?>_tdg_count<?php print($CORE_count); ?>' class="left_align" style='width:20%;'>
			<label class='wpfields'><?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?></label><?php if($label == 'User Role'){?><label style ='position:relative;top:-39px;'><?php $helptext = __('For roles created using members plugin, the value should be a string in CSV.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo  $impCE->helpnotes($helptext); }?></label> 
			<input type='hidden' name='<?php echo $key . '__fieldname' . $mappingcount; ?>' id='<?php echo $key . '__' . $name; ?>' value='<?php echo $name; ?>' class='hiddenclass'/>
                        <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
		</td>
<?php //echo '<pre>';print_r($mapping_template_mapping_info);echo '</pre>'; ?>

		<td id="<?php print($prefix); ?>_tdh_count<?php print($CORE_count); ?>" class="left-align" style='width:20%;'>
			<span id="<?php echo $key; ?>span__mapping<?php print($mappingcount); ?>" > 
			<div id="selectdiv">
			<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ 

				 echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$CORE_count);
			}else{

			if(!in_array('post_status',$impCE->headers ) && $name == 'post_status') { 
                                foreach ($impCE->headers as $csvkey => $csvheader) { ?>
                                       <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?></option>
                               <?php } ?>
                               <option id= 'publish' value="publish">publish</option>
                               <script>
                                       jQuery( document ).ready(function() {
                                               document.getElementById("publish").selected = "true";
                                       });
                               </script>
                       <?php } else { ?>
                               <option id="select"> -- Select --</option>
				<?php  foreach ($impCE->headers as $csvkey => $csvheader) {
					if (!empty($mapping_template_mapping_info[$key])) {
						$csvheader = trim($csvheader);
	                                        $mapping_selected = null;
						if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
							$mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
							if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
								<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
								<script>
									document.getElementById("<?php echo $prefix; ?>_num_<?php echo $CORE_count; ?>").checked = true;
								</script>
							<?php } else { ?>
								<option value="<?php echo $csvheader; ?>"> <?php echo $csvheader; ?> </option>
							<?php }
                                	        } else { ?>
                        	                        <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        	<?php }
					} else { 
						if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
							<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
						<?php } else { ?>
							<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
						<?php }
					}
				}
					?><option value="header_manip">Header Manipulation</option><?php
				}
			} ?>
			</select></div></span>
		</td>
		<td style='width:20%;'></td>
			<td style='width:30%;'>
				<span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
				<span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
				<div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
			</td>
		</tr>
		<?php 
		$CORE_count++;
		$mappingcount++;
	}
} ?>
</tbody>
</table>
<input type='hidden' id='CORE_count' value= '<?php echo $CORE_count; ?>'>
<!-- Display mapping Section - Core Custom Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') { ?>
<div style="background-color: #E5E4E2; border: 1px solid #d6e9c6;padding: 10px; width:100%;">
<div id = "custfield_core"><b><?php echo __("WordPress Custom Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b>
<!--<span id="core_custom_field_h_span" class="fa fa-toggle-new pull1-right"> </span>-->
</div>
</div>
 <script>
$(document).ready(function(){
 $("#custfield_core").click(function(){
$("#corecusttog").slideToggle("slow");
document.getElementById('Core_Fields').style.height="auto";
 });
});
</script>

<div id="corecusttog" style="height:auto;">
<?php $CUST_count=0; ?>
<table class="table table-striped" style="font-size: 12px;" id="CUST_table">
<tbody>
<tr>
     <td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameCORE" id="nameCORE" onClick="selectAll(this.id,'CORE')"> <?php }?></td>
<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td style='width:20%;'></td><td style='width:30%;'></td>
</tr>
<!--<tr>
        <td colspan="2"><label id="innertitle" style="margin-top:7px;margin-left:10px;">Core Custom Fields: </label></td>
        <td style="width:20%"></td>
        <td style="width:20%"></td>
        <td style="width:30%"></td>
</tr> -->
<?php
$corefields = $wpfieldsObj->commonMetaFields();
foreach ($corefields as $key => $value) {
        $prefix = $key;
        foreach ($value as $key1 => $value1) {
                $label = $value1['label'];
                $name = $value1['name'];
                ?>
                <tr id='<?php print($prefix); ?>_tr_count<?php print($CUST_count); ?>'>
                <td id='<?php echo $prefix; ?>_tdc_count<?php print($CUST_count); ?>' style='width:10%;padding:15px;'>
                <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' > 
		<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	        <input type='checkbox' id='<?php echo $prefix; ?>_num_<?php echo $CUST_count; ?>' name = '<?php print($prefix);?>_check_fieldname<?php echo $CUST_count; ?>'><?php }?></td>
                <td id='<?php print($prefix); ?>_tdg_count<?php print($CUST_count); ?>' class="left_align" style="width:20%">
                        <label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                        <input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                        <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                </td>
                <td id='<?php print($prefix); ?>_tdh_count<?php print($CUST_count); ?>' class="left-align" style="width:20%">
                <span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
                <div id="selectdiv">
                <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
			<?php if($file_extension == 'xml'){ ?>
				<?php echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$CUST_count);
                                }else {
                        ?>
		<option id="select"> -- Select --</option>
                <?php foreach ($impCE->headers as $csvkey => $csvheader) {
                        if (!empty($mapping_template_mapping_info[$key])) {
                                $csvheader = trim($csvheader);
                                $mapping_selected = null;
                                if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
                                        $mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
                                        if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
                                                <option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                <?php if($_REQUEST['step'] == 'mapping_settings') { ?>
                                                <script>
                                                        document.getElementById("<?php echo $prefix; ?>_num_<?php echo $CUST_count; ?>").checked = true;
                                                </script>
                                                  
                                        <?php  }
                                            } else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php }
                                } else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                <?php }
                        } else {
                                if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
                                        <option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
                                <?php } else { ?>
                                        <option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
                                <?php }
                        }
			}
				?><option value="header_manip">Header Manipulation</option><?php
                } ?>
                </select></div></span></td>
                <td style='width:20%;'></td>
                        <td style='width:30%;'>
                                <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                                <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                                <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
                        </td>

                </tr>
                <?php
                $CUST_count++;
                $mappingcount++;
        }
}
?>
<input type='hidden' id='CORECUSTFIELDS_count' value= '<?php echo $CUST_count; ?>'>
</tbody>
</table>
	<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') { ?>
	        <!-- Add Custom field button-->
        	<div class = ''>
	        	<!--<input id="cust_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="cust_addcustom" onclick='disp(CUST_table, <?php echo $CUST_count; ?>, "CORECUSTFIELDS",this.id)' style="margin-left:20px;margin-bottom:15px;">-->
               <?php
                       if(!(isset($_REQUEST['eventKey'])) && !(isset($_REQUEST['freshupdate']))){ ?>
                       <!--<input id="cust_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="cust_addcustom" onclick='disp(CUST_table, <?php echo $CUST_count; ?>, "CORECUSTFIELDS",this.id)' style="margin-left:20px;margin-bottom:15px;">-->
			<input id="cust_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="cust_addcustom" onclick="registrationUI(CUST_table,'CORECUSTFIELDS','<?php echo "{$_REQUEST['import_type']}"; ?>')" style = "margin-left:20px;margin-bottom:15px;">

                       <?php } ?>

        	</div>
	
	<?php } ?>
</div>
 <?php } ?>
</div>
</div>
</div>
<?php } ?>

<!-- Display mapping Section - CCTM Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') {
if(isset($wpcsvsettings['cctmcustomfield']) && $wpcsvsettings['cctmcustomfield'] == 'enable') { ?>
<?php 
                $activeplugins = array();
                $activeplugins = get_option('active_plugins');
	if(in_array('custom-content-type-manager/index.php',$activeplugins)){
?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#cctm_addcustom_panel" data-parent="#accordion">
                <div id='cctmhead' class="panel-title"> <b> <?php echo __("CCTM Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'cctm_addcustom_panel_h_span'> </span> </div>
        </div>
        <div id="cctm_addcustom_panel" style="height:auto;">

<div class="grouptitlecontent " id="cctmfield_content">
<?php $CCTM_count = 0; ?>
	<table class="table table-striped" style="font-size: 12px;" id="CCTM_table">
	<tbody>
	<tr>
	<td style='width:10%;padding:15px;'>
	  <?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	  <input type="checkbox" name="nameCCTM" id="nameCCTM" onClick="selectAll(this.id,'CCTM')"> <?php }?>
	</td>
	<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style='width:20%;'></td>
	<td style='width:30%;'></td>
	</tr>
<?php
	$cctmfields =$wpfieldsObj->CCTMCustomFields();
	foreach ($cctmfields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1 => $value1) {
			$label = $value1['label'];
			$name = $value1['name'];
?>
			<tr id="<?php print($prefix); ?>_tr_count<?php print($CCTM_count); ?>">
			<td id='<?php print($prefix); ?>_tdc_count<?php print($CCTM_count); ?>' style='width:10%;padding:15px;'>
                        <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >		
		<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $CCTM_count; ?>'><?php }?></td>
			<td id="<?php print($prefix); ?>_tdg_count<?php print($CCTM_count); ?>" class="left_align" style='width:20%;'>
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
				<input type='hidden' name='<?php echo $key . '__fieldname' . $mappingcount; ?>' id='<?php echo $key . '__' . $name; ?>' value='<?php echo $name; ?>' />
	                        <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>

			</td>
			<td id="<?php print($prefix); ?>_tdh_count<?php print($CCTM_count); ?>" class="left-align" style='width:20%;'>
				<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
				<div id="selectdiv">
				<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
	                        <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$CCTM_count);
                                }else {
	                        ?>
				<option id="select"> -- Select --</option>
				<?php foreach ($impCE->headers as $csvkey => $csvheader) {
					if (!empty($mapping_template_mapping_info[$key])) {
						$csvheader = trim($csvheader);
	                                        $mapping_selected = null;
						if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
	                                                $mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
	                                                if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
								<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
	        	                                        <script>
	        	                                              document.getElementById("<?php echo $prefix; ?>_num_<?php echo $CCTM_count; ?>").checked = true;
                	                                   	</script>
	                                		<?php } else { ?>
	                                                         <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
        	                                        <?php }
						} else{ ?>
							<option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?></option>
                                		<?php }
					 } else {
							if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
								<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
							<?php } else { ?>
								<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
							<?php }
					}
					}
					?><option value="header_manip">Header Manipulation</option><?php
					} ?>
				</select></div></span>
			</td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','cctm_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','cctm_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
	                </td>
			</tr>
			<?php 
			$CCTM_count++;
			$mappingcount++;
		}
	}
?>
</tbody>
</table>
<input type='hidden' id='CCTM_count' value= '<?php echo $CCTM_count; ?>'>

       <!-- Add Custom field button-->
        <div class = ''>
        <!--<input id="cctm_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="cctm_addcustom" onclick='disp(CCTM_table, <?php echo $CCTM_count; ?>, "CCTM","cctm_addcustom_panel")' style="margin-left:20px;margin-bottom:15px;">-->
        </div>
</div>
</div>
</div>
<?php }
}
} ?>

<!-- Display mapping Section - TYPES Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress' || $_REQUEST['import_type'] == 'users') {
if(isset($wpcsvsettings['typescustomfield']) && $wpcsvsettings['typescustomfield'] == 'enable') { 
		$activeplugins = array();
                $activeplugins = get_option('active_plugins');
if(in_array('types/wpcf.php',$activeplugins)){
?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#types_addcustom_panel" data-parent="#accordion">
                <div id='typeshead' class="panel-title"> <b> <?php echo __("TYPES Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'types_addcustom_panel_h_span'> </span> </div>
        </div>
        <div id="types_addcustom_panel" style="height:auto;">

<?php $TYPES_count = 0;?>
<div class="grouptitlecontent " id="typesfield_content">
	<table class="table table-striped" style="font-size: 12px;" id="TYPES_table">
	<tbody>
	<tr>
	<td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameTYPES" id="nameTYPES" onClick="selectAll(this.id,'TYPES')"> <?php }?>
	</td>
	<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style='width:20%;'></td>
	<td style='width:30%;'></td>
	</tr>
<?php
	$corefields =$wpfieldsObj->TypesCustomFields();
	foreach ($corefields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1 => $value1) {
			$label = $value1['label'];
			$name = $value1['name'];
?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($TYPES_count); ?>'>
                  	<td id='<?php echo $prefix; ?>_tdc_count<?php print($TYPES_count); ?>' style='width:10%;padding:15px;'>
                         <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $TYPES_count; ?>'><?php }?>
                        </td>
                    	<td id='<?php print($prefix); ?>_tdg_count<?php print($TYPES_count); ?>'class="left_align" style='width:20%;'>
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                            	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
	                        <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>

                      	</td>
                    	<td id='<?php print($prefix); ?>_tdh_count<?php print($TYPES_count); ?>' class="left-align" style='width:20%;'>
                        	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
				<div id="selectdiv">
                     		<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
	                                <?php if($file_extension == 'xml'){ 
						echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$TYPES_count);
                                }else {
                                ?>
				<option id="select"> -- Select --</option>
				<?php foreach ($impCE->headers as $csvkey => $csvheader) {
				if (!empty($mapping_template_mapping_info[$key])) {
					$csvheader = trim($csvheader);
					$mapping_selected = null;
					if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) { 
						$mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
						if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
							<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
       		                	           	<script>
               		        	              		document.getElementById("<?php echo $prefix; ?>_num_<?php echo $TYPES_count; ?>").checked = true;
                       		        	   	</script>
						<?php } else { ?>
							 <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
						<?php }
					} else { ?>
						<option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php } 
				} else {
					if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
						<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
					<?php } else { ?>
						<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
					<?php }
				}
				}
				?><option value="header_manip">Header Manipulation</option><?php
				} ?>
			</select></div></span>
			</td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','types_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','types_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
                	</td>
			</tr>
			<?php 
			$TYPES_count++;
			$mappingcount++;
		}
	}
?>
</tbody>
</table>
<input type='hidden' id='TYPES_count' value= '<?php echo $TYPES_count; ?>'>
<input type='hidden' id='TYPES_reg_count' value= '<?php echo $TYPES_count; ?>'>
        <!-- Add Custom field button-->
        <div class = ''>
<?php
			if(!(isset($_REQUEST['eventKey'])) && !(isset($_REQUEST['freshupdate']))){
?>
<!--        <input id="types_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="types_addcustom" onclick='disp(TYPES_table, <?php echo $TYPES_count; ?>, "TYPES","types_addcustom_panel","<?php echo "{$_REQUEST['import_type']}";?>")' style="margin-left:20px;margin-bottom:15px;">-->
	<input id="types_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="types_addcustom" onclick="registrationUI(TYPES_table,'TYPES','<?php echo "{$_REQUEST['import_type']}"; ?>')" style = "margin-left:20px;margin-bottom:15px;">
<?php
			}
       ?>
        </div>
</div>
</div>
</div>
<?php } 
}
} ?>

<!-- Display mapping Section - ACF Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress' || $_REQUEST['import_type'] == 'users' || $_REQUEST['import_type'] == 'customtaxonomy') {
if(isset($wpcsvsettings['acfcustomfield']) && $wpcsvsettings['acfcustomfield'] == 'enable') { 
                $activeplugins = array();
                $activeplugins = get_option('active_plugins');
if(in_array('advanced-custom-fields/acf.php',$activeplugins) || in_array('advanced-custom-fields-pro/acf.php',$activeplugins)){
?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#acf_addcustom_panel" data-parent="#accordion">
                <div id="acfhead" class="panel-title"> <b> <?php echo __("ACF CUSTOM Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'acf_addcustom_panel_h_span'> </span> </div>
        </div>
        <div id="acf_addcustom_panel">

<div class="grouptitlecontent " id="acffields_content"> 
<?php $ACF_count =0; ?>
	<table class="table table-striped" style="font-size: 12px;" id="ACF_table">
	<tbody>
	<tr>
	<td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameACF" id="nameACF" onClick="selectAll(this.id,'ACF')"> <?php }?></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style="width:20%"></td><td style="width:30%"></td>
	</tr>
<?php
	$corefields =$wpfieldsObj->ACFCustomFields();
#print_r($corefields);
	foreach ($corefields as $key => $value) {
		if($key == 'ACF') {
			$prefix = $key;
			foreach ($value as $key1) {
				$label = $key1['label'];
				$name = $key1['name'];
?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($ACF_count); ?>'>
                               	<td id='<?php echo $prefix; ?>_tdc_count<?php print($ACF_count); ?>' style='width:10%;padding:15px;'>
                                <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $ACF_count; ?>'> <?php }?>
 
                                </td>
                               	<td id='<?php print($prefix); ?>_tdg_count<?php print($ACF_count); ?>' class="left_align" style="width:20%">
					<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
					<input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
					
                                       <input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />

                               	</td>
                               	<td id='<?php print($prefix); ?>_tdh_count<?php print($ACF_count); ?>' class="left-align" style="width:20%">
                               	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
				<div id="selectdiv">
                                       <select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$ACF_count);
                                }else {
                                ?>

				<option id="select"> -- Select --</option>
				<?php foreach ($impCE->headers as $csvkey => $csvheader) {
					if (!empty($mapping_template_mapping_info[$key])) {
						$csvheader = trim($csvheader);
						$mapping_selected = null;
                                                if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
							$mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
							if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
                                                		<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                   		<script>
                                                      			document.getElementById("<?php echo $prefix; ?>_num_<?php echo $ACF_count; ?>").checked = true;
	                                                   	</script>
							<?php } else { ?>
		                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
							<?php }
						} else { ?>
	                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
        	                                <?php } 
					} else {
						if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
							<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
						<?php } else { ?>
							<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
						<?php }
					}
					}
					?><option value="header_manip">Header Manipulation</option><?php
				} ?>
				</select></div></span></td>
				<td style='width:20%;'></td>
				<td style='width:30%;'>
		                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','acf_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
		                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','acf_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                		        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
		                </td>
				</tr>
				<?php 
				$ACF_count++;
				$mappingcount++;
			}
		}
} ?>
</tbody>
</table>
<input type='hidden' id='ACF_count' value= '<?php echo $ACF_count; ?>'>
<input type='hidden' id='ACF_reg_count' value= '<?php echo $ACF_count; ?>'>

        <!-- Add Custom field button-->
        <div class = ''>
 <?php
			if(!(isset($_REQUEST['eventKey'])) && !(isset($_REQUEST['freshupdate']))){
?>
	
<!--        <input id="acf_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="acf_addcustom" onclick='disp(ACF_table, <?php echo $ACF_count; ?>, "ACF","acf_addcustom_panel","<?php echo "{$_REQUEST['import_type']}";?>")' style="margin-left:20px;margin-bottom:15px;">-->
		<input id="acf_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="acf_addcustom" onclick="registrationUI(ACF_table,'ACF','<?php echo "{$_REQUEST['import_type']}"; ?>')" style = "margin-left:20px;margin-bottom:15px;">

<?php		
			}
       ?>
        </div>
</div>
</div>
</div>
<?php }
}
} ?>

<!-- Display mapping Section - ACF RF Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') {
if(isset($wpcsvsettings['acfcustomfield']) && $wpcsvsettings['acfcustomfield'] == 'enable') { 
                $activeplugins = array();
                $activeplugins = get_option('active_plugins');
	if(in_array('advanced-custom-fields-pro/acf.php',$activeplugins) || in_array('acf-repeater/acf-repeater.php', $activeplugins)){?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#rffield" data-parent="#accordion">
                <div id='rfhead' class="panel-title"> <b> <?php echo __("RF CUSTOM Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'rffield_h_span'> </span> </div>
        </div>
        <div id="rffield" style="height:auto;">

<div class="grouptitlecontent " id"acfrf_content">
<?php $RF_count=0; ?>
        <table class="table table-striped" style="font-size: 12px;" id="RF_table">
        <tbody>
        <tr>
        <td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameRF" id="nameRF" onClick="selectAll(this.id,'RF')"><?php }?></td>
        <td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
        <td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
        <td style="width:20%"></td><td style="width:30%"></td>
        </tr>
<?php
        $corefields =$wpfieldsObj->ACFCustomFields();
        foreach ($corefields as $key => $value) { 
		if($key == 'RF') {
			$prefix = $key;
			foreach ($value as $key1 => $value1) {
				$label = $value1['label'];
				$name = $value1['name'];
?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($RF_count); ?>'>
                       	<td id='<?php echo $prefix; ?>_tdc_count<?php print($RF_count); ?>' style='width:10%;padding:15px;'>
    	                <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
		<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
                        <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $RF_count; ?>'><?php }?>
                        </td>
                       	<td  id='<?php print($prefix); ?>_tdg_count<?php print($RF_count); ?>' class="left_align" style="width:20%">
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                               	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                                <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                       	</td>
                       	<td id='<?php print($prefix); ?>_tdh_count<?php print($RF_count); ?>' class="left-align" style="width:20%">
                       	<span id="<?php print($prefix); ?>_RF__mapping<?php print($mappingcount); ?>" >
				<div id="selectdiv">
                       	<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$RF_count);
                                }else {
                                ?>

				<option id="select"> -- Select --</option>
				<?php foreach ($impCE->headers as $csvkey => $csvheader) {		
					if (!empty($mapping_template_mapping_info[$key])) {
						$csvheader = trim($csvheader);
	                                        $mapping_selected = null;   
						if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
							$mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
	                                                if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
								<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
								<script>
									document.getElementById("<?php echo $prefix; ?>_num_<?php echo $RF_count; ?>").checked = true;
								</script>
							<?php } else { ?>
		                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
							<?php }
						} else { ?>
							<option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
	                                        <?php }
	                                } else {
						if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
							<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
						<?php } else { ?>
							<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
						<?php }
					}
					}
					?><option value="header_manip">Header Manipulation</option><?php
				} ?>
				</select></div></span></td>
				<td style='width:20%;'></td>
				<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','rffield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','rffield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
		                </td>
				</tr>
				<?php 
				$RF_count++;
				$mappingcount++;
			}
		} 
	} ?>
</tbody>
</table>
<input type='hidden' id='RF_count' value= '<?php echo $RF_count; ?>'>

        <!-- Add Custom field button-->
        <div class = ''>
<!--        <input id="rf_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="rf_addcustom" onclick='disp(RF_table, <?php echo $RF_count; ?>, "RF")'>-->
        </div>
</div>
</div>
</div>
<?php } 
}
} ?>

<!-- Display mapping Section - PODS Fields-->
<?php  if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') {
if(isset($wpcsvsettings['podscustomfield']) && $wpcsvsettings['podscustomfield'] == 'enable') { 
                $activeplugins = array();
                $activeplugins = get_option('active_plugins');
if(in_array('pods/init.php',$activeplugins)){
?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#pods_addcustom_panel" data-parent="#accordion">
                <div id='podshead'class="panel-title"> <b> <?php echo __("PODS Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'pods_addcustom_panel_h_span'> </span> </div>
        </div>
        <div id="pods_addcustom_panel" style="height:auto;">
<?php $PODS_count=0;?>
<div class="grouptitlecontent " id="podsfield_content">
	<table class="table table-striped" style="font-size: 12px;" id="PODS_table">
	<tbody>
	<tr>
	<td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="namePODS" id="namePODS" onClick="selectAll(this.id,'PODS')"><?php }?></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style="width:20%"></td><td style="width:30%"></td>
	</tr>
<?php
	$corefields =$wpfieldsObj->PODSCustomFields();
	foreach ($corefields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1 => $value1) {
			$label = $value1['label'];
			$name = $value1['name'];
?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($PODS_count); ?>'>
                       	<td id='<?php echo $prefix; ?>_tdc_count<?php print($PODS_count); ?>' style='width:10%;padding:15px;'>
                        <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
		        <?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
                        <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $PODS_count; ?>'><?php }?>
                        </td>
                       	<td id='<?php print($prefix); ?>_tdg_count<?php print($PODS_count); ?>' class="left_align" style="width:20%">
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                               	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                                <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                       	</td>
                        <td id='<?php print($prefix); ?>_tdh_count<?php print($PODS_count); ?>' class="left-align" style="width:20%">
                       	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                       	<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$PODS_count);
                                }else {
                                ?>

			<option id="select"> -- Select --</option>
			<?php foreach ($impCE->headers as $csvkey => $csvheader) {
				if (!empty($mapping_template_mapping_info[$key])) {
                                        $csvheader = trim($csvheader);
                                        $mapping_selected = null;
					if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
						$mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
						if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
							<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
							<script>
								document.getElementById("<?php echo $prefix; ?>_num_<?php echo $PODS_count; ?>").checked = true;
							</script>
						<?php } else { ?>
	                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
						<?php }
					} else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php }
				} else {
					if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
						<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
					<?php } else { ?>
						<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
					<?php }
				}
				}
				?><option value="header_manip">Header Manipulation</option><?php
			} ?>
			</select></div></span></td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','pods_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','pods_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
                	</td>
			</tr>
			<?php 
			$PODS_count++;
			$mappingcount++;
		}
	}
?>
</tbody>
</table>
<input type='hidden' id='PODS_count' value= '<?php echo $PODS_count; ?>'>
<input type='hidden' id='PODS_reg_count' value= '<?php echo $PODS_count; ?>'>

        <!-- Add Custom field button-->
        <div class = ''>
<?php
				if(!(isset($_REQUEST['eventKey'])) && !(isset($_REQUEST['freshupdate']))){
?>
<!--        <input id="pods_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="pods_addcustom" onclick='disp(PODS_table, <?php echo $PODS_count; ?>, "PODS","pods_addcustom_panel","<?php echo "{$_REQUEST['import_type']}"; ?>" )' style="margin-left:20px;margin-bottom:15px;">-->
	<input id="pods_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="pods_addcustom" onclick="registrationUI(PODS_table,'PODS','<?php echo "{$_REQUEST['import_type']}"; ?>')" style = "margin-left:20px;margin-bottom:15px;">

<?php
			}
               ?>
        </div>
</div>
</div>
</div>
<?php } 
}
} ?>

<!-- Display mapping Section - AIOSEO Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') {
if(isset($wpcsvsettings['rseooption']) && $wpcsvsettings['rseooption'] == 'aioseo') { 
               $activeplugins = array();
               $activeplugins = get_option('active_plugins');
if(in_array('all-in-one-seo-pack/all_in_one_seo_pack.php',$activeplugins)){
?>

<div class="panel panel-default">
        <div class="panel-heading" data-target="#aiofield" data-parent="#accordion">
                <div id='aiohead' class="panel-title"> <b> <?php echo __("All-in-One SEO Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'aiofield_h_span'> </span> </div>
        </div>
        <div id="aiofield" style="height:auto;">

<div class="grouptitlecontent " id="aiofields_content">
<?php $AIOSEO_count=0; ?>
	<table class="table table-striped" style="font-size: 12px;" id="AIOSEO_table">	
	<tbody>
	<tr>
	<td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameAIOSEO" id="nameAIOSEO" onClick="selectAll(this.id,'AIOSEO')"> <?php }?></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style="width:20%"></td><td style="width:30%"></td>
	</tr>
	<?php
	$corefields =$wpfieldsObj->aioseoFields();
	foreach ($corefields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1 => $value1) {
			$label = $value1['label'];
			$name = $value1['name'];
	?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($AIOSEO_count); ?>'>
                       	<td id='<?php echo $prefix; ?>_tdc_count<?php print($AIOSEO_count); ?>' style='width:10%;padding:15px;'>
                        <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
			<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
                        <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $AIOSEO_count; ?>'> <?php }?>
                        </td>
                       	<td id='<?php print($prefix); ?>_tdg_count<?php print($AIOSEO_count); ?>' class="left_align" style="width:20%">
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                               	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                                <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                       	</td>
                       	<td id='<?php print($prefix); ?>_tdh_count<?php print($AIOSEO_count); ?>' class="left-align" style="width:20%">
                       	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                       	<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$AIOSEO_count);
                                }else {
                                ?>

			<option id="select"> -- Select --</option>
			<?php foreach ($impCE->headers as $csvkey => $csvheader) {
				if (!empty($mapping_template_mapping_info[$key])) {
                                        $csvheader = trim($csvheader);
                                        $mapping_selected = null;
                                        if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
                                                $mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
                                                if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
							<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
							<script>
								document.getElementById("<?php echo $prefix; ?>_num_<?php echo $AIOSEO_count; ?>").checked = true;
							</script>
						<?php } else { ?>
	                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
						<?php }
					} else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php }
                                } else {
					if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
						<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
					<?php } else { ?>
						<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
					<?php }
				}
				}
				?><option value="header_manip">Header Manipulation</option><?php
			} ?>
			</select></div></span></td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','aiofield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','aiofield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
        	        </td>
			</tr>
			<?php 
			$AIOSEO_count++;
			$mappingcount++;
		}
	}
?>
</tbody>
</table>
<input type='hidden' id='AIOSEO_count' value= '<?php echo $AIOSEO_count; ?>'>
</div>
</div>
</div>
<?php } 
}
} ?>

<!-- Display mapping Section - YOAST SEO Fields-->
<?php if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'page' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') {
if(isset($wpcsvsettings['rseooption']) && $wpcsvsettings['rseooption'] == 'yoastseo') { 
                $activeplugins = array();
                $activeplugins = get_option('active_plugins');
if(in_array('wordpress-seo/wp-seo.php',$activeplugins)){?>
<div class="panel panel-default">
        <div class="panel-heading"  data-target="#yoastfield" data-parent="#accordion">
                <div id='yoasthead' class="panel-title"> <b> <?php echo __("YOAST SEO Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'yoastfield_h_span'> </span> </div>
        </div>
        <div id="yoastfield" style="height:auto;">

<div class="grouptitlecontent " id="yoastfield_content">
<?php $YOASTSEO_count = 0; ?>
	<table class="table table-striped" style="font-size: 12px;" id="YOASTSEO_table">
	<tbody>
	<tr>
	<td style='width:10%;padding:15px'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameYOASTSEO" id="nameYOASTSEO" onClick="selectAll(this.id,'YOASTSEO')"><?php }?></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style="width:20%"></td><td style="width:20%"></td>
	</tr>
<?php
	$corefields =$wpfieldsObj->yoastseoFields();
	foreach ($corefields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1 => $value1) {
			$label = $value1['label'];
			$name = $value1['name'];
			?>
		<tr id='<?php print($prefix); ?>_tr_count<?php print($YOASTSEO_count); ?>'>
                       	<td id='<?php echo $prefix; ?>_tdc_count<?php print($YOASTSEO_count); ?>' style='width:10%;padding:15px;'>
                        <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
	  <?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $YOASTSEO_count; ?>'><?php }?>
                        </td>
                       	<td id='<?php print($prefix); ?>_tdg_count<?php print($YOASTSEO_count); ?>' class="left_align" style="width:20%">
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                               	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                                <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                       	</td>
                        <td id='<?php print($prefix); ?>_tdh_count<?php print($YOASTSEO_count); ?>' class="left-align" style="width:20%">
                       	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
				<div id="selectdiv">
                       	<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$YOASTSEO_count);
                                }else {
                                ?>

			<option id="select"> -- Select --</option>
			<?php foreach ($impCE->headers as $csvkey => $csvheader) {
				if (!empty($mapping_template_mapping_info[$key])) {
                                        $csvheader = trim($csvheader);
                                        $mapping_selected = null;
                                        if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
                                                $mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
                                                if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
							<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
							<script>
								document.getElementById("<?php echo $prefix; ?>_num_<?php echo $YOASTSEO_count; ?>").checked = true;
							</script>
						<?php } else { ?>
	                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
						<?php }
					} else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php }
                                } else {
					if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
						<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
					<?php } else { ?>
						<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
					<?php }
				}
				}
				?><option value="header_manip">Header Manipulation</option><?php
			} ?>
			</select></div></span></td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','yoastfield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','yoastfield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
	                </td>
			</tr>
			<?php 
			$YOASTSEO_count++;
			$mappingcount++;
		}
	}
?>
</tbody>
</table>
<input type='hidden' id='YOASTSEO_count' value= '<?php echo $YOASTSEO_count; ?>'>
      </div>
</div>
</div>
<?php } 
}
} ?>

<!-- Display mapping Section - WP-MEMBERS Fields-->
<?php if($_REQUEST['import_type'] == 'users') { ?>
<?php if(isset($wpcsvsettings['rwpmembers']) && $wpcsvsettings['rwpmembers'] == 'enable') { 
                $activeplugins = array();
                $activeplugins = get_option('active_plugins');
	if(in_array('wp-members/wp-members.php',$activeplugins)){
?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#wpmembers_addcustom_panel" data-parent="#accordion">
                <div id='wpmembershead' class="panel-title"> <b> <?php echo __("WP-Members Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'wpmembers_addcustom_panel_h_span'> </span> </div>
        </div>
        <div id="wpmembers_addcustom_panel" style="height:auto;">

<div class="grouptitlecontent " id="wpmemfield_content">
<?php $WPMEMBERS_count = 0; ?>
	<table class="table table-striped" style="font-size: 12px;" id="WPMEMBERS_table">
	<tbody>
	<tr>
	<td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameWPMEMBERS" id="nameWPMEMBERS" onClick="selectAll(this.id,'WPMEMBERS')"><?php }?></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style="width:20%"></td><td style="width:30%"></td>
	</tr>
	<?php
	$corefields =$wpfieldsObj->wpmembersFields();
	foreach ($corefields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1 => $value1) {
			$label = $value1['label'];
			$name = $value1['name'];
			?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($WPMEMBERS_count); ?>'>
                       	<td id='<?php echo $prefix; ?>_tdc_count<?php print($WPMEMBERS_count); ?>' style='width:10%;padding:15px;'>
                        <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
	  <?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $WPMEMBERS_count; ?>'><?php }?>
                        </td>
                       	<td id='<?php print($prefix); ?>_tdg_count<?php print($WPMEMBERS_count); ?>' class="left_align" style="width:20%">
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                               	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                                <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                       	</td>
                        <td id='<?php print($prefix); ?>_tdh_count<?php print($WPMEMBERS_count); ?>' class="left-align" style="width:20%">
                       	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                       	<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$WPMEMBERS_count);
                                }else {
                                ?>

			<option id="select"> -- Select --</option>
			<?php foreach ($impCE->headers as $csvkey => $csvheader) {
				if (!empty($mapping_template_mapping_info[$key])) {
                                        $csvheader = trim($csvheader);
                                        $mapping_selected = null;
                                        if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
                                                $mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
                                                if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
							<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
							<script>
								document.getElementById("<?php echo $prefix; ?>_num_<?php echo $WPMEMBERS_count; ?>").checked = true;
							</script>
						<?php } else { ?>
	                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
						<?php }
					} else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php }
                                } else {
					if (($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping')) { ?>
						<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
					<?php } else { ?>
						<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
					<?php }
				}
				}
				?><option value="header_manip">Header Manipulation</option><?php
			} ?>
			</select></div></span></td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','wpmembers_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','wpmembers_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
	                </td>
			</tr>
			<?php 
			$WPMEMBERS_count++;
			$mappingcount++;
		}
	}
?>
</tbody>
</table>
<input type='hidden' id='WPMEMBERS_count' value= '<?php echo $WPMEMBERS_count; ?>'>

        <!-- Add Custom field button-->
        <div class = ''>
        <!--<input id="wpmembers_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="wpmembers_addcustom" onclick='disp(WPMEMBERS_table, <?php echo $WPMEMBERS_count; ?>, "WPMEMBERS","wpmembers_addcustom_panel")' style="margin-left:20px;margin-bottom:15px;">-->
        </div>
</div>
</div>
</div>
<?php }
}
} ?>

<!-- Display mapping Section - TERMS/TAXONOMIES Fields-->
<?php  if($_REQUEST['import_type'] == 'post' || $_REQUEST['import_type'] == 'custompost' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'marketpress') { ?>
<div class="panel panel-default">
	<div class="panel-heading"  data-target="#termstaxfield" data-parent="#accordion">
	        <div id='termshead' class="panel-title"> <b> <?php echo __("Terms / Taxonomies Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'termstaxfield_h_span'> </span> </div>
        </div>
        <div id="termstaxfield" style="height:auto;">
<?php $TERMS_count=0; ?>
<div class="grouptitlecontent " id="termtax_content">
<table class="table table-striped" style="font-size: 12px;" id="TERMS_table">
<tbody>
<tr>
<td style='width:10%;padding:15px;'>
<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
<input type="checkbox" name="nameTERMS" id="nameTERMS" onClick="selectAll(this.id,'TERMS')"><?php }?></td>
<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td class='columnheader' style='width:20%;'><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td style='width:20%;'></td><td style='width:20%;'></td>
</tr>
<?php
$corefields =$wpfieldsObj->termsandtaxos($_REQUEST['import_type']);
foreach ($corefields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1) {
			$label = $key1['label'];
			$name = $key1['name'];
			?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($TERMS_count); ?>'>
                       	<td id='<?php echo $prefix; ?>_tdc_count<?php print($TERMS_count); ?>' style='width:10%;padding:15px;'>
                        <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $TERMS_count; ?>'><?php }?> 
                        </td>
                       	<td id='<?php print($prefix); ?>_tdg_count<?php print($TERMS_count); ?>' class="left_align" style='width:20%;'>
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                               	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                                <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                       	</td>
                        <td id='<?php print($prefix); ?>_tdh_count<?php print($TERMS_count); ?>' class="left-align" style='width:20%;'>
                       	<span id="<?php echo $prefix; ?>span__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                       	<select name="<?php echo $prefix; ?>__mapping<?php print($mappingcount); ?>" id="<?php echo $prefix; ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$TERMS_count);
                                }else {
                                ?>

			<option id="select"> -- Select --</option>
			<?php foreach ($impCE->headers as $csvkey => $csvheader) {
				if (!empty($mapping_template_mapping_info[$key])) {
                                        $csvheader = trim($csvheader);
                                        $mapping_selected = null;
                                        if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
                                                $mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
                                                if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
							<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
							<script>
								document.getElementById("<?php echo $prefix; ?>_num_<?php echo $TERMS_count; ?>").checked = true;
							</script>
						<?php } else { ?>
	                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
						<?php }
					} else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php }
                                } else {
					if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
						<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
					<?php } else { ?>
						<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
					<?php }
				}
				}
				?><option value="header_manip">Header Manipulation</option><?php
			} ?>
			</select></div></span></td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','termstaxfield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','termstaxfield')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
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

<!-- Display mapping Section - WP-eCommerce Custom Fields-->
<?php  if($_REQUEST['import_type'] == 'wpcommerce') { ?>
<?php if(isset($wpcsvsettings['wpcustomfields']) && $wpcsvsettings['wpcustomfields'] == 'enable') { 
		$activeplugins = array();
                $activeplugins = get_option('active_plugins');
	if(in_array('wp-e-commerce-custom-fields/custom-fields.php',$activeplugins)){
?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#wpecom_addcustom_panel" data-parent="#accordion">
                <div id='wpecomhead' class="panel-title"> <b> <?php echo __("WP-eCommerce Custom Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'wpecom_addcustom_panel_h_span'> </span> </div>
        </div>
        <div id="wpecom_addcustom_panel" style="height:auto;">
<?php $WPECOM_count = 0; ?>
<div class="grouptitlecontent " id="wpcustfield_content">
	<table class="table table-striped" style="font-size: 12px;" id="WPECOM_table">
	<tbody>
	<tr>
	<td style='width:10%;padding:15px;'>
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
	<input type="checkbox" name="nameWPECOMMETA" id="nameWPECOMMETA" onClick="selectAll(this.id,'WPECOMMETA')"><?php }?></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
	<td style="width:20%"></td><td style="width:30%"></td>
	</tr>
	<?php
	$corefields =$wpfieldsObj->wpecommerceCustomFields();
	foreach ($corefields as $key => $value) {
		$prefix = $key;
		foreach ($value as $key1 => $value1) {
			$label = $value1['label'];
			$name = $value1['name'];
			?>
			<tr id='<?php print($prefix); ?>_tr_count<?php print($WPECOM_count); ?>'>
                       	<td id='<?php echo $prefix; ?>_tdc_count<?php print($WPECOM_count); ?>' style='width:10%;padding:15px;'>
                        <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
		       <?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
                        <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $WPECOM_count; ?>'><?php }?>
                        </td>
                       	<td id='<?php print($prefix); ?>_tdg_count<?php print($WPECOM_count); ?>' class="left_align" style="width:20%">
				<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                               	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                                <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
                       	</td>
                       	<td id='<?php print($prefix); ?>_tdh_count<?php print($WPECOM_count); ?>' class="left-align" style="width:20%">
                       	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
                       	<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$WPECOM_count);
                                }else {
                                ?>

			<option id="select"> -- Select --</option>
			<?php foreach ($impCE->headers as $csvkey => $csvheader) {
				if (!empty($mapping_template_mapping_info[$key])) {
                                        $csvheader = trim($csvheader);
                                        $mapping_selected = null;
                                        if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
                                                $mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
                                                if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
							<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
							<script>
								document.getElementById("<?php echo $prefix; ?>_num_<?php echo $WPECOM_count; ?>").checked = true;
							</script>
						<?php } else { ?>
	                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>	
						<?php }
					} else { ?>
                                                <option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
                                        <?php }
                                } else {
					if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
						<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
					<?php } else { ?>
						<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
					<?php }
				}
				}
				?><option value="header_manip">Header Manipulation</option><?php
			} ?>
			</select></div></span></td>
			<td style='width:20%;'></td>
			<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','wpecom_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','wpecom_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
	                </td>
			</tr>
			<?php
			$WPECOM_count++; 
			$mappingcount++;
		}
	}
?>
</tbody>
</table>
<input type='hidden' id='WPECOMMETA_count' value= '<?php echo $WPECOM_count; ?>'>

        <!-- Add Custom field button-->
        <div class = ''>
        <!--<input id="wpecom_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="wpecom_addcustom" onclick='disp(WPECOM_table, <?php echo $WPECOM_count; ?>, "WPECOMMETA","wpecom_addcustom_panel")' style="margin-left:20px;margin-bottom:15px;">-->
        </div>
</div>
</div>
</div>
<?php } 
}
} ?>

<!-- Display mapping Section - eCommerce Meta Fields-->
<?php if($_REQUEST['import_type'] == 'wpcommerce' || $_REQUEST['import_type'] == 'woocommerce_products' || $_REQUEST['import_type'] == 'woocommerce_variations' || $_REQUEST['import_type'] == 'woocommerce_coupons' || $_REQUEST['import_type'] == 'woocommerce_orders' || $_REQUEST['import_type'] == 'woocommerce_refunds' || $_REQUEST['import_type'] == 'eshop' || $_REQUEST['import_type'] == 'marketpress') { 
                $activeplugins = array();
                $activeplugins = get_option('active_plugins');
	if(in_array('wp-e-commerce-custom-fields/custom-fields.php',$activeplugins) || in_array('woocommerce/woocommerce.php',$activeplugins) || in_array('eshop/eshop.php',$activeplugins) || in_array('wordpress-ecommerce/marketpress.php',$activeplugins)){
?>
<div class="panel panel-default">
        <div class="panel-heading" data-target="#ecom_addcustom_panel" data-parent="#accordion">
                <div id='ecomhead' class="panel-title"> <b> <?php echo __("eCommerce Meta Fields: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></b> <span class = 'fa fa-plus-circle pull-right' id = 'ecom_addcustom_panel_h_span'> </span> </div>
        </div>
        <div id="ecom_addcustom_panel" style="height:auto;">

<?php $ECOM_count=0; ?>
<div class="grouptitlecontent " id ="ecommetfield_content">
<table class="table table-striped" style="font-size: 12px;" id="ECOM_table">
<tbody>
<tr>
<td style='width:10%;padding:15px;'>
<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
<input type="checkbox" name="nameECOMMETA" id="nameECOMMETA" onClick="selectAll(this.id,'ECOMMETA')"><?php }?></td>
<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("WP Fields",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td class='columnheader' style="width:20%"><label class='groupfield'><?php echo __("CSV Header",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
<td style="width:20%"></td><td style="width:30%"></td>
</tr>
<?php
$corefields =$wpfieldsObj->ecommerceMetaFields($_REQUEST['import_type']);
foreach ($corefields as $key => $value) {
	$prefix = $key;
	foreach ($value as $key1 => $value1) {
		$label = $value1['label'];
		$name = $value1['name'];
		?>
		<tr id='<?php print($prefix); ?>_tr_count<?php print($ECOM_count); ?>'>
               	<td id='<?php echo $prefix; ?>_tdc_count<?php print($ECOM_count); ?>' style='width:10%;padding:15px;'>
          <input type = "hidden" name = '<?php print($prefix);?>_check_<?php echo $name; ?>' value = 'off' >
	<?php if(isset($proceed_status) && ($proceed_status == 'Update')) {?>
          <input type='checkbox'  name = '<?php print($prefix);?>_check_<?php echo $name; ?>' id='<?php print($prefix); ?>_num_<?php echo $ECOM_count; ?>'><?php }?>
                </td>
               	<td id='<?php print($prefix); ?>_tdg_count<?php print($ECOM_count); ?>' class="left_align" style="width:20%">
			<label class='wpfields'> <?php print('<b>'.$label.'</b></label><br><label class="samptxt">[Name: '.$name.']'); ?> </label>
                       	<input type='hidden' name='<?php echo $prefix . '__fieldname' . $mappingcount; ?>' id='<?php echo $prefix . '__' . $name; ?>' value='<?php echo $name; ?>' />
                        <input type='hidden' name='<?php echo $key . 'req__fieldname' . $mappingcount; ?>' id='<?php echo $key . 'req__' . $name; ?>' value='<?php echo $name; ?>' class='req_hiddenclass'/>
               	</td>
              	<td id='<?php print($prefix); ?>_tdh_count<?php print($ECOM_count); ?>' class="left-align" style="width:20%">
             	<span id="<?php print($prefix); ?>span__mapping<?php print($mappingcount); ?>" >
			<div id="selectdiv">
              	<select name="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" id="<?php print($prefix); ?>__mapping<?php print($mappingcount); ?>" class="uiButton">
                                <?php if($file_extension == 'xml'){ 
					echo $impCE->xml_mappingbox($getrecords,$name,$prefix,$ECOM_count);
                                }else {
                                ?>

		<option id="select"> -- Select --</option>
		<?php foreach ($impCE->headers as $csvkey => $csvheader) {
			if (!empty($mapping_template_mapping_info[$key])) {
				$csvheader = trim($csvheader);
				$mapping_selected = null;
				if (array_key_exists($csvheader,$mapping_template_mapping_info[$key])) {
					$mapping_selected = $mapping_template_mapping_info[$key][$csvheader];
					if($name == $mapping_template_mapping_info[$key][$csvheader]) { ?>
						<option value="<?php echo $csvheader; ?>" selected> <?php echo $csvheader; ?></option>
                                                <?php if(!$ECOM_count) { ?>
						<script>
							document.getElementById("<?php echo $prefix; ?>_num_<?php echo $ECOM_count; ?>").checked = true;
						</script>
                                                 <?php } ?>
					<?php } else { ?>
                                               	<option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
					<?php }
				} else { ?>
					<option value="<?php echo $csvheader; ?>" > <?php echo $csvheader; ?> </option>
				<?php }
			} else {
				if ($name == $csvheader && $wpcsvsettings['automapping'] == 'automapping') { ?>
					<option value="<?php print($csvheader); ?>" selected><?php print($csvheader); ?> </option>
				<?php } else { ?>
					<option value="<?php echo $csvheader; ?>"><?php echo $csvheader; ?> </option>
				<?php }
			}
			}
			?><option value="header_manip">Header Manipulation</option><?php
		} ?>
		</select></div></span></td>
		<td style='width:20%;'></td>
		<td style='width:30%;'>
                        <span title='Static' style='margin-right:15px;' id='<?php echo $prefix; ?>_staticbutton_mapping<?php echo $mappingcount; ?>' onclick="static_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','ecom_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/static.png' width='24' height='24' /></span>
                        <span title='Formula' style='margin-right:15px;' id='<?php echo $prefix; ?>_formulabutton_mapping<?php echo $mappingcount; ?>' onclick="formula_button(this.id,'<?php echo $prefix; ?>','<?php echo $mappingcount; ?>','ecom_addcustom_panel')"><img src='<?php echo WP_CONTENT_URL; ?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG; ?>/images/formula.png' width='24' height='24' /></span>
                        <div id="<?php echo $prefix; ?>_customdispdiv_mapping<?php echo $mappingcount; ?>" style='height:246px;padding:10px;margin-top:5px;display:none;width:300px;border:3px solid #2ea2cc;'></div>
                </td>
		</tr>
		<?php 
		$ECOM_count++;
		$mappingcount++;
	}
}
?>
</tbody>
</table>
<input type='hidden' id='ECOMMETA_count' value= '<?php echo $ECOM_count; ?>'>

        <!-- Add Custom field button-->
        <div class = ''>
        <!--<input id="ecom_addcustom" type="button" class="btn btn-primary" value="Add Custom Field" name="ecom_addcustom" onclick='disp(ECOM_table, <?php echo $ECOM_count; ?>, "ECOMMETA","ecom_addcustom_panel")' style="margin-left:20px;margin-bottom:15px;">-->
        </div>
</div>
</div>
</div>
<?php }
} ?>

</div> <!-- End of panel -->
<?php
#print_r($_POST); 
#print_r($_SESSION);  
#print('uploaded_csv_name: ' . $uploaded_csv_name);
$file_name = explode('-', $uploaded_csv_name);
$templatename = $file_name[0].'_'.date('Y-m-d h:i:s'); ?>
<br><div style="padding:15px;" align="center">

<?php if(isset($_REQUEST['templateId'])) { ?>
	<div style="margin-top:10px;">
	<label id='importalign'><?php echo __("Do you want to: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
	<label id='importalign'><input type="radio" name="update_rename_file" id="update_template" checked value="update" onclick="update_rename(this.id);"/><?php echo __("Update or ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
	<label id='importalign'><input type="radio" name="update_rename_file" id="rename_template" value="rename" onclick="update_rename(this.id);"/><?php echo __("Save this mapping as Template ?",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
	<span id = 'updatemappingtemplatename' style='display:none;'>
	<input type='text' id='template_name' style='margin-left:10px;' placeholder='<?php echo $templatename; ?>' value="" onblur='savetemplatename()'>
	</span>
	</div>
<?php } else{ ?>
	<label id='importalign'><input type="checkbox" name="newmappingtemplate" id="newmappingtemplate" value="newtemplate" onclick="update_rename(this.id);"/><?php echo __("Save this mapping as Template",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
	<span id = 'newmappingtemplatename' style='display:none;'>
	<input type='text' id='template_name' style='margin-left:10px;' placeholder='<?php echo $templatename; ?>' onblur='savetemplatename()'>
	</span>
<?php } ?>

<!--       <label class='mapoption' style="margin-top:5px;"><?php echo __("Mapping Template Name: ",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
       <input type='text' id='template_name' style='margin-left:10px;margin-top:22px;' placeholder='<?php echo $templatename; ?>' onblur='savetemplatename()'> -->
</div><br>
<input type='hidden' id='map_temp_name' name='map_temp_name' value='<?php echo $templatename; ?>'/>
<input type="hidden" id="current_temp_id" name="current_temp_id" value="<?php if(isset($_REQUEST['templateId'])) {  echo $_REQUEST['templateId']; } ?>" />
<input type='hidden' id='h1' name='h1' value='<?php if (isset($mappingcount)) { echo $mappingcount; } ?>'/>
<input type='hidden' id='reg_mapcount' name='reg_mapcont' value='<?php if (isset($mappingcount)) { echo $mappingcount; } ?>'/>
<div style="float:right;margin:15px 20px;">
<input type='button' name='clearform' id='clearform' value='<?php echo __("Clear",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>' onclick="Reload();" class='btn btn-warning'/>
<input type='submit' name='importfile' id='importfile' value='<?php echo __("Next >>",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>' class='btn btn-primary'/>
</div>
</form>
<!-- Third screen, Ends Here -->
<?php } ?>
</td>
</tr>

<?php } 
//print('<pre>'); print_r($_POST);die;
// Save auto-mapping template for all event
?>
<tr>
<td>
<!-- Forth screen, Starts Here -->
<?php #print('<pre>'); print('POST VALUES: '); print_r($_POST); print('<br><br> SESSION VALUES: '); print_r($_SESSION); print('</pre>'); ?>
<!-- Summarize section before import -->
<?php if(isset($_POST['importfile'])) { ?>
<div id='summarize_before_import' style = "display:block;">
<?php
$classifyObj = new WPClassifyFields();
$available_groups_on_module = $classifyObj->get_availgroups($_POST['selectedImporter']);
$res1 = $res2 = $get_mapped_array = array();
foreach ($available_groups_on_module as $groupKey) {
	foreach ($_SESSION[$_POST['session_key']]['SMACK_MAPPING_SETTINGS_VALUES'] as $sessKey => $sessVal) {
		$current_mapped_group_key = explode($groupKey.'__mapping', $sessKey);
		if(is_array($current_mapped_group_key) && count($current_mapped_group_key) == 2) {
			$get_mapped_array[$groupKey][$current_mapped_group_key[1]] = $sessVal;
			if($sessVal == '-- Select --' ) {
				$res1[] = $sessVal;
			}
			else {
				$res2[] = $sessVal;
			}
                 }
		$current_wpfields_group_key = explode($groupKey.'__fieldname', $sessKey);
		if(is_array($current_wpfields_group_key) && count($current_wpfields_group_key) == 2) {
			$get_wpfields_array[$groupKey][$current_wpfields_group_key[1]] = $sessVal;
		}
	}
}
$summarize_view = array();
foreach($get_wpfields_array as $key => $val) {
	foreach($val as $k => $v) {
		$summarize_view[$key][$v] = $get_mapped_array[$key][$k];
	}
}
echo "<input type=hidden id = 'check_filetype' value = '".$_POST['uploaded_csv_name']."' name = 'check_filetype'>";
$mapped = count($res2);
$unmapped = count($res1);
$totRecords = $_POST['totRecords'];
echo "<div align='center'>
       <div style='margin-top:20px;'><span style='font-weight:bold;font-size:16px;'>".__('Import Module:',WP_CONST_ULTIMATE_CSV_IMP_SLUG)."</span><span class='moduledisplay'>".$_REQUEST['import_type']." </span>
       </div>
      </div>";


echo "<div style='padding-left: 10px;'>";
echo "<div style='margin-left:10px;'> <label>".__('Total no of records : ',WP_CONST_ULTIMATE_CSV_IMP_SLUG). $totRecords . ". </label></div>";
echo "<div style='margin-left:10px;'> <label>".__('Total no of mapped fields for single record : ',WP_CONST_ULTIMATE_CSV_IMP_SLUG). $mapped . ". </label></div>";
echo "<div style='margin-left:10px;'> <label>".__('Total no of unmapped fields for a record : ',WP_CONST_ULTIMATE_CSV_IMP_SLUG). $unmapped . ". </label></div>";
echo "</div>";
echo "<div id='summarylist' style='width:100%;height:auto'>";
echo "<div class='panel panel-default'>";
echo "<div class='panel-heading' data-target='#summary_paneldiv' data-parent='#accordion'>";
echo "<div id='summaryhead' class='panel-title'> <b> Summary</b> <span class = 'fa fa-minus-circle pull-right' id = 'summary_paneldiv_h_span'> </span> </div>";
echo "</div>";
echo "<div id='summary_paneldiv' style='height:auto;'>";
echo "<div class='summarizegroupcontent' id='summary_paneldiv_content'>";
$panel_count = count($summarize_view);
$set_row_count = ceil( $panel_count / 3 );
/*print('<pre>'); print_r($set_row_count); print('</pre>');
die('rowcount');*/
                  
$i=1;$j=1; 
echo "<div id='rowdiv1' class='rowdiv'>";
foreach($available_groups_on_module as $groupKey) {
	if(!empty($summarize_view[$groupKey])) {
		echo "<div id='summarypanel$i' class='summarypanel'>";
#		echo "<input type='hidden' name='importmode' id='importmode' value='{$importMode}' />";
		echo "<div class='paneltitle' > <b> {$groupKey}</b> </div>";
		echo "<div class='grouptitlecontent' id='divcontent{$i}' >";	
		echo "<table class='table table-striped' >";
		foreach($summarize_view[$groupKey] as $fkey => $mval) {			
			$fkeytitle = $fkey;
			$mvaltitle = $mval;
			if (strlen($fkey) > 13)
			    $fkey = substr($fkey, 0, 12) . '..';
			if (strlen($mval) > 13)
			    $mval = substr($mval, 0, 12) . '..';
			echo "<tr><td style='width:50%;' title='$fkeytitle'>" . $fkey . "</td><td style='width:50%;' title ='$mvaltitle'>" . $mval . "</td></tr>";
		}
		echo "</table>";
		echo "</div>"; // End of .grouptitlecontent
		echo "</div>"; // End of .panel-default
//		echo "</div>"; // End of #summarylist
		if(ceil($i % 3) == 0) {
                                        if($j <= $set_row_count && $i != $panel_count) {
						$k = $j + 1;
                                                echo "</div><div id='rowdiv$k' class='rowdiv'>";
                                        } else {
                                                echo "</div>";
                                        }
                                        $j++;
                                }
                                $i++;
	}
}
if($j == $set_row_count)
echo "</div>"; //End of #summary_paneldiv_content
echo "</div>"; //End of #summary_paneldiv
echo "</div>"; //End of .panel-default
echo "</div>";// End of #summarylist
?>
<input type='button' name='goto_importoption' id='goto_importoption' value ='<?php echo __('Proceed Import',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>' class= 'btn btn-success' style='float:right;margin:15px 10px;' onclick="proceedtoimport();"/>
</div>
</div>
<?php } ?>
<!-- Summarize section ends here -->
<!-- Forth screen, Ends Here-->
<?php
        if (isset($_REQUEST['step']) && $_REQUEST['step'] == 'importoptions') { 
	$sessionKey = isset($_POST['session_key']) ? $_POST['session_key'] : ''; #echo '<pre>'; print_r($_POST); echo '</pre>';
		
	if(isset($_REQUEST['eventKey'])) {
		$importMode = 'update';
	} else if(isset($_REQUEST['freshupdate'])) {
		$importMode = 'freshupdate';
	} else {
		$importMode = 'insert';
	}
?>
		<input type='hidden' name='importmode' id='importmode' value="<?php echo $importMode; ?>" />
		<input type='hidden' id ='session_key' value = "<?php echo $sessionKey; ?>" name = 'session_key' />

		<div id='sec-three' <?php if (isset($_REQUEST['step']) && $_REQUEST['step'] != 'importoptions') { ?> style='display:none;' <?php } ?> style='display:none;border-style:none;'>
		<input type="hidden" id="prevoptionindex" name="prevoptionindex" value="<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['prevoptionindex'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['prevoptionindex']; } ?>"/>
		<input type="hidden" id="prevoptionvalue" name="prevoptionvalue" value="<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['prevoptionvalue']; } ?>"/>
		<input type='hidden' id='current_record' name='current_record' value='<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['current_record']; } ?>'/>
		<input type='hidden' id='tot_records' name='tot_records' value='<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['totRecords']; } ?>'/>
		<input type='hidden' id='selectedImporter' name='selectedImporter' value='<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['selectedImporter']; } ?>'/>
		<input type='hidden' id='checktotal' name='checktotal' value='<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['totRecords']; } ?>'/>
		<input type='hidden' id='tot_num' name='tot_num' value='<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['totRecords']; } ?>'/>
		<input type='hidden' id='imp_count' name='imp_count' value=1>
		<input type='hidden' id='tmpLoc' name='tmpLoc' value='<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>'/>
		<input type='hidden' id='checkfile' name='checkfile' value='<?php if (isset($_POST['uploadedFile'])) { 	echo $_POST['uploadedFile']; } ?>'/>
		<input type='hidden' id='uploaded_versioned_name' name='uploaded_versioned_name' value='<?php if (isset($_POST['versionedfilename'])) { echo $_POST['versionedfilename']; } ?>' />
<!--		<input type='hidden' id='current_import_type' name='current_import_type' value='<?php echo $_REQUEST['import_type']; ?>' /> -->
		<input type='hidden' id='csv_name' name='csv_name' value="<?php if(isset($_POST['uploaded_csv_name'])) { echo $_POST['uploaded_csv_name']; } ?>" />
		<input type='hidden' id='select_delim' name='select_delim' value='<?php if (isset($_POST['select_delimeter'])) { echo $_POST['select_delimeter']; } ?>'/>
		<input type='hidden' id='uploadedFile' name='uploadedFile' value='<?php if (isset($_POST['uploadedFile'])) { echo $_POST['uploadedFile']; } ?>'/>
		<input type='hidden' id='stepstatus' name='stepstatus' value='<?php if (isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['stepstatus'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['stepstatus']; } ?>'/>
		<input type='hidden' id='inline_image_location' name='location_inlineimages' value='<?php echo $_POST['inline_image_location']; ?>' />

		<input type='hidden' id='mappingArr' name='mappingArr' value=''/>
		<!-- Import settings options -->
		<div class="postbox" id="options" style=" margin-bottom:0px;border-style:none;">
		<div class="inside">
		<div class="importi-schedule-option">
		<label id='importalign'><input type ='radio' id='importNow' name='importMode' value='' onclick='choose_import_mode(this.id);' checked/> <?php echo __("Import right away",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label> 
		<label id='importalign'><input type ='radio' id='scheduleNow' name='importMode' value='' onclick='choose_import_mode(this.id);'/> <?php echo __("Schedule now",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label> 
		</div>
		<div id='schedule' style='display:none'>
                 <?php 
                            if(empty($_REQUEST['templateId'])) {
                                     $tempId = $impCE->getTemplateId(); 
                             } 
                            else {
                                     $tempId = $_REQUEST['templateId']; 
                             } ?>
		<input type ='hidden' id='select_templatename' name='#select_templatename' value = '<?php echo $tempId; ?>'>
       

		<?php echo WPImporter_includes_schedulehelper::generatescheduleHTML(); ?>
		</div>
                		<!-- Schedule options ends here -->
 
		<!-- Import options starts here -->
		<div id='importrightaway' style='display:block'>

		<form method="POST">
		<ul id="settings">
		<li>
		<div id="importoptions" style="display:none">
		<input type="hidden" id="filedir" name="filedir" value = <?php if(isset($_POST['file_dir'])) { echo $_POST['file_dir']; } ?>/>
		<input type='hidden' id='import_by_method' name='import_by_method' value='<?php if(isset($_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['import_method'])) { echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['import_method']; } ?>' />
		
		<?php 
			if($_REQUEST['selectedImporter'] == 'post' || $_REQUEST['selectedImporter'] == 'page' || $_REQUEST['selectedImporter'] == 'custompost' || $_REQUEST['selectedImporter'] == 'eshop' || $_REQUEST['selectedImporter'] == 'marketpress' || $_REQUEST['selectedImporter'] == 'woocommerce_products' || $_REQUEST['selectedImporter'] == 'wpcommerce'){

?>
		<label id='importalign'><input name='duplicatecontent' id='duplicatecontent' type="checkbox" value="">
		<?php echo __("Detect duplicate post content",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label><br>
		<label id='importalign'><input name='duplicatetitle' id='duplicatetitle' type="checkbox" value=""> <?php echo __("Detect duplicate post title",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label><br>
	<?php } ?>
		<!--                                                         <label id='importalign'> <input type ='checkbox' id='multiimage' name='multiimage' value = ''> Insert Multi Images </label> <br>-->
		<?php if($_REQUEST['import_type'] == 'woocommerce_variations'){
                      if(!isset($_REQUEST['freshupdate']) && !isset( $_REQUEST['eventKey'] ) ) {?>
                        <div class="import-using">
                        <label id='importalign'><input type ='radio' id='importUsingPostId' name='importProductAttribute' value='importUsingProductId' checked/> <?php echo __("Import using product-id",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
                        <label id='importalign'><input type ='radio' id='importUsingSku' name='importProductAttribute' value='importUsingSku' /> <?php echo __("Import using parent-sku",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
                        </div>
                <?php } if(isset($_REQUEST['freshupdate']) || isset( $_REQUEST['eventKey'] ) ) { ?>
                        <div class="import-using">
                        <label id='importalign'><input type ='radio' id='updateVariationId' name='updateVariationAttribute' value='updateVariationId' checked/> <?php echo __("Update using variation-id",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
                        <label id='importalign'><input type ='radio' id='updateVariationSku' name='updateVariationAttribute' value='updateVariationSku' /> <?php echo __("Update using variation-sku",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
                        </div>
                <?php }}?>
		<label id='importalign' style="margin-left:10px;"><?php echo __("No. of posts/rows per server request",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> <span class="mandatory">*</span> 
		<input name="importlimit" id="importlimit" type="text" value="1" placeholder="10" onblur="check_allnumeric(this.value);"></label> <?php $help = 'Default value is 1. You can give any value based on your environment configuration.'; echo $impCE->helpnotes($help); ?> <br>

		<label id='importalign'><input type="checkbox" name="importspecific" id="importspecific" value="importspecific"> <?php echo __("Import Specific Records Only",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
		<br>
		<div id = "import_specific_records_div">

		<label id='importalign' style="margin-left:10px;"><?php echo __("Specify the records here",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> <span class="mandatory">*</span> 
		<input type = "text" name="import_specific_records" id="import_specific_records" placeholder="1-10,12-15" onblur="enableDisableImportButton();" />
		</label><br></div>
		<input type='hidden' id='dum' value='dum' name='dum'/>
		<span class='msg' id='server_request_warning' style="display:none;color:red;margin-left:-10px;"><?php echo __("You can set upto", WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> <?php echo $_SESSION[$sessionKey]['SMACK_MAPPING_SETTINGS_VALUES']['totRecords']; ?> <?php echo __("per request",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>.</span>
		<input type="hidden" id="currentlimit" name="currentlimit" value="0"/>
		<input type="hidden" id="specificrecordimportcount" name="specificrecordimportcount" value="0" />
		<input type="hidden" id="tmpcount" name="tmpcount" value="0"/>
		<input type="hidden" id="terminateaction" name="terminateaction" value="continue"/>
		<?php
		$curr_module = $_REQUEST['import_type'];
		if($curr_module == 'post' || $curr_module == 'page' || $curr_module == 'custompost' || $curr_module == 'eshop' || $curr_module == 'wpcommerce' || $curr_module == 'woocommerce_products' || $curr_module == 'marketpress'){ ?>
                <h4 id="innertitle" style="margin-left:15px"><?php echo __('Inline image options',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></h4>
  		<form action =  name ='inline-file' method='post' enctype="multipart/form-data" >
		<div>
		<span class='advancemediahandling'> <label id='importalign'> <input type='checkbox' name='advance_media_handling' id='advance_media_handling' onclick = 'filezipopen();'/> <?php echo __('Advance Media Handling',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label><?php $helpnotes = __('Handle media files in post content body, inline within a csv for each row',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo $impCE->helpnotes($helpnotes); ?> </span>
		<span id = 'filezipup' style ='display:none;'>
		<span class='advancemediahandling' style='padding-left:30px; margin-top:-5px;'>
<!--		<span class="btn btn-success fileinput-button"><span>Browse</span><input type='file' name='inlineimages' id='inlineimages' onchange ='checkextension(this.value);' style="margin-top:7px"/> </span>-->
		<table><tr>
		<td><span class="btn btn-success fileinput-button"><span><?php echo __('Browse',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></span><input type='file' name='inlineimages' id='inlineimages' onchange ='checkextension(this.value);' style="margin-top:7px"/></span></td>
		<input type='hidden' id="uploadFile" value="Choose File" disabled="disabled" />
		<td><div style='display:none;' id='filnam'></div></td>
		<script>
			document.getElementById("inlineimages").onchange = function () {
				document.getElementById("filnam").style.display = "";
				document.getElementById("uploadFile").value = this.value;
    				document.getElementById("filnam").innerHTML = document.getElementById("uploadFile").value;
			};
		</script>
		<input type='hidden' id="pluginurl" value="<?php echo WP_CONTENT_URL; ?>" />
<!--		<input type ='button' class='btn btn-primary' name = 'upload_inline' id = 'upload_inline' value = 'upload'>
		<img id="ajaximage" style="display:none" src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>images/ajax-loader.gif"> -->
		<td><input type ='button' class='btn btn-primary' name = 'upload_inline' id = 'upload_inline'  onclick = 'process_inline();' value = '<?php echo __('upload',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>'</td>
		<td><img id="ajaximage" style="display:none" src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>images/ajax-loader.gif"></td>
		</tr></table>
		</span>
		</div></br></br>
		</form>
                <script>
		$('#upload_inline').on('click', function() {
			var file_data = $('#inlineimages').prop('files')[0];
			var form_data = new FormData();
			var eventKey = document.getElementById('csvimporter_eventkey').value;
			document.getElementById('ajaximage').style.display = '';
			var  url = (document.getElementById('pluginurl').value + '/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/lib/imagesinline/upload.php')
			form_data.append('file', file_data)
			form_data.append('eventKey', eventKey)
			form_data.append('action','inlineimage_upload')
			//alert(form_data);
			jQuery.ajax({
				//url: url, // point to server-side PHP script
				url: ajaxurl,
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function(php_script_response){ 
					document.getElementById('ajaximage').style.display = 'none';
	//                          alert(php_script_response); // display response from the PHP script, if any
				}
			});
		});
		</script>
		<h4 id="innertitle" style="margin-left:15px"><?php echo __('Featured image options',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></h4>
		<label id='importalign'><input name='renameattachment' id='renameattachment' type="checkbox" value="">
                <?php echo __("Rename attachment",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label> <?php $helpnotes = __('External url attachment file rename with your post title',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo $impCE->helpnotes($helpnotes); ?>
		<?php } ?>
		</li>
		</ul>
		<input id="nextbutton" class="btn btn-success" type="button" value="<?php echo __("Next",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>" style="color: #ffffff;margin-bottom:16px;margin-right:60px;float:right" onclick="proceedtolog(<?php echo $totRecords; ?>);" />
		</div>
                </div>
		</div> <!-- #importoptions-->
                <div class="clear"></div>
		<div id="importcontrol" style="display:none">
			<div id="buttondiv" style="text-align:center;background-color:#F1F1F1;">
				<input id="backbutton" class="btn btn-warning" type="button" value="<?php echo __("Back",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>" style="color: #ffffff;" onclick="backtoimportscreen();"/>
		       <!--		<input id="dryrunbutton" class="btn btn-primary" type="button" value="<?php echo __("Dry Run Now",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>" style="color: #ffffff;background:#2E9AFE;" onclick="importRecordsbySettings('siteurl', 'dryrun');" /> -->
				<input id="startbutton" class="btn btn-primary" type="button" value="<?php echo __("Import Now",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>" style="color: #ffffff;background:#2E9AFE;" onclick="importRecordsbySettings('siteurl', 'normal');" disabled/>
				<input id="terminatenow" class="btn btn-danger btn-sm" type="button" value="<?php echo __("Terminate Now",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" style="display:none" onclick="terminateProcess();"/>
				<input class="btn btn-warning" type="button" value="Reload" id="importagain" style="display:none" onclick="import_again();"/>
				<input id="continuebutton" class="btn btn-lg btn-success" type="button" value="<?php echo __("Continue Import",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" style="display:none;" onclick="continueprocess();"/>
				<div id="ajaxloader" style="display:none"><img src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>images/ajax-loader.gif"> <?php echo __("Processing",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>... </div>		
				<div id="dispinprogress"></div>
				<div>
				<span style='float:left;'>
				<span><?php echo __('Total no of records:',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> <b><?php echo $totRecords ?></b><label style='margin-left:20px;'>|</label></span> 
				<span style='position:relative;left:25px;'><?php echo __('Total no of Mapped: ',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?><b><?php echo $mapped ?></b><label style='margin-left:20px;'>|</label></span> 
				<span style='position:relative;left:50px;'><?php echo __('Total no of Unmapped:',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> <b><?php echo $unmapped ?></b></span> 
				</span>
				<span style='float:right;'>
				<span><span id='imprec' style='margin-left:10px;'></span>
				<span id='remrec' style='margin-left:10px;'></span></span>
				</span>
				<!--	<table width='99%'>
					<tr>
					<td width='33%'><label style='align:center;'>Total no of records: <b><?php //echo $totRecords ?></b></label></td>
					<td><span style='align:center;'>Total no of Mapped fields for single record: <b><?php //echo $mapped ?></b></span></td>
					<td><span style='align:center;'>Total no of Unmapped fields for single record: <b><?php //echo $unmapped ?></b></span></td>
					</tr>
					<tr><td width:'49%'>
					<span id='imprec' style='margin-left:10px;'></span></td>
					<td width:'49%'><span id='remrec' style='margin-left:10px;'></span></td></tr></table> -->
				</div>
			</div>
		</div>
		</form>
		</div>
		</div>
		</div>
		<?php } ?>        <!-- Code Ends Here-->
		</div>
		</td>
		</tr>
		</table>
		</div>
		<div class="clear"></div>
		<div style="width:100%;">
		<div id="accordion">
		<table class="table-importer">
		<tr>
		<td>
		<!--<h3><?php echo __("Summary",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>-->
		<div id='reportLog' class='postbox'  style='display:none;'>
		<input type='hidden' name = 'csv_version' id = 'csv_version' value = "<?php if(isset($_POST['uploaded_csv_name'])) { echo $_POST['uploaded_csv_name']; } ?>">
		<div id="logtabs" class="logcontainer" style="display:none;">
		<div id="log" class='log'>
		</div>
		</div>
		</div>
		</td>
		</tr>
		</table>
		</div>
		</div>
		<?php if(isset($_REQUEST['session_key'])){ 
			$sessionkey = $_REQUEST['session_key'];			
			$get_upload_url = wp_upload_dir();
			$uploadLogURL = $get_upload_url['baseurl'] . "/" . $impCE->exportDir;
				 //echo '<pre>'; print_r($sessionkey); echo '</pre>';
			$logfilename = $uploadLogURL . "/" . $sessionkey . ".log";
		}
		?>
		<span id="dwnld_log_link" style="display:none">
                   <?php if(isset($logfilename))  { ?>
		<a href="<?php echo $logfilename; ?>" download id="dwnldlog" style="margin-left:5px;font-size:15px;"> <?php echo __("CLICK HERE TO DOWNLOAD LOG",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></a>  
                   <?php } ?>
		</span>
		<!-- Promotion footer for other useful plugins -->
		<div class="promobox" id="pluginpromo" style="width:100%;">
		<div class="accordion-group">
		<div class="accordion-body in collapse">
		<div>
		<?php $impCE->common_footer(); ?>
		</div>
		</div>
		</div>
		</div>
		</div>
<script type = 'text/javascript'>
jQuery(document).ready(function()
{    
        /*jQuery('#Core_Fields').on('hidden.bs.collapse', function ()
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
	jQuery('#summary_paneldiv').on('hidden.bs.collapse', function ()
        {
                jQuery("#summary_paneldiv_h_span").addClass('fa-toggle-down').removeClass('fa-toggle-up');
        });
        jQuery('#summary_paneldiv').on('show.bs.collapse', function ()
        {
                jQuery("#summary_paneldiv_h_span").addClass('fa-toggle-up').removeClass('fa-toggle-down');
        });*/
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
	$("#rffield").hide();
        $('#rfhead').click(function(){
                $('#rffield').toggle();
                $("#rffield_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
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
	$('#summaryhead').click(function(){
                $('#summary_paneldiv').toggle();
                $("#summary_paneldiv_h_span", this).toggleClass("fa-plus-circle").toggleClass("fa-minus-circle");
        });
	
   /*	$("#acf_addcustom_panel").hide();
	$('#acfhead').toggle(function(){
		$("#acf_addcustom_panel").slideDown();
		$("#acf_addcustom_panel_h_span", this).addClass("fa-minus-circle").removeClass("fa-plus-circle");

   	},function(){
		$("#acf_addcustom_panel").slideUp();
		$("#acf_addcustom_panel_h_span", this).toggleClass("fa-plus-circle").removeClass("fa-minus-circle");
   	});*/

});
</script>
