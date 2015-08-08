<?php
/*
*
* CircuPress Accounts Page
*
*/

if (!current_user_can('manage_options'))  {

	wp_die( __('You do not have sufficient permissions to access this page.') );

} else {



	$wpcp_settings = get_option('wpcp-settings');
	$wpcp_options = get_option('circupress-account');

?>
<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-email"><br /></div><h2>CircuPress Account</h2>
		<div class="wrap">
			<?php

				if( isset($_GET['settings-updated']) ) {
					// Validate API Key
					$wpcp_api_validate = json_decode( wpcp_validate_api( stripslashes($wpcp_options['wpcp_apikey']), true ), true );

					//var_dump( $wpcp_api_validate );

					$lists = json_decode( wpcp_get_lists( $wpcp_api_key ), true );

					//foreach( $lists as $list ){

					//	$wpcp_list_id = $list['list_id'];

					//}

					if( $wpcp_api_validate['id'] == 0 ) {
					?>
						<div id="message" class="updated">
		        			<p><strong><?php _e('Your API Key is Valid!') ?></strong></p>
		    			</div>
					<?php
					} elseif ( strlen($wpcp_options['wpcp_apikey']) >0 ) {
					?>
						<div id="message" class="error">
		        			<p><strong><?php _e('Your API Key is Invalid!') ?></strong></p>
		    			</div>
					<?php
					}
				}
				?>
			<?php
				// Get and Update Template Options and Email Schedules
				$wpcp_options = get_option('circupress-account');
				$wpcp_api_key = stripslashes($wpcp_options['wpcp_apikey']);
				$wpcp_email_schedule = stripslashes($wpcp_options['wpcp_email_schedule']);
				$wpcp_weekly_template = stripslashes($wpcp_options['wpcp_weekly_template']);
				$wpcp_daily_template = stripslashes($wpcp_options['wpcp_daily_template']);

				if( $wpcp_weekly_template == '0' ){
					$wpcp_weekly_schedule = '7';
				} else {
					$wpcp_weekly_schedule = $wpcp_email_schedule;
				}

				if( $wpcp_daily_template == '0' ){
					$wpcp_daily_schedule = '0';
				} else {
					$wpcp_daily_schedule = '8';
				}

				// Update Daily Schedule
				wpcp_update_schedule( $wpcp_api_key, $wpcp_daily_schedule, get_site_url(), '1' );

				// Update Weekly Schedule
				wpcp_update_schedule( $wpcp_api_key, $wpcp_weekly_schedule, get_site_url(), '2' );

			?>
    			<form action="options.php" method="post">
					<?php settings_fields('circupress-account'); ?>
					<?php do_settings_sections('circupress-account'); ?>
					<?php submit_button(__("Update CircuPress Settings", 'wpcp')); ?>
				</form>
            </div>
    	<div class="clear"></div>
<?php

	// Verify the account is properly set up
	wpcp_wizard();


} ?>