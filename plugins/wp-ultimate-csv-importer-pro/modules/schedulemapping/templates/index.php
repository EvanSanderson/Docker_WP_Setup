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

<style> #ui-datepicker-div {
		display: none
	} </style>
<?php
if ($skinnyData['templatecount'] == 0) {
	$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span>'.__("No Templates Generated yet",WP_CONST_ULTIMATE_CSV_IMP_SLUG).' </span> </b>';
	$this->notificationclass = 'alert alert-info';
	$skinnyData['page'] = 0;
} else {
	if ($skinnyData['page'] > $skinnyData['lastpage']) {
		$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span>'.__("Enter page number correctly",WP_CONST_ULTIMATE_CSV_IMP_SLUG).' </span> </b>';
		$this->notificationclass = 'alert alert-warning';
	}
}
if (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 4) {
	?>
	<div id="deletesuccess"><p class="alert alert-success"><?php echo __('Scheduled successfully!',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></p></div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#deletesuccess').delay(5000).fadeOut();
		});
	</script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 5) {
	?>
	<div id="ShowMsg" class="alert alert-warning"><?php echo __('Error while scheduling.',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></div>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#ShowMsg').delay(5000).fadeOut();
		});
	</script>
<?php
}
$error = '';
# adding filter to page
$pagination = $skinnyData['filter'];
$pagination .= "<div class = 'form-group'>";
$pagination .= "<div class = 'col-sm-2' style = 'width:29%;margin-top:-5.8%;margin-left:70%;'> <ul class='pagination pagination-lg'>";
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
<div class="form-group"> <?php echo $error; ?> </div>
<?php echo $pagination; ?>
<table class="table table-bordered tablebg imgscd" id='log' style='width:98%; text-align:center;'>
	<tr>
		<th class="schedulehead"><?php echo __('#',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class="schedulehead"><?php echo __('Template Name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class="schedulehead"><?php echo __('File Name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class="schedulehead"><?php echo __('Scheduled Time',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class="schedulehead"><?php echo __('Created Time',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class="schedulehead"><?php echo __('Is Run',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class="schedulehead"><?php echo __('Action',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
	</tr>
	<?php
	foreach ($skinnyData['templatelist'] as $singletemplate) {
		$id = $singletemplate->id;
		$templatename = WPImporter_includes_schedulehelper::gettemplatename($singletemplate->templateid);
		#$csvname = WPImporter_includes_schedulehelper::getcsvname($singletemplate->importid);
		$csvname = $singletemplate->imported_as;
		$isrun = 'Not Yet Started';
		if ($singletemplate->isrun == 1) {
			$isrun = 'Completed';
		}

		?>
		<tr>
			<td class="schedulehead"> <?php echo $id; ?></td>
			<td> <?php echo $templatename; ?> </td>
			<td> <?php echo $csvname; ?></td>
			<td class="schedulehead"> <?php echo $singletemplate->scheduleddate . ' ' . $singletemplate->scheduledtimetorun . ':00'; ?></td>
			<td class="schedulehead"> <?php echo $singletemplate->createdtime; ?> </td>
			<td> <?php echo $isrun; ?> </td>
			<td style='width:150px;'>
                        <span class='col-sm-1' style='height:25px;margin-left:20px;'>
                                <button type='button' style='padding: 2px 7px;' name='editform'
										id='edit_<?php echo $id; ?>' class="btn btn-primary btn-sm" title="Edit"
										data-toggle="modal" data-target="#myModal"
										onclick="window.location.href = '<?php echo $skinnyData['targetpage']; ?>&__action=edit&id=<?php echo $id; ?>'">
									<span class="fa fa-edit"> </span>
								</button>
                        </span>
                        <span class='col-sm-1' style='height:25px;margin-left:5px;'>
                                <button type='button' style='padding: 2px 7px;' name='deleteform'
										id='delete_<?php echo $id; ?>' class="btn btn-danger btn-sm" title="Delete"
										onclick="return performdeleteaction('schedulemapping','<?php echo $id; ?>', this)"
										data-loading-text="<span class = 'fa fa-spinner fa-spin'></span>"><span
										class="fa fa-trash-o"> </span>
								</button>
                        </span>
			</td>
		</tr>
	<?php }
        $listcount = count($skinnyData['templatelist']) ;
	if($listcount == 0) { ?>
		<tr><td colspan='7'><p style = "color:red;font-size:14px;"><?php echo  __('No Results Found',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></p></td></tr>
	<?php } ?>
</table>
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
