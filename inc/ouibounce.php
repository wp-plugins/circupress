<?php
/*
*
* CircuPress Support Page
*
*/

include_once( ABSPATH . WPINC . '/feed.php' );
if (!current_user_can('manage_options'))  {
			wp_die( __('You do not have sufficient permissions to access this page.') );
} else {

	// Verify the account is properly set up
	wpcp_wizard();

	// Get Users API Key
	$wpcp_api_key = stripslashes(get_option('wpcp_apikey') );

?>
<div class="wrap">
	<div id="icon-edit" class="icon32 icon32-posts-email"><br /></div><h2>CircuPress Support</h2>
	<?php settings_errors(); ?>

	<!-- Start the CircuPress Email -->
	<div class="postbox-container" style="width:100%">
		<div class="metabox-holder">
            <div class="meta-box-sortables">
            	<div id="list_kb" class="postbox">
                    <h3 class="hndle"><span>Knowledge Base</span></h3>
                    <div class="inside" style="padding: 0 15px">
	                    <div id="pagedata" class="supportpage">
	                    	<?php

							wp_editor( $content, $editor_id );
							wp_editor( $content, $editor_id, $settings = array() );
 							wp_editor( 'Hello World! This is our first test! Enjoy!', 'ourmaineditor' );
 
							$args = array(
    							'textarea_rows' => 15,
    							'teeny' => true,
    							'quicktags' => false
							);
 
							wp_editor( 'This is the default text!', 'editor', $args );
							submit_button( 'Save content' );
 
							$post = get_post( 117, 'OBJECT' );
							wp_editor( $post, 'editor' );
 
							$settings = array(
    							'textarea_name' => 'content',
    							'media_buttons' => false,
    							'tinymce' => array(
        							'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
            						'bullist,blockquote,|,justifyleft,justifycenter' .
            						',justifyright,justifyfull,|,link,unlink,|' .
            						',spellchecker,wp_fullscreen,wp_adv'
    							)
							);
							wp_editor( '', 'content', $settings );
							?>							
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder">
            <div class="meta-box-sortables">
            	<div id="list_support" class="postbox">
                    <h3 class="hndle"><span>Support Threads</span></h3>
                    <div class="inside" style="padding: 0 15px">
	                    <div id="pagedata" class="supportpage">
	                    	<p>Support requests are responded through the <a href="https://wordpress.org/support/plugin/circupress" target="_blank">WordPress Support Forums</a>.</p>
	                    	<?php

							// Get a SimplePie feed object from the specified feed source.
							$rss = fetch_feed( 'https://wordpress.org/support/rss/plugin/circupress' );

							$maxitems = 0;

							if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

    							// Figure out how many total items there are, but limit it to 5. 
    							$maxitems = $rss->get_item_quantity( 10 ); 

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
                					<a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>" target="_blank"><?php echo esc_html( $item->get_title() ); ?></a>
            					</li>
        						<?php endforeach; ?>
    							<?php endif; ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="metabox-holder">
            <div class="meta-box-sortables">
            	<div id="list_news" class="postbox">
                    <h3 class="hndle"><span>CircuPress News</span></h3>
                    <div class="inside" style="padding: 0 15px">
	                    <div id="pagedata" class="supportpage">
	                    	<?php

							// Get a SimplePie feed object from the specified feed source.
							$rss = fetch_feed( 'https://circupress.com/news/feed/' );

							$maxitems = 0;

							if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly

    							// Figure out how many total items there are, but limit it to 5. 
    							$maxitems = $rss->get_item_quantity( 10 ); 

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
                					<a href="<?php echo esc_url( $item->get_permalink() ); ?>" title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>" target="_blank"><?php echo esc_html( $item->get_title() ); ?></a>
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

</div>
<?php } ?>

   <!-- Ouibounce Modal -->
    <div id="ouibounce-modal">
      <div class="underlay"></div>
      <div class="modal">
        <div class="modal-title">
          <h3>This is a Ouibounce modal</h3>
        </div>

        <div class="modal-body">
          <p>Thanks for stoping by!</p>
          <br>
          <p>You can style your Ouibounce modal however you see fit. You can also include big buttons, an email capture or just plain text. The sky's the limit!</p>
          <br>
          <p>Close this modal by clicking "No Thanks" below or clicking anywhere outside of the modal.</p>

          <form>
            <input type="text" placeholder="you@email.com">
            <input type="submit" value="learn more &raquo;">
            <p class="form-notice">*this is a fake form</p>
          </form>
        </div>

        <div class="modal-footer">
          <p>no thanks</p>
        </div>
      </div>
    </div>

    <!-- Example page JS        -->
    <!-- Used to fire the modal -->
    <script>

      // if you want to use the 'fire' or 'disable' fn,
      // you need to save OuiBounce to an object
      var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        aggressive: true,
        timer: 0,
        callback: function() { console.log('ouibounce fired!'); }
      });

      $('body').on('click', function() {
        $('#ouibounce-modal').hide();
      });

      $('#ouibounce-modal .modal-footer').on('click', function() {
        $('#ouibounce-modal').hide();
      });

      $('#ouibounce-modal .modal').on('click', function(e) {
        e.stopPropagation();
      });
    </script>