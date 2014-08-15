<?php

//error_reporting(E_ERROR | E_PARSE);

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
function investment_showcase_template($template) {
	$plugindir = dirname( __FILE__ );

	if ( is_page( 'Investment Showcase' )) {

    $template = $plugindir . '/templates/investment-showcase.php';
  }

	return $template;
}

add_action( 'template_include', 'submit_new_investment_showcase_template');
function submit_new_investment_showcase_template($template) {
  $plugindir = dirname( __FILE__ );

  if ( is_page( 'Submit New Investment Showcase' )) {

    $template = $plugindir . '/templates/submit-new-investment-showcase.php';
  }

  return $template;
}

add_action( 'template_include', 'apply_for_memberships_template');
function apply_for_memberships_template($template) {
  $plugindir = dirname( __FILE__ );

  if ( is_page( 'Apply for Memberships' )) {

    $template = $plugindir . '/templates/apply-for-memberships.php';
  }

  return $template;
}

add_action( 'template_include', 'list_of_members_template');
function list_of_members_template($template) {
  $plugindir = dirname( __FILE__ );

  if ( is_page( 'List of Members' )) {

    $template = $plugindir . '/templates/list-of-members.php';
  }

  return $template;
}

// ACF Apply for Memberships
add_filter('acf/pre_save_post' , 'apply_for_memberships_submit', 10, 1 );
function apply_for_memberships_submit( $post_id ) {
 
  // check if this is to be a new post
  if( $post_id != 'new-organisation' )
  {
      return $post_id;
  }

  // Create a new post
  $post = array(
      'post_status'  => 'pending',
      'post_title'  => $_POST['fields']['field_53e005437ca34'], // update to the organisation_name using ACF field key. Find out field key: http://www.advancedcustomfields.com/resources/functions/get_field_object/
      'post_type'  => 'organisation'
  );

  // insert the post
  $post_id = wp_insert_post( $post );

  // update $_POST['return']
  $_POST['return'] = add_query_arg( array('post_id' => $post_id), $_POST['return'] );

  // create membership admin contact account
  $email_address = $_POST['fields']['field_53dfe693365cc'];
  if(!username_exists( $email_address )) {

    // Generate the password and create the user
    $password = wp_generate_password( 12, false );
    $user_id = bp_core_signup_user( $email_address, $password, $email_address );

    // Set the nickname
    wp_update_user(
      array(
        'ID'          =>    $user_id,
        'nickname'    =>    $email_address
      )
    );

    // Set the role
    $user = new WP_User( $user_id );
    $user->set_role( 'membership_profile_moderator' );

    // Email the user
    wp_mail( $email_address, 'Welcome!', 'Your Password: ' . $password );

  } // end if

  // return the new ID
  return $post_id;
}

// acf/update_value/key={$field_key} - filter for a specific field based on it's name
// update post title to organisation name
add_filter('acf/update_value/key=field_53e005437ca34', 'apply_for_memberships_update', 10, 3);
function apply_for_memberships_update ( $value, $post_id, $field  )
{
  $post = array(
    'ID'  => $post_id,
    'post_title'  => $value
  );

  // update the post
  $post_id = wp_update_post( $post );
 
  // do something else to the $post object via the $post_id
 
  return $value;
}

// ACF Investment Showcase Submission
add_filter('acf/pre_save_post' , 'investment_showcase_submit', 10, 1 );
function investment_showcase_submit( $post_id ) {
 
  // check if this is to be a new post
  if( $post_id != 'new-investment-showcase' )
  {
      return $post_id;
  }

  // Create a new post
  $post = array(
      'post_status'  => 'pending',
      'post_title'  => $_POST['fields']['field_53ecf6a6ff889'], // update to the investment_showcase_name using ACF field key. Find out field key: http://www.advancedcustomfields.com/resources/functions/get_field_object/
      'post_type'  => 'investment-showcase'
  );

  // insert the post
  $post_id = wp_insert_post( $post );

  // update $_POST['return']
  $_POST['return'] = add_query_arg( array('post_id' => $post_id), $_POST['return'] );

  // return the new ID
  return $post_id;
}

// acf/update_value/key={$field_key} - filter for a specific field based on it's name
// update post title to investment showcase name
add_filter('acf/update_value/key=field_53ecf6a6ff889', 'investment_showcase_update', 10, 3);
function investment_showcase_update ( $value, $post_id, $field  )
{
  $post = array(
    'ID'  => $post_id,
    'post_title'  => $value
  );

  // update the post
  $post_id = wp_update_post( $post );
 
  // do something else to the $post object via the $post_id
 
  return $value;
}

// hide admin only fields
add_filter('acf/load_field/name=avpn_internal_notes', 'apply_for_memberships_hide_field');
add_filter('acf/load_field/name=annual_fee', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=membership_start_date', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=founder_member', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=supporting_member', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=partner_network', 'apply_for_memberships_hide_field'); 
//add_filter('acf/load_field/name=profile_moderators', 'apply_for_memberships_hide_field'); 
function apply_for_memberships_hide_field ( $field  )
{ 
  return false;
}

// disable buddypress sending activation email
add_filter( 'bp_registration_needs_activation', 'fix_signup_form_validation_text' );
function fix_signup_form_validation_text() {
  return false;
}

add_filter( 'bp_core_signup_send_activation_key', 'disable_activation_email' );
function disable_activation_email() {
  return false;
}

// overwrite bp default resend_activation_email behaviour in login form
add_action('init','disable_resend_activation_email');
function disable_resend_activation_email() {
  remove_filter('authenticate', 'bp_core_signup_disable_inactive',30);
  add_filter('authenticate', 'bp_core_signup_disable_inactive_overwritten',30, 3);
}
function bp_core_signup_disable_inactive_overwritten( $user = null, $username = '', $password ='' ) {
  // login form not used
  if ( empty( $username ) && empty( $password ) ) {
    return $user;
  }

  // An existing WP_User with a user_status of 2 is either a legacy
  // signup, or is a user created for backward compatibility. See
  // {@link bp_core_signup_user()} for more details.
  if ( is_a( $user, 'WP_User' ) && 2 == $user->user_status ) {
    $user_login = $user->user_login;

  // If no WP_User is found corresponding to the username, this
  // is a potential signup
  } elseif ( is_wp_error( $user ) && 'invalid_username' == $user->get_error_code() ) {
    $user_login = $username;

  // This is an activated user, so bail
  } else {
    return $user;
  }

  // Look for the unactivated signup corresponding to the login name
  $signup = BP_Signup::get( array( 'user_login' => sanitize_user( $user_login ) ) );

  // No signup or more than one, something is wrong. Let's bail.
  if ( empty( $signup['signups'][0] ) || $signup['total'] > 1 ) {
    return $user;
  }

  // Unactivated user account found!
  // Set up the feedback message
  $signup_id = $signup['signups'][0]->signup_id;

  $resend_url_params = array(
    'action' => 'bp-resend-activation',
    'id'     => $signup_id,
  );

  $resend_url = wp_nonce_url(
    add_query_arg( $resend_url_params, wp_login_url() ),
    'bp-resend-activation'
  );

  $resend_string = '<br /><br />' . sprintf( __( 'Please contact site administrator if you have further queries.', 'buddypress' ), $resend_url );

  return new WP_Error( 'bp_account_not_activated', __( '<strong>ERROR</strong>: Your account has not been activated. Please wait while our site administrator review your registration.', 'buddypress' ) . $resend_string );
}

?>