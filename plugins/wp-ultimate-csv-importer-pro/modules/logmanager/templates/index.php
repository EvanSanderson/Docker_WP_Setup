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
global $wpdb;
$log_val = array();
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$parse_url = explode('&',$url);
$page_url = $parse_url[0];
$skinnyData['lastpage'] = isset($skinnyData['lastpage']) ? $skinnyData['lastpage'] : 0;
if (isset($skinnyData['event_shortcodes_count']) && $skinnyData['event_shortcodes_count'] == 0) {
	$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> ' . __("No Templates Generated yet",WP_CONST_ULTIMATE_CSV_IMP_SLUG). ' </span> </b>';
	$this->notificationclass = 'alert alert-info';
	$skinnyData['page'] = 0;
} else {
	if(isset($skinnyData['lastpage']) && isset($skinnyData['page'])){
		if ($skinnyData['page'] > $skinnyData['lastpage']) {
			$this->notification = '<b> <span> <span class = "fa fa-exclamation-triangle"> </span> ' . __("Enter page number correctly",WP_CONST_ULTIMATE_CSV_IMP_SLUG).' </span> </b>';
			$this->notificationclass = 'alert alert-warning';
		}
	}
}

if (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 4) {	?>
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

<div class="form-group"> <?php echo $error; ?> </div>
<div id="event-shortcodes" style="width:98%;">
<?php echo $pagination; ?>
<table class="table table-bordered tablebg imgscd" id='log'>
	<tr>
      		<th class='loghead'><?php echo __('#',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
		<th class='loghead'><?php echo __('Event Key',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
                <th class='loghead'><?php echo __('File Name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='loghead'><?php echo __('Module',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='loghead'><?php echo __('Inserted',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='loghead'><?php echo __('Updated',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='loghead'><?php echo __('Skipped',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
		<th class='loghead'><?php echo __('Download',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </th>
	</tr>  
	<?php
        $get_val = $wpdb->get_results("SELECT eventKey,versioned_csv_name,manager_id, COUNT(*) c FROM wp_ultimate_csv_importer_eventkey_manager where manager_id != 0 GROUP BY manager_id HAVING c > 0 ");
        foreach($get_val as $kk) {
                 $log_val[] = $wpdb->get_results("SELECT sum(inserted) as ins, sum(updated) as up, sum(skipped) as sk, imported_type  FROM smackcsv_status_log where sdm_id = {$kk->manager_id} ");
        }
        for($i=0; $i< count($log_val);$i++) {
	$row = $i + 1;   
	foreach($log_val[$i] as $key => $shortcode) { ?>                  
		<tr>
			<td class='loghead'> <?php echo $row; ?> </td>
			<td> <?php echo $get_val[$i]->eventKey; ?></td>
                        <td> <?php echo $get_val[$i]->versioned_csv_name; ?></td>
			<td> <?php echo $shortcode->imported_type; ?></td>
			<td> <?php echo $shortcode->ins; ?> </td>
			<td> <?php echo $shortcode->up; ?></td>
			<td> <?php echo $shortcode->sk; ?> </td>
			<td style='width:150px;'>
                               <form action="<?php echo admin_url('admin-ajax.php'); ?>" method = "post" >
                                <?php wp_nonce_field('logdownload','my-nonce'); ?>
                                <input name="action" value="logmanagerdownload" type="hidden">
                              <input type = "hidden" name = "eKey" value = "<?php echo $get_val[$i]->eventKey; ?>">
                            <input type='submit' style='padding: 2px 7px; width:112px;margin-left:10px;' title = "download" name='Download'  class="btn btn-success btn-sm"  onclick="logFileDownload(this.id, '<?php echo $get_val[$i]->eventKey; ?>','<?php echo $page_url; ?> ');"  value='<?php echo __('Download Now',WP_CONST_ULTIMATE_CSV_IMP_SLUG) ?>' >
                            </form>
                        </td>
		</tr>
	<?php } 
       	}
	$listcount = count($skinnyData['shortcodelist']);
	if($listcount == 0) { ?>
          <tr><td colspan='8'><p style = "color:red;font-size:14px;"><?php echo __('No Results Found',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p></td></tr>	
       <?php }  ?>
</table>
</div>

