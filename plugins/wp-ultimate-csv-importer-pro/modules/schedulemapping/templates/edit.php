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
$msg = isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
if ($msg == 5) {
	$this->notification = '<b> <span> Recorded Updated Successfully</span> </b>';
	$this->notificationclass = 'alert alert-success';
} else {
	if ($msg == 4) {
		$this->notification = '<b> <span> Error while updating record </span> </b>';
		$this->notificationclass = 'alert alert-warning';
	}
}
$helper = new WPImporter_includes_helper();
$data = $skinnyData['data'];
# generating time dropdown
$select_time = "<select name = 'timetoschedule' id = 'timetoschedule'>";
for ($hours = 0; $hours < 24; $hours++) {
	for ($mins = 0; $mins < 60; $mins += 30) {
		$selected = '';
		$datetime = str_pad($hours, 2, '0', STR_PAD_LEFT) . ':' . str_pad($mins, 2, '0', STR_PAD_LEFT);
		if ($datetime == $data->scheduledtimetorun) {
			$selected = 'selected';
		}

		$select_time .= "<option $selected value = '$datetime'> $datetime </option>";
	}
}
$select_time .= "</select>";
$showscheduling = "<form name = 'updatesmartschedule' class = 'form-horizontal' style = 'margin-top:10px;' role = 'form' id = 'updatesmartschedule' action = 'admin.php?page=" . WP_CONST_ULTIMATE_CSV_IMP_SLUG . "/index.php&__module=schedulemapping&__action=updatescheduler' method = 'POST'>";
$showscheduling .= "<input type = 'hidden' name = 'id' id = 'id' value = '{$data->id}'>";
$showscheduling .= "<input type = 'hidden' name='selectedImporter' id = 'selectedImporter' value = 'post'/>";

$showscheduling .= "<div class = 'col-sm-5 form-group'> 
			<label class = 'col-sm-4'> Scheduled time </label>
			<span class = 'col-sm-4'> $select_time </span> 
		</div> 
		<div class = 'col-sm-5 form-group'>
			<label class = 'col-sm-4'> Scheduled Date </label>
			<span class = 'col-sm-4'> 
				<input type = 'text' class = 'form-control' name = 'datetoschedule' readonly style = 'cursor:default' id = 'datetoschedule' value = '{$data->scheduleddate}' > 
			</span>
		</div>";
$showscheduling .= "<div class = 'col-sm-2'> <button type = 'submit' class = 'btn btn-primary' name = 'update' id = 'update' onclick = 'return checktemplatename_edit(this.form)'> Update </button> </div>";

$showscheduling .= "</form>";
$showscheduling .= "<script type = 'text/javascript'> jQuery(document).ready(function() {
                            jQuery('#datetoschedule').datepicker({
                                dateFormat : 'yy-mm-dd'
                            });
                        });
                        </script>";
echo $showscheduling;
