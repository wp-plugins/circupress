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
	$wpcp_content = str_replace('%%SOCIAL%%', wpcp_build_social($wpcp_account_options, 'center'), $wpcp_content);
	$wpcp_content = str_replace('%%SOCIAL_RIGHT%%', wpcp_build_social($wpcp_account_options, 'right'), $wpcp_content);
	$wpcp_content = str_replace('%%SOCIAL_LEFT%%', wpcp_build_social($wpcp_account_options, 'left'), $wpcp_content);
	
	// Add WordPress auto formatting from text editor
	$wpcp_content = wpautop( $wpcp_content );
	
	// Apply Shortcodes
	$wpcp_content = do_shortcode( $wpcp_content );
	
	if( isset( $_POST['send_preview'] ) && $_POST['send_preview'] == 1  && isset( $_POST['email_address'] ) && strlen( $_POST['email_address'] ) > 0 && isset( $_POST['campaign_url'] ) && strlen( $_POST['campaign_url'] ) > 0 ){
		
		wpcp_send_preview( $wpcp_apikey, $wpcp_content, $_POST['email_address'] );
		
	}
	
		
	$wpcp_content = str_replace('</head>', '<style>
#menu { position: fixed; height: 60px; width: 100%; top: 0; left: 0; border-top: 2px solid #4B9EC9; background: #fff; -moz-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16); -webkit-box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16); box-shadow: 0 2px 3px 0px rgba(0, 0, 0, 0.16); z-index: 100; }
	
.wpcp_show { position: fixed; height: 40px; width: 100px; top: 0px; left: 80%; border-bottom: 5px solid #4B9EC9; border-left: 5px solid #4B9EC9; border-right: 5px solid #4B9EC9; color: #5a5a5a; font-family: sans-serif; font-size: 15px; background: #fff; text-align:center; padding: 15px 0 0 0; }
	
input[type=text] { border-color: #dfdfdf;background-color: #fff; color: #333; -webkit-border-radius: 3px; border-radius: 3px; border-width: 1px; border-style: solid; margin: 1px; padding: 3px; line-height: 15px;}
	
#send_preview { margin: 15px 0 15px 50px; }

.button-primary { display:inline-block;text-decoration:none;font-size:12px;line-height:23px;height:24px;margin:0;padding:0 10px 1px;cursor:pointer;border-width:1px;border-style:solid;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box; height: 30px; line-height: 28px; padding: 0 12px 2px; background-color:#21759b;background-image:-webkit-gradient(linear,left top,left bottom,from(#2a95c5),to(#21759b));background-image:-webkit-linear-gradient(top,#2a95c5,#21759b);background-image:-moz-linear-gradient(top,#2a95c5,#21759b);background-image:-ms-linear-gradient(top,#2a95c5,#21759b);background-image:-o-linear-gradient(top,#2a95c5,#21759b);background-image:linear-gradient(to bottom,#2a95c5,#21759b);border-color:#21759b;border-bottom-color:#1e6a8d;-webkit-box-shadow:inset 0 1px 0 rgba(120,200,230,.5);box-shadow:inset 0 1px 0 rgba(120,200,230,.5);color:#fff;text-decoration:none;text-shadow:0 1px 0 rgba(0,0,0,.1); }

.button-secondary { margin: 15px 0; }
 
.w { width: 900px; margin: 0 auto; margin-bottom: 40px; text-align: center; color: #5a5a5a; font-family: sans-serif; font-size: 14px; }

.wpcp_hide { position: fixed; height: 40px; width: 100px; top: 0px; left: 75%; border-bottom: 5px solid #4B9EC9; border-left: 5px solid #4B9EC9; border-right: 5px solid #4B9EC9; color: #5a5a5a; font-family: sans-serif; font-size: 14px; background: #fff; text-align:center; z-index: 101; padding: 15px 0 0 0; }

.wpcp_hide label, .wpcp_show label { cursor: pointer; font-weight: 600; }
<br type="_moz"></style>

</head>', $wpcp_content );
	$wpcp_content = str_replace('</body>', '<div id="menu">
   <div id="send_preview" class="w">
      <form action="" method="POST"><label>Send Preview Email To:</label>&nbsp;<input type="text" name="email_address" size="40" />
      	<input type="hidden" name="send_preview" value="1" />
      	<input type="hidden" name="campaign_url" value="//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" />
      	<input type="submit" class="button-primary" value="Send Email" />
      </form>
   </div>
</div>
<div id="wpcp_show" class="wpcp_hide">
	<label title="Show Preview Form" onclick="show_div();">Show</label>
</div>
<div id="wpcp_hide" class="wpcp_hide">
	<label title="Hide Preview Form" onclick="hide_div();">Hide</label>
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