<?php

function wpcp_wizard(){

	wpcp_wizard_api_key();

}

// Check API Key
function wpcp_wizard_api_key(){

	// Check Users API Key
	$wpcp_account_options = get_option('circupress-account');
	if($wpcp_account_options['wpcp_apikey'] =='') {
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<a href="http://www.circupress.com" target="_blank"><img src="'.plugins_url('circupress/images/circupress-75.png').'" style="float:left; margin: 12px 8px 0 0" height="75" width="75" /></a><p>It looks as though you are just getting started with CircuPress! Let\'s get you started. Fill out each of the required fields. Once you have scrolled through all settings and properly filled them out, click the <strong>Update CircuPress Settings</strong> button at the bottom.</p>';
	} elseif ($wpcp_account_options['wpcp_email_from_name'] == '' ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your name.</p>';
	} elseif ($wpcp_account_options['wpcp_email_from_email'] == '' ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your "From Email Address".</p>';
	} elseif ($wpcp_account_options['wpcp_email_street'] == '' ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your Street Address.</p>';
	} elseif ($wpcp_account_options['wpcp_email_city'] == '' ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your City.</p>';
	} elseif ($wpcp_account_options['wpcp_email_province'] == '' ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your State or Province.</p>';
	} elseif ($wpcp_account_options['wpcp_email_postal_code'] == '' ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your Postal Code.</p>';
	} elseif ($wpcp_account_options['wpcp_email_canspam'] == '' ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your CAN-SPAM Compliance Statement.</p>';
	} elseif ($wpcp_account_options['wpcp_daily_template'] != '0' && $wpcp_account_options['wpcp_daily_subject'] == ''  ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your Daily Subject Line.</p>';
	} elseif ($wpcp_account_options['wpcp_weekly_template'] != '0' && $wpcp_account_options['wpcp_weekly_subject'] == ''  ){
		echo '<script> window.onload=function(){ tb_show("CircuPress Setup", "#TB_inline?width=750&height=750&inlineId=TB_inline", null); } </script>';
		$wpcp_header_message = '<h2>Hey, we need some more information!<br /><p>Please enter your Weekly Subject Line.</p>';
	}

	echo '
		<div id="TB_inline" style="display:none;">'.$wpcp_header_message.'
			<form action="options.php" method="post">';
				settings_fields('circupress-account');
				do_settings_sections('circupress-account');
				submit_button(__("Update CircuPress Settings", 'wpcp'));
			echo '</form>
		</div>';

}

?>