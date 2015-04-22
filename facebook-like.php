<?php
/*
Plugin Name: Facebook Like To Reveal
Plugin URI: https://www.tipsandtricks-hq.com/facebook-like-to-reveal-wordpress-plugin 
Description: Easy add a Facebook like button to your WordPress site.
Version: 1.0.1
Author: Tips and Tricks HQ, wptipsntricks  
Author URI: https://www.tipsandtricks-hq.com/
License: GPLv2 or later
*/

add_shortcode( 'fb_like_to_reveal', 'fblk_shortcode' );

/*shortcode callback*/

function fblk_shortcode ( $atts ) {
	$address = get_permalink(); /*default value for 'url' attribute*/
	$facebook_like_app_id = get_option( 'facebook_like_app_id' );
	$atts = shortcode_atts(
		array(
				'message' 	=> '',
		), $atts, 'fb_like_to_reveal'
	);

	/*code from https://developers.facebook.com/docs/plugins/like-button?locale=ru_RU*/
	$fb_like_button = '<div id="fb-root"></div><script>';
	if ( $facebook_like_app_id ) {
		$fb_like_button .= 'window.fbAsyncInit = function() {
			FB.init({
				appId      : \'' . $facebook_like_app_id . '\',
				xfbml      : true,
				version    : \'v2.2\'
			});
		};';
	}


	$fb_like_button .= '(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));</script>';


	$fb_like_button .= '<div class="fb-like" data-href="' . $address . '" data-layout="standard" data-action="like" data-show-faces="true" data-share="false"></div>';

	return $fb_like_button;
}



/*add menu page*/
if ( ! function_exists( 'add_fblk_admin_menu' ) ) {
	function add_fblk_admin_menu() {
		add_menu_page( __( 'Facebook Like', 'fblk' ), __( 'Facebook Like Shortcode', 'fblk' ), 'edit_themes', 'facebook_like_page', 'formation_like_settings_page', 'dashicons-facebook', 66 );
	}
}

if ( ! function_exists( 'fblk_plugin_init' ) ) { 
	function fblk_plugin_init() {
		/* Internationalization, first(!) */
		load_plugin_textdomain( 'fblk', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}


/*function for adding <meta> tags into <head> */
if ( ! function_exists( 'fblk_add_meta_to_header' ) ) {
	function fblk_add_meta_to_header() {
		global $wp_query;
		$facebook_like_app_id = get_option( 'facebook_like_app_id' );
		$current_page_link = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://':'http://';/*check request scheme*/
		$current_page_link .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		/*getting regular expression for all shortcodes*/
		$pattern = get_shortcode_regex();
		$posts = $wp_query->posts;
		$shortcode_atributes = array();/*all shortcodes attributes for [fb_like_to_reveal] shortcode */
		foreach ($posts as $post) {

			preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) ;

			if ( array_key_exists( 2, $matches ) && array_key_exists( 3, $matches ) ) {
				foreach ( $matches['2'] as $id => $shortcode ) {
					if ( 'fb_like_to_reveal' == $shortcode ) {
						$current_shortcode_atributes = shortcode_parse_atts( $matches['3'][$id] ) ;
						$current_shortcode_atributes['url'] = get_permalink( $post->ID );
						$current_shortcode_atributes['title'] =  get_the_title();
						$shortcode_atributes[] = $current_shortcode_atributes;
					}
				}
			}
		}
		/*add meta to head if current like button, links to current page*/
		foreach ( $shortcode_atributes as $shortcode_atribute ) {
			if ( ( $shortcode_atribute['url'] == $current_page_link || $shortcode_atribute['url'] . '/'== $current_page_link ) && !empty( $shortcode_atribute['message'] ) ) {
				echo '<meta property="og:title" content="' . $shortcode_atribute['title'] . '" />
				<meta property="og:type" content="article" />
				<meta property="og:url" content="' . $shortcode_atribute['url'] . '" />
				<meta property="og:description" content="' . $shortcode_atribute['message'] . '" />
				<meta property="og:locale" content="en_US" />';
				if ( $facebook_like_app_id ) {
					echo '<meta property="fb:app_id" content="' . $facebook_like_app_id . '" />' ;
				}
			}
		}
	}
}

/*callback function for the admin page*/
if ( ! function_exists( 'formation_like_settings_page' ) ) {
	function formation_like_settings_page() { ?>
		<?php $facebook_like_app_id = get_option( 'facebook_like_app_id' );
		if( isset( $_POST['fblk-app-id'] ) ) {
			if ( '' != $_POST['fblk-app-id'] ) {
				update_option( 'facebook_like_app_id', trim( $_POST['fblk-app-id'] ), '', 'yes' );
			} else {
				delete_option( 'facebook_like_app_id' );
			}
		} ?>
		<div class="wrap">
			<h2><?php _e( 'Facebook shortcode', 'fblk' ); ?></h2>
			<div id="fblk-settings">

				<p>
					<?php _e( 'To view the Like Button comments in the Facebook Activity log, you should create an application in Facebook associated with your site and enter application ID in the "Facebook Application ID" field', 'fblk' ); ?> <a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>
				</p>

				<p>
					<?php _e( 'Insert the shortcode of the following kind', 'fblk' ); ?> [fb_like_to_reveal message="<?php _e( 'your message', 'fblk' ); ?>"] (<?php _e( 'where', 'fblk' ); ?> "<?php _e( 'your message', 'fblk' ); ?>" <?php _e( 'is a text that will show up in the like window', 'fblk' ); ?>), <?php _e( 'inside the post to display the standard Facebook Like button on the page (post).', 'fblk' ) ?>
				</p>
				
				<p>
					<?php _e( 'Example', 'fblk' ) ?>: 
					<ul>
						<li>
							[fb_like_to_reveal] - <?php _e( 'creates a button to like the current page without a message.', 'fblk' ); ?>
						</li>
						<li>
							[fb_like_to_reveal message="<?php _e( 'your message', 'frblk' ); ?>"] - <?php _e( 'creates a button to like the current page with your text in Facebook Like window', 'fblk' ); ?>
						</li>
					</ul>
				</p>
				<form method="post" action="admin.php?page=facebook_like_page">
					<table class="form-table">
						<tr>
							<th>
								<?php _e( 'Facebook Application ID', 'fblk' ) ?>
							</th>
							<td>
								<input type="text" name="fblk-app-id" value="<?php if ( $facebook_like_app_id ) echo $facebook_like_app_id; ?>">
							</td>
						</tr>
					</table>
					<input class="button button-primary" type="submit" value="<?php _e( 'Submit ID', 'fblk' ) ?>">
				</form>
			</div>
		</div>
	<?php }
}

/*action for adding <meta> tags into <head> */
add_action( 'admin_menu', 'add_fblk_admin_menu' );
add_action( 'wp_head', 'fblk_add_meta_to_header' );
add_action( 'init', 'fblk_plugin_init' );
?>