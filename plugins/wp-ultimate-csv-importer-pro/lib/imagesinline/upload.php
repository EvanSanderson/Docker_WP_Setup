<?php
//print_r($_FILES); die('sss');
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly
global $detail_image;
global $wpdb;
$uploadDir = wp_upload_dir();
	if(isset($_FILES['file'])){
    if ( 0 < $_FILES['file']['error'] ) {
		if($_FILES['file']['error'] == 1 || $_FILES['file']['error'] == 2) {
			echo 'Uploaded file size exceeds the MAX Size in php.ini';
		} else {
			echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		}
    }
    else {
	    if(isset($_FILES['file']['name']))
	    {	
		$uploaded_compressedFile = '';
		$uploaded_compressedFile = $_FILES['file']['tmp_name'];
                $get_basename_zipfile = explode('.', $_FILES['file']['name']);
                $basename_zipfile = $get_basename_zipfile[0];
		if (!is_dir($uploadDir['basedir'] . '/smack_inline_images')) {
			wp_mkdir_p($uploadDir['basedir'] . '/smack_inline_images');
		}
		$eventkey = $_REQUEST['eventKey'];
	        $location_to_extract = $uploadDir['basedir'] . '/smack_inline_images/' . $eventkey;
                $extracted_image_location = $uploadDir['baseurl'] . '/smack_inline_images/' . $eventkey;
                $zip = new ZipArchive;
                if ($zip->open($uploaded_compressedFile) === TRUE) {
                        $zip->extractTo($location_to_extract);
                        $zip->close();
                        $extracted_status = 1;
                } else {
                        $extracted_status = 0;
                }
		$detail_image['extractlocation'] = $extracted_image_location;
		$detail_image['zipname']  = $_FILES['file']['name'];
		$detail_image['tmpname'] = $uploaded_compressedFile;
	   }
        //move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
    }
}
?>
