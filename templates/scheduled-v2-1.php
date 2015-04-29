<?php
/*

CircuPress Template: Scheduled Single Column V2.1
Width: 600

This Template is a Scheduled single column email. It displays all of the blog posts from either the last day or the last 7 days depending on the Circupress Schedule.

The header image for this template should be 200x50
# Merge Tags
 * %%ONLINE%% - Inserts the URL of the View Online Page
 * %%FIRST_NAME%% - Inserts the First Name of the Recipient, Clears if the First Name isn't available
 * %%LAST_NAME%% - Inserts the Last Name of the Recipient, Clears if the Last Name isn't available
 * %%UNSUB%% - Inserts the entire CAN-SPAM Compliant Unsubscribe required information block. This area will inherit any formatting from its' enclosing element
 * %%POST_TITLE%% - The Title of the First Post. Circupress will pull the Subject Line from the TITLE element in the template herder. This variable is typically used there.
 * %%HEADER%% - The url of the Header Image
 * %%SOCIAL%% - Inserts a social block dynamically with any of the social URLs you've included
 * %%SIDEBAR%% - The Sidebar HTML Content
# End Merge Tags

*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<title>%%POST_TITLE%%</title>

<style type="text/css">

html {width:100%; height:100%;}
body {margin:0; padding:0; width:100%; background:#fff; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
img {border:0;}
table {border-collapse:collapse;}

.ReadMsgBody { width: 100%;}
.ExternalClass {width: 100%;}

/* INTRO [OR] CALL TO ACTION TEXT */

td[class="action"] {padding:0 60px!important;}
table[class="action_text"] {font-family:'Open Sans', Source Sans Pro, Arial, Verdana, Tahoma!important; font-size:25px!important; color:#444!important; line-height:35px!important; font-weight:lighter!important;}

/* FEATURED AUTHORS AND AD */

table[class="authors"] {margin-top:30px!important;}


/* FOOTER */

table[class="footer"] {margin:auto!important; padding-bottom:20px!important;}
table[class="footer_column"] {text-align:left!important;}

/* COPY-RIGHT */

table[class="copyright"] {text-align:left!important;}
table[class="unsubscribe"] {text-align:right!important;}


/* MEDIA QUIRES */

@media only screen and (max-width:640px) {

	/* GENERAL */

	body {width:auto!important; background:#eee!important;}
	table[class="layout"] {width:480px!important; margin:auto!important; background:#fff!important;} /* CONTROLS THE LAYOUT WIDTH */
	table[class="container"] {width:420px!important; margin:auto!important;} /* CONTROLS THE WIDTH OF EACH SECTION */
	td[class="space"] {height:30px!important;}
	td[class="hrule"] {border-bottom:1px solid #ddd!important; height:30px!important;}
	img[class="top-space"] {margin-top:30px!important;}
	img[class="bottom-space"] {margin-bottom:30px!important;}

	/* HEADER */

	table[class="logo"] {width:100%!important; text-align:center!important; margin-bottom:20px!important; border-bottom:1px solid #ddd!important;}
	table[class="logo_place"] {padding-bottom:20px!important;}
	table[class="media"] {width:100%!important;}

	/* INTRO [OR] CALL TO ACTION TEXT */

	td[class="action"] {padding:0!important;}
	table[class="action_text"] {width:250px!important; font-size:16px!important; line-height:25px!important; font-weight:600!important;}

	/* IMAGES LEFT [OR] RIGHT SIDE */

	table[class="image_content"] {width:100%!important;}
	table[class="text_content"] {width:100%!important;}
	table[class="half-width"] {width:100%!important; margin-top:30px!important;}


	/* FEATURED AUTHORS AND AD */

	table[class="authors"] {width:100%!important; margin:30px 0!important;}
	table[class="ad-one"] {display:none!important;}

	/* ILLUSTRATIONS LEFT [OR] RIGHT SIDE */

	table[class="illustration_content"], table[class="illustration_text"] {width:100%!important;}

	/* THREE COLUMN */

	table[class="one_third"] {width:100%!important; margin-bottom:30px!important;}
	table[class="two_third"] {width:100%!important;}
	table[class="single_column"] {width:165px!important;}

	/* GALLERY */

	table[class="gallery"] {width:100%!important;}

	/* FOOTER */

	table[class="footer"] {width:400px!important;}
	table[class="footer_column"] {width:100%!important; text-align:center!important;}

	/* COPY-RIGHT */

	table[class="copyright"], table[class="unsubscribe"] {width:100%!important; text-align:center!important;}

}

@media only screen and (max-width:480px) {

	/* GENERAL */

	body {width:auto!important; background:#eee!important;}
	table[class="layout"] {width:300px!important; margin:auto!important;}
	table[class="container"] {width:260px!important;}
	td[class="space"] {height:20px!important;}
	td[class="hrule"] {border-bottom:1px solid #ddd!important; height:22px!important;}
	img[class="top-space"] {margin-top:20px!important;}
	img[class="bottom-space"] {margin-bottom:20px!important;}
	img[class="img_top_space"] {margin-top:20px!important;}
	table[class="half-width"] {margin-top:20px!important;}

	/* INTRO [OR] CALL TO ACTION TEXT */

	table[class="action_text"] {width:100%!important; text-align:center!important; font-size:14px!important; line-height:normal!important; font-weight:600!important;}
	table[class="action_button"] {display:none!important;}

	/* FEATURED AUTHORS AND AD */

	table[class="authors"] {width:100%!important; margin:15px 0!important;}

	/* THREE COLUMN */

	table[class="one_third"] {width:100%!important; margin-bottom:20px!important;}
	table[class="two_third"] {width:100%!important;}
		table[class="single_column"] {width:100%!important;}

	/* FOOTER */

	table[class="footer"] {width:200px!important;}

}

</style>
</head>
<body>

<!-- FULL WIDTH OUTER MOST CONTAINER -->

<table cellpadding="0" cellspacing="0" style="width:100%; border-top:5px solid #3A3A3C; padding:30px 0;">
<tr>
  <td>

<!-- MAIN LAYOUT CONTAINER - CONTROLS THE WIDTH OF NEWSLETTER -->

	<table width="600" cellspacing="0" cellpadding="0" border="0" align="center" class="layout">
        <tr>
          <td height="30">&nbsp;</td>
        </tr>
        <tr>
          <td valign="middle">

<!-- HEADER SECTION : LOGO AND SOCIAL MEDIA LINKS -->

            <table width="600" align="center" border="0" cellpadding="0" cellspacing="0" class="container">
              <tr>
                <td>

                    <!-- YOUR LOGO -->

                    <table border="0" width="121" align="left" cellpadding="0" cellspacing="0" class="logo">
                        <tr>
                            <td class="logo_place"><img src="%%HEADER%%" alt="logo" /></td>
                        </tr>
                    </table>

                    <!-- SOCIAL MEDIA LINKS -->

                          %%SOCIAL_RIGHT%%

                </td>
              </tr>
            </table>

          </td>
        </tr>
        <tr>
          <td height="30">&nbsp;</td>
        </tr>
        <tr>
        <td>

<!-- MAIN HEADER IMAGE SPACE 600 X 250 PIXELS -->

        	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="container">
              <tr>
                <td style="line-height:0;">

                <a href="<?php the_permalink_rss() ?>" target="_blank">
                <?php if ( has_post_thumbnail() ) {
					$src = wp_get_attachment_image_src( get_post_thumbnail_id( $events->ID ), array(600,300) ); ?>
					<img src="<?php echo $src[0]; ?>" style="width:100%;" />
				<?php } ?>
				</a>

                </td>
              </tr>
              <tr>
          		<td height="50" class="space">&nbsp;</td>
        		</tr>
              <tr>
                      <td align="left" valign="top" style="font-family:'Open Sans', Source Sans Pro, arial, verdana, tahoma; font-size:20px; font-weight:600; color:#323f4e;"><?php echo get_the_title(); ?></td>
              </tr>
              <tr>
          		<td height="50" class="space">&nbsp;</td>
        		</tr>
              <tr>
                <td align="left" valign="middle" style="font-family:'Open Sans', Source Sans Pro, arial, verdana, tahoma; font-size:14px; line-height:21px; color:#323f4e;"><?php echo the_content(); ?></td>
              </tr>
              <tr>
                 <td>&nbsp;</td>
              </tr>
              <tr>
          		<td height="50" style="border-bottom:1px solid #ddd;" class="hrule">&nbsp;</td>
        		</tr>
        	 <tr>
          <td height="50" class="space">&nbsp;</td>
        </tr>
        <tr>
             <td align="left" valign="top" style="font-family:'Open Sans', Source Sans Pro, arial, verdana, tahoma; font-size:20px; font-weight:600; color:#323f4e;">In Case You Missed Our Latest Posts:</td>
        </tr>
        <tr>
          	<td height="50" style="border-bottom:1px solid #ddd;" class="hrule">&nbsp;</td>
        </tr>
        <tr>
          <td height="50" class="space">&nbsp;</td>
        </tr>
            </table>

        </td>
        </tr>


<?php
	$wpcp_args = array(
		'post_status' => 'publish',
		'posts_per_page' => 25,
		'date_query' => array(
			'after' => array(
				'year'     => date('Y', strtotime('-'.$_GET['days'].' days')),
				'month'    => date('m', strtotime('-'.$_GET['days'].' days')),
				'day'      => date('d', strtotime('-'.$_GET['days'].' days'))
			),
			'inclusive' => true,
		),
		'offset' => -1
	);

	$posts = new WP_Query( $wpcp_args );

	$postnumber = 0;

	while ( $posts->have_posts() ) : $posts->the_post();
		$content = get_the_content();
		$content = strip_tags($content);
		$trimmed_content = wp_trim_words( $content, 30, '...' );

?>

        <tr>
          <td valign="top">

<!-- TWO COLUMN : IMAGE LEFT AND CONTENT RIGHT -->

              <table width="600" align="center" border="0" cellpadding="0" cellspacing="0" class="container">
              <tr>
                <td>

                  <table width="260" border="0" cellspacing="0" cellpadding="0" align="left" class="image_content">
                    <tr>
                      <td align="center" valign="top">

                      <a href="<?php the_permalink_rss() ?>" target="_blank">
                      <?php if ( has_post_thumbnail() ) {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id( $events->ID ), array(300,300) ); ?>
						<img src="<?php echo $src[0]; ?>" alt="image left" style="width:100%;" class="bottom-space" />
					  <?php } ?>
					  </a>

                      </td>
                 	</tr>
                  </table>

                  <table width="290" border="0" cellspacing="0" cellpadding="0" align="right" class="text_content">
                    <tr>
                      <td align="left" valign="top" style="font-family:'Open Sans', Source Sans Pro, arial, verdana, tahoma; font-size:20px; font-weight:600; color:#323f4e;"><a href="<?php the_permalink_rss() ?>" target="_blank" style="text-decoration:none; color:#323f4e;"><?php the_title_rss(); ?></a></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" style="font-family:'Open Sans', Source Sans Pro, arial, verdana, tahoma; font-size:14px; line-height:21px; color:#323f4e;"><?php echo $trimmed_content; ?></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="bottom"><a href="<?php the_permalink_rss() ?>" target="_blank"><img src="http://s1.circupress.com.s3.amazonaws.com/wp-content/uploads/2014/02/read_more.gif" width="110" height="30" alt="read more" style="border:none;" /></a></td>
                    </tr>
                  </table>

                </td>
              </tr>
            </table>

          </td>
        </tr>
        <tr>
          <td height="50" style="border-bottom:1px solid #ddd;" class="hrule">&nbsp;</td>
        </tr>
        <tr>
          <td height="50" class="space">&nbsp;</td>
        </tr>

        <?php $postnumber = $postnumber + 1; ?>

<?php endwhile; ?>

	</table>

<!-- FOOTER FULL WIDTH -->

</body></html>