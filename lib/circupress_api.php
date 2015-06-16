<?php

############# CircuPress Email API File #######################

### Set Global Options
$cp_options['api_url'] = 'https://app.circupress.com/api/api.php';
$cp_options['report_url'] = 'https://app.circupress.com/api/reports/reports.php';

### Used to post to calls to circupress.com
function wpcp_curl($url, $data){

	/* For Wordpress Implementation */
	$response = wp_remote_post( $url, array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'headers' => array(),
		'body' => stripslashes_deep($data),
		'sslverify' => false,
		'cookies' => array()
	    )
	);

	return $response['body'];
	/* For Direct Curl
	 *
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$resp = curl_exec ($ch);
		curl_close ($ch);
		return $resp;
	 *
	 */

}

### Add New List
function wpcp_add_list($api_key, $cp_list_name, $cp_list_reminder, $cp_list_address, $cp_list_city, $cp_list_state, $cp_list_zip, $cp_list_phone, $cp_list_company, $cp_list_from_name, $cp_list_from_email){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'add_list',
		'cp_api_key' => $api_key,
		'cp_list_name' => $cp_list_name,
		'cp_list_reminder' => $cp_list_reminder,
		'cp_list_address' => $cp_list_address,
		'cp_list_city' => $cp_list_city,
		'cp_list_state' => $cp_list_state,
		'cp_list_zip' => $cp_list_zip,
		'cp_list_phone' => $cp_list_phone,
		'cp_list_company' => $cp_list_company,
		'cp_list_from_name' => $cp_list_from_name,
		'cp_list_from_email' => $cp_list_from_email

	);

	//Curl CircuPress API
	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Get List Statistics
function wpcp_get_list_stats( $api_key, $list_id ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'get_list_stats',
		'cp_api_key' => $api_key,
		'cp_list_id' => $list_id

	);

	//Curl CircuPress API
	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Get Lists Associated with this account
function wpcp_get_lists( $api_key ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'get_lists',
		'cp_api_key' => $api_key

	);

	//Curl CircuPress API
	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Get Campaigns Associated with this account
function wpcp_get_campaigns( $api_key ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'get_campaigns',
		'cp_api_key' => $api_key

	);

	//Curl CircuPress API
	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Get Subscribers associated with this list
function wpcp_get_list_subscribers( $api_key, $list_id ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'get_list_subscribers',
		'cp_api_key' => $api_key,
		'cp_list_id' => $list_id

	);

	//Curl CircuPress API
	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Get CSV file with list subscribers
function wpcp_get_list_subscribers_csv( $api_key, $list_id ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'get_list_csv',
		'cp_api_key' => $api_key,
		'cp_list_id' => $list_id

	);

	//Curl CircuPress API
	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Update List
function wpcp_update_list($api_key, $cp_list_name, $cp_list_reminder, $cp_list_address, $cp_list_city, $cp_list_state, $cp_list_zip, $cp_list_phone, $cp_list_company, $cp_list_from_name, $cp_list_from_email, $cp_list_id, $cp_list_status){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'update_list',
		'cp_api_key' => $api_key,
		'cp_list_name' => $cp_list_name,
		'cp_list_reminder' => $cp_list_reminder,
		'cp_list_address' => $cp_list_address,
		'cp_list_city' => $cp_list_city,
		'cp_list_state' => $cp_list_state,
		'cp_list_zip' => $cp_list_zip,
		'cp_list_phone' => $cp_list_phone,
		'cp_list_company' => $cp_list_company,
		'cp_list_from_name' => $cp_list_from_name,
		'cp_list_from_email' => $cp_list_from_email,
		'cp_list_id' => $cp_list_id,
		'cp_list_active' => $cp_list_status

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Update schedule of Daily/Weekly Digests
function wpcp_update_schedule( $api_key, $cp_schedule, $cp_url, $cp_schedule_type ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'update_schedule',
		'cp_api_key' => $api_key,
		'cp_schedule' => $cp_schedule,
		'cp_url' => $cp_url,
		'cp_schedule_type' => $cp_schedule_type

	);

	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Update Account Informaiton
function wpcp_update_account($api_key, $cp_first_name, $cp_last_name, $cp_email_address, $cp_address, $cp_city, $cp_state, $cp_zip, $cp_phone, $cp_website, $cp_company_name, $cp_status){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'update_account',
		'cp_api_key' => $api_key,
		'cp_first_name' => $cp_first_name,
		'cp_last_name' => $cp_last_name,
		'cp_email_address' => $cp_email_address,
		'cp_address' => $cp_address,
		'cp_city' => $cp_city,
		'cp_state' => $cp_state,
		'cp_zip' => $cp_zip,
		'cp_phone' => $cp_phone,
		'cp_website' => $cp_website,
		'cp_company_name' => $cp_company_name,
		'cp_active' => $cp_status

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Add New Subscriber to List
function wpcp_add_list_subscriber($api_key, $cp_email_address, $cp_list_id, $cp_first_name, $cp_last_name, $cp_address, $cp_city, $cp_state, $cp_zip, $cp_phone, $cp_website, $cp_company_name, $cp_mobile, $cp_daily, $cp_weekly ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'add_list_subscriber',
		'cp_api_key' => $api_key,
		'cp_email_address' => $cp_email_address,
		'cp_list_id' => $cp_list_id,
		'cp_first_name' => $cp_first_name,
		'cp_last_name' => $cp_last_name,
		'cp_address' => $cp_address,
		'cp_city' => $cp_city,
		'cp_state' => $cp_state,
		'cp_zip' => $cp_zip,
		'cp_phone' => $cp_phone,
		'cp_website' => $cp_website,
		'cp_company_name' => $cp_company_name,
		'cp_mobile' => $cp_mobile,
		'cp_daily' => $cp_daily,
		'cp_weekly' => $cp_weekly

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Update List Subscriber
function wpcp_update_list_subscriber($api_key, $cp_email_address, $cp_list_id, $cp_subscriber_id, $cp_subscriber_status = '1', $cp_first_name = '', $cp_last_name = '', $cp_address = '', $cp_city = '', $cp_state = '', $cp_zip = '', $cp_phone = '', $cp_website = '', $cp_company_name = '', $cp_mobile = '', $cp_daily = '1', $cp_weekly = '1'  ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'update_list_subscriber',
		'cp_api_key' => $api_key,
		'cp_email_address' => $cp_email_address,
		'cp_list_id' => $cp_list_id,
		'cp_first_name' => $cp_first_name,
		'cp_last_name' => $cp_last_name,
		'cp_address' => $cp_address,
		'cp_city' => $cp_city,
		'cp_state' => $cp_state,
		'cp_zip' => $cp_zip,
		'cp_phone' => $cp_phone,
		'cp_website' => $cp_website,
		'cp_company_name' => $cp_company_name,
		'cp_mobile' => $cp_mobile,
		'cp_subscriber_id' => $cp_subscriber_id,
		'cp_subscriber_status' => $cp_subscriber_status,
		'cp_daily' => $cp_daily,
		'cp_weekly' => $cp_weekly

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Add Campaign by URL
function wpcp_add_url_campaign($api_key, $cp_campaign_name, $cp_list_id, $cp_email_subject, $cp_dts, $cp_campaign_type, $cp_campaign_url, $cp_status){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'add_campaign',
		'cp_api_key' => $api_key,
		'cp_campaign_name' => $cp_campaign_name,
		'cp_list_id' => $cp_list_id,
		'cp_email_subject' => $cp_email_subject,
		'cp_dts' => $cp_dts,
		'cp_campaign_type' => $cp_campaign_type,
		'cp_campaign_url' => $cp_campaign_url,
		'cp_status' => $cp_status,

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Add Campaign by HTML
function wpcp_add_html_campaign($api_key, $cp_campaign_name, $cp_list_id, $cp_email_subject, $cp_dts, $cp_campaign_type, $cp_email_body, $cp_email_text, $cp_status){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'add_campaign',
		'cp_api_key' => $api_key,
		'cp_campaign_name' => $cp_campaign_name,
		'cp_list_id' => $cp_list_id,
		'cp_email_subject' => $cp_email_subject,
		'cp_dts' => $cp_dts,
		'cp_campaign_type' => $cp_campaign_type,
		'cp_email_body' => $cp_email_body,
		'cp_email_text' => $cp_email_text,
		'cp_status' => $cp_status,


	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Update URL Campaign
function wpcp_update_url_campaign($api_key, $cp_campaign_name, $cp_list_id, $cp_email_subject, $cp_dts, $cp_campaign_type, $cp_campaign_url, $cp_status, $cp_campaign_id){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'update_campaign',
		'cp_api_key' => $api_key,
		'cp_campaign_name' => $cp_campaign_name,
		'cp_list_id' =>	$cp_list_id,
		'cp_campaign_id' => $cp_campaign_id,
		'cp_email_subject' => $cp_email_subject,
		'cp_dts' => $cp_dts,
		'cp_campaign_type' => $cp_campaign_type,
		'cp_campaign_url' => $cp_campaign_url,
		'cp_status' => $cp_status,

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Update HTML Campaign
function wpcp_update_html_campaign($api_key, $cp_campaign_name, $cp_list_id, $cp_email_subject, $cp_dts, $cp_campaign_type, $cp_email_body, $cp_email_text, $cp_status, $cp_campaign_id){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'update_campaign',
		'cp_api_key' => $api_key,
		'cp_campaign_name' => $cp_campaign_name,
		'cp_list_id' =>	$cp_list_id,
		'cp_campaign_id' => $cp_campaign_id,
		'cp_email_subject' => $cp_email_subject,
		'cp_dts' => $cp_dts,
		'cp_campaign_type' => $cp_campaign_type,
		'cp_email_body' => $cp_email_body,
		'cp_email_text' => $cp_email_text,
		'cp_status' => $cp_status,

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Find Subscriber
function wpcp_find_subscriber( $api_key, $wpcp_email ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'find_subscriber',
		'cp_api_key' => $api_key,
		'cp_subscriber' => $wpcp_email

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;


}

### Schedule Email Post
function wpcp_schedule_email_type_post( $api_key, $post_id, $post_gmt, $upload_directory, $schedule ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'schedule_email_type_post',
		'cp_api_key' => $api_key,
		'cp_post_id' => $post_id,
		'cp_post_gmt' => $post_gmt,
		'cp_upload_dir' => $upload_directory,
		'cp_schedule' => $schedule

	);


	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Validate API Key
function wpcp_validate_api( $api_key , $api_update = NULL ){

	// Check if the API has been validated in the last 24 hours
	if ( false === ( get_transient( 'wpcp_api_validate' ) ) && $api_update == NULL ) {

	     ### Pull in Global Variables
		global $cp_options;

		//Create a post to the API
		$post_options = array(

			'cp_method' => 'validate',
			'cp_api_key' => $api_key

		);

		set_transient( 'wpcp_api_validate', wpcp_curl($cp_options['api_url'], $post_options), 24 * HOUR_IN_SECONDS );

		$result = get_transient( 'wpcp_api_validate' );

	} else {

		$result = get_transient( 'wpcp_api_validate' );

	}

	return $result;

}

### Import List
function wpcp_import_list( $api_key, $cp_list_import, $cp_list_id ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'import_list',
		'cp_api_key' => $api_key,
		'cp_list_import' => $cp_list_import,
		'cp_list_id' => $cp_list_id

	);

	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Get Campaign Stats
function wpcp_get_campaign_stats( $api_key, $wpcp_campaign_id ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'get_campaign_stats',
		'cp_api_key' => $api_key,
		'cp_campaign_id' => $wpcp_campaign_id

	);

	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Send Preview Email
function wpcp_send_preview( $api_key, $wpcp_campaign_url, $wpcp_email_address ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'send_preview',
		'cp_api_key' => $api_key,
		'cp_campaign_url' => $wpcp_campaign_url,
		'cp_email_address' => $wpcp_email_address
	);

	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Add Campaign
function wpcp_create_campaign( $api_key, $wpcp_campaign_name, $wpcp_list_id, $wpcp_email_subject, $wpcp_dts, $wpcp_campaign_type, $wpcp_campaign_url, $wpcp_status, $wpcp_campaign_id, $wpcp_email_body ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'add_campaign',
		'cp_api_key' => $api_key,
		'cp_campaign_name' => $wpcp_campaign_name,
		'cp_list_id' => $wpcp_list_id,
		'cp_email_subject' => $wpcp_email_subject,
		'cp_dts' => $wpcp_dts,
		'cp_campaign_type' => $wpcp_campaign_type,
		'cp_campaign_url' => $wpcp_campaign_url,
		'cp_status' => $wpcp_status,
		'cp_campaign_id' => $wpcp_campaign_id,
		'cp_email_body' => $wpcp_email_body

	);

	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;


}

### Get Campaign ID for Validation purposes
function wpcp_fetch_campaign_id( $api_key, $wpcp_campaign_id, $wpcp_campaign_type ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'fetch_campaign_id',
		'cp_api_key' => $api_key,
		'cp_campaign_id' => $wpcp_campaign_id,
		'cp_campaign_type' => $wpcp_campaign_type

	);

	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

### Create Campaign ID
function wpcp_create_campaign_id( $api_key ){

	### Pull in Global Variables
	global $cp_options;

	//Create a post to test the API
	$post_options = array(

		'cp_method' => 'create_campaign_id',
		'cp_api_key' => $api_key

	);

	$result = wpcp_curl($cp_options['api_url'], $post_options);

	return $result;

}

function wpcp_load_reports( $cp_report_name ){

	### Pull in Global Variables
	global $cp_options;

	### Get Account Settings
	$options = get_option('circupress-account');
	$wpcp_apikey = stripslashes($options['wpcp_apikey']);

	//Create a post to the API
	$post_options = array(

		'cp_method' => 'report',
		'cp_api_key' => $wpcp_apikey,
		'cp_report' => $cp_report_name

	);

	//Get the Report
	return wpcp_curl($cp_options['report_url'], $post_options);

}
?>