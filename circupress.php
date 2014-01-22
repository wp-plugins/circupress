<?php
/*

Plugin Name: CircuPress
Plugin URI: http://www.circupress.com
Description: CircuPress is a subscription service offering email marketing, email reporting and automated daily and weekly digests directly from WordPress. CircuPress is fully compliant with email regulations and offers subscriber, bounce and campaign management directly from WordPress!
Version: 1.17
Author: Adam Small, Douglas Karr, Stephen Coley
Author URI: http://www.circupress.com/
License: GPL2

	Responsive email templates provided by Zurb:
	Link: http://zurb.com/playground/responsive-email-templates
	
	Conversion of Style tags to Inline by Emogrifier (Source code is distributed under the MIT License).
	Link: http://www.pelagodesign.com/sidecar/emogrifier/

	CircuPress Copyright 2013 Douglas Karr, Adam Small (email: info@circupress.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

require( 'config.php' );

add_action( 'init', 'wpcp_init' );
add_action( 'admin_init', 'wpcp_account_settings' );
add_action( 'admin_init', 'wpcp_email_editor_settings' );
add_action( 'admin_menu', 'wpcp_add_pages' );
add_action( 'admin_notices', 'wpcp_warning' );
add_filter( 'post_updated_messages', 'wpcp_codex_email_updated_messages' );
add_action( 'contextual_help', 'codex_add_help_text', 10, 3 );
add_action( 'admin_print_scripts', 'wpcp_admin_scripts' );
add_action( 'admin_print_styles', 'wpcp_admin_styles' );
add_action( 'admin_enqueue_scripts', 'wpcp_enqueue', 10, 1 );
add_action( 'publish_email', 'wpcp_schedule_email', 9, 2 );
add_filter( 'template_include','wpcp_include_template_function', 1 );
add_filter( 'gettext', 'wpcp_change_publish_button', 10, 2 );
add_filter( 'gettext', 'wpcp_change_published_on', 10, 2 );
add_filter( 'gettext', 'wpcp_change_publish_on', 10, 2 );
add_action( 'wp_ajax_wpcp_subscriber_optin', 'wpcp_subscriber_optin' );  
add_action( 'wp_ajax_nopriv_wpcp_subscriber_optin', 'wpcp_subscriber_optin' );  
add_action( 'admin_footer', 'wpcp_admin_footer_script' );
add_action( 'admin_print_footer_scripts', 'wpcp_pointer_scripts' );
add_action( 'wp_enqueue_scripts', 'wpcp_add_scripts' );
add_filter( 'init','wpcp_init_feed_daily' );
add_filter( 'init','wpcp_init_feed_weekly' );

// Email Columns
add_action( 'admin_head', 'wpcp_email_column_style');
add_filter( 'manage_email_posts_columns', 'wpcp_email_columns', 10 );
add_action( 'manage_edit-email_sortable_columns', 'wpcp_email_sortable_columns' );
add_action( 'manage_email_posts_custom_column', 'wpcp_email_columns_content', 10, 2 );
add_action( 'load-edit.php', 'wpcp_email_posts_load' );

function wpcp_email_posts_load(){
	add_filter( 'request', 'email_column_orderby' );
}

include( 'inc/circupress_widget.php' );

?>