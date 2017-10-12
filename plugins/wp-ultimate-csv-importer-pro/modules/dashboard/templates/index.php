<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
      exit; // Exit if accessed directly
global $wpdb;
$dashObj = new DashboardActions();
$ret_arr = array();
$ret_arr = $dashObj->getStats();
if (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'filenotfound') {
	?>
	<script>
		showMapMessages('error', translateAlertString('The files does not exist'));
	</script>
<?php
} ?>
<div class="box-one">
	<div class="top-right-box">
		<h3><span class="" style="margin: -5px 5px 5px 5px;"><img src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR;?>images/chart_bar.png" /></span><?php echo __("Importers Activity",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>

		<div class="top-right-content">
			<div id='dispLabel'></div>
			<div class='lineStats' id='lineStats'
				 style='height: 250px;width:100%;margin-top:15px; margin-bottom:15px;'></div>
		</div>
	</div>
	<div class="top-right-box">
		<h3><span class="" style="margin: -5px 5px 5px 5px;">
<img src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR;?>images/stat_icon.png"></span><?php echo __("Import Statistics",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
		<div class="top-left-content">
			<div id='dispLabel'></div>
			<?php $dashObj->drilldown(); ?>
			<div class='drillStats' id='drillStats'
				 style='float:left;height:400px;width:100%;margin-top:15px;margin-bottom:15px;'></div>
		</div>
	</div>
</div>

<?php if (isset($_REQUEST['errormsg'])) {
	?>
	<script type="text/javascript">
		showMapMessages('error', "<?php echo $_REQUEST['errormsg']; ?>");
	</script>
<?php
}
