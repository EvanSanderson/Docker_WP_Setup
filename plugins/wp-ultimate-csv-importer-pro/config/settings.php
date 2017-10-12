<?php
/******************************************************************************************
 * Copyright (C) Smackcoders 2014 - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
if ( ! defined( 'ABSPATH' ) )
        exit; // Exit if accessed directly

class SkinnySettings {
	public static $CONFIG = array(

		"project name" => WP_CONST_ULTIMATE_CSV_IMP_NAME, "debug" => false, "preload model" => true, //true = all model classes will be loaded with each request;

		"session persistency" => false, //tmp in your project dir must be writeable by the server!
		"session timeout" => 1800, //in seconds!

		"unauthenticated default module" => "default", //set this to where you want unauthenticated users redirected.
		"unauthenticated default action" => "index",
	);
}
    
