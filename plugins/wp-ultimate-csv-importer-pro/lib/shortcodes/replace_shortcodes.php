<?php
#print_r($_POST);
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

global $wpdb;
$shortcodes = $shortcodelist = array();
$eventKey = $_POST['eventKey'];
$default_image = 0;
$rowID = $_POST['row_id'];
$get_shortcode_mode = $wpdb->get_results("select shortcode_mode from wp_ultimate_csv_importer_shortcodes_statusrel where eventkey = '{$eventKey}' and id = $rowID");
$shortcode_mode = $get_shortcode_mode[0]->shortcode_mode;
$get_all_shortcodes = $wpdb->get_results("select pID, shortcode from wp_ultimate_csv_importer_manageshortcodes where eventkey = '{$eventKey}' and mode_of_code = '{$shortcode_mode}'");
foreach($get_all_shortcodes as $key => $val) {
	$post_id = $val->pID;
	$shortcodelist[$post_id][] = $val->shortcode;
}
#print($shortcode_mode); print_r($shortcodelist); die;
if(is_array($shortcodelist) && !empty($shortcodelist)) {
	foreach($shortcodelist as $postID => $shortcodes) {
		$get_post_content = $wpdb->get_results("select post_content from $wpdb->posts where ID = $postID");
		$post_content = $get_post_content[0]->post_content;
#print_r($shortcodes); die;
		foreach($shortcodes as $shortcode) {
			if($shortcode_mode == 'Inline') {
				$get_inlineimage_val = substr($shortcode, "13", -1);
                                $image_attribute = explode('|',$get_inlineimage_val);
                                $get_inlineimage_val = $image_attribute[0];
			} else if($shortcode_mode == 'Featured') {
				$get_inlineimage_val = substr($shortcode, "15", -1);
			}
#		print($get_inlineimage_val); die;
			$uploadDir = wp_upload_dir();
			$inlineimageDir = $uploadDir['basedir'] . '/smack_inline_images';
			$inlineimageURL = $uploadDir['baseurl'] . '/smack_inline_images';
			$wp_media_url = $uploadDir['baseurl'];

			$get_media_settings = get_option('uploads_use_yearmonth_folders');
			if ($get_media_settings == 1) {
				$dirname = date('Y') . '/' . date('m');
				$full_path = $uploadDir['basedir'] . '/' . $dirname;
				$baseurl = $uploadDir['baseurl'] . '/' . $dirname;
			} else {
				$full_path = $uploadDir['basedir'];
				$baseurl = $uploadDir['baseurl'];
			}

			$wp_media_path = $full_path;

			$inlineimageDirpath = $inlineimageDir . '/' . $eventKey;
			$imagelist = scanDirectories($inlineimageDirpath);
			if(empty($imagelist)) {
                               $noimage = WP_CONST_ULTIMATE_CSV_IMP_DIR . "images/noimage.png";
                                $oldWord = $shortcode;
                                $newWord = '<img src="' .$noimage . '" />';
                                $post_content = str_replace($oldWord , $newWord , $post_content);
                               $set_inline_img_status = $wpdb->update('wp_ultimate_csv_importer_manageshortcodes', array('populate_status' => 2), array('pID' => $postID, 'shortcode' => $shortcode, 'mode_of_code' => $shortcode_mode));
                               $default_image = 1; 
                       }else{
				$currentLoc = '';
                               foreach($imagelist as $imgwithloc) {
                                       if(strpos($imgwithloc, $get_inlineimage_val)){
                                               $currentLoc = $imgwithloc;
					}
                               }
                               $exploded_currentLoc = explode("$eventKey", $currentLoc);
                               if(!empty($exploded_currentLoc))
                                        $inlimg_curr_loc = isset($exploded_currentLoc[1]) ? $exploded_currentLoc[1] : '';
					$inlineimageURL = $inlineimageURL . '/' . $eventKey . $inlimg_curr_loc;
					$impObj = new WPUltimateCSVImporter();
					$impObj->get_images_from_URL($inlineimageURL, $wp_media_path, $get_inlineimage_val, '');
					$wp_media_path = $wp_media_path . "/" . $get_inlineimage_val;

#		copy("$currentLoc", "$wp_media_path");

				if (@getimagesize($wp_media_path)) {
					$img = wp_get_image_editor($wp_media_path);
					if (!is_wp_error($img)) {
						$sizes_array = array(
								// #1 - resizes to 1024x768 pixel, square-cropped image
								array('width' => 1024, 'height' => 768, 'crop' => true),
								// #2 - resizes to 100px max width/height, non-cropped image
								array('width' => 100, 'height' => 100, 'crop' => false),
								// #3 - resizes to 100 pixel max height, non-cropped image
								array('width' => 300, 'height' => 100, 'crop' => false),
								// #3 - resizes to 624x468 pixel max width, non-cropped image
								array('width' => 624, 'height' => 468, 'crop' => false)
								);
						$resize = $img->multi_resize($sizes_array);
					}
					$inline_file ['guid'] = $baseurl . "/" . $get_inlineimage_val;
					$inline_file ['post_title'] = $get_inlineimage_val;
					$inline_file ['post_content'] = '';
					$inline_file ['post_status'] = 'attachment';
					$wp_upload_dir = wp_upload_dir();
					$attachment = array('guid' => $inline_file ['guid'], 'post_mime_type' => 'image/jpeg', 'post_title' => preg_replace('/\.[^.]+$/', '', @basename($inline_file ['guid'])), 'post_content' => '', 'post_status' => 'inherit');
					if ($get_media_settings == 1) {
						$generate_attachment = $dirname . '/' . $get_inlineimage_val;
					} else {
						$generate_attachment = $get_inlineimage_val;
					}
					$uploadedImage = $wp_upload_dir['path'] . '/' . $get_inlineimage_val;
					$real_image_name = $attachment['post_title'];
                                       //duplicate check for media
                                       global $wpdb;
                                       $existing_attachment = array();
                                       $query = $wpdb->get_results("select post_title from $wpdb->posts where post_type = 'attachment' and post_mime_type = 'image/jpeg'");
                                       foreach($query as $key){
                                               $existing_attachment[] = $key->post_title;
                                       }
                                       //duplicate check for media     
				       
                                       if($shortcode_mode == 'inline' && !in_array($attachment['post_title'] ,$existing_attachment)){
						$attach_id = wp_insert_attachment($attachment, $generate_attachment, $postID);	
						$attach_data = wp_generate_attachment_metadata($attach_id, $uploadedImage);
						wp_update_attachment_metadata($attach_id, $attach_data);
						set_post_thumbnail($postID, $attach_id);
				       }
				       if($shortcode_mode == 'Featured' && !in_array($attachment['post_title'] ,$existing_attachment)){
						$attach_id = wp_insert_attachment($attachment, $generate_attachment, $postID);
                                                $attach_data = wp_generate_attachment_metadata($attach_id, $uploadedImage);
                                                wp_update_attachment_metadata($attach_id, $attach_data);
                                                set_post_thumbnail($postID, $attach_id);
	
				       }
				       if($shortcode_mode == 'Featured' && in_array($attachment['post_title'] ,$existing_attachment)){    
						$query2 = $wpdb->get_results("select ID from $wpdb->posts where post_title = '$real_image_name' and post_type = 'attachment'");
						foreach($query2 as $key2){
						       $attach_id = $key2->ID;
						}
						set_post_thumbnail($postID, $attach_id);
					}
					if($shortcode_mode == 'Inline') {
						$oldWord = $shortcode;
					//	$newWord = '<img src="' . $inline_file['guid'] . '" />';
						$imgattr1 = isset($image_attribute[1]) ? $image_attribute[1] : '' ;
						$imgattr2 = isset($image_attribute[2]) ? $image_attribute[2] : '' ;
						$imgattr3 = isset($image_attribute[3]) ? $image_attribute[3] : '' ;
                                                $newWord = '<img src="' . $inline_file['guid'] . '" '.$imgattr1.' '.$imgattr2.' '.$imgattr3.' />';
						$post_content = str_replace($oldWord , $newWord , $post_content);
					}
					$default_image = 2;
					$set_inline_img_status = $wpdb->update('wp_ultimate_csv_importer_manageshortcodes', array('populate_status' => 0), array('pID' => $postID, 'shortcode' => $shortcode, 'mode_of_code' => $shortcode_mode));
					} else {
					$inline_file = false;
					}
				}
			}
		if($shortcode_mode == 'Inline') {
			$update_content['ID'] = $postID;
			$update_content['post_content'] = $post_content;
			wp_update_post($update_content);
		}
	}
}
// Set Shortcode Status in Relation Table
$get_replaced_ids = $wpdb->get_results("select count(*) as nonreplaced from wp_ultimate_csv_importer_manageshortcodes where eventkey = '{$eventKey}' and mode_of_code = '{$shortcode_mode}' and populate_status = 1");
$get_noimages_ids = $wpdb->get_results("select count(*) as nonreplaced from wp_ultimate_csv_importer_manageshortcodes where eventkey = '{$eventKey}' and mode_of_code = '{$shortcode_mode}' and populate_status = 2");
if( $default_image == 2 && $get_replaced_ids[0]->nonreplaced == 0) {
	$wpdb->update('wp_ultimate_csv_importer_shortcodes_statusrel', array('current_status' => 'Replaced'), array('id' => $rowID, 'eventkey' => $eventKey));
	echo '1';
} 
if($default_image == 2 && $get_replaced_ids[0]->nonreplaced != 0) {
	$wpdb->update('wp_ultimate_csv_importer_shortcodes_statusrel', array('current_status' => 'Partially'), array('id' => $rowID, 'eventkey' => $eventKey));
	echo '2';
}
if($default_image == 1 && $get_noimages_ids[0]->nonreplaced != 0){
       echo 'Images not available!';
}

function scanDirectories($rootDir, $allData=array()) {
	// set filenames invisible if you want
	$invisibleFileNames = array(".", "..", ".htaccess", ".htpasswd");
	// run through content of root directory
	if(!is_dir($rootDir))
                 return false;
	       $dirContent = scandir($rootDir);
         foreach($dirContent as $key => $content) {
		// filter all files not accessible
		$path = $rootDir.'/'.$content;
		if(!in_array($content, $invisibleFileNames)) {
			// if content is file & readable, add to array
			if(is_file($path) && is_readable($path)) {
				// save file name with path
				$allData[] = $path;
				// if content is a directory and readable, add path and name
			}elseif(is_dir($path) && is_readable($path)) {
				// recursive callback to open new directory
				$allData = scanDirectories($path, $allData);
			}
		}
	}
	return $allData;
}
?>
