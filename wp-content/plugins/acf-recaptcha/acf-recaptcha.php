<?php

/*
Plugin Name: Advanced Custom Fields: reCAPTCHA
Plugin URI: PLUGIN_URL
Description: Google reCAPTCHA for Advance Custom Field
Version: 1.0.0
Author: kfwong
Author URI: https://www.kfwong.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'acf-recaptcha', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 




// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_recaptcha( $version ) {
	
	include_once('acf-recaptcha-v5.php');
	
}

add_action('acf/include_field_types', 'include_field_types_recaptcha');	




// 3. Include field type for ACF4
function register_fields_recaptcha() {
	
	include_once('acf-recaptcha-v4.php');
	
}

add_action('acf/register_fields', 'register_fields_recaptcha');	



	
?>