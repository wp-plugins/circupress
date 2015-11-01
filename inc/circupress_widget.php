<?php
### Circupress Optin Form Widget

/** Add our function to the widgets_init hook. **/
add_action('init', 'wpcp_enqueue');

function circupress_optin_form() {
	register_widget( 'circupress_optin_widget' );
}

add_action( 'widgets_init', 'circupress_optin_form' );

/** Define the Widget as an extension of WP_Widget **/
class circupress_optin_widget extends WP_Widget {
	function circupress_optin_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'circupress-email-optin', 'description' => 'Adds an email optin form to your sidebar' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'circupress-email-optin' , 'width' => 400, 'height' => 350);

		/* Create the widget. */
		$this->WP_Widget( 'circupress-email-optin', 'CircuPress Email Optin Form', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract($args, EXTR_SKIP);

		$circupress_title =  apply_filters( 'widget_title', $instance['title'] );
		$circupress_layout =  apply_filters( 'widget_title', $instance['layout'] );
		$circupress_description =  apply_filters( 'widget_title', $instance['description'] );
		$circupress_style =  apply_filters( 'widget_title', $instance['style'] );
		$circupress_button =  apply_filters( 'widget_title', $instance['button'] );

		echo $before_widget;
		echo $before_title.$circupress_title.$after_title;
		echo $circupress_description;

		$wpcp_sform = wpcp_buildform($content, $circupress_layout, $circupress_button, $circupress_style, $instance);

    	echo $wpcp_sform;
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['layout'] = $new_instance['layout'];
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		$instance['button'] = strip_tags( $new_instance['button'] );
		$instance['circupress_list_id'] = strip_tags( $new_instance['circupress_list_id'] );

		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Join our Email List!', 'layout' => 'vertical', 'description' => '', 'style' => '' , 'button' => 'Subscribe!');
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'description' ); ?>">Description:</label><br />
		<textarea class="widefat monospace" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" rows="3" cols="20"><?php echo $instance['description']; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'layout' ); ?>">Layout:</label><br />
		&nbsp;<input type="radio" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" value="vertical" <?php checked( 'vertical', $instance['layout'] ); ?> />&nbsp;Vertical&nbsp;&nbsp;
        &nbsp;<input type="radio" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>" value="horizontal" <?php checked( 'horizontal', $instance['layout'] ); ?> />&nbsp;Horizontal
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'button' ); ?>">Button Text:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" value="<?php echo $instance['button']; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'style' ); ?>">Additional Styling:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>" value="<?php echo $instance['style']; ?>" />
		</p>
		<?php 
			$wpcp_options = get_option('circupress-account');
			$wpcp_api_key = stripslashes($wpcp_options['wpcp_apikey']);
			$lists = json_decode( wpcp_get_lists( $wpcp_api_key ), true );
		?>
		<input type="hidden" name="wpcp_email_list" value="<?php echo $lists[0]['list_id']; ?>" />
		<?php
	}
}

?>