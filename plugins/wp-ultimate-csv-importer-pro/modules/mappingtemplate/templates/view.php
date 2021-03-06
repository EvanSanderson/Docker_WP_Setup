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
	$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> No Templates Generated yet </span> </b>';
	$this->notificationclass = 'alert alert-info';
	$skinnyData['page'] = 0;
} else {
	if ($skinnyData['page'] > $skinnyData['lastpage']) {
		$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> Enter page number correctly </span> </b>';
		$this->notificationclass = 'alert alert-warning';
	}
}

$error = '';
# adding filter to page
$pagination = $skinnyData['filter'];
$pagination .= "<div class = 'form-group'>";
$pagination .= "<div class = 'col-sm-3'> <ul class='pagination pagination-lg'>";
# previous button
if ($skinnyData['page'] > 1) {
	$pagination .= "<li> <a href='{$skinnyData['targetpage']}&paged=1'> <span class = 'fa fa-angle-double-left'> </span> </a> </li> <li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['prev']}'> <span class = 'fa fa-angle-left'> </span> </a> </li>";
} else {
	$pagination .= "<li class = 'disabled'> <a> <span class = 'fa fa-angle-double-left'> </span> </a> </li> <li class = 'disabled'> <a> <span class = 'fa fa-angle-left'> </span> </a> </li>";
}

# page text box
$pagination .= '<li> <span class="paging-input"> <input class="current-page" type="text" value="' . $skinnyData['page'] . '" name="saiob_queue_page" id = "saiob_queue_page" title="Current page"> of <span class="total-pages"> ' . $skinnyData["lastpage"] . '</span> </span> </li>';

#next button
if ($skinnyData['page'] < $skinnyData['lastpage']) {
	$pagination .= "<li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['next']}'> <span class = 'fa fa-angle-right'> </span> </a> </li> <li> <a href='{$skinnyData['targetpage']}&paged={$skinnyData['lastpage']}'> <span class = 'fa fa-angle-double-right'> </span> </a> </li>";
} else {
	$pagination .= "<li class='disabled'> <a> <span class = 'fa fa-angle-right'> </span> </a> </li> <li class = 'disabled'> <a> <span class = 'fa fa-angle-double-right'> </span> </a> </li>";
}

$pagination .= "</ul> </div> </div> </div>";
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
<table class="table table-bordered" id='log'>
	<tr>
		<th> #</th>
		<th> Template Name</th>
		<th> Template Used</th>
		<th> Created Time</th>
		<th> Action</th>
	</tr>
	<?php
	foreach ($skinnyData['templatelist'] as $singletemplate) {
		$id = $singletemplate->id;
		?>
		<tr>
			<td> <?php echo $id; ?></td>
			<td> <?php echo $singletemplate->templatename; ?> </td>
			<td> <?php echo $singletemplate->templateused; ?></td>
			<td> <?php echo $singletemplate->createdtime; ?> </td>
			<td><span class='col-sm-1' style='height:25px;'> <button type='button' name='deleteform'
																	 id='delete_<?php echo $id; ?>'
																	 class="btn btn-danger btn-sm" title="Delete"
																	 onclick="return performdeleteaction('log','<?php echo $id; ?>', this)"
																	 data-loading-text="<span class = 'fa fa-spinner fa-spin'></span>">
						<span class="fa fa-trash-o"> </span></button> </span></td>
		</tr>
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
