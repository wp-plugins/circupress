<?php 

/**
 * WPCP Init
 */
 
function wpcp_init() {
	// Check to see if Templates Directory Exists. If Not Create it and copy default templates into it.
	wpcp_make_template_dir();

	// Adds the email post type to wordpress
	wpcp_create_email_post_type();
	
}

function wpcp_add_scripts() {
	wp_enqueue_script(
		'circupress',
		WP_PLUGIN_URL . '/circupress/js/circupress.js',
		array( 'jquery' )
	);
}

/*
 * Displays a notice on wp-admin to authenticate the Circupress plugin
 */
function wpcp_warning() {
	$options = get_option('circupress-account'); 
	if($options['wpcp_apikey'] =='') {
		echo "<div id='wpcp-warning' class='error fade'><p><strong>";
		echo __('Circupress is almost ready.');
		echo "</strong> ";
		echo sprintf(__('You must <a href="%1$s">enter your API Key</a> for it to work.'), "edit.php?post_type=email&page=circupress-account");
		echo "</p></div>";
	}
}

/**
 * Create custom post type: email
 */
function wpcp_create_email_post_type() {
  $labels = array(
    'name' => _x('Emails', 'post type general name'),
    'singular_name' => _x('Email', 'post type singular name'),
    'add_new' => _x('Add New', 'email'),
    'add_new_item' => __('Add New Email'),
    'edit_item' => __('Edit Email'),
    'new_item' => __('New Email'),
    'all_items' => __('All Emails'),
    'view_item' => __('View Email'),
    'search_items' => __('Search Emails'),
    'not_found' =>  __('No emails found'),
    'not_found_in_trash' => __('No emails found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'CircuPress'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    //'register_meta_box_cb' => 'add_events_metaboxes', To be used later
    'supports' => array('title','editor','author')
  ); 
  register_post_type('email',$args);
}


// Styling for the custom post type icon
add_action( 'admin_head', 'wpcp_circupress_icons' );


function wpcp_circupress_icons() {
    ?>
    <style type="text/css" media="screen">
    #menu-posts-email .wp-menu-image {
            background: url(<?php echo WP_PLUGIN_URL . '/circupress/images/wpcp-16.png'; ?>) no-repeat -1px -35px !important;
        }
	#menu-posts-email:hover .wp-menu-image, #menu-posts-email.wp-has-current-submenu .wp-menu-image {
            background-position: -1px -3px !important;
        }
	#icon-edit.icon32-posts-email {background: url(<?php echo WP_PLUGIN_URL . '/circupress/images/circupress-32.png'; ?>) no-repeat;}
	div.wrap { margin-right: 5%; }
	span.success { background: url(<?php echo WP_PLUGIN_URL . '/circupress/images/success.png'; ?>) no-repeat 0 0 !important; padding: 0 0 0 18px; margin-left: 4px; }
	span.error { background: url(<?php echo WP_PLUGIN_URL . '/circupress/images/error.png'; ?>) no-repeat 0 0 !important; padding: 0 0 0 18px; margin-left: 4px; }
	span.alert { background: url(<?php echo WP_PLUGIN_URL . '/circupress/images/alert.png'; ?>) no-repeat 0 0 !important; padding: 0 0 0 18px; margin-left: 4px; }
	span.notice { background: url(<?php echo WP_PLUGIN_URL . '/circupress/images/notice.png'; ?>) no-repeat 0 0 !important; padding: 0 0 0 18px; margin-left: 4px; }
	#tabs ul li { list-style: none; display: inline; }
	#tabs ul li a { border: 1px solid #d3e4ef; padding: 5px 8px 8px 8px; text-decoration: none; }
	#tabs ul li.ui-tabs-active a { font-weight: bold; border-bottom: none; }
	.supportpage { width: 100%; }
	.supportpage p { margin-left: 10px; }
	.supportpage ul, .supportpage ol { margin-left: 20px; }
    </style>
<?php }



/**
 * Notice messages
 *
 * Add filter to ensure the text Email, or email, is displayed when user updates a email 
 */
function wpcp_codex_email_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['email'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Email updated. <a href="%s">View email</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Email updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Email restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Email published. <a href="%s">View email</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Email saved.'),
    8 => sprintf( __('Email submitted. <a target="_blank" href="%s">Preview email</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Email scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview email</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Email draft updated. <a target="_blank" href="%s">Preview email</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}


/**
 * Display contextual help for Emails
 */
function codex_add_help_text($contextual_help, $screen_id, $screen) { 
  //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
  if ('email' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a email:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct writer of the email..') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the email review to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://www.marketingtechblog.com" target="_blank">Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://www.marketingtechblog.com" target="_blank">Support</a>') . '</p>' ;
  } elseif ( 'edit-email' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of emails.') . '</p>' ;
  }
  return $contextual_help;
}


/**
 * Add Circupress submenus
 */
function wpcp_add_pages() {
	// Add a Submenu for CircuPress Subscriber Data
	
	$wpcp_subscribers_page = add_submenu_page('edit.php?post_type=email', 'Subscribers', 'Subscribers', 'manage_options', 'circupress-subscribers', 'my_circupress_subscribers' );
	add_action( 'admin_footer-'. $wpcp_subscribers_page, 'wpcp_admin_footer' );
	
	function my_circupress_subscribers() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		include('subscribers.php');
	}
	
	
	// Add a Submenu for CircuPress Options
	$wpcp_accounts_page = add_submenu_page('edit.php?post_type=email', 'Account', 'Account', 'manage_options', 'circupress-account', 'my_circupress_account' );
	add_action( 'admin_footer-'. $wpcp_accounts_page, 'wpcp_admin_footer' );
	
	function my_circupress_account() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		include('account.php');
	}
	
	// Add a Submenu for CircuPress Support
	$wpcp_support_page = add_submenu_page('edit.php?post_type=email', 'Support', 'Support', 'manage_options', 'circupress-support', 'my_circupress_support' );
	add_action( 'admin_footer-'. $wpcp_support_page, 'wpcp_admin_footer' );
	
	function my_circupress_support() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		include('support.php');
	}

	// Add a Submenu for CircuPress Email Template
	$wpcp_editor_page = add_submenu_page('edit.php?post_type=email', 'Editor', 'Editor', 'manage_options', 'circupress-template', 'my_circupress_template' );
	add_action( 'admin_footer-'. $wpcp_editor_page, 'wpcp_admin_footer' );

	function my_circupress_template() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		include('circupress_editor.php');
	}

	// Add a Submenu for viewing CicuPress Email Template
	$wpcp_template_preview_page = add_submenu_page(null, 'Template Preview', 'Template Preview', 'manage_options', 'circupress-template-preview', 'my_circupress_template_preview_page' );
	add_action( 'admin_footer-'. $wpcp_editor_page, 'wpcp_admin_footer' );
	
	function my_circupress_template_preview_page() {
		if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		include('circupress_template_view.php');
	}
	
}

/**
 * Functions for the Email Editor settings page
 */
function wpcp_email_editor_settings() {

	if(false == get_option('circupress-email-editor')) {    
		add_option('circupress-email-editor');
	}

	add_settings_section(  
		 'wpcp_email_editor_settings_section',         // ID used to identify this section and with which to register options  
		 '',                  // Title to be displayed on the administration page  
		 'wpcp_settings_desc_callback', // Callback used to render the description of the section  
		 'circupress-email-editor'     // Page on which to add this section of options  
	);

	add_settings_field(   
		'wpcp_email_header',                      // ID used to identify the field throughout the theme 
		'Header Image:',                           // The label to the left of the option interface element 
		'wpcp_email_header_callback',   // The name of the function responsible for rendering the option interface 
		'circupress-email-editor',    // The page on which this option will be displayed 
		'wpcp_email_editor_settings_section',         // The name of the section to which this field belongs 
		array('') 
	);
	
	register_setting('circupress-email-editor', 'circupress-email-editor');
}

function wpcp_email_template_callback($args) { 
	$options = get_option('circupress-account'); 
	$wpcp_email_template = $options['wpcp_email_template'];
	$wpcp_template_id = "circupress-account[wpcp_email_template]";
	echo wpcp_build_template_select($wpcp_template_id, $wpcp_email_template);
	if( $wpcp_email_template == '0' ){
		wpcp_notifications( 'alert', 'You have not selected a template for your Emails.' );
	}
}

function wpcp_daily_template_callback($args) {	 
	$options = get_option('circupress-account'); 
	$wpcp_daily_template = $options['wpcp_daily_template'];
	$wpcp_template_id = "circupress-account[wpcp_daily_template]";
	echo wpcp_build_template_select($wpcp_template_id, $wpcp_daily_template);	
	if( $wpcp_daily_template == '0' ){
		wpcp_notifications( 'alert', 'You are not sending Daily Digest Emails' );
	}
}

function wpcp_daily_template_subject_callback($args) {	 
	$options = get_option('circupress-account'); 
	$wpcp_daily_subject = $options['wpcp_daily_subject'];
	
	$html = '<input type="text" id="circupress-account[wpcp_daily_subject]" name="circupress-account[wpcp_daily_subject]"  value="'.stripslashes($wpcp_daily_subject).'" />';	
	$html .= '<label for="wpcp_daily_subject"> '  . $args[0] . '</label>';  
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_daily_subject'])) < 1) {
		echo wpcp_notifications("error","You must provide a subject for the Daily Digest.");
	} else { 
		echo wpcp_notifications("success",""); 
	}

}

function wpcp_weekly_template_subject_callback($args) {	 
	$options = get_option('circupress-account'); 
	$wpcp_weekly_subject = $options['wpcp_weekly_subject'];
	
	$html = '<input type="text" id="circupress-account[wpcp_weekly_subject]" name="circupress-account[wpcp_weekly_subject]"  value="'.stripslashes($wpcp_weekly_subject).'" />';	
	$html .= '<label for="wpcp_weekly_subject"> '  . $args[0] . '</label>';  
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_weekly_subject'])) < 1) {
		echo wpcp_notifications("error","You must provide a subject for the Weekly Digest.");
	} else { 
		echo wpcp_notifications("success",""); 
	}

}

function wpcp_weekly_template_callback($args) { 
	$options = get_option('circupress-account'); 
	$wpcp_weekly_template = $options['wpcp_weekly_template'];
	$wpcp_template_id = "circupress-account[wpcp_weekly_template]";
	echo wpcp_build_template_select($wpcp_template_id, $wpcp_weekly_template);	
	if( $wpcp_weekly_template == '0' ){
		wpcp_notifications( 'alert', 'You are not sending Weekly Digest Emails' );
	}
}

function wpcp_get_template_files() {
	$dir = WPCP_TEMPLATE_BASE.'/';
	$files = array();
	
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
				
			while (($file = readdir($dh)) !== false ) {
				
				if($file != '.' && $file != '..'){
		
					$file_handle = fopen($dir.$file, "r") or exit("Unable to open file!");
					while (!feof($file_handle)) {	
						$line = fgets($file_handle);
						if( substr($line, 0, 20) == 'CircuPress Template:'){
							$name = substr($line, 21);
							$files[$name] = $file;
						}
					}
					fclose($file_handle);
				}
			}
			closedir($dh);
		}
	}
	return $files;
}

function wpcp_build_template_select($wpcp_template_id, $wpcp_selected_template) {
	$dir = WPCP_TEMPLATE_BASE.'/';
	$html = '';
	
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
					
			$select .= '<select id="'.$wpcp_template_id.'" name="'.$wpcp_template_id.'" >';
			
			$select .=  '<option value="0">Do Not Send</option>';
				
			while (($file = readdir($dh)) !== false ) {
				
				if($file != '.' && $file != '..'){
					
					$file_handle = fopen($dir.$file, "r") or exit("Unable to open file!");
					while (!feof($file_handle)) {
									
						$line = fgets($file_handle);
						if( substr($line, 0, 20) == 'CircuPress Template:'){
							$select .= '<option value="'.$file.'"';
							if( $file == $wpcp_selected_template ){
								$select .= ' selected="selected" ';
							}
							$select .= '>'.substr($line, 21).'</option>';
						}
					}
					fclose($file_handle);
				}
			}
			closedir($dh);
			$select .= '</select>';
		}
	}
	return $select;
}

function wpcp_email_header_callback($args) {
	$options = get_option('circupress-email-editor');
	$wpcp_email_header = $options['wpcp_email_header'];

	$html = '<input type="text" id="circupress-email-editor[wpcp_email_header]" name="circupress-email-editor[wpcp_email_header]" value="' . $wpcp_email_header . '" size="30" />';
	$html .= '<input type="button" class="cp_upload button" value="' . __("Upload Header", 'wpcp') . '" />';
	echo $html;
}

function wpcp_output_checked($saved, $option) {
	if($saved == $option) {
		return ' checked="checked" ';
	}
}

function wpcp_weekly_schedule_callback($args) {
	$options = get_option('circupress-account');
	$wpcp_email_schedule = $options['wpcp_email_schedule']; 
	
	$html = '<select name="circupress-account[wpcp_email_schedule]">';
	
	$days = array(
                1 => 'Monday',
                2 => 'Tuesday',
                3 => 'Wednesday',
                4 => 'Thursday',
                5 => 'Friday',
                6 => 'Saturday',
                0 => 'Sunday');
                
    for ($i = 0; $i <= 6; $i++) {
                $html .= '<option value="'.$i.'"';
                if ($i == $wpcp_email_schedule) { $html.= ' selected'; }
				$html .= '>'.$days[$i].'</option>';
        }
	$html .= '</select>';
	$html .= '</td></tr></table>';
	echo $html;
	
}


/**
 * Functions for the Account settings page
 */

function wpcp_account_settings() {

	if(false == get_option('circupress-account')) {    
		add_option('circupress-account');
	}

	add_settings_section(  
		 'wpcp_settings_section',			// ID used to identify this section and with which to register options  
		 'CircuPress Account Settings',     // Title to be displayed on the administration page  
		 'wpcp_settings_desc_callback', 	// Callback used to render the description of the section  
		 'circupress-account'     			// Page on which to add this section of options  
	);
	
	$options = get_option('circupress-account');
	$wpcp_apikey = stripslashes($options['wpcp_apikey']);
	$wpcp_api_validate = json_decode( wpcp_validate_api( $wpcp_apikey ), true );
	if( $wpcp_api_validate['id'] == 0 ) {
	
	add_settings_section(  
		 'wpcp_settings_email_section',		// ID used to identify this section and with which to register options  
		 'CircuPress Email Settings',     	// Title to be displayed on the administration page  
		 'wpcp_settings_email_callback', 	// Callback used to render the description of the section  
		 'circupress-account'     			// Page on which to add this section of options  
	);
	
	add_settings_section(  
		 'wpcp_settings_schedule_section',		// ID used to identify this section and with which to register options  
		 'Templates and Scheduling',     	// Title to be displayed on the administration page  
		 'wpcp_settings_schedule_callback', 	// Callback used to render the description of the section  
		 'circupress-account'     			// Page on which to add this section of options  
	);
	
	add_settings_section(  
		 'wpcp_settings_social_section',		// ID used to identify this section and with which to register options  
		 'Social Media Settings',     	// Title to be displayed on the administration page  
		 'wpcp_settings_social_callback', 	// Callback used to render the description of the section  
		 'circupress-account'     			// Page on which to add this section of options  
	);
	
	}

	add_settings_field(   
		'wpcp_apikey',                      // ID used to identify the field throughout the theme 
		'API Key:',              			// The label to the left of the option interface element 
		'wpcp_apikey_callback',   			// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	
	if( $wpcp_api_validate['id'] == 0 ) {
	
	add_settings_field(   
		'wpcp_email_template',  			// ID used to identify the field throughout the theme 
		'Email Template:',                  // The label to the left of the option interface element 
		'wpcp_email_template_callback',   	// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_schedule_section',         	// The name of the section to which this field belongs 
		array('') 
	); 
	
	add_settings_field(   
		'wpcp_daily_template',      		// ID used to identify the field throughout the theme 
		'Daily Digest Template:',       	// The label to the left of the option interface element 
		'wpcp_daily_template_callback',   	// The name of the function responsible for rendering the option interface 
		'circupress-account', 				// The page on which this option will be displayed 
		'wpcp_settings_schedule_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	$wpcp_daily_template = $options['wpcp_daily_template'];
	if( $wpcp_daily_template  != '0' ){
		add_settings_field(    
			'wpcp_daily_subject',      		// ID used to identify the field throughout the theme 
			'Daily Digest Subject:',       	// The label to the left of the option interface element 
			'wpcp_daily_template_subject_callback',   	// The name of the function responsible for rendering the option interface 
			'circupress-account', 				// The page on which this option will be displayed 
			'wpcp_settings_schedule_section',         	// The name of the section to which this field belongs 
			array('') 
		);
	}
		
	add_settings_field(   
		'wpcp_weekly_template',             // ID used to identify the field throughout the theme 
		'Weekly Digest Template:',      	// The label to the left of the option interface element 
		'wpcp_weekly_template_callback',   	// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_schedule_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	
	$wpcp_weekly_template = $options['wpcp_weekly_template'];
	if( $wpcp_weekly_template != '0' ) {
		
		add_settings_field(   
			'wpcp_weekly_subject',      		// ID used to identify the field throughout the theme 
			'Weekly Digest Subject:',       	// The label to the left of the option interface element 
			'wpcp_weekly_template_subject_callback',   	// The name of the function responsible for rendering the option interface 
			'circupress-account', 				// The page on which this option will be displayed 
			'wpcp_settings_schedule_section',         	// The name of the section to which this field belongs 
			array('') 
		);
	
		add_settings_field(   
			'wpcp_email_schedule',     			// ID used to identify the field throughout the theme 
			'Send my weekly email on:',   		// The label to the left of the option interface element 
			'wpcp_weekly_schedule_callback',   	// The name of the function responsible for rendering the option interface 
			'circupress-account',    			// The page on which this option will be displayed 
			'wpcp_settings_schedule_section',         	// The name of the section to which this field belongs 
			array('') 
		);
	
	}

	add_settings_field(   
		'wpcp_email_from_name',             // ID used to identify the field throughout the theme 
		'From Name:',              			// The label to the left of the option interface element 
		'wpcp_email_from_name_callback',   	// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',      // The name of the section to which this field belongs 
		array('') 
	);

	add_settings_field(   
		'wpcp_email_from_email',            // ID used to identify the field throughout the theme 
		'From Email Address:',              // The label to the left of the option interface element 
		'wpcp_email_from_email_callback',   // The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',      // The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_email_company_name',              	// ID used to identify the field throughout the theme 
		'Name or Company:',              	// The label to the left of the option interface element 
		'wpcp_email_company_name_callback',   		// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',      // The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_email_street',              		// ID used to identify the field throughout the theme 
		'Street Address:',              	// The label to the left of the option interface element 
		'wpcp_email_street_callback',   			// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',      // The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_email_city',              // ID used to identify the field throughout the theme 
		'City:',              				// The label to the left of the option interface element 
		'wpcp_email_city_callback',   	// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',      // The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_email_province',              // ID used to identify the field throughout the theme 
		'State or Province:',              	// The label to the left of the option interface element 
		'wpcp_email_province_callback',   			// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',         	// The name of the section to which this field belongs 
		array('') 
	);

	add_settings_field(   
		'wpcp_email_postal_code',              // ID used to identify the field throughout the theme 
		'Postal Code:',              	// The label to the left of the option interface element 
		'wpcp_email_postal_code_callback',   			// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',         	// The name of the section to which this field belongs 
		array('') 
	);

	add_settings_field(   
		'wpcp_email_phone_number',              // ID used to identify the field throughout the theme 
		'Phone Number:',              	// The label to the left of the option interface element 
		'wpcp_email_phone_number_callback',   			// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_email_canspam',              // ID used to identify the field throughout the theme 
		'CAN-SPAM:',              	// The label to the left of the option interface element 
		'wpcp_email_canspam_callback',   			// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_email_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_social_fb',             // ID used to identify the field throughout the theme 
		'Facebook Page URL:',      	// The label to the left of the option interface element 
		'wpcp_social_fb',   	// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_social_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_social_twitter',             // ID used to identify the field throughout the theme 
		'Twitter Page URL:',      	// The label to the left of the option interface element 
		'wpcp_social_twitter',   	// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_social_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	
	add_settings_field(   
		'wpcp_social_google_plus',             // ID used to identify the field throughout the theme 
		'Google Plus Page URL:',      	// The label to the left of the option interface element 
		'wpcp_social_google_plus',   	// The name of the function responsible for rendering the option interface 
		'circupress-account',    			// The page on which this option will be displayed 
		'wpcp_settings_social_section',         	// The name of the section to which this field belongs 
		array('') 
	);
	
	}
	
	register_setting('circupress-account', 'circupress-account');
}

function wpcp_apikey_callback($args) { 
	$options = get_option('circupress-account');
	$wpcp_apikey = stripslashes($options['wpcp_apikey']);
	$wpcp_api_validate = json_decode( wpcp_validate_api( $wpcp_apikey ), true );
	
	$html = '<input type="text" id="circupress-account[wpcp_apikey]" name="circupress-account[wpcp_apikey]" value="'.$wpcp_apikey.'" />';
	$html .= '<label for="wpcp_apikey"> '  . $args[0] . '</label>'; 	 
	echo $html; 
	
	if( $wpcp_api_validate['id'] == 0 ) { 
		echo wpcp_notifications("success",""); 
	} else { 
		echo wpcp_notifications("error","Invalid API Key"); 
	}
}

function wpcp_email_from_name_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_from_name]" name="circupress-account[wpcp_email_from_name]"  value="'.stripslashes($options['wpcp_email_from_name']).'" />';	
	$html .= '<label for="wpcp_email_from_name"> '  . $args[0] . '</label>';  
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_email_from_name']))<1) {
		echo wpcp_notifications("error","You must provide a full name.");
	} else { 
		echo wpcp_notifications("success",""); 
	}
	
	$lists = json_decode( wpcp_get_lists( stripslashes($options['wpcp_apikey']) ), true );
									
	if( isset( $lists['id'] ) and $lists['id'] == '401' ){
										
		echo '<tr><td colspan="7"><h3>'.$lists['description'].'</h3></td></tr>';
										
	} else {
	
		$list_id = $lists[0]['list_id'];	
		$list_name = $lists[0]['list_name'];						
			
	}
	
	wpcp_update_list( stripslashes($options['wpcp_apikey']), $list_name, stripslashes($options['wpcp_email_canspam']), stripslashes($options['wpcp_email_street']), stripslashes($options['wpcp_email_city']), stripslashes($options['wpcp_email_province']), stripslashes($options['wpcp_email_postal_code']), stripslashes($options['wpcp_email_phone_number']), stripslashes($options['wpcp_email_company_name']), stripslashes($options['wpcp_email_from_name']), stripslashes($options['wpcp_email_from_email']), $list_id, '1');
	
}

function wpcp_email_from_email_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_from_email]" name="circupress-account[wpcp_email_from_email]"  value="'.stripslashes($options['wpcp_email_from_email']).'" />';
	$html .= '<label for="wpcp_email_from_email"> '  . $args[0] . '</label>';  
	echo $html; 
	
	if(!wpcp_checkemail(stripslashes($options['wpcp_email_from_email']))) {
		echo wpcp_notifications("error", "You must provide a valid return email address.");
	} else { 
		echo wpcp_notifications("success",""); 
	}
}

function wpcp_email_company_name_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_company_name]" name="circupress-account[wpcp_email_company_name]"  value="'.stripslashes($options['wpcp_email_company_name']).'" />';	
	$html .= '<label for="wpcp_email_company_name_callback"> '  . $args[0] . '</label>';  
	echo $html; 
}

function wpcp_email_street_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_street]" name="circupress-account[wpcp_email_street]"  value="'.stripslashes($options['wpcp_email_street']).'" />';	
	$html .= '<label for="wpcp_email_street"> '  . $args[0] . '</label>';
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_email_street']))<1) {
		echo wpcp_notifications("error","You must provide a valid street address.");
	} else { 
		echo wpcp_notifications("success",""); 
	}
}

function wpcp_email_city_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_city]" name="circupress-account[wpcp_email_city]"  value="'.stripslashes($options['wpcp_email_city']).'" />';	
	$html .= '<label for="wpcp_email_city"> '  . $args[0] . '</label>'; 
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_email_city']))<1) {
		echo wpcp_notifications("error","You must provide a valid city.");
	} else { 
		echo wpcp_notifications("success",""); 
	} 
}

function wpcp_email_province_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_province]" name="circupress-account[wpcp_email_province]"  value="'.stripslashes($options['wpcp_email_province']).'" />';	
	$html .= '<label for="wpcp_email_province"> '  . $args[0] . '</label>';  
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_email_province']))<1) {
		echo wpcp_notifications("error","You must provide a valid state or province.");
	} else { 
		echo wpcp_notifications("success",""); 
	}
}

function wpcp_email_postal_code_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_postal_code]" name="circupress-account[wpcp_email_postal_code]"  value="'.stripslashes($options['wpcp_email_postal_code']).'" />';
	$html .= '<label for="wpcp_email_postal_code"> '  . $args[0] . '</label>'; 
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_email_postal_code']))<1) {
		echo wpcp_notifications("error","You must provide a valid zip or postal code.");
	} else { 
		echo wpcp_notifications("success",""); 
	} 
}

function wpcp_email_phone_number_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_phone_number]" name="circupress-account[wpcp_email_phone_number]"  value="'.stripslashes($options['wpcp_email_phone_number']).'" />';	
	$html .= '<label for="wpcp_email_phone_number"> '  . $args[0] . '</label>'; 
	echo $html; 
}

function wpcp_email_canspam_callback($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_email_canspam]" name="circupress-account[wpcp_email_canspam]"  value="'.stripslashes($options['wpcp_email_canspam']).'" />';	
	$html .= '<label for="wpcp_canspam"> '  . $args[0] . '</label>'; 
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_email_canspam']))<1) {
		echo wpcp_notifications("error","You must provide an explanation of how the subscriber joined your email marketing list.");
	} else { 
		echo wpcp_notifications("success",""); 
	}
}

function wpcp_settings_desc_callback(){
	echo "<p>When you successfully sign up for <a href=\"http://www.circupress.com/admin\" target=\"_blank\">CircuPress</a>, we provide you with this API Key to begin sending emails!</p>";
}

function wpcp_settings_schedule_callback($args) { 
	echo "<p>Select the templates you wish to use and when you would like to send daily and weekly digests automatically.</p>";
}

function wpcp_settings_social_callback($args) { 
	echo "<p>These settings will be merged into your emails if your template accomodates them.</p>";
}

function wpcp_settings_email_callback($args) { 
	echo "<p>These settings are required in order to send emails in accordance with national and international email marketing regulations.</p>";
}

function wpcp_checkemail($email) {
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		return false;
  	} else {
  		return true;
  	}
}
 
function wpcp_social_fb($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_social_fb]" name="circupress-account[wpcp_social_fb]"  value="'.stripslashes($options['wpcp_social_fb']).'" />';	
	$html .= '<label for="wpcp_social_fb"> '  . $args[0] . '</label>'; 
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_social_fb']))<1) {
		
	} else { 
		echo wpcp_notifications("success",""); 
	}
}

function wpcp_social_twitter($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_social_fb]" name="circupress-account[wpcp_social_twitter]"  value="'.stripslashes($options['wpcp_social_twitter']).'" />';	
	$html .= '<label for="wpcp_social_twitter"> '  . $args[0] . '</label>'; 
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_social_twitter']))<1) {
		
	} else { 
		echo wpcp_notifications("success",""); 
	}
}

function wpcp_social_google_plus($args) { 
	$options = get_option('circupress-account'); 
	$html = '<input type="text" id="circupress-account[wpcp_social_google_plus]" name="circupress-account[wpcp_social_google_plus]"  value="'.stripslashes($options['wpcp_social_google_plus']).'" />';	
	$html .= '<label for="wpcp_social_google_plus"> '  . $args[0] . '</label>'; 
	echo $html; 
	
	if(strlen(stripslashes($options['wpcp_social_google_plus']))<1) {
		
	} else { 
		echo wpcp_notifications("success",""); 
	}
}

// End Account settings functions



/**
 * Start enqueue functions
 */
function wpcp_enqueue() {
	wp_enqueue_script('jquery');
}

function wpcp_admin_scripts() {
	if (isset($_GET['page']) ) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('wpcp-upload', WPCP_PLUGIN_URL.'js/cp.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('wpcp-upload');
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );
	}
}

function wpcp_admin_styles() {
	if (isset($_GET['page']) ) {
		wp_enqueue_style('thickbox');
	}
}

/**
 * Start wpcp functions
 */

function wpcp_meta_add_update( $wpcp_post_id, $wpcp_meta_name, $wpcp_meta_value ){
			
	// Add Meta Data to the Post
	add_post_meta( $wpcp_post_id, $wpcp_meta_name, $wpcp_meta_value, true ) || update_post_meta( $wpcp_post_id, $wpcp_meta_name, $wpcp_meta_value  );

}

function wpcp_admin_tabs( $current = 'customize' ) {
    $tabs = array( 'customize' => 'Customize', 'edit' => 'Edit', 'preview' => 'Preview' );
	
	if( isset( $_GET['file'] ) ){
		$file = "&file=".$_GET['file'];
	} else {
		$file = '';
	}
	
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='edit.php?post_type=email&page=circupress-template&tab=$tab$file'>$name</a>";	

    }
    echo '</h2>';
}

function wpcp_include_template_function($template_path ) {
	if ( get_post_type() == 'email' ) {
		if ( is_single() ) {
			if ( $theme_file = locate_template( array( 'single-email.php' ) ) ) {
				$template_path = $theme_file;
			} else {
				$template_path = plugin_dir_path( __FILE__ ) .'single-email.php';
			}
		}
	}
	return $template_path;
}
 
function wpcp_make_template_dir() {
	
	// Check if the Templates Directory Exists - If Not Create It
	if ( !file_exists( WPCP_TEMPLATE_BASE ) ) {
	    mkdir( WPCP_TEMPLATE_BASE, 0755);
	}
	
	### Check if the Default Templates Exists - If Not Then Copy Them From The Plugin
	// Scan the Core Plugin Template Directory for Files
	$dir = WPCP_PLUGIN_BASE.'circupress/templates/';
	
	// Validate the Templates directory exists
	if ( is_dir( $dir ) ) {
		// Scan the Templates directory for files
		$files = scandir( $dir );
		
		// Cycle through the Files
		foreach( $files as $file ){
		
			// Make sure we aren't working with . and ..
			if($file != '.' && $file != '..'){
			
				// See if the Template exists in the Uploads/Templates Directory. If Not then Copy
				if ( !file_exists( WPCP_TEMPLATE_BASE.'/'.$file ) ) {
				    
					// File Does Not Exist - Copy
					if ( !copy( WPCP_PLUGIN_BASE.'circupress/templates/'.$file, WPCP_TEMPLATE_BASE.'/'.$file ) ) {
					    // Put some error Catching here!
					} // End If Copy
				} // End If File Exists	
			} // End If . ..	
		} // End For Each File 	
	} // End Validate Template Directory
}

function wpcp_change_publish_button( $translation, $text ) {
	if ( 'email' == get_post_type())
		if ( $text == 'Publish' )
		    return 'Send Email';
		
	return $translation;
}

function wpcp_change_published_on( $translation, $text ) {

	if ( 'email' == get_post_type())
	if ( $text == 'Published on: <b>%1$s</b>' )
	    return 'Sent on: <b>%1$s</b>';
	
	return $translation;

}

function wpcp_change_publish_on( $translation, $text ) {

	if ( 'email' == get_post_type())
	if ( $text == 'Publish on: <b>%1$s</b>' )
	    return 'Send on: <b>%1$s</b>';
	elseif ( $text == 'Publish <b>immediately</b>' )
		return 'Send <b>immediately</b>';
	return $translation;

}

function wpcp_schedule_email( $post_ID ) {	
	wpcp_on_demand_circupress( $post_ID );
}

function add_events_metaboxes() {
	add_meta_box('wpcp_events_metabox', 'Email Info', 'wpcp_events_metabox', 'email', 'side', 'default');
}

function wpcp_events_metabox() {

	/*
   	 * Use get_post_meta() to retrieve an existing value
   	 * from the database and use the value for the form.
    */
  	$wpcp_total_sent = get_post_meta( get_the_ID(), 'wpcp_total_sent', true );
	if( strlen( $wpcp_total_sent ) < 1 ){
		$wpcp_total_sent = 0;
	}
	
	$wpcp_opened = get_post_meta( get_the_ID(), 'wpcp_total_opened', true );
	if( strlen( $wpcp_opened ) < 1 ){
		$wpcp_opened = 0;
	}
	
	$wpcp_clicked = get_post_meta( get_the_ID(), 'wpcp_total_clicked', true );
	if( strlen( $wpcp_clicked ) < 1 ){
		$wpcp_clicked = 0;
	}
	
	$wpcp_bounced = get_post_meta( get_the_ID(), 'wpcp_total_bounced', true );
	if( strlen( $wpcp_bounced ) < 1 ){
		$wpcp_bounced = 0;
	}
	
	
	echo '
<div class="submitbox" id="submitpost">
	<div id="minor-publishing">
		<div id="misc-publishing-actions">
		
			<div class="misc-pub-section">
				<label for="total">Total Sent:</label>
				<span id="total">'.$wpcp_total_sent.'</span>
			</div><!-- .misc-pub-section -->
			<div class="misc-pub-section">
				<label for="opened">Total Opened:</label>
				<span id="opened">'.$wpcp_opened.'</span>
			</div><!-- .misc-pub-section -->
			<div class="misc-pub-section">
				<label for="clicked">Total Clicked:</label>
				<span id="clicked">'.$wpcp_clicked.'</span>
			</div><!-- .misc-pub-section -->
			<div class="misc-pub-section">
				<label for="bounced">Total Bounced:</label>
				<span id="bounced">'.$wpcp_bounced.'</span>
			</div><!-- .misc-pub-section -->
		
		</div>
	</div>
</div>';
}

function wpcp_include_file_to_var( $wpcp_file ){
    ob_start();
    include( $wpcp_file );
    return ob_get_clean();
}


// ADD NEW COLUMNS
function wpcp_email_columns( $columns ) {	
	$columns['total_sent']  = 'Sent';
	$columns['total_opened'] = 'Opened';
	$columns['total_clicked']  = 'Clicked';
	$columns['total_unsubscribed'] = 'Unsubscribed';
	$columns['total_bounced'] = 'Bounced';
	$columns['total_abuse_reports'] = "Abuse Reports";
	return $columns;
}

function wpcp_email_columns_content($column, $post_id) {
	
	switch ( $column ) {

        case 'total_sent' :
			wpcp_update_report_meta( $post_id );
            echo get_post_meta( $post_id, 'wpcp_total_sent', true );
			
        break;

        case 'total_opened' :
            echo get_post_meta( $post_id, 'wpcp_total_opened', true );
       	break;
		
		case 'total_clicked' :
            echo get_post_meta( $post_id, 'wpcp_total_clicked', true );
       	break;
		
		case 'total_unsubscribed' :
            echo get_post_meta( $post_id, 'wpcp_total_unsubscribed', true );
       	break;
		
		case 'total_bounced' :
            echo get_post_meta( $post_id, 'wpcp_total_bounced', true );
       	break;
		
		case 'total_abuse_reports' :
            echo get_post_meta( $post_id, 'wpcp_total_abuse_reports', true );
       	break;

    }

}

function wpcp_update_report_meta( $wpcp_post_id ){
	
	$wpcp_options = get_option('circupress-account'); 
	$wpcp_campaign_id = get_post_meta( $wpcp_post_id, 'wpcp_campaign_id', true );	
	$wpcp_campaign_stats = json_decode( wpcp_get_campaign_stats( stripslashes($wpcp_options['wpcp_apikey']), $wpcp_campaign_id ), true );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_bounced', $wpcp_campaign_stats['bounces'] );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_clicked', $wpcp_campaign_stats['clicks'] );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_abuse_reports', $wpcp_campaign_stats['abuse_reports'] );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_unsubscribed', $wpcp_campaign_stats['unsubscribed'] );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_sent', $wpcp_campaign_stats['delivered'] );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_opened', $wpcp_campaign_stats['opens'] );
	
	
}

function wpcp_email_column_style() {
    echo '<style type="text/css">
    	th#total_sent,
    	.column-total_sent, .column-total_opened, .column-total_clicked, .column-total_unsubscribed, .column-total_bounced, .column-total_abuse_reports { text-align: right; !important; }
    </style>';
}

function wpcp_email_sortable_columns( $columns ) {
	$columns['total_sent'] = 'total_sent';
	$columns['total_opened'] = 'total_opened';
	$columns['total_clicked'] = 'total_clicked';
	$columns['total_unsubscribed'] = 'total_unsubscribed';
	$columns['total_bounced'] = 'total_bounced';
	$columns['total_abuse_reports'] = "total_abuse_reports";
	return $columns;
}

function email_column_orderby( $vars ){
	if ( isset( $vars['orderby'] ) && 'total_sent' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wpcp_total_sent',
				'orderby'  => 'meta_value_num'
			) );
		}
	if ( isset( $vars['orderby'] ) && 'total_opened' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wpcp_total_opened',
				'orderby'  => 'meta_value_num'
			) );
		}
	if ( isset( $vars['orderby'] ) && 'total_clicked' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wpcp_total_clicked',
				'orderby'  => 'meta_value_num'
			) );
		}
	if ( isset( $vars['orderby'] ) && 'total_unsubscribed' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wpcp_total_unsubscribed',
				'orderby'  => 'meta_value_num'
			) );
		}
	if ( isset( $vars['orderby'] ) && 'total_bounced' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wpcp_total_bounced',
				'orderby'  => 'meta_value_num'
			) );
		}
	if ( isset( $vars['orderby'] ) && 'total_abuse_reports' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wpcp_total_abuse_reports',
				'orderby'  => 'meta_value_num'
			) );
		}
  return $vars;
}

function wpcp_notifications( $notification_type, $message ){
	if($message=="") { $message = $message."&nbsp;"; }
	echo '<span class="'.$notification_type.'">'.$message.'</span>';
}

function wpcp_get_css( $html ){
	if (preg_match('/<style(.*)?>(.*)<\/style>/msU', $html, $matches)   ){
		$css = $matches[0];
	} else {
		$css = '';
	}
	return $css;	   
}

// End wpcp functions

/**
 * Start Widget Ajax Functions
 */

function wpcp_subscriber_optin(){
	if( isset( $_POST['wpcp_first_name'] ) ){
		$wpcp_first_name = $_POST['wpcp_first_name'];
	} else {
		$wpcp_first_name = '';
	}
	if( isset( $_POST['wpcp_last_name'] ) ){
		$wpcp_last_name = $_POST['wpcp_last_name'];
	} else {
		$wpcp_last_name = '';
	}
	if( isset( $_POST['wpcp_email_address'] ) ){
		$wpcp_email_address = $_POST['wpcp_email_address'];
	} else {
		$wpcp_email_address = '';
	}
	if( isset( $_POST['wpcp_daily_digest'] ) ){
		$wpcp_daily_digest = $_POST['wpcp_daily_digest'];
	} else {
		$wpcp_daily_digest = '0';
	}
	if( isset( $_POST['wpcp_weekly_digest'] ) ){
		$wpcp_weekly_digest = $_POST['wpcp_weekly_digest'];
	} else {
		$wpcp_weekly_digest = '0';
	}
	
	// Get API KEY
	$wpcp_account_options = get_option('circupress-account');
	$wpcp_api_key = stripslashes($wpcp_account_options['wpcp_apikey']);
	
	//GET List ID
	$lists = json_decode( wpcp_get_lists( $wpcp_api_key ), true );
								
	if( isset( $lists['id'] ) and $lists['id'] == '401' ){
										
		echo 'There was a problem Subscribing the email address. Please try again.';
		exit;
										
	} else {
		
		foreach( $lists as $list ){
		
			$wpcp_list_id = $list['list_id'];
									
		}
										
	}
	
	// Attempt to Subscribe the Email Address
	$wpcp_subscriber_optin = json_decode( wpcp_add_list_subscriber( $wpcp_api_key, $wpcp_email_address, $wpcp_list_id, $wpcp_first_name, $wpcp_last_name, '', '', '', '', '', '', '', '', $wpcp_daily_digest, $wpcp_weekly_digest ), true );
	
	echo '<span class="wpcp_subscribe_message">'.$wpcp_subscriber_optin['description'].'</span>';

	die();
	
}


function wpcp_admin_footer_script() {
    global $post_type;
    if( 'email' == $post_type )
    wpcp_admin_footer();
}

function wpcp_pointer_scripts() {
    $pointer_content = '<h3>Welcome to CircuPress</h3>';
    $pointer_content .= '<p>Click on the Support menu option for an overview of how to set up your CircuPress account.</p>';
	$wpcp_account_options = get_option('circupress-account');
	$wpcp_api_key = stripslashes($wpcp_account_options['wpcp_apikey']);
	
	if($wpcp_api_key=="") {
?>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready( function($) {
    $('#menu-posts-email').pointer({
        content: '<?php echo $pointer_content; ?>',
        position: {
               edge: 'left',
               align: 'center'
           },
        close: function() {
            // Once the close button is hit
        }
    }).pointer('open');
});
//]]>
</script>
<?php
}
}

// Zendesk Support Tab
function wpcp_admin_footer(){
  echo '<script type="text/javascript" src="//assets.zendesk.com/external/zenbox/v2.6/zenbox.js"></script>
<style type="text/css" media="screen, projection">
  @import url(//assets.zendesk.com/external/zenbox/v2.6/zenbox.css);
</style>
<script type="text/javascript">
  if (typeof(Zenbox) !== "undefined") {
    Zenbox.init({
      dropboxID:   "20251986",
      url:         "https://circupress.zendesk.com",
      tabTooltip:  "Ask CircuPress",
      tabImageURL: "http://s1.circupress.com.s3.amazonaws.com/wp-content/uploads/2013/10/tab.png",
      tabColor:    "#438DB4",
      tabPosition: "Right"
    });
  }
</script>';
}

// Shortcode to insert form into the page
function wpcp_circupressform( $atts, $content = null ) { 
	$options = get_option('circupress-account'); 
	$wpcp_weekly_template = $options['wpcp_weekly_template'];
	$wpcp_daily_template = $options['wpcp_daily_template'];
	$circupress_list_id = $options['wpcp_circupress_list_id'];
		
	extract(shortcode_atts(array("layout" => 'vertical', "buttontext"=>"Subscribe", "style" => "text-align:left"), $atts, 'circupress')); 
	
	$wpcp_sform = '<span id="wpcp_response">'.$content.'</span>';
	
	$wpcp_sform .= '<div id="circupress-container" style="'.$style.'">';
	$wpcp_sform .= '<form action="" method="post" id="wpcp_subscribe_form">';
	if ($layout == 'vertical') {
		$wpcp_sform .= '<table cellpadding="4" border="0" style="text-align:center;margin-top: 10px;">
							<tr>
								<td style="text-align:right;"><label for="wpcp_first_name">First Name:</label></td>
								<td style="text-align:left;"><input id="wpcp_first_name" name="wpcp_first_name" type="text" size="20" maxlength="255" /><input type="hidden" name="list_id" value="" /></td>
							</tr>
							<tr>
								<td style="text-align:right;"><label for="wpcp_last_name">Last Name:</label></td>
								<td style="text-align:left;"><input id="wpcp_last_name" name="wpcp_last_name" type="text" size="20" maxlength="255" /></td>
							</tr>
							<tr>
								<td style="text-align:right;"><label for="wpcp_email_address">Email Address:</label></td>
								<td style="text-align:left;"><input id="wpcp_email_address" name="wpcp_email_address" type="text" size="20" maxlength="255" /></td>
							</tr>
							<tr>
								<td style="text-align:right;">Receive:</td>';
		if( $wpcp_daily_template != '0' ){
				$wpcp_sform .='<td style="text-align:left;"><input type="checkbox" id="wpcp_daily_digest" name="wpcp_daily_digest"  /><label for="wpcp_daily_digest">Daily Digest</label><br />'; }
		if( $wpcp_weekly_template != '0' ){		
				$wpcp_sform .='<input type="checkbox" id="wpcp_weekly_digest" name="wpcp_weekly_digest"  checked="checked" /><label for="wpcp_weekly_digest">Weekly Digest</label>'; }
				$wpcp_sform .='</td>
							</tr>
							<tr>
								<td colspan="2" style="text-align:right;"><input type="button" value="'.$buttontext.'" id="wpcp_submit" name="btn_submit" class="wpcp_submit" /></td>
							</tr>
				</table>';
	} elseif ($layout == 'horizontal') {
		$wpcp_sform .= '<table cellpadding="4" width="'.$width.'" border="0" style="text-align:center;">
							<tr>
								<td style="text-align:left;">
									<label for="wpcp_first_name">First Name:</label>&nbsp;
									<input id="wpcp_first_name" name="wpcp_first_name" type="text" size="20" maxlength="255" /><input type="hidden" name="list_id" value="" />
									<label for="wpcp_last_name">Last Name:</label>&nbsp;
									<input id="wpcp_last_name" name="wpcp_last_name" type="text" size="20" maxlength="255" />
								</td>
							</tr>
							<tr>
								<td style="text-align:left;">
									<label for="wpcp_email_address">Email Address:</label>&nbsp;
									<input id="wpcp_email_address" name="wpcp_email_address" type="text" size="30" maxlength="255" />
								</td>
							<tr>
								<td style="text-align:left;">';
			if(($wpcp_daily_template != '0')||($wpcp_weekly_template != '0')){
				$wpcp_sform .= 'Receive:&nbsp;';
				if( $wpcp_daily_template != '0' ){
					$wpcp_sform .= '<input type="checkbox" id="wpcp_daily_digest" name="wpcp_daily_digest"  />
									<label for="wpcp_daily_digest">Daily Digest</label>'; }
				if( $wpcp_weekly_template != '0' ){		
				$wpcp_sform .='&nbsp;<input type="checkbox" id="wpcp_weekly_digest" name="wpcp_weekly_digest"  checked="checked" />
									<label for="wpcp_weekly_digest">Weekly Digest</label>';
									}}
				$wpcp_sform .= '<input type="button" value="'.$buttontext.'" id="wpcp_submit" name="btn_submit" class="wpcp_submit" style="float:right" /></td>
							</tr>
				</table>';
	}
	$wpcp_sform .= '<input type="hidden" name="type" value="ADDSUB" />';
	$wpcp_runto = admin_url('admin-ajax.php');
	$wpcp_sform .= '<input type="hidden" name="runto" id="wpcp_runto" value="'.$wpcp_runto.'" />';
	$wpcp_sform .= '<input type="hidden" name="list_id" value="'.$circupress_list_id.'" />';
	$wpcp_sform .= '</form></div>';
	
    return $wpcp_sform;   
}  

add_shortcode("circupress", "wpcp_circupressform");

// CircuPress Feeds
function wpcp_init_feed_daily(){
			
	// Initialize the Feed	
	add_feed('circupress-daily','wpcp_feed_circupress_daily');
	
}

function wpcp_init_feed_weekly(){
	
	// Initialize the Feed	
	add_feed('circupress-weekly','wpcp_feed_circupress_weekly');
	
}

function wpcp_feed_circupress_daily(){
	
	// Get Account Options	
	$wpcp_account_options = get_option('circupress-account');
	$wpcp_email_editor_options = get_option('circupress-email-editor');
	$wpcp_email_schedule = stripslashes($wpcp_account_options['wpcp_email_schedule']);
	$wpcp_weekly_template = stripslashes($wpcp_account_options['wpcp_weekly_template']);
	$wpcp_daily_template = stripslashes($wpcp_account_options['wpcp_daily_template']);
	$wpcp_on_demand_email_template = stripslashes( $wpcp_account_options['wpcp_email_template'] );
	$wpcp_fb = stripslashes( $wpcp_account_options['wpcp_social_fb'] );
	$wpcp_twitter = stripslashes( $wpcp_account_options['wpcp_social_twitter'] );
	$wpcp_google_plus = stripslashes( $wpcp_account_options['wpcp_social_google_plus'] );
	$wpcp_apikey = stripslashes($wpcp_account_options['wpcp_apikey']);
	
	// Validate that the Campaign Comes from CircuPress
	$wpcp_campaign_id = wpcp_fetch_campaign_id( $wpcp_apikey, $_GET['campaign_id'], '1' );
	
	// Validate that the APIKey is present in the call. If not exit.
	if( $wpcp_campaign_id != $_GET['campaign_id'] ){
		exit();
	}
	
	// Set the Schedule and Get the Template	
	$days = 1;
	$wpcp_scheduled_template = $wpcp_daily_template;
	$wpcp_subject = stripslashes($wpcp_account_options['wpcp_daily_subject']);
	$wpcp_template = "wpcp_template_".substr($wpcp_scheduled_template,0,-4);
	$wpcp_template_head = strtolower($wpcp_template."_header");
	$wpcp_template_side = strtolower($wpcp_template."_sidebar");
	$wpcp_header_image = get_option( $wpcp_template_head );
	$wpcp_sidebar = get_option( $wpcp_template_side );

	$num_posts = 0;
	$wpcp_content_post = '';	
	// Check to see if there have been posts in the last day.
	$wpcp_args = array(
					'post_status' => 'publish',
					'posts_per_page' => 50,
					'date_query' => array(
						array(
							'after'     => date('Y-m-d', strtotime('-1 days'))
						),
						'inclusive' => true,
					),
					'posts_per_page' => -1,
				);
		
	$posts = new WP_Query( $wpcp_args );
	while ( $posts->have_posts() ) : $posts->the_post();	
		$title = get_the_title();
		$link = get_permalink();
		$thumb = get_the_post_thumbnail();
		$excerpt = get_the_excerpt();
		set_post_thumbnail_size( 100, 100, true );
		$wpcp_content_post .= '
					<div class="content">	
						<table bgcolor="">
							<tr> 
								<td>'.$thumb.'				
									<a href="'.$link.'" title="'.$title.'" ><h4>'.$title.'</h4></a>
									<p class="">'.$excerpt.'</p>
									<p class="">By '.the_author().' on '.mysql2date('F d, Y', get_post_time('Y-m-d H:i:s', true), false).'</p>
									<a href="'.$link.'" class="btn">Read More</a>	
								</td>
							</tr>
						</table>
					</div>';
		$num_posts++; 
	endwhile;
		
	if( $num_posts > 0 ){
		$wpcp_post_title = $wpcp_subject;
	} else {
		$wpcp_post_title = 'NO POSTS';
	}
		
	// Reset Wordpress 
	wp_reset_query();
		
	// Get the Template Path
	$wpcp_path = WPCP_TEMPLATE_BASE.'/'.$wpcp_scheduled_template;
		
	// Get the email content
	$wpcp_content = wpcp_include_file_to_var( $wpcp_path );
		
	// Merge Tags
	$wpcp_content = str_replace('%%POST_TITLE%%', $wpcp_post_title, $wpcp_content);
	$wpcp_content = str_replace('%%HEADER%%', $wpcp_header_image, $wpcp_content);
	$wpcp_content = str_replace('%%SIDEBAR%%', $wpcp_sidebar, $wpcp_content);
		
	if( strlen( $wpcp_fb ) > 0 ){
		$wpcp_fb_full = '<a href="'.$wpcp_fb.'" class="soc-btn fb">Facebook</a>';
		$wpcp_content = str_replace('%%FACEBOOK%%', $wpcp_fb_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%FACEBOOK%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_twitter ) > 0 ){
		$wpcp_tw_full = '<a href="'.$wpcp_twitter.'" class="soc-btn tw">Twitter</a>';
		$wpcp_content = str_replace('%%TWITTER%%', $wpcp_tw_full, $wpcp_content);		
	} else {
		$wpcp_content = str_replace('%%TWITTER%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_google_plus ) > 0 ){
		$wpcp_google_plus_full = '<a href="'.$wpcp_google_plus.'" class="soc-btn gp">Google+</a>';
		$wpcp_content = str_replace('%%GOOGLE%%', $wpcp_google_plus_full, $wpcp_content);	
	} else {
		$wpcp_content = str_replace('%%GOOGLE%%', '', $wpcp_content);
	}
		
	if( $wpcp_post_title != 'NO POSTS' && isset( $_GET['make_post'] ) && strlen( $_GET['make_post'] ) > 0 && $_GET['make_post'] == 1 ){
			
		// Create a Post to add the email to.
		$wpcp_post = array(
		  'post_title'    => $wpcp_post_title.' '.date('m/d/Y'),
		  'post_content'  => '',
		  'post_status'   => 'draft',
		  'post_type'     => 'email'
		);
			
		$wpcp_post_id = wp_insert_post( $wpcp_post );
			
		// Get Post Permalink
		$wpcp_permalink = get_permalink( $wpcp_post_id );
			
		// Merge Tags
		$wpcp_content = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content);
		$wpcp_content_post = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content_post);
			
		$wpcp_content_post = str_replace('%%FIRST_NAME%%', '', $wpcp_content_post);
		$wpcp_content_post = str_replace('%%LAST_NAME%%', '', $wpcp_content_post);
		$wpcp_content_post = str_replace('%%UNSUB%%', '', $wpcp_content_post);
			
		// Add Report Metrics to the Meta Data of the Post
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_campaign_id', $wpcp_campaign_id );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_bounced', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_clicked', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_abuse_reports', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_unsubscribed', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_sent', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_opened', '0' );
			
		// Tell CP what schedule 
		if( $days == 1 ){
			$schedule = 8;
		} else {
			$schedule = $days;
		}
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_post_schedule', $schedule );
		// Extract CSS
		$css = wpcp_get_css( $wpcp_content_post );
		if( $css == '' ){
			$css = '<style></style>';
		}
		
		$e = new Emogrifier( $wpcp_content_post, $css);

        $processedHTML = $e->emogrify();
		$processedHTML = preg_replace ("'<style[^>]*?>.*?</style>'si", "", $processedHTML);
		
			
		// Update Post Content to have complete merged info
		$wpcp_post = array(
    		'ID'           => $wpcp_post_id,
      		'post_content' => $processedHTML,
      		'post_status'   => 'publish'
  		);
			
		wp_update_post( $wpcp_post );
	
		$wpcp_gmt = get_gmt_from_date( date('Y-m-d H:i:s') );
		$wpcp_campaign_type = '8';
		
		$lists = json_decode( wpcp_get_lists( stripslashes( $wpcp_apikey ) ), true );
									
		if( isset( $lists['id'] ) and $lists['id'] == '401' ){
											
											
		} else {
		
			$wpcp_list_id = $lists[0]['list_id'];	
			
			// Create the campaign
			wpcp_create_campaign( $wpcp_apikey, $wpcp_post_title, $wpcp_list_id, $wpcp_post_title, $wpcp_gmt, $wpcp_campaign_type, $wpcp_permalink, '2', $wpcp_campaign_id, $wpcp_content );					
				
		}
	}		

}

function wpcp_feed_circupress_weekly(){
	
	// Get Account Options	
	$wpcp_account_options = get_option('circupress-account');
	$wpcp_email_editor_options = get_option('circupress-email-editor');
	$wpcp_email_schedule = stripslashes($wpcp_account_options['wpcp_email_schedule']);
	$wpcp_weekly_template = stripslashes($wpcp_account_options['wpcp_weekly_template']);
	$wpcp_daily_template = stripslashes($wpcp_account_options['wpcp_daily_template']);
	$wpcp_on_demand_email_template = stripslashes( $wpcp_account_options['wpcp_email_template'] );
	$wpcp_fb = stripslashes( $wpcp_account_options['wpcp_social_fb'] );
	$wpcp_twitter = stripslashes( $wpcp_account_options['wpcp_social_twitter'] );
	$wpcp_google_plus = stripslashes( $wpcp_account_options['wpcp_social_google_plus'] );
	$wpcp_apikey = stripslashes($wpcp_account_options['wpcp_apikey']);
	
	// Validate that the Campaign Comes from CircuPress
	$wpcp_campaign_id = wpcp_fetch_campaign_id( $wpcp_apikey, $_GET['campaign_id'], '1' );
	
	// Validate that the APIKey is present in the call. If not exit.
	if( $wpcp_campaign_id != $_GET['campaign_id'] ){
		exit();
	}
	
	// Set the Schedule and Get the Template	
	$days = 7;
	$wpcp_scheduled_template = $wpcp_weekly_template;
	$wpcp_subject = stripslashes($wpcp_account_options['wpcp_weekly_subject']);
	$wpcp_template = "wpcp_template_".substr($wpcp_scheduled_template,0,-4);
	$wpcp_template_head = strtolower($wpcp_template."_header");
	$wpcp_template_side = strtolower($wpcp_template."_sidebar");
	$wpcp_header_image = get_option( $wpcp_template_head );
	$wpcp_sidebar = get_option( $wpcp_template_side );

	$num_posts = 0;
			
	// Check to see if there have been posts in the last day.
	$wpcp_args = array(
					'post_status' => 'publish',
					'posts_per_page' => 50,
					'date_query' => array(
						array(
							'after'     => date('Y-m-d', strtotime('-7 days'))
						),
						'inclusive' => true,
					),
					'posts_per_page' => -1,
				);
		
	$posts = new WP_Query( $wpcp_args );
	while ( $posts->have_posts() ) : $posts->the_post();	
		$title = get_the_title();
		$link = get_permalink();
		$thumb = get_the_post_thumbnail();
		$excerpt = get_the_excerpt();
		set_post_thumbnail_size( 100, 100, true );
	
		$wpcp_content_post .= '
					<div class="content">	
						<table bgcolor="">
							<tr> 
								<td>	
									'.$thumb.'			
									<a href="'.$link.'" title="'.$title.'" ><h4>'.$title.'</h4></a>
									<p class="">'.$excerpt.'</p>
									<p class="">By '.the_author().' on '.mysql2date('F d, Y', get_post_time('Y-m-d H:i:s', true), false).'</p>
									<a href="'.$link.'" class="btn">Read More</a>	
								</td>
							</tr>
						</table>
					</div>';
		$num_posts++; 
	endwhile;
		
	if( $num_posts > 0 ){
		$wpcp_post_title = $wpcp_subject;
	} else {
		$wpcp_post_title = 'NO POSTS';
	}
		
	// Reset Wordpress 
	wp_reset_query();
		
	// Get the Template Path
	$wpcp_path = WPCP_TEMPLATE_BASE.'/'.$wpcp_scheduled_template;
		
	// Get the email content
	$wpcp_content = wpcp_include_file_to_var( $wpcp_path );
		
	// Merge Tags
	$wpcp_content = str_replace('%%POST_TITLE%%', $wpcp_post_title, $wpcp_content);
	$wpcp_content = str_replace('%%HEADER%%', $wpcp_header_image, $wpcp_content);
	$wpcp_content = str_replace('%%SIDEBAR%%', $wpcp_sidebar, $wpcp_content);
		
	if( strlen( $wpcp_fb ) > 0 ){
		$wpcp_fb_full = '<a href="'.$wpcp_fb.'" class="soc-btn fb">Facebook</a>';
		$wpcp_content = str_replace('%%FACEBOOK%%', $wpcp_fb_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%FACEBOOK%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_twitter ) > 0 ){
		$wpcp_tw_full = '<a href="'.$wpcp_twitter.'" class="soc-btn tw">Twitter</a>';
		$wpcp_content = str_replace('%%TWITTER%%', $wpcp_tw_full, $wpcp_content);		
	} else {
		$wpcp_content = str_replace('%%TWITTER%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_google_plus ) > 0 ){
		$wpcp_google_plus_full = '<a href="'.$wpcp_google_plus.'" class="soc-btn gp">Google+</a>';
		$wpcp_content = str_replace('%%GOOGLE%%', $wpcp_google_plus_full, $wpcp_content);	
	} else {
		$wpcp_content = str_replace('%%GOOGLE%%', '', $wpcp_content);
	}
		
	if( $wpcp_post_title != 'NO POSTS' && isset( $_GET['make_post'] ) && strlen( $_GET['make_post'] ) > 0 && $_GET['make_post'] == 1 ){
			
		// Create a Post to add the email to.
		$wpcp_post = array(
		  'post_title'    => $wpcp_post_title.' '.date('m/d/Y'),
		  'post_content'  => '',
		  'post_status'   => 'draft',
		  'post_type'     => 'email'
		);
			
		$wpcp_post_id = wp_insert_post( $wpcp_post );
			
		// Get Post Permalink
		$wpcp_permalink = get_permalink( $wpcp_post_id );
			
		// Merge Tags
		$wpcp_content = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content);
		$wpcp_content_post = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content_post);
			
		$wpcp_content_post = str_replace('%%FIRST_NAME%%', '', $wpcp_content_post);
		$wpcp_content_post = str_replace('%%LAST_NAME%%', '', $wpcp_content_post);
		$wpcp_content_post = str_replace('%%UNSUB%%', '', $wpcp_content_post);
			
		// Add Report Metrics to the Meta Data of the Post
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_campaign_id', $wpcp_campaign_id );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_bounced', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_clicked', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_abuse_reports', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_unsubscribed', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_sent', '0' );
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_opened', '0' );
			
		// Tell CP what schedule 
		if( $days == 1 ){
			$schedule = 8;
		} else {
			$schedule = date('w');
		}
		wpcp_meta_add_update( $wpcp_post_id, 'wpcp_post_schedule', $schedule );
			
		// Extract CSS
		$css = wpcp_get_css( $wpcp_content_post );
		if( $css == '' ){
			$css = '<style></style>';
		}
		
		$e = new Emogrifier( $wpcp_content_post, $css);

        $processedHTML = $e->emogrify();
		$processedHTML = preg_replace ("'<style[^>]*?>.*?</style>'si", "", $processedHTML);
			
		// Update Post Content to have complete merged info
		$wpcp_post = array(
    		'ID'           => $wpcp_post_id,
      		'post_content' => $processedHTML,
      		'post_status'   => 'publish'
  		);
			
		wp_update_post( $wpcp_post );
		
		$wpcp_gmt = get_gmt_from_date( date('Y-m-d H:i:s') );
		$wpcp_campaign_type = date('w');
		
		$lists = json_decode( wpcp_get_lists( stripslashes( $wpcp_apikey ) ), true );
									
		if( isset( $lists['id'] ) and $lists['id'] == '401' ){
											
											
		} else {
		
			$wpcp_list_id = $lists[0]['list_id'];	
			
			// Create the campaign
			wpcp_create_campaign( $wpcp_apikey, $wpcp_post_title, $wpcp_list_id, $wpcp_post_title, $wpcp_gmt, $wpcp_campaign_type, $wpcp_permalink, '2', $wpcp_campaign_id, $wpcp_content );					
				
		}
	
	}	

}

function wpcp_on_demand_circupress( $wpcp_post_id ){
	
	// Make sure that this post hasn't already been sent
	$email_complete = get_post_meta( $wpcp_post_id, 'wpcp_post_schedule', true ); 
	if( strlen( $email_complete ) > 0 ){
		return '';
		exit;	
	}
	
	//Get Post Info
	$post_array = get_post( $wpcp_post_id, ARRAY_A );
	$title = $post_array['post_title'];
	$post_gmt = $post_array['post_date_gmt'];
	$post_content = $post_array['post_content'];	 
	
	// Get Account Options	
	$wpcp_account_options = get_option('circupress-account');
	$wpcp_email_editor_options = get_option('circupress-email-editor');
	$wpcp_on_demand_email_template = stripslashes( $wpcp_account_options['wpcp_email_template'] );
	$wpcp_fb = stripslashes( $wpcp_account_options['wpcp_social_fb'] );
	$wpcp_twitter = stripslashes( $wpcp_account_options['wpcp_social_twitter'] );
	$wpcp_google_plus = stripslashes( $wpcp_account_options['wpcp_social_google_plus'] );
	$wpcp_apikey = stripslashes($wpcp_account_options['wpcp_apikey']);
	
	$wpcp_template = "wpcp_template_".substr($wpcp_on_demand_email_template,0,-4);
	$wpcp_template_head = strtolower($wpcp_template."_header");
	$wpcp_template_side = strtolower($wpcp_template."_sidebar");
	$wpcp_header_image = get_option( $wpcp_template_head );
	$wpcp_sidebar = get_option( $wpcp_template_side );
		
	// Get the Template Path
	$wpcp_path = WPCP_TEMPLATE_BASE.'/'.$wpcp_on_demand_email_template;
	
	$wpcp_post_title = $title;
		
	// Get the email content
	$wpcp_args =   array( 'post_type' => 'email', 'posts_per_page' => 1, 'p' => $wpcp_post_id );
	$email = new WP_Query( $wpcp_args );
	while ( $email->have_posts() ) : $email->the_post();
		// This is ok to be blank. We run the query to get the post
	endwhile;
	
	$wpcp_content = wpcp_include_file_to_var( $wpcp_path );
	
	// Get Post Permalink
	$wpcp_permalink = get_permalink( $wpcp_post_id );	
	$wpcp_content = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content);
	$wpcp_content = str_replace('%%POST_TITLE%%', $wpcp_post_title, $wpcp_content);
	$wpcp_content = str_replace('%%HEADER%%', $wpcp_header_image, $wpcp_content);
	$wpcp_content = str_replace('%%SIDEBAR%%', $wpcp_sidebar, $wpcp_content);
	
	// Merge Online Link
	$wpcp_content = str_replace('%%POST_TITLE%%', $wpcp_post_title, $wpcp_content);
	$wpcp_content = str_replace('%%HEADER%%', $wpcp_header_image, $wpcp_content);
	$wpcp_content = str_replace('%%SIDEBAR%%', $wpcp_sidebar, $wpcp_content);
		
	if( strlen( $wpcp_fb ) > 0 ){
		$wpcp_fb_full = '<a href="'.$wpcp_fb.'" class="soc-btn fb">Facebook</a>';
		$wpcp_content = str_replace('%%FACEBOOK%%', $wpcp_fb_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%FACEBOOK%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_twitter ) > 0 ){
		$wpcp_tw_full = '<a href="'.$wpcp_twitter.'" class="soc-btn tw">Twitter</a>';
		$wpcp_content = str_replace('%%TWITTER%%', $wpcp_tw_full, $wpcp_content);	
	} else {
		$wpcp_content = str_replace('%%TWITTER%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_google_plus ) > 0 ){
		$wpcp_google_plus_full = '<a href="'.$wpcp_google_plus.'" class="soc-btn gp">Google+</a>';
		$wpcp_content = str_replace('%%GOOGLE%%', $wpcp_google_plus_full, $wpcp_content);	
	} else {
		$wpcp_content = str_replace('%%GOOGLE%%', '', $wpcp_content);
	}
		
	$wpcp_content_post = $wpcp_content;
					
	$wpcp_content_post = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content_post);	
	$wpcp_content_post = str_replace('%%FIRST_NAME%%', '', $wpcp_content_post);
	$wpcp_content_post = str_replace('%%LAST_NAME%%', '', $wpcp_content_post);
	$wpcp_content_post = str_replace('%%UNSUB%%', '', $wpcp_content_post);
		
	$wpcp_campaign_id = wpcp_create_campaign_id( $wpcp_apikey );		
			
	// Add Report Metrics to the Meta Data of the Post
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_campaign_id', $wpcp_campaign_id );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_bounced', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_clicked', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_abuse_reports', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_unsubscribed', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_sent', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_opened', '0');
			
	// Extract CSS
	$css = wpcp_get_css( $wpcp_content_post );
	if( $css == '' ){
		$css = '<style></style>';
	}

	$e = new Emogrifier( $wpcp_content_post, $css);

    $processedHTML = $e->emogrify();
	$processedHTML = preg_replace ("'<style[^>]*?>.*?</style>'si", "", $processedHTML);
			
			
			
	// Update Post Content to have complete merged info
	$wpcp_post = array(
   		'ID'           => $wpcp_post_id,
      	'post_content' => $processedHTML
  	);
	
	
			
	//wp_update_post( $wpcp_post );
		
	
		
	$wpcp_gmt = get_gmt_from_date( date('Y-m-d H:i:s') );
	$wpcp_campaign_type = '9999999';
		
	$lists = json_decode( wpcp_get_lists( stripslashes( $wpcp_apikey ) ), true );
									
	if( isset( $lists['id'] ) and $lists['id'] == '401' ){
											
											
	} else {
		
	$wpcp_list_id = $lists[0]['list_id'];	
	
		$email_complete = get_post_meta( $wpcp_post_id, 'wpcp_post_schedule', true ); 
		if( strlen( $email_complete ) < 1 ){
			// Create the campaign
			wpcp_create_campaign( $wpcp_apikey, $wpcp_post_title, $wpcp_list_id, $wpcp_post_title, $wpcp_gmt, $wpcp_campaign_type, $wpcp_permalink, '2', $wpcp_campaign_id, $wpcp_content );	
		}
			
					
				
	}

	return '';
	exit;	

}

function wpcp_email_preview( $wpcp_template ){
	
	//Get Post Info
	$post_array = get_post( $wpcp_post_id, ARRAY_A );
	$title = $post_array['post_title'];
	$post_gmt = $post_array['post_date_gmt'];
	$post_content = $post_array['post_content'];	 
	
	// Get Account Options	
	$wpcp_account_options = get_option('circupress-account');
	$wpcp_email_editor_options = get_option('circupress-email-editor');
	$wpcp_on_demand_email_template = stripslashes( $wpcp_account_options['wpcp_email_template'] );
	$wpcp_fb = stripslashes( $wpcp_account_options['wpcp_social_fb'] );
	$wpcp_twitter = stripslashes( $wpcp_account_options['wpcp_social_twitter'] );
	$wpcp_google_plus = stripslashes( $wpcp_account_options['wpcp_social_google_plus'] );
	$wpcp_apikey = stripslashes($wpcp_account_options['wpcp_apikey']);
	
	$wpcp_template = "wpcp_template_".substr($wpcp_on_demand_email_template,0,-4);
	$wpcp_template_head = strtolower($wpcp_template."_header");
	$wpcp_template_side = strtolower($wpcp_template."_sidebar");
	$wpcp_header_image = get_option( $wpcp_template_head );
	$wpcp_sidebar = get_option( $wpcp_template_side );
		
	// Get the Template Path
	$wpcp_path = WPCP_TEMPLATE_BASE.'/'.$wpcp_on_demand_email_template;
	
	$wpcp_post_title = $title;
		
	// Get the email content
	$wpcp_args =   array( 'post_type' => 'email', 'posts_per_page' => 1, 'p' => $wpcp_post_id );
	$email = new WP_Query( $wpcp_args );
	while ( $email->have_posts() ) : $email->the_post();
		// This is ok to be blank. We run the query to get the post
	endwhile;
	
	$wpcp_content = wpcp_include_file_to_var( $wpcp_path );
	
	// Get Post Permalink
	$wpcp_permalink = get_permalink( $wpcp_post_id );	
	$wpcp_content = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content);
	$wpcp_content = str_replace('%%POST_TITLE%%', $wpcp_post_title, $wpcp_content);
	$wpcp_content = str_replace('%%HEADER%%', $wpcp_header_image, $wpcp_content);
	$wpcp_content = str_replace('%%SIDEBAR%%', $wpcp_sidebar, $wpcp_content);
	
	// Merge Online Link
	$wpcp_content = str_replace('%%POST_TITLE%%', $wpcp_post_title, $wpcp_content);
	$wpcp_content = str_replace('%%HEADER%%', $wpcp_header_image, $wpcp_content);
	$wpcp_content = str_replace('%%SIDEBAR%%', $wpcp_sidebar, $wpcp_content);
		
	if( strlen( $wpcp_fb ) > 0 ){
		$wpcp_fb_full = '<a href="'.$wpcp_fb.'" class="soc-btn fb">Facebook</a>';
		$wpcp_content = str_replace('%%FACEBOOK%%', $wpcp_fb_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%FACEBOOK%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_twitter ) > 0 ){
		$wpcp_tw_full = '<a href="'.$wpcp_twitter.'" class="soc-btn tw">Twitter</a>';
		$wpcp_content = str_replace('%%TWITTER%%', $wpcp_tw_full, $wpcp_content);	
	} else {
		$wpcp_content = str_replace('%%TWITTER%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_google_plus ) > 0 ){
		$wpcp_google_plus_full = '<a href="'.$wpcp_google_plus.'" class="soc-btn gp">Google+</a>';
		$wpcp_content = str_replace('%%GOOGLE%%', $wpcp_google_plus_full, $wpcp_content);	
	} else {
		$wpcp_content = str_replace('%%GOOGLE%%', '', $wpcp_content);
	}
		
	$wpcp_content_post = $wpcp_content;
					
	$wpcp_content_post = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content_post);	
	$wpcp_content_post = str_replace('%%FIRST_NAME%%', '', $wpcp_content_post);
	$wpcp_content_post = str_replace('%%LAST_NAME%%', '', $wpcp_content_post);
	$wpcp_content_post = str_replace('%%UNSUB%%', '', $wpcp_content_post);
		
	$wpcp_campaign_id = wpcp_create_campaign_id( $wpcp_apikey );		
			
	// Add Report Metrics to the Meta Data of the Post
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_campaign_id', $wpcp_campaign_id );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_bounced', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_clicked', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_abuse_reports', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_unsubscribed', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_sent', '0' );
	wpcp_meta_add_update( $wpcp_post_id, 'wpcp_total_opened', '0');
			
	// Extract CSS
	$css = wpcp_get_css( $wpcp_content_post );
	if( $css == '' ){
		$css = '<style></style>';
	}
			
	$e = new Emogrifier( $wpcp_content_post, $css);

    $processedHTML = $e->emogrify();
	$processedHTML = preg_replace ("'<style[^>]*?>.*?</style>'si", "", $processedHTML);
			
	// Update Post Content to have complete merged info
	$wpcp_post = array(
   		'ID'           => $wpcp_post_id,
      	'post_content' => $processedHTML
  	);
			
	//wp_update_post( $wpcp_post );
		
	$wpcp_gmt = get_gmt_from_date( date('Y-m-d H:i:s') );
	$wpcp_campaign_type = '9999999';
		
	$lists = json_decode( wpcp_get_lists( stripslashes( $wpcp_apikey ) ), true );
									
	if( isset( $lists['id'] ) and $lists['id'] == '401' ){
											
											
	} else {
		
	$wpcp_list_id = $lists[0]['list_id'];	
	
		$email_complete = get_post_meta( $wpcp_post_id, 'wpcp_post_schedule', true ); 
		if( strlen( $email_complete ) < 1 ){
			// Create the campaign
			wpcp_create_campaign( $wpcp_apikey, $wpcp_post_title, $wpcp_list_id, $wpcp_post_title, $wpcp_gmt, $wpcp_campaign_type, $wpcp_permalink, '2', $wpcp_campaign_id, $wpcp_content );	
		}
					
	}

	return '';
	exit;	

}
?>