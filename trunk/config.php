<?php

// include Circupress API File
include_once( 'lib/circupress_api.php' );

// include CSS to Inline File
include_once( 'lib/emogrifier.php' );

// Require wpcp functions file
require( 'inc/functions.php' );

// Enable localization 
load_plugin_textdomain( 'wpcp', $path = 'wp-content/plugins/circupress' );

// Create Easy to use URL for Plugin Directory
define ( 'WPCP_PLUGIN_URL', plugin_dir_url(__FILE__)); // with forward slash (/).

// Create Plugin Base Path
define ( 'WPCP_PLUGIN_BASE', str_replace( 'circupress/', '', plugin_dir_path( __FILE__ ) ) ); // contains the trailing slash (/)

// Create Template Base Path
$upload_dir = wp_upload_dir();
$upload_directory = $upload_dir['basedir']; 
	
// Set BASE Template Directory
define( 'WPCP_TEMPLATE_BASE', $upload_directory.'/circupress_templates' );

?>
