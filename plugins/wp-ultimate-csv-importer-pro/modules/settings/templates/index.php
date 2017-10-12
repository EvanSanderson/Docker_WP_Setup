<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

global $wp_version, $wpdb;
$impCE = new WPImporter_includes_helper();
$impUh = new WPUltimateCSVImporter();
/*$setvalue = get_option('wpcsvprosettings');
$seovalue = $setvalue['rseooption'];*/
$setvalue = get_option('wpcsvprosettings');
if(isset($setvalue['rseooption'])){
	$seovalue = $setvalue['rseooption'];
}
if (isset($skinnyData['savesettings']) && $skinnyData['savesettings'] == 'done') { ?>
	<div id="ShowMsg" class="alert alert-warning" style="display:none"></div>
	<div id="deletesuccess"><p class="alert alert-success"><?php echo __("Settings Saved",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p></div>
	<?php
	$skinnyData['savesettings'] == 'notdone';
	?>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#ShowMsg').delay(5000).fadeOut();
			$('#ShowMsg').css("display", "none");
			$('#deletesuccess').delay(5000).fadeOut();
		});
	</script>
<?php
} ?>
<div style ='text-align:center;margin:0;color:red;font-size:smaller;' id='securitymsg'> <?php echo __('Go to Security and Performance tab for your environment configuration details',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?> </div></br>

<input type='hidden' id='tmpLoc' name='tmpLoc' value='<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>'/>
<div class="uiplus-settings">
<form class="add:the-list: validate" name="importerSettings" method="post" enctype="multipart/form-data">
<div id="settingheader">
        <span class="corner-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/lSettingsCorner.png" width="24" height="24" /> </span>
        <span><label id="activemenu"><?php echo __('General Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG)?></label></span>
<!--        <button class="action btnn btn-primary" onclick="saveSettings();" style="float:right;position:relative; margin: 7px 15px 5px;" value="Save" name="savesettings" type="submit">Save Changes </button>-->
</div>
<div id="settingsholder">
        <div id="sidebar">
        <ul>
                <li id="1" class="bg-sidebar selected" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/settings.png" width="24" height="24" /> </span>
                        <span id="settingmenu1" ><?php echo __('General Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow1" class="list-arrow"></span>
                </li>
                <li id="2" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/lcustomposts.png" width="24" height="24" /> </span>
                        <span id="settingmenu2" ><?php echo __('Custom Posts & Taxonomy',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow2" class="list-arrow" style="display:none;" ></span>
                </li>
                <li id="3" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/lcustomfields.png" width="24" height="24" /> </span>
                        <span id="settingmenu3" ><?php echo __('Custom Fields',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow3" class="list-arrow" style="display:none;" ></span>
                </li>
                <li id="4" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/lcart.png" width="24" height="24" /> </span>
                        <span id="settingmenu4" ><?php echo __('Ecommerce Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow4" class="list-arrow" style="display:none;" ></span>
                </li>
                <li id="5" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/seo24.png" width="24" height="24" /> </span>
                        <span id="settingmenu5" ><?php echo __('SEO Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
			<span id="arrow5" class="list-arrow" style="display:none;" ></span>
                </li>
                <li id="6" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/additionalfeatures.png" width="24" height="24" /> </span>
                        <span id="settingmenu6" ><?php echo __('Additional Features',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow6" class="list-arrow" style="display:none;" ></span>
                </li>
                <li id="7" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/DBOptimize.png" width="24" height="24" /> </span>
                        <span id="settingmenu7" ><?php echo __('Database Optimization',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow7" class="list-arrow" style="display:none;" ></span>
                </li>
                <li id="8" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/security.png" width="24" height="24" /> </span>
                        <span id="settingmenu8" ><?php echo __('Security and Performance',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow8" class="list-arrow" style="display:none;" ></span>
                </li>
                <li id="9" class="bg-sidebar" onclick="showsettingsoption(this.id);">
                        <span class="settings-icon"> <img src="<?php echo WP_CONTENT_URL;?>/plugins/<?php echo WP_CONST_ULTIMATE_CSV_IMP_SLUG;?>/images/ldocs24.png" width="24" height="24" /> </span>
                        <span id="settingmenu9" ><?php echo __('Documentation',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span>
                        <span id="arrow9" class="list-arrow" style="display:none;" ></span>
                </li>
	 </ul>
        </div>
	<div id="contentbar">
<!-- div-1-->
                <div id="section1" class="generalsettings">
                        <div class="title">
                                        <h3><?php echo __('Enabled Modules',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <span style="float:right;margin-right:92px;margin-top:-34px;">
                                                <a title = "<?php echo __('Check All',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> " id="checkallModules" onclick="checkallOption(this.id);" name="checkallModules" value="Check All" href="#"><?php echo $impUh->reduceStringLength(__('Check All',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Check All'); ?></a>
                                        </span>
                                        <span style="float:right;margin-right:5px;margin-top:-34px;">
                                                <a title = "<?php echo __('/ Uncheck All',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> " id="uncheckallModules" onclick="checkallOption(this.id);" value="Un Check All " name="checkallModules" href="#"> <?php echo $impUh->reduceStringLength(__('/ Uncheck All',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Uncheck All'); ?>
                                                </a>
                                        </span>
                        </div>
                        <div id="data">
				<table><tbody> 
				<tr><td>
					<h3 id="innertitle"><?php echo __('Post',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
		                        <label><div><?php echo __('Enables to import posts with custompost and customfields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </div>        
					<div><?php echo __('Enable to import posts with attributes from csv.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>
</label></td><td>
				</td><td style="width:119px">
                                <label id="postlabel" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['post']; ?>"><input type='checkbox' name='post' value='post' id ='post' <?php echo $skinnyData['post']; ?> style="display:none" onclick="postsetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="nopostlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nopost']; ?>"><input type='checkbox' name='post' style="display:none" onclick="postsetting(this.id, this.name);" ><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
				</td></tr>
				<tr><td>
				<h3 id="innertitle"><?php echo __('Page',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <label><div><?php echo __('Enables to import pages with custompost and customfields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>        
					<div><?php echo __('Enable to import pages with attributes from csv.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div></label></td><td>
                                </td><td style="width:119px">
                                <label id="pagelabel" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['page']; ?>"><input type='checkbox' name='page_module' value='page' id ='page' <?php echo $skinnyData['page']; ?> style="display:none" onclick="pagesetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="nopagelabel" title = "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nopage']; ?>"><input type='checkbox' name='page_module' style="display:none" onclick="pagesetting(this.id, this.name);"> <?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?> </label>
				</td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Users',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <label><?php echo __('Enable to import users with attributes from csv.',WP_CONST_ULTIMATE_CSV_IMP_SLUG,WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td><td>
                                </td><td style="width:119px">
                                <label id="userlabel" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['users']; ?>"><input type='checkbox' name='users' value='users' id = 'users' <?php echo $skinnyData['users']; ?> style="display:none" onclick="usersetting(this.id, this.name);" ><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?> </label>
				<label id="nouserlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nousers']; ?>"><input type='checkbox' name='users' style="display:none" onclick="usersetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
				</td></tr>
                                <tr><td>
                                <!--<h3 id="innertitle"><?php /*echo __('Comments',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <label><div><?php echo __('Enables to import posts with custompost and customfields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>        
<div><?php echo __('Enable to import comments for post ids from csv.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div></label></td><td>
                                </td><td style="width:119px">
                                <label id="commentslabel" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['comments']; ?>"><input type='checkbox' name='comments' value='comments' id= 'comments' <?php echo $skinnyData['comments']; ?> style="display:none" onclick="commentsetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="nocommentslabel" title = "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"  class="<?php echo $skinnyData['nocomments']; ?>"><input type='checkbox' name='comments' style="display:none" onclick="commentsetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); */?> </label>
				</td></tr>
                                <tr><td>-->
                                <h3 id="innertitle"><?php echo __('Custom Post',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <label><div><?php echo __('Enables to import Customposts.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>        
<div><?php echo __('Enable to import custom posts with attributes from csv',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div></label></td><td>
                                </td><td style="width:119px">
                                <label id="cplabel" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['custompost']; ?>"><input type='checkbox' name='custompost' value='custompost' id = 'custompost' <?php echo $skinnyData['custompost']; ?> style="display:none" onclick="cpsetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="nocplabel" title = "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nocustompost']; ?>"><input type='checkbox' name='custompost'style="display:none" onclick="cpsetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?> </label>
				</td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Custom Taxonomy',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <label><div><?php echo __('Enables to import Custom taxonomy.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>        
<div><?php echo __('Enable to import nested custom taxonomies with description and slug for each from csv',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div></label></td><td>
                                </td><td style="width:119px">
				<?php 
				 $skinny_customtaxonomy = '';
				if(isset($skinnyData['customtaxonomy']))
				{
					$skinny_customtaxonomy = $skinnyData['customtaxonomy'];
				}
				else
				{

					$skinny_customtaxonomy = '';
				}


				?>
                                <label id="custaxlabel" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinny_customtaxonomy; ?>"><input type='checkbox' name='customtaxonomy' value='customtaxonomy' id = 'customtaxonomy' <?php echo $skinny_customtaxonomy; ?> style="display:none" onclick="custaxsetting(this.id, this.name);" ><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label><input type='hidden'id="customtaxonomystatus" value="<?php echo $skinny_customtaxonomy; ?>" />
				<label id="nocustaxlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nocustomtaxonomy']; ?>"><input type='checkbox' name='customtaxonomy' style="display:none" onclick="custaxsetting(this.id, this.name);"><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
				</td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Categories/Tags',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <label><div><?php echo __('Enables to import Categories.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>    
<div><?php echo __('Enable to import nested categories with description and slug for each from csv.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div></label></td><td>
                                </td><td style="width:119px">
				 <?php
                                 $skinny_categories = '';
                                if(isset($skinnyData['categories']))
                                {
                                        $skinny_categories = $skinnyData['categories'];
                                }
                                else
                                {

                                        $skinny_categories = '';
                                }
                                
				$categoryvalue = '';
				$customerreviewsvalue = '';
				?>
                                <label id="catlabel" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinny_categories; ?>"><input type='checkbox' name='categories' value='categories' id = 'categories' <?php echo $skinnyData['categories']; ?> style="display:none" onclick="catsetting(this.id, this.name);" ><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label><input type='hidden'id="categorystatus" value="<?php echo $categoryvalue; ?>" />
				<?php if(isset($skinnyData['nocategories'])) { ?>
                                <label id="nocatlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nocategories']; ?>"><input type='checkbox' name='categories' style="display:none" onclick="catsetting(this.id, this.name);" ><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
		                <?php } ?>
                   		</td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Customer Reviews',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <label><div><?php echo __('Enables to import Customer reviews.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div>
<div><?php echo __('Enable to import customer reviews with attributes from csv.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></div></label></td><td>
                                </td><td style="width:119px">
                                <label id="custrevlabel" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['customerreviews']; ?>" <?php if (($skinnyData['customerreviewstd'] == 'pluginAbsent') || ($skinnyData['customerreviewstd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='rcustomerreviews' id='rcustomerreviews' value='customerreviews' <?php echo $skinnyData['customerreviews']; ?> style="display:none" onclick="cusrevsetting(this.id, this.name);" <?php if (($skinnyData['customerreviewstd'] == 'pluginAbsent') || ($skinnyData['customerreviewstd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
                                <input type='hidden'id="customerreviewstatus" value="<?php echo $customerreviewsvalue; ?>">
				<label id="nocustrevlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nocustomerreviews']; ?>"<?php if (($skinnyData['customerreviewstd'] == 'pluginAbsent') || ($skinnyData['customerreviewstd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;"<?php } ?>><input type='checkbox' name='rcustomerreviews' style="display:none" onclick="cusrevsetting(this.id, this.name);" <?php if (($skinnyData['customerreviewstd'] == 'pluginAbsent') || ($skinnyData['customerreviewstd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
                                </td></tr>
				</tbody></table><br />
                                <label style='color:red;'><?php echo __("Note: Supports WordPress Custom Post by default. For Custom Post Type UI plugin, please enable it under Custom Posts & Taxonomy",WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                        </div>
                </div>
<!--div-2 -->
                <div id="section2" class="custompost" style="display:none;">
                        <div class="title" class="databorder" >
                                <h3><?php echo __('Custom Posts & Taxonomy',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h3>
                        </div>
                        <div id="data">
                               <table>
                               <tbody>
                               <tr><td>
                               <h3 id="innertitle"><?php echo __('Custom Post Type UI',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                               <label><?php echo __('Import support for Custom Post Type UI data.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td><td>
                               <label id="cptulabel" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['custompostuitype']; ?>" <?php if (($skinnyData['cptutd'] == 'pluginAbsent') || ($skinnyData['cptutd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='cptuicustompost' id="cptui" value='custompostuitype' <?php echo $skinnyData['custompostuitype']; ?> style="display:none" onclick="cptuicustompostsetting(this.id, this.name);" <?php if (($skinnyData['cptutd'] == 'pluginAbsent') || ($skinnyData['cptutd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>	
				<label id="nocptulabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nocustompostuitype']; ?>" <?php if (($skinnyData['cptutd'] == 'pluginAbsent') || ($skinnyData['cptutd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" <?php } ?>><input type='checkbox' name='cptuicustompost' style="display:none" onclick="cptuicustompostsetting(this.id, this.name);" <?php if (($skinnyData['cptutd'] == 'pluginAbsent') || ($skinnyData['cptutd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
                               
                               </td></tr>
                               <tr><td>
                               <h3 id="innertitle"><?php echo __('Types Custom Posts & Taxonomy',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                               <label><?php echo __('Import support for Types Custom Post Type and taxonomies data.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                               <label id="typescustompost" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['wptypes']; ?>" <?php if (($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox'  name='typescustompost' id='wptypespost' value='wptypes' <?php echo $skinnyData['wptypes']; ?> style="display:none" onclick="typescustompostsetting(this.id, this.name);" <?php if (($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="notypescustompost" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nowptypes']; ?>" <?php if (($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" <?php } ?>><input type='checkbox'  name='typescustompost' style="display:none" onclick="typescustompostsetting(this.id, this.name);" <?php if (($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
                                
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('CCTM Custom Posts',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Import support for CCTM Custom Posts from csv.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="cctmcustompost" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['cctm']; ?>" <?php if (($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='cctmcustompost' id='cctm' value='cctm' <?php echo $skinnyData['cctm']; ?> style="display:none" onclick="cctmcustompostsetting(this.id, this.name);" <?php if (($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="nocctmcustompost" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nocctm']; ?>" <?php if (($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" <?php } ?>><input type='checkbox' name='cctmcustompost' style="display:none" onclick="cctmcustompostsetting(this.id, this.name);" <?php if (($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
                                
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('PODS Custom Posts & Taxonomy',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Import support for PODS Custom Posts.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="podscustompost" title = "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['podspost']; ?>" <?php if (($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?> style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='podscustompost' id='podspost' value='podspost' <?php echo $skinnyData['podspost']; ?> style="display:none" onclick="podscustompostsetting(this.id, this.name);" <?php if (($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?> disabled  <?php } ?>><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>		
		              <label id="nopodscustompost" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nopodspost']; ?>" <?php if (($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?> style="border-color: #ccc;color: #999;box-shadow: none;background-color:#e6e6e6;background-image:none;" <?php } ?>><input type='checkbox' name='podscustompost' style="display:none" onclick="podscustompostsetting(this.id, this.name);" <?php if (($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
				</td></tr>
                                </tbody>
                                </table>
                        </div>
                </div>
                <!--div-3-->
                <div id="section3" class="Customfields" style="display:none;">
                        <div class="title">
                                        <h3><?php echo __('Custom Fields',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                        <span id="resetcustfield"><a id="resetopt" href="#" value="reset" name="resetcustfield" onclick="resetOption(this.id);"><?php echo __('Reset Custom Field',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></a> </span>
                        </div>
                        <div id="data" class="databorder custom-fields" >
                                <table>
                                <tbody>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('WP-Members for Users',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable to add import support WP-Members user fields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="wpusercheck" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['checkuser']; ?>" <?php if(($skinnyData['wpmemberstd'] == 'pluginAbsent') || ($skinnyData['wpmemberstd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio' name='rwpmembers' id='rwpmembers' value='wpmembers' <?php echo $skinnyData['wpmembers']; ?> style="display:none" onclick="wpmembersetting(this.id, this.name);" <?php if(($skinnyData['wpmemberstd'] == 'pluginAbsent') || ($skinnyData['wpmemberstd'] == 'pluginPresent')) { ?> disabled <?php } ?> ><span id="checkuser"><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></span> </label>
                                <label id="wpuseruncheck" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['uncheckuser']; ?>" <?php if(($skinnyData['wpmemberstd'] == 'pluginAbsent') || ($skinnyData['wpmemberstd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;"<?php } ?>><input type='radio' name='rwpmembers' id="runcheckmember" style="display:none" onclick="wpmembersetting(this.id, this.name);" <?php if(($skinnyData['wpmemberstd'] == 'pluginAbsent') || ($skinnyData['wpmemberstd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?> </label>
                                </td></tr>
				<tr><td>
                                <h3 id="innertitle"><?php echo __('WP e-Commerce Custom Fields',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h3>
                                <label><?php echo __('Enable to add import support for WP e-Commerce custom fields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="ecomlabel" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['ecomfield']; ?>" <?php if(($skinnyData['wecftd'] == 'pluginAbsent') || ($skinnyData['wecftd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio' name='wpcustomfields' id='wpcustomfields' <?php #echo $skinnyData['wpcustomfields']; ?> value="wpcustomfields" style="display:none" onclick="wpfieldsetting(this.id, this.name);" <?php if(($skinnyData['wecftd'] == 'pluginAbsent') || ($skinnyData['wecftd'] == 'pluginPresent')) { ?>disabled <?php } ?>/><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="noecomlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['noecomfield']; ?>" <?php if(($skinnyData['wecftd'] == 'pluginAbsent') || ($skinnyData['wecftd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;"<?php } ?>><input type='radio' name='wpcustomfields' style="display:none" onclick="wpfieldsetting(this.id, this.name);" <?php if(($skinnyData['wecftd'] == 'pluginAbsent') || ($skinnyData['wecftd'] == 'pluginPresent')) { ?>disabled <?php } ?>/><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('ACF Custom Fields',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable to add import support for ACF Custom Fields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </br>
				</td><td>
                                <label id="acffieldlabel" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['acf']; ?>" <?php if(($skinnyData['acftd'] == 'pluginAbsent') || ($skinnyData['acftd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='acfcustomfield' id='acfcustomfield' value='acf' <?php echo $skinnyData['acf']; ?> style="display:none" onclick="acfcustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['acftd'] == 'pluginAbsent') || ($skinnyData['acftd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="noacffieldlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['noacf']; ?>" <?php if(($skinnyData['acftd'] == 'pluginAbsent') || ($skinnyData['acftd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;"<?php } ?>><input type='checkbox' name='acfcustomfield' style="display:none" onclick="acfcustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['acftd'] == 'pluginAbsent') || ($skinnyData['acftd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('CCTM Custom Fields',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
				<label><?php echo __('Enable to add import support for CCTM Custom Fields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="cctmfieldlabel" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['cctmcustfields']; ?>" <?php if(($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='cctmcustomfield' id='cctmcustomfield' value='cctmcustfields' <?php echo $skinnyData['cctm']; ?> style="display:none" onclick="cctmcustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?> </label>
				<label id="nocctmfieldlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nocctmcustfields']; ?>" <?php if(($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;"<?php } ?>><input type='checkbox' name='cctmcustomfield' style="display:none" onclick="cctmcustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['cctmtd'] == 'pluginAbsent') || ($skinnyData['cctmtd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?> </label>
                                
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Types Custom Fields',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable to add import support for Types custom fields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="typesfieldlabel" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['wptypescustfields']; ?>" <?php if(($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='typescustomfield' id='typescustomfield' value='wptypescustfields' <?php echo $skinnyData['wptypes']; ?> style="display:none" onclick="typescustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
				<label id="notypesfieldlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nowptypescustfields']; ?>" <?php if(($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;"<?php } ?>><input type='checkbox' name='typescustomfield' style="display:none" onclick="typescustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['wptypestd'] == 'pluginAbsent') || ($skinnyData['wptypestd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>
                                
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('PODS Custom Fields',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h3>
                                <label><?php echo __('Enable to add import support for PODS custom fields.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
				<label id="podsfieldlabel" title= "<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>"class="<?php echo $skinnyData['podscustomfields']; ?>" <?php if(($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='checkbox' name='podscustomfield' id='podscustomfield' value='podscustomfields' <?php echo $skinnyData['podscustomfields']; ?> style="display:none" onclick="podscustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?> </span></label>
				<label id="nopodsfieldlabel" title= "<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['nopodscustomfields']; ?>" <?php if(($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;"<?php } ?>><input type='checkbox' name='podscustomfield' style="display:none" onclick="podscustomfieldsetting(this.id, this.name);" <?php if(($skinnyData['podstd'] == 'pluginAbsent') || ($skinnyData['podstd'] == 'pluginPresent')) { ?>disabled<?php } ?>/><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?> </span></label>
                                </td></tr>
                                </tbody>
                                </table>
                        </div>
                </div>
	<!--div-4 -->
                <div id="section4" class="ecommercesettings" style="display:none;">
                        <div class="title">
                        <h3><?php echo __('Ecommerce Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        </div>
                        <div id="data" class="databorder" >
                                <table>
                                <tbody>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('None',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Ecommerce import is disabled.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="ecommercesetting1" class="<?php echo $skinnyData['nonerecommerce']; ?>"><input type='radio' id='ecommercenone' name='recommerce'  value='nonerecommerce' <?php echo $skinnyData['nonerecommerce']; ?>  class='ecommerce' onclick='ecommercesetting(this.id, this.name)' style="display:none" ><span id="ecommerce1text"> <?php echo $skinnyData['ecomnone_status']; ?> </span></label>
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Eshop',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h3>
                                <label><?php echo __('Enable ecommerce import for Eshop.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="ecommercesetting2" class="<?php echo $skinnyData['eshop']; ?>" <?php if(($skinnyData['eshoptd'] == 'pluginAbsent') || ($skinnyData['eshoptd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>> <input type='radio' id = 'eshop' name='recommerce' value='eshop' <?php echo $skinnyData['eshop']; ?> class='ecommerce'  onclick='ecommercesetting(this.id, this.name)' style="display:none" <?php if(($skinnyData['eshoptd'] == 'pluginAbsent') || ($skinnyData['eshoptd'] == 'pluginPresent')) { ?>disabled <?php } ?>><span id="ecommerce2text"><?php if(($skinnyData['eshoptd'] == 'pluginAbsent') || ($skinnyData['eshoptd'] == 'pluginPresent')) { ?><?php echo __('Disabled',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?><?php } else { echo $skinnyData['eshop_status']; } ?></span></label>
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Marketpress Lite',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable ecommerce import for marketpress Lite.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
				<label id="ecommercesetting3" class="<?php echo $skinnyData['marketpress']; ?>" <?php if(($skinnyData['marketpresslitetd'] == 'pluginAbsent') || ($skinnyData['marketpresslitetd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio' name='recommerce' id = 'marketpress' id='recommerce' value='marketpress' <?php echo $skinnyData['marketpress']; ?> class='marketpress' onclick='ecommercesetting(this.id, this.name)' style="display:none"<?php if(($skinnyData['marketpresslitetd'] == 'pluginAbsent') || ($skinnyData['marketpresslitetd'] == 'pluginPresent')) { ?>disabled <?php } ?>><span id="ecommerce3text"><?php if(($skinnyData['marketpresslitetd'] == 'pluginAbsent') || ($skinnyData['marketpresslitetd'] == 'pluginPresent')) { ?><?php echo __('Disabled',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?><?php } else { echo $skinnyData['marketpress_status']; } ?></span></label>
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Woocommerce',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h3>
                                <label><?php echo __('Enable ecommerce import for Woocommerce.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="ecommercesetting4" class="<?php echo $skinnyData['woocommerce']; ?>" <?php if(($skinnyData['woocomtd'] == 'pluginAbsent') || ($skinnyData['woocomtd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio' name='recommerce' id = 'woocommerce' value='woocommerce' <?php echo $skinnyData['woocommerce']; ?> class='woocommerce' onclick='ecommercesetting(this.id, this.name)' style="display:none" <?php if(($skinnyData['woocomtd'] == 'pluginAbsent') || ($skinnyData['woocomtd'] == 'pluginPresent')) { ?>disabled <?php }?>><span id="ecommerce4text"><?php if(($skinnyData['woocomtd'] == 'pluginAbsent') || ($skinnyData['woocomtd'] == 'pluginPresent')) { ?><?php echo __('Disabled',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?><?php } else { echo $skinnyData['woocommerce_status']; } ?></span></label>
                                </td></tr>
                                <tr><td>
				<h3 id="innertitle"> <?php echo __('WP e-Commerce',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable ecommerce import for WP e-Commerce.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="ecommercesetting5" class="<?php echo $skinnyData['wpcommerce']; ?>" <?php if(($skinnyData['wpcomtd'] == 'pluginAbsent') || ($skinnyData['wpcomtd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio' name='recommerce' id = 'wpcommerce' value='wpcommerce' <?php echo $skinnyData['wpcommerce']; ?> class='ecommerce' onclick='ecommercesetting(this.id, this.name)' style="display:none" <?php if(($skinnyData['wpcomtd'] == 'pluginAbsent') || ($skinnyData['wpcomtd'] == 'pluginPresent')) { ?>disabled <?php }?>><span id="ecommerce5text"><?php if(($skinnyData['wpcomtd'] == 'pluginAbsent') || ($skinnyData['wpcomtd'] == 'pluginPresent')) { ?><?php echo __('Disabled',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?><?php } else { echo $skinnyData['wpcommerce_status']; } ?></span></label>
                                
				</td></tr>
                                </tbody>
                                </table>
                        </div>
                </div>
		<!--div-5-->
                <div id="section5" class="seosettings" style="display:none;">
                        <div class="title">
                                <h3><?php echo __('SEO Settings',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        </div>
                        <div id="data" class="databorder" >
                                <table>
                                <tbody>
                                <tr><td>
                                 <h3 id="innertitle"><?php echo __('None',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('SEO Meta import is disabled.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="seosetting1" class="<?php echo $skinnyData['nonerseooption']; ?> " ><input type='radio' name='rseooption'id="none" value='nonerseooption' <?php echo $skinnyData['nonerseooption']; ?> style="display:none" class='ecommerce' onclick="seosetting(this.id,this.name);" ><span id="seosetting1text"> <?php echo $skinnyData['none_status']; ?> </span></label>
                                </td></tr>
				<tr><td>
                                <h3 id="innertitle"><?php echo __('All-in-one SEO',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h3>
                                <label><?php echo __('Enable All-in-one SEO import.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="seosetting2" class="<?php echo $skinnyData['aioseo']; ?>" <?php if(($skinnyData['aioseotd'] == 'pluginAbsent') || ($skinnyData['aioseotd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio' name='rseooption' id="aioseo" value='aioseo' <?php echo $skinnyData['aioseo']; ?> style="display:none" onclick="seosetting(this.id,this.name);" <?php if(($skinnyData['aioseotd'] == 'pluginAbsent') || ($skinnyData['aioseotd'] == 'pluginPresent')) { ?>disabled <?php }?>><span id="seosetting2text"> <?php echo $skinnyData['aioseo_status']; ?> </span></label> 
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"> <?php echo __('Yoast SEO',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable Wordpress SEO by  Yoast support.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
<label id="seosetting3" class="<?php echo $skinnyData['yoastseo']; ?>" <?php if(($skinnyData['yoasttd'] == 'pluginAbsent') || ($skinnyData['yoasttd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio' name='rseooption' id="yoastseo" value='yoastseo' <?php echo $skinnyData['yoastseo']; ?> style="display:none" onclick="seosetting(this.id,this.name);" <?php if(($skinnyData['yoasttd'] == 'pluginAbsent') || ($skinnyData['yoasttd'] == 'pluginPresent')) { ?>disabled<?php }?>><span id="seosetting3text"><?php echo $skinnyData['yoastseo_status']; ?> </span></label>

                                </td></tr>
                                </tbody>
                                </table>
                        </div>
                </div>

		 <!--div-6-->
                <div id="section6" class="additionalfeatures" style="display:none;">
                        <div class="title">
                                <h3><?php echo __('Additional Features',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        </div>
                        <div id="data">
                                <table class="enablefeatures">
                                <tbody>
				<tr class="databorder"><td>
				<h3 id="innertitle"><?php echo __('Debug Mode',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
				<label><?php echo __('You can enable/disable the debug mode.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
				<label id="debugmode_enable" class="<?php echo $skinnyData['debugmode_enable']; ?>"><input type='radio' name='debug_mode' value='enable_debug' <?php echo $skinnyData['debugmode_enable']; ?> id="enabled" style="display:none" onclick="debugmode_check(this.id, this.name);" > <?php echo __('On',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
				<label id="debugmode_disable" class="<?php echo $skinnyData['debugmode_disable']; ?>"><input type='radio' name='debug_mode' value='disable_debug' <?php echo $skinnyData['debugmode_disable']; ?> id="disabled" style="display:none" onclick="debugmode_check(this.id, this.name);" > <?php echo __('Off',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
				</td></tr>
				<tr class="databorder"><td>
				<h3 id="innertitle"><?php echo __('Scheduled log mails',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable to get scheduled log mails.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label> </td><td>
                                <label id="schedulecheck" class="<?php echo $skinnyData['schedulelog']; ?>"><input type='radio' name='send_log_email' value='send_log_email' <?php echo $skinnyData['send_log_email']; ?> id="scheduled" style="display:none" onclick="schedulesetting(this.id, this.name);" > <?php echo __('Yes',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
                                <label id="scheduleuncheck" class="<?php echo $skinnyData['schedulenolog']; ?>"><input type='radio' name='send_log_email' id="noscheduled" style="display:none" onclick="schedulesetting(this.id, this.name);" > <?php echo __('No',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle"><?php echo __('Drop Table',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('If enabled plugin deactivation will remove plugin data, this cannot be restored.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td>
				<td><label id="dropon" class="<?php echo $skinnyData['drop_on'] ; ?>" ><input type='radio' name='drop_table' id='drop_table' value='on' <?php echo $skinnyData['dropon_status']; ?> style="display:none" onclick="dropsetting(this.id, this.name);" > <?php echo __('On',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </label>
                                <label id="dropoff" class="<?php echo $skinnyData['drop_off'] ; ?>" ><input type='radio' name='drop_table' id='drop_tab' value='off' <?php echo $skinnyData['dropoff_status']; ?> style="display:none" onclick="dropsetting(this.id, this.name);" > <?php echo __('Off',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                                </td></tr>
                                <tr><td>
                                <h3 id="innertitle" ><?php echo __('Category Icons',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enable to import category icons for category.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                                </td>
                                <td>
				<label id="catenable" title="<?php echo __('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['catyenable'] ; ?>"  <?php if(($skinnyData['cateicontd'] == 'pluginAbsent') || ($skinnyData['cateicontd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?>><input type='radio'  name='rcateicons' id='caticonenable' value='enable' <?php echo $skinnyData['catyenablestatus']; ?> style="display:none" onclick="categoryiconsetting(this.id, this.name);" style="display:none" <?php if(($skinnyData['cateicontd'] == 'pluginAbsent') || ($skinnyData['cateicontd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Enable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Enable'); ?></label>
                                <label id="catdisable" title="<?php echo __('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" class="<?php echo $skinnyData['catydisable']; ?>" <?php if(($skinnyData['cateicontd'] == 'pluginAbsent') || ($skinnyData['cateicontd'] == 'pluginPresent')) { ?>style="background-color:#e6e6e6;border-color: #ccc;color: #999;box-shadow: none;background-image:none;" title="Enable the plugin to activate."<?php } ?> ><input type='radio' name='rcateicons' id='caticondisable' value='disable' <?php echo $skinnyData['catydisablestatus']; ?>  style="display:none" onclick="categoryiconsetting(this.id, this.name);" style="display:none" <?php if(($skinnyData['cateicontd'] == 'pluginAbsent') || ($skinnyData['cateicontd'] == 'pluginPresent')) { ?> disabled <?php } ?>><?php echo $impUh->reduceStringLength(__('Disable',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Disable'); ?></label>                                
                                </td>
                                </tr>
				<tr><td>
                                <h3 id="innertitle" ><?php echo __('Woocommerce Custom attribute',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                                <label><?php echo __('Enables to register woocommrce custom attribute.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                                </td>
                                <td>
                                <label id="onwoocomreg" class="<?php echo $skinnyData['onwoocomreg'] ; ?>"><input type='radio'  name='woocomattr' id='woocomattr' value='on' <?php echo $skinnyData['onwoocomreg_status']; ?> onclick="woocomregattr(this.id, this.name);" style="display:none" ><?php echo __('On',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                                <label id="offwoocomreg" class="<?php echo $skinnyData['offwoocomreg'] ; ?>"><input type='radio' name='woocomattr' id='disablewoocomattr' value='off' <?php echo $skinnyData['offwoocomreg_status']; ?>  onclick="woocomregattr(this.id, this.name);" style="display:none"><?php echo __('Off',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                                </td></tr>
                                </tbody>
                                </table>
                        </div>
                </div>
		<!--div-7-->
                <div id="section7" class="databaseoptimization" style="display:none;">
                        <div class="title">
                                <h3><?php echo __('Database Optimization',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h3>
                                <span style="float:right;margin-right:168px;margin-top:-35px;">
                                        <a title = "<?php echo __('Check All',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> " id="checkOpt" onclick="selectOptimizer(this.id);" href="#"> <?php echo $impUh->reduceStringLength(__('Check All',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Check All'); ?> </a>
                                </span>
                                <span style="float:right;margin-right:81px;margin-top:-35px;">
                                        <a title = "<?php echo __('/ Uncheck All',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" id="uncheckOpt" onclick="selectOptimizer(this.id);" href="#"> <?php echo $impUh->reduceStringLength(__('/ Uncheck All',WP_CONST_ULTIMATE_CSV_IMP_SLUG),'Uncheck All'); ?> </a>
                                </span>
                        </div>
                        <div id="data" class="database">
                        <table class="databaseoptimization">
                        <tbody>
                        <tr>
                        <td>
			<?php
			if(isset($skinnyData['delete_all_orphaned_post_page_meta']))
			{
				$skinny_delete_all_post_page = $skinnyData['delete_all_orphaned_post_page_meta'];
			}
			else
			{
				$skinny_delete_all_post_page = '';
			}
			if(isset($skinnyData['delete_all_unassigned_tags']))
                        {
                                $skinny_delete_all_unassigned_tag = $skinnyData['delete_all_unassigned_tags'];
                        }
                        else
                        {
                                $skinny_delete_all_unassigned_tag = '';
                        }
			if(isset($skinnyData['delete_all_post_page_revisions']))
                        {
                                $skinny_delete_all_page_revisions = $skinnyData['delete_all_post_page_revisions'];
                        }
                        else
                        {
                                $skinny_delete_all_page_revisions = '';
                        }
			if(isset($skinnyData['delete_all_auto_draft_post_page']))
                        {
                                $skinny_delete_all_auto_draft_page = $skinnyData['delete_all_auto_draft_post_page'];
                        }
                        else
                        {
                                $skinny_delete_all_auto_draft_page = '';
                        }
			if(isset($skinnyData['delete_all_post_page_in_trash']))
                        {
                                $skinny_delete_all_post_page_trash = $skinnyData['delete_all_post_page_in_trash'];
                        }
                        else
                        {
                                $skinny_delete_all_post_page_trash = '';
                        }

			if(isset($skinnyData['delete_all_spam_comments']))
                        {
                                $skinny_delete_all_spam_comments = $skinnyData['delete_all_spam_comments'];
                        }
                        else
                        {
                                $skinny_delete_all_spam_comments = '';
                        }
			if(isset($skinnyData['delete_all_comments_in_trash']))
                        {
                                $skinny_delete_all_comments_trash = $skinnyData['delete_all_comments_in_trash'];
                        }
                        else
                        {
                                $skinny_delete_all_comments_trash = '';
                        }
			if(isset($skinnyData['delete_all_unapproved_comments']))
                        {
                                $skinny_delete_all_unapproved_comments = $skinnyData['delete_all_unapproved_comments'];
                        }
                        else
                        {
                                $skinny_delete_all_unapproved_comments = '';
                        }
			if(isset($skinnyData['delete_all_pingback_commments']))
                        {
                                $skinny_delete_all_pingback_comments = $skinnyData['delete_all_pingback_commments'];
                        }
                        else
                        {
                                $skinny_delete_all_pingback_comments = '';
                        }
			if(isset($skinnyData['delete_all_trackback_comments']))
                        {
                                $skinny_delete_all_trackback_comments = $skinnyData['delete_all_trackback_comments'];
                        }
                        else
                        {
                                $skinny_delete_all_trackback_comments = '';
                        }


			?>
			<label id="dblabel"><input type='checkbox' name='delete_all_orphaned_post_page_meta' id='delete_all_orphaned_post_page_meta' value='delete_all_orphaned_post_page_meta' <?php echo $skinny_delete_all_post_page; ?> onclick='database_optimization_settings(this.id);' /><td><span id="align"> <?php echo __('Delete all orphaned Post/Page Meta',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        <td>
			<label id="dblabel"><input type='checkbox' name='delete_all_unassigned_tags' id='delete_all_unassigned_tags' value='delete_all_unassigned_tags' <?php echo $skinny_delete_all_unassigned_tag; ?> onclick='database_optimization_settings(this.id);' /><td><span id="align"> <?php echo __('Delete all unassigned tags',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        </tr>
                        <tr>
                        <td>
			<label id="dblabel"><input type='checkbox' name='delete_all_post_page_revisions' id='delete_all_post_page_revisions' value='delete_all_post_page_revisions' <?php echo $skinny_delete_all_page_revisions; ?> onclick='database_optimization_settings(this.id);'  /><td><span id="align"> <?php echo __('Delete all Post/Page revisions',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        <td>
			<label id="dblabel"><input type='checkbox' name='delete_all_auto_draft_post_page' id='delete_all_auto_draft_post_page' value='delete_all_auto_draft_post_page' <?php echo $skinny_delete_all_auto_draft_page; ?> onclick='database_optimization_settings(this.id);' /><td><span id="align"> <?php echo __('Delete all auto drafted Post/Page',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <label id="dblabel"><input type='checkbox' name='delete_all_post_page_in_trash' id='delete_all_post_page_in_trash' value='delete_all_post_page_in_trash' <?php echo $skinny_delete_all_post_page_trash; ?> onclick='database_optimization_settings(this.id);' /><td><span id="align"> <?php echo __('Delete all Post/Page in trash',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        <td>
			<label id="dblabel"><input type='checkbox' name='delete_all_spam_comments' id='delete_all_spam_comments' value='delete_all_spam_comments' <?php echo $skinny_delete_all_spam_comments; ?> onclick='database_optimization_settings(this.id);' /><td><span id="align"> <?php echo __('Delete all Spam Comments',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <label id="dblabel"><input type='checkbox' name='delete_all_comments_in_trash' id='delete_all_comments_in_trash' value='delete_all_comments_in_trash'  <?php echo $skinny_delete_all_comments_trash; ?> onclick='database_optimization_settings(this.id);'  /><td><span id="align"> <?php echo __('Delete all Comments in trash',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        <td>
                        <label id="dblabel"><input type='checkbox' name='delete_all_unapproved_comments' id='delete_all_unapproved_comments' value='delete_all_unapproved_comments'  <?php echo $skinny_delete_all_unapproved_comments; ?> onclick='database_optimization_settings(this.id);' /><td><span id="align"> <?php echo __('Delete all Unapproved Comments',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        </tr>
                        <tr>
                        <td>
                        <label id="dblabel"><input type='checkbox' name='delete_all_pingback_commments' id='delete_all_pingback_commments' value='delete_all_pingback_commments'  <?php echo $skinny_delete_all_pingback_comments; ?> onclick='database_optimization_settings(this.id);' /><td><span id="align"> <?php echo __('Delete all Pingback Comments',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        <td>
			<label id="dblabel"><input type='checkbox' name='delete_all_trackback_comments' id='delete_all_trackback_comments' value='delete_all_trackback_comments'  <?php echo $skinny_delete_all_trackback_comments; ?> onclick='database_optimization_settings(this.id);' /><td> <span id="align"> <?php echo __('Delete all Trackback Comments',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></span></td></label>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                                <div style="float:right;padding:17px;margin-top:-2px;">
                                        <input id="database_optimization" class="action btn btn-warning" type="button" onclick="databaseoptimization();" value="<?php echo __('Run DB Optimizer',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?>" name="database_optimization">
                                </div>
                                <div id="optimizelog" style="margin-top:35px;display:none;">
                                        <h4><?php echo __('Database Optimization Log',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h4>
                                        <div id="optimizationlog" class="optimizerlog">
                                                <div id="log" class="log">
                                                        <p style="margin:15px;color:red;" id="align"><?php echo __('NO LOGS YET NOW.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
		<!--div-8-->
                <div id="section8" class="securityperformance" style="display:none;">
                        <div class="title">
                                <h3><?php echo __('Security and Performance',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        </div>
                        <div id="data" class="databorder security-perfoemance" >
                        <table class="securityfeatures">
                        <tr><td>
                        <h3 id="innertitle"><?php echo __('Allow authors/editors to import',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        <label><?php echo __('This enables authors/editors to import.',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label></td><td>
                        <label id="allowimport" class="<?php echo $skinnyData['authorimport']; ?>" ><input type='radio' name='enable_plugin_access_for_author' id="enableimport" class="importauthor" value='enable_plugin_access_for_author' <?php echo $skinnyData['enable_plugin_access_for_author']; ?> style="display:none" onclick="authorimportsetting(this.id, this.name);"  /><?php echo __('Check',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                        <label id="donallowimport" class="<?php echo $skinnyData['noauthorimport']; ?>" > <input type='radio' name='enable_plugin_access_for_author' class="importauthor" style="display:none" onclick="authorimportsetting(this.id, this.name);" ><?php echo __('Uncheck',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                        </td></tr>
                        </table>
                        <table class="table table-striped">
                        <tr><th colspan="3" >
                        <h3 id="innertitle"><?php echo __('Minimum required php.ini values (Ini configured values)',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        </th></tr>
                        <tr><th>
                        <label><?php echo __('Variables',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                        </th><th class='ini-configured-values'>
                        <label><?php echo __('System values',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                        </th><th class='min-requirement-values'>
                        <label><?php echo __('Minimum Requirements',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></label>
                        </th></tr>
                        <tr><td><?php echo __('post_max_size',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('post_max_size') ?></td><td class='min-requirement-values'>10M</td></tr>
                        <tr><td><?php echo __('auto_append_file',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td class='ini-configured-values'>- <?php echo ini_get('auto_append_file') ?></td><td class='min-requirement-values'>-</td></tr>
                        <tr><td><?php echo __('auto_prepend_file',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'>- <?php echo ini_get('auto_prepend_file') ?></td><td class='min-requirement-values'>-</td></tr>
                        <tr><td><?php echo __('upload_max_filesize',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('upload_max_filesize') ?></td><td class='min-requirement-values'>2M</td></tr>
                        <tr><td><?php echo __('file_uploads',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('file_uploads') ?></td><td class='min-requirement-values'>1</td></tr>
			<tr><td><?php echo __('allow_url_fopen',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('allow_url_fopen') ?></td><td class='min-requirement-values'>1</td></tr>
                        <tr><td><?php echo __('max_execution_time',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('max_execution_time') ?></td><td class='min-requirement-values'>3000</td></tr>
                        <tr><td><?php echo __('max_input_time',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('max_input_time') ?></td><td class='min-requirement-values'>3000</td></tr>
                        <tr><td><?php echo __('max_input_vars',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('max_input_vars') ?></td><td class='min-requirement-values'>3000</td></tr>
                        <tr><td><?php echo __('memory_limit',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td class='ini-configured-values'><?php echo ini_get('memory_limit') ?></td><td class='min-requirement-values'>99M</td></tr>
                        </table>
                        <h3 id="innertitle" colspan="2" ><?php echo __('Required to enable/disable Loaders, Extentions and modules:',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        <table class="table table-striped">
                        <?php $loaders_extensions = get_loaded_extensions();?>
			<?php if(function_exists('apache_get_modules')){
					$mod_security = apache_get_modules(); 
			}?>	
                        <tr><td><?php echo __('IonCube Loader',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td><?php if(in_array('ionCube Loader', $loaders_extensions)) {
                                        echo '<label style="color:green;">'; echo __('Yes',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } else {
                                        echo '<label style="color:red;">'; echo __('No',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } ?> </td><td></td></tr>
                        <tr><td>PDO </td><td><?php if(in_array('PDO', $loaders_extensions)) {
                                        echo '<label style="color:green;">';echo __('Yes',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } else {
                                        echo '<label style="color:red;">';echo __('No',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } ?></td><td></td></tr>
                        <tr><td><?php echo __('Curl',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td><?php if(in_array('curl', $loaders_extensions)) {
                                        echo '<label style="color:green;">';echo __('Yes',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } else {
                                        echo '<label style="color:red;">';echo __('No',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } ?></td><td></td></tr>
			<tr><td><?php echo __('Mod Security',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </td><td><?php if(isset($mod_security) && in_array('mod_security.c', $mod_security)) {
                                        echo '<label style="color:green;">'; echo __('Yes',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } else {
                                        echo '<label style="color:red;">'; echo __('No',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>';
                                } ?></td><td>
					<div style='float:left'>
						<a href="#" class="tooltip">
							<img src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>images/help.png" style="margin-left:-74px;"/>
							<span style="margin-left:20px;margin-top:-10px;width:150px;">
								<img class="callout" src="<?php echo WP_CONST_ULTIMATE_CSV_IMP_DIR; ?>images/callout.gif"/>
								<strong><?php echo __('htaccess settings:',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></strong>
								<p><?php echo __('Locate the .htaccess file in Apache web root,if not create a new file named .htaccess and add the following:',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></p>
<b><?php echo '<IfModule mod_security.c>';?> <?php echo __('SecFilterEngine Off SecFilterScanPOST Off',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> <?php echo __('</IfModule>',WP_CONST_ULTIMATE_CSV_IMP_SLUG);?></b>

							</span>
						</a>
					</div>
				    </td></tr>
                        </table>
                        <h3 id="innertitle" colspan="2" ><?php echo __('Debug Information:',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        <table class="table table-striped">
                        <tr><td class='debug-info-name'><?php echo __('WordPress Version',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php echo $wp_version; ?></td><td></td></tr>
                        <tr><td class='debug-info-name'><?php echo __('PHP Version',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php echo phpversion(); ?></td><td></td></tr>
                        <tr><td class='debug-info-name'><?php echo __('MySQL Version',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php echo $wpdb->db_version(); ?></td><td></td></tr>
                        <tr><td class='debug-info-name'><?php echo __('Server SoftWare',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php echo $_SERVER[ 'SERVER_SOFTWARE' ]; ?></td><td></td></tr>			       <tr><td class='debug-info-name'><?php echo __('Your User Agent',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php echo $_SERVER['HTTP_USER_AGENT']; ?></td><td></td></tr>
                        <tr><td class='debug-info-name'><?php echo __('WPDB Prefix',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php echo $wpdb->prefix; ?></td><td></td></tr>
                        <tr><td class='debug-info-name'><?php echo __('WP Multisite Mode',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php if ( is_multisite() ) { echo '<label style="color:green;">'; __('Enabled',WP_CONST_ULTIMATE_CSV_IMP_SLUG); echo '</label>'; } else { echo '<label style="color:red;">'; __('Disabled',WP_CONST_ULTIMATE_CSV_IMP_SLUG);echo '</label>'; } ?> </td><td></td></tr>
                        <tr><td class='debug-info-name'><?php echo __('WP Memory Limit',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></td><td><?php echo (int) ini_get('memory_limit'); ?></td><td></td></tr>
                        </table>
                        </div>
                </div>
		<div id="section9" class="documentation" style="display:none;">
                        <div class="title">
                                <h3><?php echo __('Documentation',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?></h3>
                        </div>
                        <div id="data">
                                <div id="video">
                                        <iframe width="560" height="315" src="//www.youtube.com/embed/FhTUXE5zk0o?list=PL2k3Ck1bFtbRli9VdJaqwtzTSzzkOrH4j" frameborder="0" allowfullscreen></iframe>
                                </div>
                                <div id="relatedpages">
                                        <h2 id="doctitle"><?php echo __('Smackcoders Guidelines',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </h2 >
					<p> <a href="https://www.smackcoders.com/blog/category/web-development-news/" target="_blank"> <?php echo __('Development News',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </a> </p>
					<p> <a href="http://www.wpultimatecsvimporter.com/" target="_blank"><?php echo __('Whats New?',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </a> </p>
					<p> <a href="http://wiki.smackcoders.com/WP_Ultimate_CSV_Importer_Pro" target="_blank"><?php echo __(' Documentation',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </a> </p>
					<p> <a href="https://www.smackcoders.com/blog/csv-importer-a-simple-and-easy-csv-importer-tutorial.html" target="_blank"> <?php echo __('Tutorials',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </a> </p>
					<p> <a href="http://www.youtube.com/user/smackcoders/channels" target="_blank"> <?php echo __('Youtube Channel',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </a> </p>
					<p> <a href="https://www.smackcoders.com/store/products-46/wordpress.html" target="_blank"><?php echo __(' Other Plugins',WP_CONST_ULTIMATE_CSV_IMP_SLUG); ?> </a> </p>
				</div>
                        </div>
                </div>
<!--conbar-->
	 </div>
</div>
</form>
</div>





