<?php
/**
 * The Template for displaying all single posts with post type of email
 *
 * @package Circupress
 */

if( isset( $_GET['p'] ) && strlen( $_GET['p'] ) > 0 ){
	// Remove all Actions so that only the post content is shown
	remove_all_actions( 'the_content' );
	
	error_reporting(0);
	$wpcp_account_options = get_option('circupress-account');
	$wpcp_email_editor_options = get_option('circupress-email-editor');
	$wpcp_apikey = stripslashes($wpcp_account_options['wpcp_apikey']);
	$wpcp_email_template = stripslashes($wpcp_account_options['wpcp_email_template']);
	$wpcp_email_header = stripslashes($wpcp_email_editor_options['wpcp_email_header']);
	$wpcp_template = "wpcp_template_".substr($wpcp_email_template,0,-4);
	$wpcp_template_head = strtolower($wpcp_template."_header");
	$wpcp_template_side = strtolower($wpcp_template."_sidebar");
	$wpcp_header_image = get_option( $wpcp_template_head );
	$wpcp_sidebar = get_option( $wpcp_template_side );
	$wpcp_fb = stripslashes( $wpcp_account_options['wpcp_social_fb'] );
	$wpcp_twitter = stripslashes( $wpcp_account_options['wpcp_social_twitter'] );
	$wpcp_google_plus = stripslashes( $wpcp_account_options['wpcp_social_google_plus'] );
	
	// Get the desired post id from the GET variable
	if( isset( $_GET['p'] ) && strlen( $_GET['p'] ) > 0 ){
		
		$wpcp_post_id = $_GET['p'];
		
		$wpcp_args =   array( 'post_type' => 'email', 'posts_per_page' => 1, 'p' => $wpcp_post_id );
		
	} else {
				
		$wpcp_args = array( 'post_type' => 'email', 'posts_per_page' => 1 );
	
	}
	
	$email = new WP_Query( $wpcp_args );
	while ( $email->have_posts() ) : $email->the_post();
		$wpcp_post_title = get_the_title();
	endwhile;
			
	// Reset Wordpress 
	wp_reset_query();
		
	// Get the Template Path
	$wpcp_path = WPCP_TEMPLATE_BASE.'/'.$wpcp_email_template;
	
	// Get the email content
	$wpcp_content = wpcp_include_file_to_var( $wpcp_path );
	
	// Merge Tags
	$wpcp_content = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content);
	$wpcp_content = str_replace('%%FIRST_NAME%%', '', $wpcp_content);
	$wpcp_content = str_replace('%%LAST_NAME%%', '', $wpcp_content);
	$wpcp_content = str_replace('%%UNSUB%%', '', $wpcp_content);
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
	
	
	if( isset( $_POST['send_preview'] ) && $_POST['send_preview'] == 1  && isset( $_POST['email_address'] ) && strlen( $_POST['email_address'] ) > 0 && isset( $_POST['campaign_url'] ) && strlen( $_POST['campaign_url'] ) > 0 ){
		
		// Extract CSS
		$css = wpcp_get_css( $wpcp_content );
		if( $css == '' ){
			$css = '<style></style>';
		}
		
		$e = new Emogrifier( $wpcp_content, $css);

        $processedHTML = $e->emogrify();
		$processedHTML = preg_replace ("'<style[^>]*?>.*?</style>'si", "", $processedHTML);
		
		wpcp_send_preview( $wpcp_apikey, $processedHTML, $_POST['email_address'] );
		
	}
	
		
	$wpcp_content = str_replace('</head>', '<style>#menu {
    position: fixed;
    height: 40px;
    width: 100%;
    top: 0;
    left: 0;
    border-top: 5px solid #4B9EC9;
    background: #fff;
    -moz-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);
    -webkit-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);
    box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16);
    z-index: 100;
}
	
	.wpcp_show {
		position: fixed;
	    height: 30px;
		width: 100px;
	    top: 0px;
		left: 80%;
		border-bottom: 5px solid #4B9EC9;
		border-left: 5px solid #4B9EC9;
		border-right: 5px solid #4B9EC9;
		color: #5a5a5a;
		font-family: sans-serif;
		font-size: 14px;
		background: #fff;
		text-align:center;
		
		
	}
	
	
 
.w {
    width: 900px;
    margin: 0 auto;
    margin-bottom: 40px;
	text-align: center;
	color: #5a5a5a;
	font-family: sans-serif;
	font-size: 14px;
}
.wpcp_hide {
		position: fixed;
	    height: 30px;
		width: 100px;
	    top: 0px;
		left: 75%;
		border-bottom: 5px solid #4B9EC9;
		border-left: 5px solid #4B9EC9;
		border-right: 5px solid #4B9EC9;
		color: #5a5a5a;
		font-family: sans-serif;
		font-size: 14px;
		background: #fff;
		text-align:center;
		z-index: 101;
		
	}
<br type="_moz"></style>


</head>', $wpcp_content );
	$wpcp_content = str_replace('</body>', '<div id="menu">
   <div id="send_preview" class="w">
      <form action="" method="POST"><label>Send Preview Email To:</label><input type="text" name="email_address" size="40" />
      	<input type="hidden" name="send_preview" value="1" />
      	<input type="hidden" name="campaign_url" value="//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />
      	<input type="submit" value="Send" />
      </form>
   </div>
   
   
   
</div>
<div id="wpcp_show" class="wpcp_hide">
	<label title="Show Preview Form" onclick="show_div();" style="margin-top:10px;" >Show</label>
</div>
<div id="wpcp_hide" class="wpcp_hide">
	<label title="Hide Preview Form" onclick="hide_div();" style="margin-top:10px;"  >Hide</label>
</div>
<script type="text/javascript">
    function hide_div() {
        document.getElementById(\'menu\').style.visibility = \'hidden\';
		document.getElementById(\'wpcp_hide\').style.visibility = \'hidden\';
		document.getElementById(\'wpcp_show\').style.visibility = \'visible\';
		
	}
	
	function show_div() {
        document.getElementById(\'menu\').style.visibility = \'visible\';
		document.getElementById(\'wpcp_hide\').style.visibility = \'visible\';
		document.getElementById(\'wpcp_show\').style.visibility = \'hidden\';
		
	}
</script>

', $wpcp_content);	
	
	echo $wpcp_content;	
		
	remove_filter('posts_where', 'filter_where');
	
	
} else {
	if( file_exists( get_template_directory().'/single.php') ){
		include( get_template_directory().'/single.php' );
	} else {
		?>
		<?php /* The loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>		
				<?php echo the_content(); ?>
		<?php endwhile; ?>
		<?php
	}
}


?>
