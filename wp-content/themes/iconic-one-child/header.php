<?php
/*
 * Header Section of Iconic One
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress - Themonic Framework
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
			<?php if ( get_theme_mod( 'themonic_logo' ) ) : ?>
		
		<div class="themonic-logo">
        	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'themonic_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
		</div>
		<div class="alignright full-width" style="padding: 17px; margin: 10px 0px;">
			<div class="alignright" style="margin-top:10px;">
				<?php get_search_form(); ?>
			</div>
			<div style="clear:both"></div>
			<!--bp_login_widget-->
			<?php if ( is_user_logged_in() ) : ?>

				<?php do_action( 'bp_before_login_widget_loggedin' ); ?>

				<div class="bp-login-widget-user-avatar alignright">
					<a href="<?php echo bp_loggedin_user_domain(); ?>">
						<?php bp_loggedin_user_avatar( 'type=thumb&width=50&height=50' ); ?>
					</a>
				</div>

				<div class="bp-login-widget-user-links alignright" style="margin-right:10px;">
					<div class="bp-login-widget-user-link" style="text-align:right;"><strong><?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?></strong></div>
					<div class="bp-login-widget-user-logout" style="text-align:right;"><a class="logout" href="<?php echo wp_logout_url( bp_get_requested_url() ); ?>"><small><?php _e( 'Log Out', 'buddypress' ); ?></small></a></div>
				</div>

				<?php do_action( 'bp_after_login_widget_loggedin' ); ?>

			<?php else : ?>

				<?php do_action( 'bp_before_login_widget_loggedout' ); ?>

				<form name="bp-login-form" id="bp-login-widget-form" class="standard-form alignright" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
					<input type="text" name="log" id="bp-login-widget-user-login" class="input" value="" placeholder="Username or Email" />

					<input type="password" name="pwd" id="bp-login-widget-user-pass" class="input" value="" placeholder="Password" />

					<input type="submit" name="wp-submit" id="bp-login-widget-submit" value="<?php esc_attr_e( 'Log In', 'buddypress' ); ?>" />

					<div class="forgetmenot"><small><label class="alignright" style="display: block;padding-left: 15px;text-indent: -15px;"><input name="rememberme" type="checkbox" id="bp-login-widget-rememberme" value="forever" style="width: 13px;height: 13px;padding: 0;margin:0;vertical-align: bottom;position: relative;top: -1px;*overflow: hidden;" /> <?php _e( 'Remember Me', 'buddypress' ); ?></label></small></div>

					<span class="bp-login-widget-register-link alignleft"><a href="<?php echo wp_lostpassword_url(); ?>"><small>Lost your password?</small></a>&nbsp;|&nbsp;</span>

					<?php if ( bp_get_signup_allowed() ) : ?>

						<span class="bp-login-widget-register-link alignleft"><small><?php printf( __( '<a href="%s" title="Register for a new account">Register</a>', 'buddypress' ), bp_get_signup_page() ); ?></small></span>

					<?php endif; ?>

				</form>

				<?php do_action( 'bp_after_login_widget_loggedout' ); ?>

			<?php endif; ?>
			<!--end of bp_login_widget-->
		</div>
	<?php if( get_theme_mod( 'iconic_one_social_activate' ) == '1') { ?>	
		<div class="socialmedia">
			<?php if( get_theme_mod( 'twitter_url' ) !== '' ) { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'twitter_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/twitter.png" alt="Follow us on Twitter"/></a> 
			<?php } ?>
			<?php if( get_theme_mod( 'facebook_url' ) !== '' ) { ?>
					<a href="<?php echo esc_url( get_theme_mod( 'facebook_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/facebook.png" alt="Follow us on Facebook"/></a>
			<?php } ?>
			<?php if( get_theme_mod( 'plus_url' ) !== '' ) { ?>
					<a href="<?php echo esc_url(get_theme_mod( 'plus_url', 'default_value' ) ); ?>" rel="author" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/gplus.png" alt="Follow us on Google Plus"/></a>
			<?php } ?>
			<?php if( get_theme_mod( 'rss_url' ) !== '' ) { ?>
			<a class="rss" href="<?php echo esc_url( get_theme_mod( 'rss_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/rss.png" alt="Follow us on rss"/></a>			
			<?php } ?>
		</div>
	<?php } ?>	

		<?php else : ?>
		<hgroup>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<br .../> <a class="site-description"><?php bloginfo( 'description' ); ?></a>
		</hgroup>
	<?php if( get_theme_mod( 'iconic_one_social_activate' ) == '1') { ?>
		<div class="socialmedia">
			<?php if( get_theme_mod( 'twitter_url' ) !== '' ) { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'twitter_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/twitter.png" alt="Follow us on Twitter"/></a> 
			<?php } ?>
			<?php if( get_theme_mod( 'facebook_url' ) !== '' ) { ?>
					<a href="<?php echo esc_url( get_theme_mod( 'facebook_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/facebook.png" alt="Follow us on Facebook"/></a>
			<?php } ?>
			<?php if( get_theme_mod( 'plus_url' ) !== '' ) { ?>
					<a href="<?php echo esc_url(get_theme_mod( 'plus_url', 'default_value' ) ); ?>" rel="author" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/gplus.png" alt="Follow us on Google Plus"/></a>
			<?php } ?>
			<?php if( get_theme_mod( 'rss_url' ) !== '' ) { ?>
			<a class="rss" href="<?php echo esc_url( get_theme_mod( 'rss_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/rss.png" alt="Follow us on rss"/></a>			
			<?php } ?>
		</div>
	<?php } ?>	
		<?php endif; ?>

		<nav id="site-navigation" class="themonic-nav" role="navigation">
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'themonic' ); ?>"><?php _e( 'Skip to content', 'themonic' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'menu-top', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->
		<div class="clear"></div>
	</header><!-- #masthead -->

	<div id="main" class="wrapper">