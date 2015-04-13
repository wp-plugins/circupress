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
		$this->WP_Widget( 'circupress-email-optin', 'Circupress Email Optin Form', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract($args, EXTR_SKIP);

		$circupress_title =  apply_filters( 'widget_title', $instance['title'] );
		$circupress_layout =  apply_filters( 'widget_title', $instance['layout'] );
		$circupress_description =  apply_filters( 'widget_title', $instance['description'] );
		$circupress_style =  apply_filters( 'widget_title', $instance['style'] );
		$circupress_button =  apply_filters( 'widget_title', $instance['button'] );

		$options = get_option('circupress-account');
		$wpcp_weekly_template = $options['wpcp_weekly_template'];
		$wpcp_daily_template = $options['wpcp_daily_template'];
		$circupress_list_id = $options['wpcp_circupress_list_id'];

		echo $before_widget;

		?>

			<?php echo $before_title.$circupress_title.$after_title; ?>

			<span id="wpcp_response"><?php echo $circupress_description; ?></span>

			<div id="circupress-container" style="<?php echo $circupress_style; ?>">

			<?php

			$wpcp_sform = '<form action="" method="post" id="wpcp_subscribe_form">';
	if ($circupress_layout == 'vertical') {
		$wpcp_sform .= '<table border="0" style="text-align:center; margin-top: 10px;">
							<tr>
								<td style="text-align:right;"><label for="wpcp_first_name">First Name:</label></td>
								<td style="text-align:left;"><input id="wpcp_first_name" name="wpcp_first_name" type="text" size="20" maxlength="255" /><input type="hidden" name="list_id" value="" /></td>
							</tr>
							<tr>
								<td style="text-align:right;"><label for="wpcp_last_name">Last Name:</label></td>
								<td style="text-align:left;"><input id="wpcp_last_name" name="wpcp_last_name" type="text" size="20" maxlength="255" /></td>
							</tr>
							<tr>
								<td style="text-align:right;"><label for="wpcp_email_address">Email Address:</label></td>
								<td style="text-align:left;"><input id="wpcp_email_address" name="wpcp_email_address" type="text" size="20" maxlength="255" /></td>
							</tr>';
		if( ($wpcp_daily_template != '0' ) || ($wpcp_weekly_template != '0')) {
			$wpcp_sform .= '<tr>
								<td style="text-align:right;">Receive:</td>';
			if( $wpcp_daily_template != '0' ){
				$wpcp_sform .='<td style="text-align:left;"><input type="checkbox" id="wpcp_daily_digest" name="wpcp_daily_digest"  /><label for="wpcp_daily_digest">Daily Digest</label><br />'; }
			if( $wpcp_weekly_template != '0' ){
				$wpcp_sform .='<input type="checkbox" id="wpcp_weekly_digest" name="wpcp_weekly_digest"  checked="checked" /><label for="wpcp_weekly_digest">Weekly Digest</label>'; }
				$wpcp_sform .='</td>
							</tr>'; }
			$wpcp_sform .= '<tr>
								<td colspan="2" style="text-align:right;"><input type="button" value="'.$circupress_button.'" id="wpcp_submit" name="btn_submit" class="wpcp_submit" onclick="wpcp_subscribe_submit()" /></td>
							</tr>
				</table>';
	} elseif ($circupress_layout == 'horizontal') {
		$wpcp_sform .= '<table border="0" style="text-align:center;">
							<tr>
								<td style="text-align:left;">
									<label for="wpcp_first_name">First Name:</label>&nbsp;
									<input id="wpcp_first_name" name="wpcp_first_name" type="text" size="20" maxlength="255" /><input type="hidden" name="list_id" value="" />
									<label for="wpcp_last_name">Last Name:</label>&nbsp;
									<input id="wpcp_last_name" name="wpcp_last_name" type="text" size="20" maxlength="255" />
								</td>
							</tr>
							<tr>
								<td style="text-align:left;">
									<label for="wpcp_email_address">Email Address:</label>&nbsp;
									<input id="wpcp_email_address" name="wpcp_email_address" type="text" size="30" maxlength="255" />
								</td>
							<tr>
								<td style="text-align:left;">';
			if(($wpcp_daily_template != '0')||($wpcp_weekly_template != '0')){
				$wpcp_sform .= 'Receive:&nbsp;';
				if( $wpcp_daily_template != '0' ){
					$wpcp_sform .= '<input type="checkbox" id="wpcp_daily_digest" name="wpcp_daily_digest"  />
									<label for="wpcp_daily_digest">Daily Digest</label>'; }
				if( $wpcp_weekly_template != '0' ){
				$wpcp_sform .='&nbsp;<input type="checkbox" id="wpcp_weekly_digest" name="wpcp_weekly_digest"  checked="checked" />
									<label for="wpcp_weekly_digest">Weekly Digest</label>';
									}}
				$wpcp_sform .= '<input type="button" value="'.$circupress_button.'" id="wpcp_submit" name="btn_submit" style="float:right" class="wpcp_submit" /></td>
							</tr>
				</table>';
	}
	$wpcp_sform .= '<input type="hidden" name="type" value="ADDSUB" />';
	$wpcp_runto = admin_url('admin-ajax.php');
	$wpcp_sform .= '<input type="hidden" name="runto" id="wpcp_runto" value="'.$wpcp_runto.'" />';
	$wpcp_sform .= '<input type="hidden" name="list_id" value="'.$circupress_list_id.'" />';
	$wpcp_sform .= '</form></div>';

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
		<p>
			<!--
		<label for="<?php echo $this->get_field_id( 'circupress_list_id' ); ?>">List:</label>



		                    		<?php

		                    		$wpcp_api_key = stripslashes(get_option('wpcp_apikey') );

		                    		$lists = json_decode( wpcp_get_lists( $wpcp_api_key ), true );

									if( isset( $lists['id'] ) and $lists['id'] == '401' ){

										echo '<h3>'.$lists['description'].'</h3>';

									} else {

										echo '<select class="widefat" name="wpcp_email_list">';

										foreach( $lists as $list ){


											echo '<option value="'.$list['list_id'].'">'.$list['list_name'].'</option>';

										}

										echo '</select>';
									}
									?>





		</p> -->
		<?php
	}
}

?>