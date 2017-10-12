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
$dashObj = new FilemanagerActions();
$provider_dd = '';
$error = '';
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$parse_url = explode('&',$url);
$page_url = $parse_url[0];
# adding filter to page
$pagination = $skinnyData['filter'];
$pagination .= "<div style='float:right;margin-right:-60px;'><ul class='pagination pagination-lg'>";
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

$pagination .= "</ul></div> ";
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

if (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'filenotfound') {
	?>
	<script>
		showMapMessages('error', translateAlertString('The files does not exist'));
	</script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'nothingselected') {
	?>
	<script>
		showMapMessages('error', translateAlertString('Please select any records'));
	</script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'deletedallrecords') {
	?>
	<script>
		showMapMessages("success", translateAlertString("Deleted all captured records to the selected manager id's"));
	</script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'records_trashed') {
	?>
	<script>
		showMapMessages("error", translateAlertString("Records has been trashed for all selected manager id's"));
	</script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'records_already_trashed') {
	?>
	<script>
		showMapMessages("error", translateAlertString("Dont select the already trashed records"));
	</script>
<?php
} elseif (isset($_REQUEST['msg']) && $_REQUEST['msg'] == 'records_restored') {
	?>
	<script>
		showMapMessages("success", translateAlertString("Records has been restored for all selected manager id's"));
	</script>
<?php
} ?>
<div class='manager-filter' style='width:98%;'>
	<div> <?php echo $error; ?> </div>
	<div class="pagination"><?php echo $pagination; ?></div>
</div>

<div class="demo" style="margin-left:20px;">	
        <a id="demoimg" title="Download the file"><span class="manageraction glyphicon glyphicon-floppy-save"></span><?php echo __('Download',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
	<a id="demoimg" title="Download all files"><span class="manageraction glyphicon glyphicon-compressed"></span><?php echo __('Download
		all',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
	<a id="demoimg" title="Delete the file"><span class="manageraction glyphicon glyphicon-floppy-remove"></span><?php echo __('Delete
		file',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
	<a id="demoimg" title="Delete all the files and records"><span
			class="manageraction glyphicon glyphicon-remove-sign"></span><?php echo __('Delete files and records',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
	<a id="demoimg" title="Trash"><span class="manageraction glyphicon glyphicon-trash"></span><?php echo __('Trash',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
	<a id="demoimg" title="Restore"><span class="manageraction glyphicon glyphicon-repeat"></span><?php echo __('Restore',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
	<a id="demoimg" title="Delete all records"><span class="manageraction glyphicon glyphicon-remove"></span><?php echo __('Delete all',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
	<a id="demoimg" title="Update records"><span class="manageraction glyphicon glyphicon-retweet"></span><?php echo __('Update',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></a>
</div>
<div class="box-two" style="margin-top:20px;">
	<div class="fileManager">
		<h3><span class="header-icon glyphicon glyphicon-pushpin"></span><?php echo __('File Manager',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></h3>

		<div class="manager-content">
			<div class="global-actions" align="center">
				<form name="global_Action" id="global_Action" method="post"
					  action="<?php echo get_admin_url(); ?>admin.php?page=wp-ultimate-csv-importer-pro/index.php&__module=filemanager&__action=Manageglobalactions">
					<input type='button' id='dwnldallaszip' name='dwnldallaszip' class="btn btn-primary btn-sm"
						   value='<?php echo __('Download All',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>' onclick='downloadallfiles();'/>
					<input type='button' id='trashallrecords' name='trashallrecords' class="btn btn-warning"
						   value='<?php echo __('Trash All Records',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>' onclick='gtrash_restore_records(this.id);'/>
					<input type='button' id='restoretrashedrecords' name='restoretrashedrecords' class="btn btn-success"
						   value='<?php echo __('Restore Trashed Records',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>' onclick='gtrash_restore_records(this.id);'/>
					<input type='button' id='deleteallrecords' name='deleteallrecords' class="btn btn-danger btn-sm"
						   value='<?php echo __('Delete All Records',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>' onclick='delete_allfiles_and_records(this.id);'/>
					 <input type='button' id='deleteallfilesandrecords' name='deleteallfilesandrecords'
                                                   class="btn btn-danger btn-sm" value='<?php echo __('Delete Files and Records',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>'
                                                   onclick='delete_allfiles_and_records(this.id);'/>

					<!--<input type='button' id='deleteselectedfiles' name='deleteselectedfiles' class="btn btn-danger btn-sm" value='Delete Selected Files' />-->
					<input type='hidden' id='choosen_manager_records' name='choosen_manager_records' value=''/>
					<input type='hidden' id='gbuttonaction' name='gbuttonaction' value=''/>
				</form>
			</div>
			<table id="sample-table-1" class="table table-hover tablebg filmg">
				<thead>
				<tr>
					<th class="selectAll" style="width:20px;"><input type="checkbox" id="selectAllId" name="selectAllId"
												 onclick='AllManagerRecords(this.id);'/></th>
					<th class="importedfilename fmheadstyle"><?php echo __('File Name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
					<th class="importedtype fmheadstyle" style="width:130px;"><?php echo __('Type',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
					<th class="importedtime fmheadstyle"><?php echo __('Imported On',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
					<th class="updatedtime fmheadstyle"><?php echo __('Updated On',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
					<th class="file-version fmheadstyle"><?php echo __('Version',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></th>
					<th class="manager-actions fmheadstyle" style="width:224px;padding:12px;"><?php echo __('Action');?></th>
				</tr>
				</thead>
				<tbody>
				<!-- start -->
				<tr>
					<?php
					$inc = 0;
					$getDashboard = $skinnyData['filemanagerlist'];
					foreach ($getDashboard as $manager){
					$inc++;
					$status = 0;
					$ver = $manager->version;
					$action = $manager->created_records;

					$getVersion = unserialize($ver);

					$getStatus = unserialize($action);
					$importedAs = $manager->imported_as;
					if ($importedAs == 'post' && isset($getStatus['post'])) {
						$status = count($getStatus['post']);
					}
					if ($importedAs == 'Users' && isset($getStatus['Users/Roles'])) {
						$status = count($getStatus['user']);
					}
					if ($importedAs == 'wpsc-product' && isset($getStatus['wpsc-product'])) {
						$status = count($getStatus['wpcommerce']);
					}
					if ($importedAs == 'eShop-products' && isset($getStatus['eShop-products'])) {
						$status = count($getStatus['post']);
					}
					$post_types = get_post_types();
					foreach ($post_types as $key => $value) {
						if (($value != 'attachment') && ($value != 'revision') && ($value != 'page') && ($value != 'post') && ($value != 'wpsc-product-file') && ($value != 'wpsc-product') && ($value != 'nav_menu_item')) {
							if ($importedAs == $value) {
								$status = count($getStatus[$value]);
							}
						}
					}
					if ($manager->modified_on == '0000-00-00 00:00:00') {
						$updated_on = 'No Updates';
					} else {
						$updated_on = $manager->modified_on;
					}
					?>

					<input type='hidden' name='totalcount' id='totalcount'
						   value="<?php print(count($getDashboard)); ?>"/>
				<tr class="t-border smackaltrow">
					<td class="t-small"><input type="checkbox" id="selectAllId<?php echo $inc; ?>"
											   name="selectAllId<?php echo $inc; ?>"
											   onclick="checkwhetherallchecked(this.id);"/></td>
					<td class="t-medium"><?php echo $manager->csv_name; ?></td>
					<td class="t-small" style="width:8%"><?php echo $manager->imported_as;
						echo '  ';
						echo($dashObj->getInlineGraphValues($manager->id)); ?></td>
					<td class="t-small"><?php echo $manager->imported_on; ?></td>
					<td class="t-small"><?php echo $updated_on; ?></td>

					<td class="t-small">
						<select name="version" id="version<?php echo $inc; ?>"
								onchange='return checkcsvfound("<?php echo $inc; ?>");'>
							<option value="select"><?php echo __('-- Select --',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
							<?php
							$ver = 0;
							if(isset($getVersion )){
							foreach ($getVersion as $key => $value) {
								$ver = $ver + 1;
								$version = $key;
								$download = $value;
								if ((trim($download) != 'deleted') && (trim($download) != '')) {
									?>
								<option value="<?php echo $download.'__'.$key; ?>"><?php print_r($key); ?></option>
                                                                <?php
								}
							}}
							?>
						</select>
					</td>
					<?php
					$get_upload_dir = wp_upload_dir();
					$upload_dir = $get_upload_dir['basedir'] . '/' . 'ultimate_importer';
					?>
					<input type='hidden' id='contenturl' name='contenturl' value='<?php echo WP_CONTENT_URL; ?>'/>
					<input type='hidden' id='uploaddir' name='uploaddir' value='<?php echo $upload_dir; ?>'/>
					<input type='hidden' name='details' id="details<?php echo $inc; ?>"/>
					<input type='hidden' id='csv_name<?php echo $inc; ?>' name='importas'
						   value='<?php echo $manager->csv_name; ?>'/>
					<td class="manager-actions" style="width:25%">
					<div style='text-align:center;'>
						<div style="float:left;">
							<form name="fileManager_Action<?php echo $inc; ?>"
								  id="fileManager_Action<?php echo $inc; ?>" method="post"
								  action="<?php echo get_admin_url(); ?>admin.php?page=wp-ultimate-csv-importer-pro/index.php&__module=dashboard&__action=Managefiles"
								  onsubmit="return check_exists();">
								<input type='hidden' id='contenturl' name='contenturl'
									   value='<?php echo WP_CONTENT_URL; ?>'/>
								<input type='hidden' name='managerid' id="managerid<?php echo $inc; ?>"
									   value='<?php echo $manager->id; ?>'/>
								<input type='hidden' name='importedas' id="importedas<?php echo $inc; ?>"
									   value='<?php echo $manager->imported_as; ?>'/>
								<input type='hidden' id='csv_name<?php echo $inc; ?>' name='csvname'
									   value='<?php echo $manager->csv_name; ?>'/>
								<?php if ($manager->trashed == 0) {
									$trashed = 'trash';
								} else {
									$trashed = 'restore';
								} ?>
								<input type='hidden' id='trash<?php echo $inc; ?>' name='trash'
									   value='<?php echo $trashed; ?>'/>
								<input type='hidden' id='selectedversion<?php echo $inc; ?>' name='selectedversion'
									   value='0'/>
								<input type='hidden' id="button_action<?php echo $inc; ?>" name='button_action'
									   value=''/>
								<a id="dwn<?php echo $inc; ?>" title="Download the file"><span
										name="downloadfile<?php echo $inc; ?>" id="downloadfile<?php echo $inc; ?>"
										class="manageraction glyphicon glyphicon-floppy-save" value="downloadfile"
										onclick='download_selected_file("<?php echo $inc; ?>");'></span></a>
							</form>
						</div>
						<div style="float:left;">
							<form name="fileManager_Action<?php echo $inc; ?>"
								  id="fileManager_Action<?php echo $inc; ?>" method="post"
								  action="<?php echo WP_PLUGIN_URL; ?>/wp-ultimate-csv-importer-pro/templates/download_zip.php?manager_id=<?php echo $manager->id; ?> "
								  onsubmit="return check_exists();">
								<a id="dwn_all" title="Download all files"
								   onclick='return downloadallfile("<?php echo $inc; ?>");'><span
										class="manageraction glyphicon glyphicon-compressed"></span></a>
							</form>
						</div>
						<div style="float:left;">
							<a id="delete" title="Delete the file" onclick='return deletefiles("<?php echo $inc; ?>");'><span
									class="manageraction glyphicon glyphicon-floppy-remove"></span></a>
							<a id="deletefilesrecords" title="Delete all the files and records"
							   onclick='return deletefilesandecords("<?php echo $inc; ?>");'><span
									class="manageraction glyphicon glyphicon-remove-sign"></span></a>

							<?php if ($manager->trashed == 0) {
								if ($importedAs == 'Category' || $importedAs == 'Tags' || $importedAs == 'Users' || $importedAs == 'customtaxonomy') {
									?>
									<span id="trashall<?php echo $inc; ?>" title="Not available"><span
											class="manageraction glyphicon glyphicon-trash"></span></span>
									<a id="delete_all" title="Delete all records"
									   onclick='return deleteall("<?php echo $inc; ?>");'><span
											class="manageraction glyphicon glyphicon-remove"></span></a>
								<?php
								} else {
									?>
									<a id="trashall<?php echo $inc; ?>" title="Trash all records"
									   onclick='return trashall("<?php echo $inc; ?>");'><span
											class="manageraction glyphicon glyphicon-trash"></span></a>
									<a id="delete_all" title="Delete all records"
									   onclick='return deleteall("<?php echo $inc; ?>");'><span
											class="manageraction glyphicon glyphicon-remove"></span></a>
								<?php
								}
							} elseif ($manager->trashed == 2) {
								?>
								<span id="trashall<?php echo $inc; ?>"><span
										class="manageraction glyphicon glyphicon-trash"></span></span>
								<span id="delete_all"><span
										class="manageraction glyphicon glyphicon-remove"></span></span>
							<?php } else { ?>
								<a id="trashall<?php echo $inc; ?>" title="Restore all records"
								   onclick='return trashall("<?php echo $inc; ?>");'><span
										class="manageraction glyphicon glyphicon-repeat"></span></a>
								<a id="delete_all" title="Delete all records"
								   onclick='return deleteall("<?php echo $inc; ?>");'><span
										class="manageraction glyphicon glyphicon-remove"></span></a>
							<?php } ?>
						</div>
						<div style="float:left;">
                                                        <form name="fileManager_Action<?php echo $inc; ?>"
                                                                  id="fileManager_Action<?php echo $inc; ?>" method="post"
                                                                  action=""
                                                                  onsubmit="">
                                                                <a id="Update" title="Update"
                                                                   onclick='Update("<?php echo $inc; ?>","<?php echo $page_url; ?>");' ><span
                                                                                class="manageraction glyphicon glyphicon-retweet"></span></a>
                                                        </form>
                                                </div>
					</div>
					</td>

				</tr>
				<?php } ?>
				<!-- End-->
                                <?php   if(count($getDashboard) == 0 ) { ?> 
					 <tr><td colspan='7'><p style = "color:red;font-size:14px;margin-left:400px;"><?php echo __('No File Imports Yet',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p></td></tr>
				<?php } ?>

			</table>
		</div>
	</div>
</div>
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
