<?php
/* 

CircuPress Template: On Demand Responsive Right Sidebar
This Template has a right sidebar with table of contents that can be configured using the widget editor in Wordpress. It displays all of the blog posts from either the last day or the last 7 days depending on the Circupress Schedule.
 
# Merge Tags
 * %%ONLINE%% - Inserts the URL of the View Online Page
 * %%FIRST_NAME%% - Inserts the First Name of the Recipient, Clears if the First Name isn't available
 * %%LAST_NAME%% - Inserts the Last Name of the Recipient, Clears if the Last Name isn't available
 * %%UNSUB%% - Inserts the entire CAN-SPAM Compliant Unsubscribe required information block. This area will inherit any formatting from its' enclosing element
 * %%POST_TITLE%% - The Title of the First Post. Circupress will pull the Subject Line from the TITLE element in the template hearder. This variable is typically used there.
 * %%HEADER%% - The url of the Header Image
 * %%SIDEBAR%% - The Sidebar HTML Content
# End Merge Tags 

*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>%%POST_TITLE%%</title>
		<style>
			/* ------------------------------------- 
					GLOBAL 
			------------------------------------- */
			* { 
				margin:0;
				padding:0;
			}
			* { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; }
			
			img { 
				max-width: 100%; 
			}
			.collapse {
				margin:0;
				padding:0;
			}
			body {
				-webkit-font-smoothing:antialiased; 
				-webkit-text-size-adjust:none; 
				width: 100%!important; 
				height: 100%;
			}
			
			
			/* ------------------------------------- 
					ELEMENTS 
			------------------------------------- */
			a { color: #2BA6CB;}
			
			.btn {
				text-decoration:none;
				color: #FFF;
				background-color: #666;
				padding:10px 16px;
				font-weight:bold;
				margin-right:10px;
				text-align:center;
				cursor:pointer;
				display: inline-block;
			}
			
			p.callout {
				padding:15px;
				background-color:#ECF8FF;
				margin-bottom: 15px;
			}
			.callout a {
				font-weight:bold;
				color: #2BA6CB;
			}
			
			table.social {
			/* 	padding:15px; */
				background-color: #ebebeb;
				
			}
			.social .soc-btn {
				padding: 3px 7px;
				font-size:12px;
				margin-bottom:10px;
				text-decoration:none;
				color: #FFF;font-weight:bold;
				display:block;
				text-align:center;
			}
			a.fb { background-color: #3B5998!important; }
			a.tw { background-color: #1daced!important; }
			a.gp { background-color: #DB4A39!important; }
			a.ms { background-color: #000!important; }
			
			.sidebar .soc-btn { 
				display:block;
				width:100%;
			}
			
			/* ------------------------------------- 
					HEADER 
			------------------------------------- */
			table.head-wrap { width: 100%;}
			
			.header.container table td.logo { padding: 15px; }
			.header.container table td.label { padding: 15px; padding-left:0px;}
			
			
			/* ------------------------------------- 
					BODY 
			------------------------------------- */
			table.body-wrap { width: 100%;}
			
			
			/* ------------------------------------- 
					FOOTER 
			------------------------------------- */
			table.footer-wrap { width: 100%;	clear:both!important;
			}
			.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
			.footer-wrap .container td.content p {
				font-size:10px;
				font-weight: bold;
				
			}
			
			
			/* ------------------------------------- 
					TYPOGRAPHY 
			------------------------------------- */
			h1,h2,h3,h4,h5,h6 {
			font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
			}
			h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }
			
			h1 { font-weight:200; font-size: 44px;}
			h2 { font-weight:200; font-size: 37px;}
			h3 { font-weight:500; font-size: 27px;}
			h4 { font-weight:500; font-size: 23px;}
			h5 { font-weight:900; font-size: 17px;}
			h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}
			
			.collapse { margin:0!important;}
			
			p, ul { 
				margin-bottom: 10px; 
				font-weight: normal; 
				font-size:14px; 
				line-height:1.6;
			}
			p.lead { font-size:17px; }
			p.last { margin-bottom:0px;}
			
			ul li {
				margin-left:5px;
				list-style-position: inside;
			}
			
			/* ------------------------------------- 
					SIDEBAR 
			------------------------------------- */
			ul.sidebar {
				background:#ebebeb;
				display:block;
				list-style-type: none;
			}
			ul.sidebar li { display: block; margin:0;}
			ul.sidebar li a {
				text-decoration:none;
				color: #666;
				padding:10px 16px;
			/* 	font-weight:bold; */
				margin-right:10px;
			/* 	text-align:center; */
				cursor:pointer;
				border-bottom: 1px solid #777777;
				border-top: 1px solid #FFFFFF;
				display:block;
				margin:0;
			}
			ul.sidebar li a.last { border-bottom-width:0px;}
			ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}
			
			
			
			/* --------------------------------------------------- 
					RESPONSIVENESS
					Nuke it from orbit. It's the only way to be sure. 
			------------------------------------------------------ */
			
			/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
			.container {
				display:block!important;
				max-width:600px!important;
				margin:0 auto!important; /* makes it centered */
				clear:both!important;
			}
			
			/* This should also be a block element, so that it will fill 100% of the .container */
			.content {
				padding:15px;
				max-width:600px;
				margin:0 auto;
				display:block; 
			}
			
			/* Let's make sure tables in the content area are 100% wide */
			.content table { width: 100%; }
			
			
			/* Odds and ends */
			.column {
				width: 300px;
				float:left;
			}
			.column tr td { padding: 15px; }
			.column-wrap { 
				padding:0!important; 
				margin:0 auto; 
				max-width:600px!important;
			}
			.column table { width:100%;}
			.social .column {
				width: 280px;
				min-width: 279px;
				float:left;
			}
			
			/* Be sure to place a .clear element after each set of columns, just to be safe */
			.clear { display: block; clear: both; }
			
			
			/* ------------------------------------------- 
					PHONE
					For clients that support media queries.
					Nothing fancy. 
			-------------------------------------------- */
			@media only screen and (max-width: 600px) {
				
				a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}
			
				div[class="column"] { width: auto!important; float:none!important;}
				
				table.social div[class="column"] {
					width:auto!important;
				}
			
			}
		</style>
	</head>
 	<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
		<table class="head-wrap" bgcolor="#999999">
			<tr>
				<td></td>
				<td class="header container" >
						
						<div class="content">
						<table bgcolor="#999999">
							<tr>
								<td><img src="%%HEADER%%" /></td>
								<td align="right"><h6 class="collapse"><?php echo get_bloginfo('name'); ?></h6></td>
							</tr>
						</table>
						</div>
						
				</td>
				<td></td>
			</tr>
		</table>
		<table class="body-wrap">
			<tr>
				<td></td>
				<td class="container" bgcolor="#FFFFFF">
					
					<div class="column-wrap">
						
						<div class="column">
							<div class="content">
								<table>
									<tr>
										<td>				
											<h1>%%POST_TITLE%%</h1>
										</td>
									</tr>
								</table>
							</div>
							<div class="content">	
								<table bgcolor="">
									<tr> 
										<td>
											<?php $post_id = get_the_ID(); ?>
											<p class=""><?php echo the_content(); ?></p>
											<p class="">By <?php the_author(); ?> on <?php echo mysql2date('F d, Y', get_post_time('Y-m-d H:i:s', true), false); ?></p>
										
										</td>
									</tr>
								</table>
							
							</div><!-- /content -->
							<div class="content">
								<table>
	
									<?php
										
									// Get the last 5 posts and insert excerpts											     
									$wpcp_args = array( 'post_status' => 'publish', 'posts_per_page' => 5 );
									$posts = new WP_Query( $wpcp_args );
									while ( $posts->have_posts() ) : $posts->the_post();
										if( get_the_ID() == $post_id ){ continue; } 
										set_post_thumbnail_size( 75, 75, true );
									
									?>
									<tr> 
										<td>
												
											<a name="wpcp<?php echo $posts->post->ID; ?>" href="<?php the_permalink_rss() ?>" title="<?php the_title_rss(); ?>" ><h4><?php the_title_rss(); ?></h4></a>
											<p class=""><?php the_excerpt(); ?></p>
											<p class="">By <?php the_author(); ?> on <?php echo mysql2date('F d, Y', get_post_time('Y-m-d H:i:s', true), false); ?></p>
											<a href="<?php the_permalink_rss(); ?>" class="btn">Read More</a>	
										</td>
									</tr>
									<?php 
										$table_of_contents .= '<li><a href="#wpcp'.$posts->post->ID.'" class="last">'.the_title('','', false).'</a></li>';
										endwhile; 
									?>
								</table>
							</div>
						</div>
					
						<div class="column">
							<table>
								<tr>
									<td>				
																	
										<ul class="sidebar">
											<li>
												<a>
													<h5>Table of Contents &raquo;</h5>
												</a>
											</li>
											<?php
												
												echo $table_of_contents;
											
											?>
										</ul>
										
										<!-- social & contact -->
										<table bgcolor="" class="social" width="100%">
											<tr>
												<td>
													
													
														<table bgcolor="" class="" cellpadding="" align="left" width="100%">
														<tr>
															<td>				
																
																<h6 class="">Connect with Us:</h6>
																<p class=""><a href="#" class="soc-btn fb">Facebook</a> <a href="#" class="soc-btn tw">Twitter</a> <a href="#" class="soc-btn gp">Google+</a></p>
																
																<p class="">%%UNSUB%%</p>
																
															</td>
														</tr>
													</table>
													
												</td>
											</tr>
										</table><!-- /social & contact -->
				
									</td>
								</tr>
							</table>				
						</div>
						<div class="clear"></div>			
					</div>
				</td>
				<td></td>
			</tr>
		</table><!-- /BODY -->
		
		<!-- FOOTER -->
		<table class="footer-wrap">
			<tr>
				<td></td>
				<td class="container">
					
						<!-- content -->
						<div class="content">
						<table>
						<tr>
							<td align="center">
								<p>
									<a href="%%ONLINE%%" title="View online">View Online</a>
								</p>
							</td>
						</tr>
					</table>
						</div><!-- /content -->
						
				</td>
				<td></td>
			</tr>
		</table><!-- /FOOTER -->
	</body>
</html>