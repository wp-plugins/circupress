<?php
/*
*
* CircuPress Subscribers Page
*
*/

if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
} else {

	wpcp_wizard();

	// Get Users API Key
	$wpcp_account_options = get_option('circupress-account');

	$wpcp_account = stripslashes($wpcp_account_options['wpcp_account']);
	$wpcp_api_key = stripslashes($wpcp_account_options['wpcp_apikey']);

	if( isset( $_POST['stage'] ) && $_POST['stage'] == 'update_subscriber' && isset( $_POST['wpcp_email_address'] ) && strlen( $_POST['wpcp_email_address'] ) > 0 ){

		if( isset( $_POST['wpcp_first_name'] ) ){
			$wcpc_first_name = $_POST['wpcp_first_name'];
		} else {
			$wcpc_first_name = '';
		}
		if( isset( $_POST['wpcp_last_name'] ) ){
			$wcpc_last_name = $_POST['wpcp_last_name'];
		} else {
			$wcpc_last_name = '';
		}
		if( isset( $_POST['wpcp_active'] ) && $_POST['wpcp_active'] == 1 ){
			$wpcp_active = 1;
		} else {
			$wpcp_active = 0;
		}
		if( isset( $_POST['wpcp_daily_digest'] ) && $_POST['wpcp_daily_digest'] == 1 ){
			$wpcp_daily_digest = 1;
		} else {
			$wpcp_daily_digest = 0;
		}
		if( isset( $_POST['wpcp_weekly_digest'] ) && $_POST['wpcp_weekly_digest'] == 1 ){
			$wpcp_weekly_digest = 1;
		} else {
			$wpcp_weekly_digest = 0;
		}

		$wpcp_update = json_decode( wpcp_update_list_subscriber( $wpcp_api_key, $_POST['wpcp_email_address'], $_POST['wpcp_list_id'], $_POST['wpcp_subscriber_id'], $wpcp_active,  $wcpc_first_name, $wcpc_last_name, '', '', '', '', '', '', '', '', $wpcp_daily_digest, $wpcp_weekly_digest ), true );

	}

	if( isset( $_POST['stage'] ) && $_POST['stage'] == 'cp_add_subscriber' && isset( $_POST['wpcp_email_address'] ) && strlen( $_POST['wpcp_email_address'] ) > 0 ){

		if( isset( $_POST['wpcp_first_name'] ) ){
			$wcpc_first_name = $_POST['wpcp_first_name'];
		} else {
			$wcpc_first_name = '';
		}
		if( isset( $_POST['wpcp_last_name'] ) ){
			$wcpc_last_name = $_POST['wpcp_last_name'];
		} else {
			$wcpc_last_name = '';
		}
		if( isset( $_POST['wpcp_daily_digest'] ) ){
			$wpcp_daily_digest = '1';
		} else {
			$wpcp_daily_digest = '0';
		}
		if( isset( $_POST['wpcp_weekly_digest'] ) ){
			$wpcp_weekly_digest = '1';
		} else {
			$wpcp_weekly_digest = '0';
		}

		$wpcp_add = json_decode( wpcp_add_list_subscriber( $wpcp_api_key, $_POST['wpcp_email_address'], $_POST['wpcp_email_list'], $wcpc_first_name, $wcpc_last_name, '', '', '', '', '', '', '', '', $wpcp_daily_digest, $wpcp_weekly_digest ), true);

	}

	if( isset( $_POST['stage'] ) && $_POST['stage'] == 'cp_update_list' ) {

		if( isset( $_POST['wpcp_list_active'] ) && $_POST['wpcp_list_active'] == 1 ){
			$wpcp_list_active = 1;
		} else {
			$wpcp_list_active = 0;
		}

		$wpcp_update_list = json_decode( wpcp_update_list( $wpcp_api_key, $_POST['wpcp_list_name'], $_POST['wpcp_list_reminder'], $_POST['wpcp_list_address'], $_POST['wpcp_list_city'], $_POST['wpcp_list_state'], $_POST['wpcp_list_zip'], $_POST['wpcp_list_phone'], $_POST['wpcp_list_company'], $_POST['wpcp_from_name'], $_POST['wpcp_list_email_address'], $_POST['wpcp_list_id'], $wpcp_list_active), true );

	}

	if( isset( $_POST['stage'] ) && $_POST['stage'] == 'cp_import_subscribers' ) {

			if( isset( $_POST['wpcp_subscribers'] ) && strlen( $_POST['wpcp_subscribers'] ) > 0 ){
				$wpcp_list_import = $_POST['wpcp_subscribers'];
			} else {
				$wpcp_list_import = '';
			}

			if( isset( $_POST['wpcp_email_list'] ) && strlen( $_POST['wpcp_email_list'] ) > 0 ){
				$wpcp_list_id = $_POST['wpcp_email_list'];
			} else {
				$wpcp_list_id = '';
			}

			$wpcp_import_list = json_decode( wpcp_import_list( $wpcp_api_key, $wpcp_list_import, $wpcp_list_id  ), true );

	}
?>
<?php if ( !empty( $wpcp_update ) ) : ?>
	<div id="message" class="updated fade"><p><strong><?php _e( $wpcp_update['description'] ); ?></strong></p></div>
<?php endif; ?>

<?php if ( !empty( $wpcp_add ) ) : ?>
	<div id="message" class="updated fade"><p><strong><?php _e( $wpcp_add['description'] ); ?></strong></p></div>
<?php endif; ?>

<?php if ( !empty( $wpcp_update_list ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e( $wpcp_update_list['description'] ); ?></strong></p></div>
<?php endif; ?>

<?php if ( !empty( $wpcp_add_list ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e( $wpcp_add_list['description'] ); ?></strong></p></div>
<?php endif; ?>

<?php if ( !empty( $wpcp_import_list ) ) : ?>
<div id="message" class="updated fade"><p><strong><?php _e( $wpcp_import_list['description'] ); ?></strong></p></div>
<?php endif; ?>

<div class="wrap">
<div id="icon-edit" class="icon32 icon32-posts-email"><br /></div><h2>CircuPress Subscribers</h2>
<div class="wrap">
    <div class="postbox-container" style="width:100%;">
        <div class="metabox-holder">
            <div class="meta-box-sortables">
			<!-- List Reports -->
            	<?php
            		$reports = wpcp_load_reports( "subscriber_reports" );
            		if( strlen( $reports ) > 0 ){
            			?>
						<div id="list_reports" class="postbox" style="width: 100%">

			                    <div class="inside" style="padding:15px">
				                    <div id="pagedata" style="width:100%;min-height:100px">
				                    	<?php echo $reports; ?>
				                    </div>
			                	</div>

			            	</div>
					<?php
            		}
			?>
            	<!-- End List Reports -->

               <div id="list_statistics" class="postbox" style="width: 100%">
                    <h3 class="hndle"><span>Subscribers<form action="" method="post">
		                    	<input type="hidden" name="stage" value="cp_add_list" />
		                    </form></span></h3>
                    <div class="inside">
	                    <div id="pagedata" class="widefat">
	                    	<table style="width:100%; table-layout:fixed;" cellspacing="4">
	                    		<thead>
	                    			<tr>
		                    			<td align="center">
		                    				<strong>Total<br />Subscribers</strong>
		                    			</td>
		                    			<td align="center">
		                    				<strong>Daily<br />Subscribers</strong>
		                    			</td>
		                    			<td align="center">
		                    				<strong>Weekly<br />Subscribers</strong>
		                    			</td>
		                    			<td align="center">
		                    				<strong>Opt-Out<br />Rate</strong>
		                    			</td>
		                    			<td align="center">
		                    				<strong>Click<br />Rate</strong>
		                    			</td>
		                    			<td align="center">
		                    				<strong>Bounce<br />Rate</strong>
		                    			</td>
		                    			<td align="center">
		                    				<strong>Spam<br />Rate</strong>
		                    			</td>
	                    			</tr>
	                    		</thead>

		                    	<?php

									$lists = json_decode( wpcp_get_lists( $wpcp_api_key ), true );

									if( isset( $lists['id'] ) and $lists['id'] == '401' ){

										echo '<tr><td colspan="7"><h3>'.$lists['description'].'('.$lists['id'].')</h3></td></tr>';

									} else {
										foreach( $lists as $list ){

										echo '
											<tr align="left">
												<td align="center">'.$list['subscribers'].'</td>
												<td align="center">'.$list['daily_subscribers'].'</td>
												<td align="center">'.$list['weekly_subscribers'].'</td>
												<td align="center">'.$list['opt_out_rate'].'%</td>
												<td align="center">'.$list['click_rate'].'%</td>
												<td align="center">'.$list['bounce_rate'].'%</td>
												<td align="center">'.$list['spam_rate'].'%</td>
											</tr>
											<tr align="right">
												<td colspan="7"><a href="https://www.circupress.com/api/api_list_export.php?cp_method=get_list_csv&cp_api_key='.$wpcp_api_key.'&cp_list_id='.$list['list_id'].'" target="_blank" class="button-primary">Download Subscribers &raquo;</a>
		                    					</td>
		                    				</tr>';

										}
									}

								?>
	                    	</table>



	                    </div>
                	</div>

            	</div>
            	<!-- End Lists -->
            	<!-- Start Find Subscriber -->
				<div id="list_details" class="postbox" style="width: 100%">
	            	<h3 class="hndle"><span>Find Subscriber</span></h3>
	                <div class="inside">
		            	<div id="pagedata" style="width:100%">
		                	<form action="" method="post">
		                	<table style="width:100%" cellspacing="4">
		                   		<tr>
		                   			<td colspan="2">
		                   				<p>Enter the email address of the Subscriber you want to find.</p>
		                   			</td>
		                   		</tr>
	                    		<tr>
		                    		<td align="right">
			                   			<label><strong>Email Address:&nbsp;</strong></label>
			                   		</td>
			                   		<td align="left">
			                   			<input type="text" name="wpcp_email_address" size="30" />
			                   			<input type="hidden" name="stage" value="cp_find_subscriber" />
		                   				<input type="submit" class="button-primary" name="submit" value="<?php _e("Find Subscriber", 'wpcp'); ?> &raquo;" />
		                   			</td>
		                   		</tr>
		                    </table>
		                    </form>

		                    <?php

		                    	if( isset( $_POST['stage'] ) && $_POST['stage'] == 'cp_find_subscriber' && isset( $_POST['wpcp_email_address'] ) && strlen( $_POST['wpcp_email_address'] ) > 0 ){

									$subscribers = json_decode( wpcp_find_subscriber( $wpcp_api_key, $_POST['wpcp_email_address'] ), true );



									if( isset( $subscribers['id'] ) && $subscribers['id'] == '419' ){

										echo '<h3>'.$subscribers['description'].'</h3>';

									} else {


							?>

								<table style="width:100%" cellspacing="4">

									<?php


										foreach ( $subscribers as $subscriber ){

											echo '<tr>
												<td colspan="5">
													<form action="" method="post">
														<table width="100%">
															<tr style="display:none">
																<td colspan="7">
																<label style="width:100px;display:block;float:left;"><strong>List Name:</strong></label>'.$subscriber['list_name'].'
																</td>
															</tr>
															<tr>
																<td>
																<label style="width:100px;display:block">Email Address:* </label>
																	<input type="text" name="wpcp_email_address" size="40" value="'.$subscriber["email_address"].'" />
																</td>
																<td>
																	<label style="width:100px;display:block">First Name: </label>
																	<input type="text" name="wpcp_first_name" size="10" value="'.$subscriber["first_name"].'" />
																</td>
																<td>
																	<label style="width:100px;display:block">Last Name: </label>
																	<input type="text" name="wpcp_last_name" size="10" value="'.$subscriber['last_name'].'" />
																</td>
																<td>
																	<label style="width:100px;display:block">Daily Digest: </label>
																	<input type="checkbox" name="wpcp_daily_digest" value="1"';

																	if( $subscriber['daily_digest'] == 1 ){ echo ' checked="checked" '; }
																echo ' />
																</td>
																<td>
																	<label style="width:100px;display:block">Weekly Digest: </label>
																	<input type="checkbox" name="wpcp_weekly_digest" value="1"';

																	if( $subscriber['weekly_digest'] == 1 ){ echo ' checked="checked" '; }
																echo ' />
																</td>
																<td>
																	<label style="width:100px;display:block">Active: </label>
																	<input type="checkbox" name="wpcp_active" value="1"';

																	if( $subscriber['active'] == 1 ){ echo ' checked="checked" '; }
																echo ' />
																</td>
																<td>
																	<input type="hidden" name="wpcp_subscriber_id" value="'.$subscriber['subscriber_id'].'" />
																	<input type="hidden" name="wpcp_list_id" value="'.$subscriber['list_id'].'" />
																	<input type="hidden" name="stage" value="update_subscriber" />
		                    											<input type="submit" class="button-primary" name="submit" value="Update &raquo;" />
																</td>
															</tr>
														</table>
													</form>
													<hr />
												</td>
											</tr>';

										}

									?>
								</table>

							<?php

								}

							}

		                    ?>
		          		</div>
	         		</div>

	      		</div>
            	<!-- End Find Subscriber -->

            	<!-- Start Add Subscriber -->
				<div id="list_details" class="postbox" style="width: 100%">
	            	<h3 class="hndle"><span>Add Subscriber</span></h3>
	                <div class="inside">
		            	<div id="pagedata" style="width:100%;">
		                	<form action="" method="post">
		                		<table style="width:100%" cellspacing="4">
		                   		<tr>
		                   			<td colspan="2">
		                   				<p>Enter the email address and information of the Subscriber you wish to add.</p>
		                   			</td>
		                   		</tr>
	                    		<tr>
		                    		<td align="right">
			                   			<label><strong>Email Address:&nbsp;</strong></label>
			                   		</td>
			                   		<td align="left">
		                				<input type="text" name="wpcp_email_address" size="30" />
		                				&nbsp;<small>Required</small>
		                			</td>
		                		<tr>
		                			<td align="right">
			                   			<label><strong>First Name:&nbsp;</strong></label>
			                   		</td>
			                   		<td align="left">
		                				<input type="text" name="wpcp_first_name" size="30" />
		                			</td>
		                		</tr>
		                		<tr>
		                			<td align="right">
			                   			<label><strong>Last Name:&nbsp;</strong></label>
			                   		</td>
			                   		<td align="left">
		                				<input type="text" name="wpcp_last_name" size="30" />
		                			</td>
		                		</tr>
		                    	<?php

		                    		$options = get_option('circupress-account');
									$wpcp_weekly_template = $options['wpcp_weekly_template'];
									$wpcp_daily_template = $options['wpcp_daily_template'];

									if( $wpcp_daily_template != '0' ){
										echo '<tr><td></td><td><label style="width:100px;text-align:right; float:left; display:block">Daily Digest:&nbsp;</label> <input type="checkbox" id="wpcp_daily_digest" name="wpcp_daily_digest"  /></td></tr>';
									} else {
										echo '<tr><td></td><td>Daily Digest is currently disabled. <a href="' . admin_url( '/edit.php?post_type=email&page=circupress-account#daily_template', __FILE__ ) . '">Select a template</a> to enable a daily digest.<input type="hidden" name="wpcp_daily_digest" value="0" /></td></tr>';
									}
								?>
								<?php

									if( $wpcp_weekly_template != '0' ){
										echo '<tr><td></td><td><label style="width:100px;text-align:right; float:left; display:block">Weekly Digest:&nbsp;</label> <input type="checkbox" id="wpcp_weekly_digest" name="wpcp_weekly_digest"  checked="checked" /></td></tr>';
									} else {
										echo '<tr><td></td><td>Weekly Digest is currently disabled. <a href="' . admin_url( 'edit.php?post_type=email&page=circupress-account#weekly_template', __FILE__ ) . '">Select a template</a> to enable a weekly digest.<input type="hidden" name="wpcp_weekly_digest" value="0" /></td></tr>';
									}
								?>
		   		                <tr>
		                   			<td></td>
		                   			<td colspan="2">
		                   				<input type="hidden" name="list_id" value="<?php $circupress_list_id = $lists[0]['list_id']; echo $circupress_list_id; ?>" />
		                   				<input type="hidden" name="stage" value="cp_add_subscriber" />
		                    			<input type="submit" class="button-primary" name="submit" value="<?php _e("Add Subscriber", 'wpcp'); ?> &raquo;" />
		                    	</tr>
		                    </table>
		                    </form>
		          		</div>
	         		</div>

	      		</div>
            	<!-- End Add Subscriber -->

            	<!-- Start Import Subscribers -->
				<div id="list_import" class="postbox" style="width: 100%">
	            	<h3 class="hndle"><span>Import Subscribers</span></h3>
	                <div class="inside">
		            	<div id="pagedata" style="width:100%;">
		                	<form action="" method="post">
		                		<table style="width:100%" cellspacing="4">
		                		<tr>
			              		 <td colspan="2"><p>Copy and Paste your Subscriber list into the textarea above. Your import will be placed into a queue and processed in the order in which it was received. You will receive an email when the list has been processed. The format is a comma separated list in the following order. Email address is always required. The following example will subscribe someone to the weekly newsletter but not the daily.</p>
			              		 </td>
			              		 </tr>
			              		 <tr>
			              		  <td></td>
			              		  <td>
			              		 	<table align="left" style="table-layout:fixed;">
			              		 		<thead>
			              		 			<tr>
			              		 				<td>Email Address</td>
			              		 				<td>First Name</td>
			              		 				<td>Last Name</td>
			              		 				<td>Daily</td>
			              		 				<td>Weekly</td>
			              		 			</tr>
			              		 		</thead>
			              		 		<tbody>
			              		 			<tr>
			              		 				<td><code>test@domain.com,</code></td>
			              		 				<td><code>John,</code></td>
			              		 				<td><code>Smith,</code></td>
			              		 				<td><code>0,</code></td>
			              		 				<td><code>1</code></td>
			              		 			</tr>
			              		 		</tbody>
			              		 	</table>
		                    	</td>
		                    	</tr>
	                    		<tr>
		                    		<td align="right" valign="top">
			                   			<label><strong>Subscribers:&nbsp;</strong></label>
			                   		</td>
			              			<td align="left">
			              				<textarea width="100%" name="wpcp_subscribers" rows="8" cols="75"></textarea>
			              			</td>
			              		</tr>
			              		<tr>
			              			<td></td>
			              			<td align="right">
			              				<input type="hidden" name="stage" value="cp_import_subscribers" />

		                    	<p style="display:none"><label style="width:80px;text-align:right; float:left; display:block">List Name: </label><select name="wpcp_email_list">
		                    		<?php

										foreach( $lists as $list ){

											echo '<option value="'.$list['list_id'].'">'.$list['list_name'].'</option>';

										}

									?>
		                    		</select>
		                    	</p>
		                    	</tr>
		                    	<tr>
		                    		<td></td>
		                    		<td align="left"><input type="submit" class="button-primary" name="submit" value="<?php _e("Import Subscribers", 'wpcp'); ?> &raquo;" /></td>
		                    	</tr>
		                   </table>
		                   <p><strong>Note: </strong>No more than 5,000 subscribers can be imported in a single week so that we can ensure a good deliverability reputation.</p>
		                   </form>
		          		</div>
	         		</div>
	      		</div>
            	<!-- End Import Subscribers -->
        	</div>
    	</div>
    </div>
<?php } ?>
</div>