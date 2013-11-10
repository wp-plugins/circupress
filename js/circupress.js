/*
 
CircuPress Ajax Subscription 

*/
jQuery(document).ready(function() {
	jQuery('input.wpcp_submit').click(wpcp_subscribe_submit);
});

function wpcp_subscribe_submit(){

	var ajaxurl = jQuery('#wpcp_runto').val();	
	var wpcp_subscribe_form;
	var wpcp_first_name = jQuery('#wpcp_first_name').val();
	var wpcp_last_name = jQuery('#wpcp_last_name').val();
	var wpcp_email_address = jQuery('#wpcp_email_address').val();
	
	if (jQuery("#wpcp_daily_digest").length > 0){
		
		if (jQuery('#wpcp_daily_digest').attr('checked')) {
	        var wpcp_daily_digest = '1';
		} else {
			var wpcp_daily_digest = '0';
		} 
		
	} else {
		
		var wpcp_daily_digest = '0';
	
	}
	
	if (jQuery("#wpcp_weekly_digest").length > 0){
		
		if (jQuery('#wpcp_weekly_digest').attr('checked')) {
	        var wpcp_weekly_digest = '1';
		} else {
			var wpcp_weekly_digest = '0';
		} 
		
	} else {
		
		var wpcp_weekly_digest = '0';
	
	}
	
	wpcp_subscribe_form = "wpcp_email_address=" + encodeURIComponent(wpcp_email_address) + "&wpcp_first_name=" + encodeURIComponent(wpcp_first_name) +"&wpcp_last_name=" + encodeURIComponent(wpcp_last_name) + "&action=" + encodeURIComponent('wpcp_subscriber_optin') + "&wpcp_daily_digest=" +encodeURIComponent(wpcp_daily_digest) + "&wpcp_weekly_digest=" +encodeURIComponent(wpcp_weekly_digest);

	jQuery.ajax({
		type:"POST",
		url: ajaxurl + "/wp-admin/admin-ajax.php",
		data: wpcp_subscribe_form,
		success:function(data){
			jQuery("#wpcp_response").html(data);
			jQuery("#circupress-container").hide();
		}
	});
	
}