<?php
/**
 * CircuPress Editor.
 *
 * @package WordPress
 * @subpackage Administration
 */

if ( is_multisite() && ! is_network_admin() ) {
	wp_redirect( network_admin_url( 'theme-editor.php' ) );
	exit();
}

if ( !current_user_can('edit_themes') )
	wp_die('<p>'.__('You do not have sufficient permissions to edit templates for this site.').'</p>');

// Verify the account is properly set up
wpcp_wizard();

$title = __("CircuPress Template Editor");
$uploads = wp_upload_dir(); // Array of key => value pairs
$dir = WPCP_TEMPLATE_BASE.'/';

$template_files = wpcp_get_template_files();

if( isset( $_POST['file']) ){

	$file = $_POST['file'];
	$real_file = $dir.$file;
	while (list( $name, $value) = each($template_files)) {
		if( $file == $value ){
			$wpcp_template_name = $name;
		}
	}

} elseif ( empty( $_GET['file'] ) ) {

	$x = 1;
	while (list( $name, $value) = each($template_files)) {
		if( $x == 1 ){
			$file = $value;
			$real_file = $dir.$value;
			$wpcp_template_name = $name;
		}
	   $x++;
	}

} else {
	$file = $_GET['file'];
	$real_file = $dir.$file;
	while (list( $name, $value) = each($template_files)) {
		if( $file == $value ){
			$wpcp_template_name = $name;
		}
	}
}

$scrollto = isset($_REQUEST['scrollto']) ? (int) $_REQUEST['scrollto'] : 0;

$action = $_POST['action'];

switch ( $action ) {

case 'update':

	check_admin_referer('edit-theme_' . $file);

	$newcontent = wp_unslash( $_POST['newcontent'] );
	if ( is_writeable( $dir.$_POST['file'] ) ) {
		$f = fopen( $dir.$_POST['file'], 'w+');
		fwrite($f, $newcontent);
		fclose($f);
	} else {

	}

	break;

case 'wpcp_head':

		if( isset( $_POST['wpcp_template_head'] ) && strlen( $_POST['wpcp_template_head'] ) > 0 && isset( $_POST['wpcp_header'] ) ){

			// Update/Insert the Header Value
			update_option( $_POST['wpcp_template_head'], $_POST['wpcp_header'] );

		}

		if( isset( $_POST['wpcp_template_side'] ) && strlen( $_POST['wpcp_template_side'] ) > 0 ){

			// Update/Insert the Header Value
			update_option( $_POST['wpcp_template_side'], $_POST['wpcp_sidebar'] );

		}
	break;
	
case 'wpcp_remove':

	if( isset( $_POST['template_file'] ) && strlen( $_POST['template_file'] ) > 0 ){
	
		wpcp_remove_template($_POST['template_file']);
	
	}

	break;

default:

	break;
}

	// List of allowable extensions
	$editable_extensions = array('php');
	$editable_extensions = (array) apply_filters('editable_extensions', $editable_extensions);

	if ( ! is_file($real_file) ) {
		wp_die(sprintf('<p>%s</p>', __('No such file exists! Double check the name and try again.')));
	} else {
		// Get the extension of the file
		if ( preg_match('/\.([^.]+)$/', $real_file, $matches) ) {
			$ext = strtolower($matches[1]);
			// If extension is not in the acceptable list, skip it
			if ( !in_array( $ext, $editable_extensions) )
				wp_die(sprintf('<p>%s</p>', __('Files of this type are not editable.')));
		}
	}

	get_current_screen()->add_help_tab( array(
	'id'		=> 'overview',
	'title'		=> __('Overview'),
	'content'	=>
		'<p>' . __('You can use the editor to make changes to any of your CircuPress template individual PHP files.') . '</p>' .
		'<p>' . __('Click once on any file name to load it in the editor, and make your changes. Don&#8217;t forget to save your changes (Update Template) when you&#8217;re finished.') . '</p>' .
		'<p id="newcontent-description">' . __('In the editing area the Tab key enters a tab character. To move below this area by pressing Tab, press the Esc key followed by the Tab key.') . '</p>' .
		'<p>' . __('If you want to make changes but don&#8217;t want them to be overwritten when the template is updated, you may be ready to think about writing your own template. For information on how to edit templates, write your own from scratch, or just better understand their anatomy, check out the links below.') . '</p>' .
		( is_network_admin() ? '<p>' . __('Any edits to files from this screen will be reflected on all sites in the network.') . '</p>' : '' )
	) );

	get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('For more information:') . '</strong></p>' .
		'<p>' . __('<a href="http://www.circupress.com/templates/" target="_blank">Documentation on Editing Templates</a>') . '</p>'
	);

	$content = file_get_contents( $real_file );
	$content = esc_textarea( $content );

	?>
<div class="wrap">
<?php if (isset($_GET['a'])) : ?>
 <div id="message" class="updated"><p><?php _e('File edited successfully.') ?></p></div>
 
<?php elseif (isset($_GET['r'])) : ?>
 <div id="message" class="updated"><p><?php _e('Files removed successfully.') ?></p></div>

<?php elseif (isset($_GET['phperror'])) : ?>
 <div id="message" class="updated"><p><?php _e('Editing the file resulted in a <strong>fatal error</strong>.') ?></p>
 </div>
<?php endif; ?>

<?php screen_icon(); ?>
<h2><?php echo esc_html( $title ); ?></h2>

	<p>Use the <strong>customize</strong> tab to make simple edits to your email template, including the header image and (optional) sidebar content. Advanced users can actually <strong>edit</strong> the email template (we recommend copying and making a new one). Don't worry about plugin updates, we won't overwrite your templates - we've put them safely in the uploads directory of WordPress.</p>
	
	<big><?php _e('Your CircuPress Templates:'); ?></big>
	
	<p>Click on a template to make changes. You are currently working on the highlighted template. If you wish to remove a template, check the box and click Remove Template.<br /><strong>Note:</strong> Deleting the latest distributed templates will cause them to be replaced rather than removed. If you delete a modified template, there is no way to restore it.</p>
	
	<form name="wpcp_template" id="wpcp_template" action="edit.php?post_type=email&page=circupress-template&r=true" method="post">

	<ul style="margin-left: 10px">
<?php
foreach ( $template_files as $template_file_name => $template_file ) :

	// Get the extension of the file
	if ( preg_match('/\.([^.]+)$/', $template_file, $matches) ) {
		$ext = strtolower($matches[1]);
		// If extension is not in the acceptable list, skip it
		if ( !in_array( $ext, $editable_extensions ) )
			continue;
	} else {
		// No extension found
		continue;
	}
	
?>
		<li<?php echo $file == $template_file ? ' class="highlight " style="font-weight:bold"' : ''; ?>> <input type="checkbox" name="template_file" value="<?php echo urlencode( $template_file ) ?>" /><a href="edit.php?post_type=email&page=circupress-template&file=<?php echo urlencode( $template_file ) ?>"><?php echo $template_file_name.'<span class="nonessential"> ('.$template_file.')</span>'; ?></a></li>
<?php

	endforeach; ?>
	</ul>
	
	<input type="hidden" name="action" value="wpcp_remove" />
	
	<p class="submit">
		<?php submit_button( __( 'Remove Templates' ), 'primary', 'submit', false ); ?>
	</p>
	
	</form>

<?php if ( $error ) :
	echo '<div class="error"><p>' . __('Oops, no such file exists! Double check the name and try again, merci.') . '</p></div>';
else : ?>


<?php

if ( isset ( $_GET['tab'] ) ) $wpcp_tab = $_GET['tab']; else $wpcp_tab = 'customize' ;
endif;

wpcp_admin_tabs( $wpcp_tab );
?>
<div style="float:left;width:80%;padding-top:10px;">
<?php
switch ( $wpcp_tab ){
  	case 'customize' :

  		echo '<p>Update your email header image and optional sidebar content here. We recommend a 600px wide header image!</p>';

		$wpcp_template = "wpcp_template_".substr($file,0,-4);
		$wpcp_template_head = strtolower($wpcp_template."_header");
		$wpcp_template_side = strtolower($wpcp_template."_sidebar");
		$wpcp_header_image = get_option( $wpcp_template_head );
		$wpcp_sidebar = get_option( $wpcp_template_side );


		?>
			<form name="wpcp_header" id="wpcp_header" action="edit.php?post_type=email&page=circupress-template&tab=customize&file=<?php echo esc_attr( $file ); ?>" method="post">
				<div class="uploader">
						<h3>Header Image:</h3>
						<?php if($file == "") { ?>
						<input type="text" value="<?php echo $wpcp_header_image; ?>" id="wpcp_header" size="55" name="wpcp_header" />
						<input type="button" class="cp_upload button-primary" value="<?php _e("Upload Header Image", 'wpcp'); ?>" />
						<br /><span>Enter a new image location or upload an image from your computer.</span>

						<?php } else { ?>

						<p>Your current header image is:<br />
						<img src="<?php echo $wpcp_header_image; ?>" /></p>

						<input type="text" value="<?php echo $wpcp_header_image; ?>" id="wpcp_header" size="55" name="wpcp_header" />
						<input type="button" class="cp_upload button-primary" value="<?php _e("Change Header Image", 'wpcp'); ?>" />
						<br /><span>Enter the image location or upload an image from your computer.</span>

						<?php } ?>

						<input type="hidden" name="action" value="wpcp_head" />
						<input type="hidden" name="file" value="<?php echo esc_attr( $file ); ?>" />
						<input type="hidden" name="wpcp_template_head" value="<?php echo $wpcp_template_head; ?>" />
						<input type="hidden" name="wpcp_template_side" value="<?php echo $wpcp_template_side; ?>" />
						<br />
						<br />
						<div
						<?php

							if(strpos(strtolower($wpcp_template_name),"sidebar")>0) {
								echo '>';
							} else {
								echo 'style="display:none" >';
							}

						?>

							<h3><label for="<?php echo $wpcp_template_side; ?>">Email Sidebar HTML:</label></h3>
							<div>
								<?php

									wp_editor( stripslashes( $wpcp_sidebar ), 'wpcp_sidebar' );

								?>
							</div>
						</div>

						<p class="submit">
								<?php submit_button( __( 'Update Template' ), 'primary', 'submit', false ); ?>

						</p>
				</div>
			</form>

		<?php

	break;
	case 'edit' :

		echo '<p><strong>Proceed with caution!</strong> We would highly recommend you just copy and paste an existing template file rather than editing an original. At least back them up!</p>';

		if ( is_writeable($real_file) ) {
			?>
				<form name="template" id="template" action="edit.php?post_type=email&page=circupress-template&tab=edit&file=<?php echo esc_attr( $file ); ?>" method="post">
					<?php wp_nonce_field( 'edit-theme_' . $file ); ?>
					<div>
						<textarea cols="80" rows="25" name="newcontent" id="newcontent" aria-describedby="newcontent-description"><?php echo $content; ?></textarea>
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="file" value="<?php echo esc_attr( $file ); ?>" />
						<input type="hidden" name="scrollto" id="scrollto" value="<?php echo $scrollto; ?>" />
						<p class="submit">
							<?php submit_button( __( 'Update Template' ), 'primary', 'submit', false ); ?>
						</p>
					</div>
				</form>
			<?php
		} else { ?>
			<p><em><?php _e('You need to make this file writable before you can save your changes. See <a href="http://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.'); ?></em></p>
		<?php }
	break;
	case 'preview' :
				error_reporting(0);

		$wpcp_args = array( 'post_status' => 'publish', 'posts_per_page' => 1 );

		$posts = new WP_Query( $wpcp_args );
		while ( $posts->have_posts() ) : $posts->the_post();
			$wpcp_post_title = get_the_title();
		endwhile;

		echo '<div style="width: 95%">';
		$wpcp_account_options = get_option('circupress-account');
		$wpcp_email_header = stripslashes($wpcp_email_editor_options['wpcp_email_header']);
		$wpcp_fb = stripslashes( $wpcp_account_options['wpcp_social_fb'] );
		$wpcp_twitter = stripslashes( $wpcp_account_options['wpcp_social_twitter'] );
		$wpcp_google_plus = stripslashes( $wpcp_account_options['wpcp_social_google_plus'] );

		$wpcp_template = "wpcp_template_".substr($file,0,-4);
		$wpcp_template_head = strtolower($wpcp_template."_header");
		$wpcp_template_side = strtolower($wpcp_template."_sidebar");
		$wpcp_header_image = get_option( $wpcp_template_head );
		$wpcp_sidebar = get_option( $wpcp_template_side );

		$wpcp_content = wpcp_include_file_to_var( WPCP_TEMPLATE_BASE.'/'.$file );
		$wpcp_content = str_replace('%%POST_TITLE%%', $wpcp_post_title, $wpcp_content);
		$wpcp_content = str_replace('%%HEADER%%', $wpcp_header_image, $wpcp_content);
		$wpcp_content = str_replace('%%SIDEBAR%%', $wpcp_sidebar, $wpcp_content);
		$wpcp_content = str_replace('%%SOCIAL%%', wpcp_build_social($wpcp_account_options, 'center'), $wpcp_content);
		$wpcp_content = str_replace('%%SOCIAL_RIGHT%%', wpcp_build_social($wpcp_account_options, 'right'), $wpcp_content);
		$wpcp_content = str_replace('%%SOCIAL_LEFT%%', wpcp_build_social($wpcp_account_options, 'left'), $wpcp_content);
		$wpcp_content = str_replace('%%ONLINE%%', $wpcp_permalink, $wpcp_content);
		
	if( strlen( $wpcp_rss ) > 0 ){
		$wpcp_rss_full = '<a href="'.$wpcp_rss.'" class="soc-btn rss">RSS</a>';
		$wpcp_content = str_replace('%%RSS%%', $wpcp_rss_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%RSS%%', '', $wpcp_content);
	}
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
	if( strlen( $wpcp_linkedin ) > 0 ){
		$wpcp_linkedin_full = '<a href="'.$wpcp_linkedin.'" class="soc-btn li">LinkedIn</a>';
		$wpcp_content = str_replace('%%LINKEDIN%%', $wpcp_linkedin_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%LINKEDIN%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_instagram ) > 0 ){
		$wpcp_instagram_full = '<a href="'.$wpcp_instagram.'" class="soc-btn ig">Instagram</a>';
		$wpcp_content = str_replace('%%INSTAGRAM%%', $wpcp_instagram_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%INSTAGRAM%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_pinterest ) > 0 ){
		$wpcp_pinterest_full = '<a href="'.$wpcp_pinterest.'" class="soc-btn pi">Pinterest</a>';
		$wpcp_content = str_replace('%%PINTEREST%%', $wpcp_pinterest_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%PINTEREST%%', '', $wpcp_content);
	}
	if( strlen( $wpcp_youtube ) > 0 ){
		$wpcp_youtube_full = '<a href="'.$wpcp_youtube.'" class="soc-btn yt">YouTube</a>';
		$wpcp_content = str_replace('%%YOUTUBE%%', $wpcp_youtube_full, $wpcp_content);
	} else {
		$wpcp_content = str_replace('%%YOUTUBE%%', '', $wpcp_content);
	}

        $processedHTML = $wpcp_content;
		/*$processedHTML = preg_replace ("'<!DOCTYPE[^>]*?>'si", "", $processedHTML);
		$processedHTML = str_replace( '<html>', "", $processedHTML);
		$processedHTML = preg_replace ("'<head[^>]*?>.*?</head>'si", "", $processedHTML);
		$processedHTML = str_replace( '</html>', "", $processedHTML);
		$processedHTML = str_replace( '<body', "<div", $processedHTML);
		$processedHTML = str_replace( '</body', "</div", $processedHTML); */
		echo $processedHTML;
		echo '</div>';
		echo '<div>&nbsp;</div>';

	break;
	default:

	break;
}
?>

</div>
</div>
<br class="clear" />
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#template').submit(function(){ $('#scrollto').val( $('#newcontent').scrollTop() ); });
	$('#newcontent').scrollTop( $('#scrollto').val() );
});
</script>