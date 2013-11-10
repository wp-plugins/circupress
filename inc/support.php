<?php
/* 
*
* CircuPress Support Page
*
*/

if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
} else {
	
	// Get Users API Key
	$wpcp_api_key = stripslashes(get_option('wpcp_apikey') ); 
	
?>
<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-email"><br /></div><h2>CircuPress Support</h2>
	<?php settings_errors(); ?>

	<!-- Start the CircuPress Email -->
	<div class="postbox-container" style="width:65%;">
		<div class="metabox-holder">	
            <div class="meta-box-sortables">
            	<div id="list_statistics" class="postbox" style="width:100%;">
                    <h3 class="hndle"><span>Getting Started</span></h3>
                    <div class="inside" style="padding: 0 15px">
	                    <div id="pagedata" style="width:100%">
	                    	<h4>Welcome to CircuPress!</h4>
	                    	<p>We wanted to provide you with a short tutorial here on how to setup your account.</p>
	                    	<ol>
	                    		<li>Create your account at <a href="https://circupress.com/admin/signup.php" target="_blank">CircuPress</a> and you'll receive your API Key.</li>
								<li>Add that <strong>API Key</strong> to your <a href="/wp-admin/edit.php?post_type=email&page=circupress-account">Account Page</a></li>
								<li>Fill in all the required <strong>Email Settings Fields</strong> on the  <a href="/wp-admin/edit.php?post_type=email&page=circupress-account">Account Page</a></li>
								<li>Select the <strong>Email Templates</strong> on the  <a href="/wp-admin/edit.php?post_type=email&page=circupress-account">Account Page</a></li>
								<li>Move to the <a href="/wp-admin/edit.php?post_type=email&page=circupress-template">Editor tab</a> and <strong>customize your email template</strong> with your own header and, optional, sidebar.</li>
								<li><strong>That's it!</strong> You're ready to send email with CircuPress.</li>
	                    	</ol>
	                    	
	             		<h4>More info on Email Templates</h4>
	             		<p>We've already supplied the necessary email templates to send a single email, a daily digest of your blog posts, and a weekly digest of your blog posts. Here's how they work:</p>
	             		<ul style="list-style-type:circle; margin: 10px 0 10px 20px">
	             			<li><strong>Email Template:</strong> - Just as you would write a blog post, this template enables you to <a href="/wp-admin/post-new.php?post_type=email">write and send an email</a> directly from WordPress. When you click send, CircuPress comes and gets your content, builds the email, and sends it for you!</li>
	             			<li><strong>Daily Digest Template:</strong> - If you're writing great content and folks want to get a daily email with that content, this template allows you to do it. No fuss, no muss… just write blog posts and the email will be sent out by CircuPress. Just a note: If you have a lot of subscribers, be careful - this could drive up your monthly sends pretty quick!</li>
	             			<li><strong>Weekly Digest Template:</strong> - As an alternative to the daily email, this template allows you to send a weekly email with that content. Write your blog posts and the email will be sent out by CircuPress.</li>
	             		</ul>
	             		<p>While the scheduled emails are automatically sent, don't worry if you haven't written any posts… we check before we send the email!</p>
	             		<h4>Need More Help?</h4>
	             		<p>On the right side of the page, you'll see a CircuPress tab - click that and it will open up our support ticket and knowledge base system. And of course, feature requests are welcome since we're just getting started!</p>
	             		<h4>How to Insert a Subscribe Form</h4>
	             		We have 3 methods of including a subscribe form on your site:
	             		<ul style="list-style-type:circle; margin: 10px 0 10px 20px">
	             			<li><strong>Sidebar Widget</strong> - Just drag and drop the CircuPress widget to your sidebar!</li>
	             			<li><strong>Shortcode</strong> - Syntax: You can set a horizontal or vertical layout, including the style tag.<br /><code>[circupress buttontext="Subscribe!" layout="horizontal" style="width:500px"]Be sure to sign up for updates![/circupress]</code></li>
	             			<li><strong>Function</strong> - Syntax: You can set a horizontal or vertical layout, including the style tag.<br /><code>&lt;?php echo wpcp_circupressform( 'buttontext=&gt;"Subscribe!", style=&gt;"margin: 10px;", layout=&gt;"horizontal"', $content='Subscribe Today!' ); ?&gt;</code></li>
	             		</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div style="float:right;width:33%;">
		<div class="metabox-holder">	
            <div class="meta-box-sortables">
            	<div id="list_statistics" class="postbox" style="width:100%;">
            		<h3 class="hndle"><span>CircuPress News &amp; Updates</span></h3>
					<div class="inside" style="padding: 0 15px">
						<?php // Get RSS Feed(s)
							include_once( ABSPATH . WPINC . '/feed.php' );

							// Get a SimplePie feed object from the specified feed source.
							$rss = fetch_feed( 'http://www.circupress.com/feed/' );

							if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

    						// Figure out how many total items there are, but limit it to 5. 
    						$maxitems = $rss->get_item_quantity( 5 ); 

    						// Build an array of all the items, starting with element 0 (first element).
    						$rss_items = $rss->get_items( 0, $maxitems );

							endif;
						?>

						<ul>
    					<?php if ( $maxitems == 0 ) : ?>
        					<li><?php _e( 'No items', 'my-text-domain' ); ?></li>
    					<?php else : ?>
        				<?php // Loop through each feed item and display each item as a hyperlink. ?>
        				<?php foreach ( $rss_items as $item ) : ?>
            				<li>
            					<h4><?php echo $item->get_date('F j, Y g:i a'); ?>: <a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('F j, Y g:i a') ); ?>" target="_blank">
                    	<?php echo esc_html( $item->get_title() ); ?></a></h4><p><?php echo $item->get_description(); ?></p>
            				</li>
        				<?php endforeach; ?>
    					<?php endif; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>			
	</div>
</div>
<?php } ?>