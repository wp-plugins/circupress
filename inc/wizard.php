<?php

function wpcp_wizard(){
	wpcp_wizard_api_key();
}

// Check API Key
function wpcp_wizard_api_key(){

	// Set Lightbox Header
	$wpcp_header_message = '';
	$echo_tag = 0;
	$tag = '<p></p><h2>Hey, we need some more information!</h2><p></p>';

	// Check Users API Key
	$wpcp_account_options = get_option('circupress-account');
	if($wpcp_account_options['wpcp_apikey'] =='') {
		$echo_tag = 1;
		$wpcp_header_message .= '<p>It looks as though you are just getting started with CircuPress! Let\'s get you started. Fill out each of the required fields. Once you have scrolled through all settings and properly filled them out, click the <strong>Update CircuPress Settings</strong> button at the bottom.</p>';
	}

	if ($wpcp_account_options['wpcp_email_from_name'] == '' ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your name.</p>';
	}

	if ($wpcp_account_options['wpcp_email_from_email'] == '' ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your "From Email Address".</p>';
	}

	if ($wpcp_account_options['wpcp_email_street'] == '' ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your Street Address.</p>';
	}

	if ($wpcp_account_options['wpcp_email_city'] == '' ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your City.</p>';
	}

	if ($wpcp_account_options['wpcp_email_province'] == '' ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your State or Province.</p>';
	}

	if ($wpcp_account_options['wpcp_email_postal_code'] == '' ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your Postal Code.</p>';
	}
	if ($wpcp_account_options['wpcp_email_canspam'] == '' ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your CAN-SPAM Compliance Statement.</p>';
	}
	if ($wpcp_account_options['wpcp_daily_template'] != '0' && $wpcp_account_options['wpcp_daily_subject'] == ''  ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your Daily Subject Line.</p>';
	}
	if ($wpcp_account_options['wpcp_weekly_template'] != '0' && $wpcp_account_options['wpcp_weekly_subject'] == ''  ){
		$echo_tag = 1;
		$wpcp_header_message .= '<p>Please enter your Weekly Subject Line.</p>';
	}

	if( $echo_tag == 1 ){
		$wpcp_header_message = $tag.$wpcp_header_message;
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		echo '<div id="TB_inline" style="display:none;"><a href="http://www.circupress.com" target="_blank"><img src="'.plugins_url('circupress/images/circupress-75.png').'" style="float:left; margin: 12px 8px 0 0" height="75" width="75" /></a>'.$wpcp_header_message.'
			<form action="options.php" method="post">';
				settings_fields('circupress-account');
				do_settings_sections('circupress-account');
				submit_button(__("Update CircuPress Settings", 'wpcp'));
			echo '</form>
		</div>';
	}
}

?>