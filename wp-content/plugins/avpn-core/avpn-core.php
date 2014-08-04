<?php

/*
Plugin Name: AVPN Core
Description: Collections of AVPN's core functions to handle special membership application process
Version: 1.0
Author: Wong Kang Fei (kfwong)
Author URI: mailto:kfwong@zoho.com
*/


add_action( 'body_class', 'investment_showcase_full_width');
function investment_showcase_full_width( $classes ) {
  global $post;
  if ( is_page('Investment Showcase') ){
  	$classes[] = 'full-width';
  }
  return $classes;
}

add_action( 'template_include', 'investment_showcase_template');
function investment_showcase_template() {
	$plugindir = dirname( __FILE__ );

	if ( is_page( 'Investment Showcase' )) {

        $template = $plugindir . '/templates/investment-showcase.php';
    }

	return $template;
}

function test_save_post($post)
{
  
}
add_action('save_post_organisation', 'test_save_post');



?>