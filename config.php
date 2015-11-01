<?php

if ( ! defined( 'WPCP_FILE' ) ) {
	define( 'WPCP_FILE', __FILE__ );
}

if ( ! defined( 'WPCP_PATH' ) ) {
	define( 'WPCP_PATH', plugin_dir_path( WPCP_FILE ) );
}

if ( ! defined( 'WPCP_BASENAME' ) ) {
	define( 'WPCP_BASENAME', plugin_basename( WPCP_FILE ) );
}

if ( ! defined( 'WPCP_PLUGIN' ) ) {
	define( 'WPCP_PLUGIN', plugin_dir_url( WPCP_FILE ) );
}


// Add Thickbox
add_thickbox();

// include Circupress API File
if ( file_exists( WPCP_PATH . '/lib/circupress_api.php' ) ) {
	include_once WPCP_PATH . '/lib/circupress_api.php';
}

// Require wpcp functions file
if ( file_exists( WPCP_PATH . '/inc/functions.php' ) ) {
	require WPCP_PATH . '/inc/functions.php';
}

// Include Wizard File
if ( file_exists( WPCP_PATH . '/inc/wizard.php' ) ) {
	include_once WPCP_PATH . '/inc/wizard.php';
}

// Enable localization
load_plugin_textdomain( 'wpcp', $path = 'wp-content/plugins/circupress' );

// Create Template Base Path
$upload_dir = wp_upload_dir();
$upload_directory = $upload_dir['basedir'];

// Set BASE Template Directory
define( 'WPCP_TEMPLATE_BASE', $upload_directory.'/circupress_templates' );

?>