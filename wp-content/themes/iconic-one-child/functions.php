<?php

## single-organisation.php adding full-width class to fill up sidebar space
add_action( 'body_class', 'single_organisation_css');
function single_organisation_css( $classes ) {
  global $post;
  if ( 'organisation' == $post->post_type ){
  	$classes[] = 'full-width';
  }
  return $classes;
}

## single-investment-showcase.php adding full-width class to fill up sidebar space
add_action( 'body_class', 'single_investment_showcase_css');
function single_investment_showcase_css( $classes ) {
  global $post;
  if ( 'investment-showcase' == $post->post_type ){
  	$classes[] = 'full-width';
  }
  return $classes;
}

## buddypress theme adding full-width class to fill up sidebar space
add_action( 'body_class', 'buddypress_css');
function buddypress_css( $classes ) {
  if ( bp_is_user() ){
    $classes[] = 'full-width';
  }
  return $classes;
}

function admin_acf_styles()
{

	wp_enqueue_style( 'css-select2', 'http://cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.css');
 
  wp_enqueue_script( 'js-select2', 'http://cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.js' );

  wp_enqueue_script( 'js-child', dirname( get_bloginfo('stylesheet_url')) . '/js/child.js' , array('jquery'));

}
add_action( 'admin_enqueue_scripts', 'admin_acf_styles' );

?>

