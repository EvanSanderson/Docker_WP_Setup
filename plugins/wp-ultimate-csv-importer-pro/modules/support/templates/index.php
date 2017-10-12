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
if (isset($skinnyData['mail']) && $skinnyData['mail'] == 'sent') { ?>
       	<div id="deletesuccess"><p class="alert alert-success"><?php echo __("Mail Sent Successfully",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p></div>
<?php } else if (isset($skinnyData['fail']) && $skinnyData['mail'] == 'fail') { ?>
       	<div id="deletesuccess"><p class="alert alert-warning"><?php echo __("Failed to send mail. Try Again",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p></div>
<?php } ?>
       	<script type="text/javascript">
               	$(document).ready(function () {
                       	$('#ShowMsg').delay(5000).fadeOut();
                       	$('#ShowMsg').css("display", "none");
                       	$('#deletesuccess').delay(5000).fadeOut();
               	});
       	</script>

<div style="width:99%;">
	<div class="contactus" id="contactus">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
					<?php echo __('Contact Us',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </a>
			</div>
			<div class="accordion-body in collapse">
				<div class="accordion-inner">
					<form
						action='<?php echo admin_url() . 'admin.php?page=' . WP_CONST_ULTIMATE_CSV_IMP_SLUG . '/index.php&__module=' . $_REQUEST['__module'] . '&step=sendmail2smackers' ?>'
						id='send_mail' method='post' name='send_mail' onsubmit="return sendemail2smackers();">
						<div style='float:right;'><a class='label label-info'
													 href='http://forge.smackcoders.com/projects/customer-support/issues'
													 target="_blank"><?php echo __('Issue Tracker',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></a></div>
						<br><br>
						<table class="table table-condensed">
							<tr>
								<td><?php echo __('First name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> <span class="mandatory">*</span></td>
								<td><input type="text" id="firstname" placeholder="<?php echo __('First name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>" name="firstname"/></td>
								<td><?php echo __('Last name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> <span class="mandatory">*</span></td>
								<td><input type="text" id="lastname" placeholder="<?php echo __('Last name',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?>" name="lastname"/>
									<input type="hidden" id="smackmailid" name="smackmailid"
										   value="helpdesk@smackcoders.com"/>
								</td>
							</tr>
							<tr>
								<td><?php echo __('Related To',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td>
								<td colspan=3>
									<select name="subject">
										<option><?php echo __('Support',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
										<option><?php echo __('Feature Request',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
										<option><?php echo __('Customization',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></option>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php echo __('Message',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> <span class="mandatory">*</span></td>
								<td colspan=3>
									<textarea class="form-control" rows="3" name="message" id="message"></textarea>
								</td>
							</tr>
						</table>
						<div style="float:right;padding:10px;"><input class="btn btn-primary" type="submit"
																	  name="send_mail"/></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div style="float:right;" id="promobox">
		<div class="promobox">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
						<?php echo __('Share Your Love',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </a>
				</div>
				<div class="accordion-body in collapse">
					<div class="accordion-inner">
						<table class="table table-condensed">
							<tr>
								<td><?php echo __('Rate Our Plugin',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td>
								<td>
									<a href="http://www.smackcoders.com/store/wp-ultimate-csv-importer-pro.html">
										<ul class="stars">
											<li>1</li>
											<li>2</li>
											<li>3</li>
											<li>4</li>
											<li>5</li>
									</a>
									</ul>
								</td>
							</tr>
							<tr>
								<td><?php echo __('Social Share',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></td>
								<td>
									<?php $impCE->importer_social_profile_share(); ?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="promobox" id="pluginpromo" style="width:99%;">
		<div class="accordion-group">
			<div class="accordion-body in collapse">
				<div>
					<?php $impCE->common_footer_for_other_plugin_promotions(); ?>
				</div>
			</div>
		</div>
	</div>
