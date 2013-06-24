<?php
/*
 * Plugin Name: Google Picker library
 * Plugin URI: http://wordpress.lowtone.nl/libs/google-picker
 * Plugin Type: lib
 * Description: Library for Google Picker.
 * Version: 1.0
 * Author: Lowtone <info@lowtone.nl>
 * Author URI: http://lowtone.nl
 * License: http://wordpress.lowtone.nl/license
 */

namespace lowtone\google\picker {

	use lowtone\content\packages\Package;

	// Includes
	
	if (!include_once WP_PLUGIN_DIR . "/lowtone-content/lowtone-content.php") 
		return trigger_error("Lowtone Content plugin is required", E_USER_ERROR) && false;

	Package::init(array(
			Package::INIT_PACKAGES => array("lowtone"),
			Package::INIT_MERGED_PATH => __NAMESPACE__,
			Package::INIT_SUCCESS => function() {

				// Load text domain
				
				if (!is_textdomain_loaded("lowtone_google_picker"))
					load_textdomain("lowtone_google_picker", __DIR__ . "/assets/languages/" . get_locale() . ".mo");

			}
		));

}