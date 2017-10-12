<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
?>
<?php #print('<pre>'); print_r($skinnyData); print('</pre>'); ?>
<style> #ui-datepicker-div {
		display: none
	} </style>
<?php
if ($skinnyData['event_shortcodes_count'] == 0) {
	$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> ' . __("No Templates Generated yet",WP_CONST_ULTIMATE_CSV_IMP_SLUG).' </span> </b>';
	$this->notificationclass = 'alert alert-info';
	$skinnyData['page'] = 0;
} else {
	if ($skinnyData['page'] > $skinnyData['lastpage']) {
		$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> ' . __("Enter page number correctly",WP_CONST_ULTIMATE_CSV_IMP_SLUG).' </span> </b>';
		$this->notificationclass = 'alert alert-warning';
	}
}

if (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 4) {
	?>
	<div id="deletesuccess"><p class="alert alert-success"><?php echo __('Template has been saved successfully!',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p></div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#deletesuccess').delay(5000).fadeOut();
		});
	</script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 5) {
	?>
	<div id="ShowMsg" class="alert alert-warning"><?php echo __('Error while saving template.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#ShowMsg').delay(5000).fadeOut();
		});
	</script>
<?php
}
$error = '';
# adding filter to page
#$pagination = $skinnyData['filter'];
$pagination = '';
$pagination .= "<div class = 'form-group'>";
$pagination .= "<div class = 'col-sm-3' style = 'width:29% !important;margin-top:-4.6%;margin-left:57%;float:right;'> <ul class='pagination pagination-lg'>";
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

$pagination .= "</ul> </div> </div> ";
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
<!-- Code Added For POP UP  Starts here -->
<div class='modal fade' id = 'upload_inline' tabindex='-1' role='dialog' aria-labelledby='mymodallabel' aria-hidden='true'>
             <div class='modal-dialog'>
                  <div class='modal-content'>
                        <div class='modal-header'>
                           <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                   <h4 class='modal-title' id='mymodallabel'> <?php echo __('Upload your inline image',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h4>
        </div>
        <div class='modal-body' id = 'upload_file'>
        ...
        </div>
        <div class='modal-footer'>
         <!--<button type='button' class='btn btn-default' data-dismiss='modal'>close</button>  -->
         <button type='button' class='btn btn-primary' data-dismiss='modal'><?php echo __('Close',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></button>
                  </div>
              </div>
           </div>
</div>
 <!-- POP UP Ends Here -->
<div class='modal fade' id = 'upload_blur' tabindex='-1' role='dialog' aria-labelledby='mymodallabel' aria-hidden='true'>
             <div class='modal-dialog'>
                  <div class='modal-content' style="position:fixed;margin-top:40%;margin-left:40%;">
                        <div class='modal-header' style="text-align:center;">
              <!--             <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>-->
		                   <h4 class='modal-title' id='mymodallabel'> <?php echo __('Image is getting populated!!',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h4>
				<div id="ajaxloader" ><img src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>images/ajax-loader.gif"> <?php echo __("Processing",WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></div>
			</div>
		</div>
	</div>
</div>
<div class="form-group"> <?php echo $error; ?> </div>
<div id="event-shortcodes" style="width:98%;">
<?php echo $pagination;
$pid = $eventkey = ''; 
foreach($skinnyData['shortcodelist'] as $shortcodedetail){

//echo '<pre>'; print_r($shortcodedetail['id']); echo '</pre>';
$pid = $shortcodedetail['id'];
$eventkey = $shortcodedetail['event_key'];

}
?>
<table class="table table-bordered tablebg imgscd" id='log'>
	<tr>
		<th class='imgcodehead'> <?php echo __('#',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class='imgcodehead'> <?php echo __('Event Key',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
                <th class='imgcodehead'> <?php echo __('File Name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='imgcodehead'> <?php echo __('Mode of Shortcode',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='imgcodehead'> <?php echo __('Module',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='imgcodehead'> <?php echo __('No of Shortcodes',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='imgcodehead'> <?php echo __('Status',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='imgcodehead'> <?php echo __('Action',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
              <!--  <th class='imgcodehead'> Upload </th> -->
	</tr>
       <input type ='hidden' name ='pid' id ='pid' value ='<?php if(isset($pid)){ echo $pid; } ?>'>
       <input type ='hidden' name ='event' id ='event' value ='<?php if(isset($eventkey)){ echo $eventkey; } ?>'>
	<?php
	if(isset($skinnyData['shortcodelist'])) {
	foreach ($skinnyData['shortcodelist'] as $shortcode) {
#		$id = $shortcode->id;
		if($shortcode['mode_of_code'] == 'inline')
			$mode_of_code = 'Inline';
		?>
		<tr>
			<td class='imgcodehead'> <?php echo $shortcode['id']; ?></td>
			<td> <?php echo $shortcode['event_key']; ?> </td>
                        <td><?php echo $shortcode['csv']; ?></td>
			<td> <?php echo $shortcode['mode_of_code']; ?></td>
			<td> <?php echo $shortcode['module']; ?> </td>
			<td> <?php echo $shortcode['inline_shortcodes_count']; ?> </td>
			<td><span id="eventst<?php echo $shortcode['id']; ?>_<?php echo $shortcode['event_key']; ?>"> <?php echo $shortcode['populate_status']; ?> </span></td>
			<td style='width:300px;'>
			<span class='col-sm-1' style='height:25px;margin-left:30px;' id='statusmsg_<?php echo $shortcode['id']?>'>
			<?php if($shortcode['populate_status'] == 'Replaced') { ?>		
				<button type='button' style='padding: 2px 7px; width:75px;' name='populate' id='populate_<?php echo $shortcode['event_key']; ?>' class="btn btn-success" title="Populate all ShortCodes" data-toggle="modal" data-target="#myModal" > <?php echo __('Success');?> </button>
			<?php } else if($shortcode['populate_status'] == 'Partially') { ?>
                              <button type='button' style='padding: 2px 7px; width:75px;' name='populate' id='populate_<?php echo $shortcode['event_key']; ?>' class="btn btn-warning btn-sm" title="Populate all ShortCodes" data-toggle="modal" data-target="#myModal" onclick="populate_shortcodes(this.id, '<?php echo $shortcode['id']; ?>');" ><?php echo __('Continue',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </button>
                        <?php } else { ?>
				<button type='button' style='padding: 2px 7px; width:75px;' name='populate' id='populate_<?php echo $shortcode['event_key']; ?>' class="btn btn-danger btn-sm" title="Populate all ShortCodes" data-toggle="modal" data-target="#myModal" onclick="populate_shortcodes(this.id, '<?php echo $shortcode['id']; ?>');" ><?php echo __('Populate',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </button>
			<?php } ?>
			</span>
<!--			</td>
			<td style='width:150px;'> -->
			<span style='margin-left:25px;'>
                            <button type='button' style='padding: 2px 7px; width:75px;' name='Update' id='update_<?php echo $shortcode['event_key']; ?>' class="btn btn-success btn-sm" title="Update"  onclick="update_inlineimages(this.id, '<?php echo $shortcode['id']; ?>');" ><?php echo __('Update',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </button>
			</span>
                        </td>
		</tr>
	<?php }
	 } 
	$listcount = count($skinnyData['shortcodelist']); 
	if($listcount == 0) { ?>
                <tr><td colspan='8'><p style = "color:red;font-size:14px;"><?php echo __('No Results Found',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></p></td></tr>	
       <?php } ?>
</table>
</div>

