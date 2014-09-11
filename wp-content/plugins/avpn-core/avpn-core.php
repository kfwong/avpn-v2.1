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
    // NOTE: this is for the sake of registering user using bp_core_signup_user function, the password will be regenerated again during activate_membership. (the password need to be forward to user upon activation)
    // TODO: is there any other way to only generate once? 
    $password = wp_generate_password( 12, false );
    $user_id = bp_core_signup_user( $email_address, $password, $email_address );

  } // end if

  // return the new ID
  return $post_id;
}

// post-action after admin activate pending membership
add_action('bp_core_activated_user','activate_membership');
function activate_membership($user_id){

  $email_address = get_user_by('id', $user_id)->user_email;

  // Set the nickname & default role
  wp_update_user(
    array(
      'ID'          =>    $user_id,
      'nickname'    =>    $email_address,
      'role'        =>    'membership_profile_moderator'
    )
  );

  // Regenerate random user password
  $password = wp_generate_password( 12, false );
  wp_set_password($password, $user_id);

  // Email the user & password
  wp_mail( $email_address, 'Welcome!', 'Your Password: ' . $password );

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
add_filter('acf/load_field/name=membership_profile_moderators', 'apply_for_memberships_hide_field');
add_filter('acf/load_field/name=featured_image', 'apply_for_memberships_hide_field');
function apply_for_memberships_hide_field ( $field  )
{ 
  //if it's currently at backend acf form, return the field
  if(is_admin()){
    return $field;
  }else{
    // if not, hide/do not generate the field
    return false;  
  }  
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
add_action('init','avpn_core_signup_disable_inactive');
function avpn_core_signup_disable_inactive() {
  remove_filter('authenticate', 'bp_core_signup_disable_inactive',30);
  add_filter('authenticate', 'bp_core_signup_disable_inactive_override',30, 3);
}
function bp_core_signup_disable_inactive_override( $user = null, $username = '', $password ='' ) {
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

add_action( 'widgets_init', 'avpn_core_widgets_init' );
function avpn_core_widgets_init() {
  register_sidebar( array(
    'name' => 'Featured',
    'id' => 'featured',
    'description' => 'Featured content with flexslider.',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
  ) );

  register_sidebar( array(
    'name' => 'Featured Sidebar',
    'id' => 'featured-sidebar',
    'description' => 'Featured sidebar displaying on the homepage.',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<p class="widget-title">',
    'after_title' => '</p>',
  ) );
}

add_action( 'wp_enqueue_scripts', 'avpn_core_enqueue_script_style' );
function avpn_core_enqueue_script_style()
{

  wp_enqueue_style( 'css-flexslider', plugins_url( '/lib/flexslider/flexslider.css' , __FILE__ ));

  wp_enqueue_script( 'js-flexslider', plugins_url( '/lib/flexslider/jquery.flexslider-min.js' , __FILE__ ) , array('jquery'));
  wp_enqueue_script( 'js-ammap-main', plugins_url( '/lib/ammap/ammap.js' , __FILE__ ) , array('jquery'));
  wp_enqueue_script( 'js-ammap-worldlow', plugins_url( '/lib/ammap/maps/js/worldLow.js' , __FILE__ ) , array('jquery'));


}

// Creating the widget 
class avpn_core_featured_flexslider extends WP_Widget {

  function __construct() {
    parent::__construct(
    // Base ID of your widget
    'featured-flexslider', 

    // Widget name will appear in UI
    'Featured Flexlider', 

    // Widget description
    array( 'description' => 'Featured content display with flexslider.', ) 
    );
  }

  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];

    // This is where you run the code and display the output
    ?>
    <div class="flexslider" style="margin-bottom:10px;">
      <ul class="slides">
        <li>
          <iframe width="640" height="360" src="//www.youtube.com/embed/5HPCg9VHp1w?rel=0&autoplay=0&controls=0&showinfo=0&modestbranding=1" frameborder="0" allowfullscreen></iframe>
        </li>
        <?php $loop = new WP_Query( array( 'post_type' => 'investment-showcase', 'posts_per_page' => 5, 'post_status' => 'publish') ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <li>
            <?php $image = get_field('featured_image');?>
            <a href="<?php the_permalink() ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /></a>
            <p class="flex-caption">
              <strong style="font-size:20px;"><?php the_title(); ?> (<?php echo get_field('organisation_name')->post_title; ?>)</strong>
              <br/>
              <span><?php the_field('social_sector'); ?></span>
            </p>
          </li>     
        <?php endwhile; ?>
      </ul>
    </div>
    <?php
    echo $args['after_widget'];
  }
    
  // Widget Backend 
  public function form( $instance ) {
    // Widget admin form
    ?>
    <p>
      Nothing to change here yet.
    </p>
    <?php 
  }
  
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
  }
} // Class wpb_widget ends here

// Register and load the widget
add_action( 'widgets_init', 'wpb_load_widget' );
function wpb_load_widget() {
  register_widget( 'avpn_core_featured_flexslider' );
}

// Adding extra settings mmenu to membership applications
add_action('admin_menu', 'avpn_core_membership_application_notification');
function avpn_core_membership_application_notification(){
  add_users_page( 'Notification Settings', 'Notification Settings', 'manage_options', 'avpn-core-membership-application-notification', 'avpn_core_membership_application_notification_settings_page'); 
}
 
function avpn_core_membership_application_notification_settings_page(){
?>
  <div class="wrap">
    <h2>Notification Settings</h2>
    <?php settings_errors(); ?>
    <?php
      // for toggle between the tabs, which to display or hidden
      if( isset( $_GET[ 'tab' ] ) ) {
         $active_tab = $_GET[ 'tab' ];
      }
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=avpn-core-membership-application-notification&tab=avpn-core-membership-application-notification-admin-options" class="nav-tab <?php echo $active_tab == 'avpn-core-membership-application-notification-admin-options' ? 'nav-tab-active' : ''; ?>">Membership Admin Email Options</a>
        <a href="?page=avpn-core-membership-application-notification&tab=a" class="nav-tab <?php echo $active_tab == 'a' ? 'nav-tab-active' : ''; ?>">a</a>
        <a href="?page=avpn-core-membership-application-notification&tab=b" class="nav-tab <?php echo $active_tab == 'b' ? 'nav-tab-active' : ''; ?>">b</a>
    </h2>
    <form method="post" action="options.php">
      <?php
        if( $active_tab == 'avpn-core-membership-application-notification-admin-options' ) {
          settings_fields( 'avpn-core-membership-application-notification' );
          do_settings_sections( 'avpn-core-membership-application-notification' );
          submit_button(); 
        }else{
          //do nothing yet
        }
      ?>
    </form>
  </div>
<?php
}

// Wordpress settings API
add_action('admin_init', 'avpn_core_membership_application_notification_settings');
function avpn_core_membership_application_notification_settings() {
 
    // First, we register a section. This is necessary since all future options must belong to one.
    add_settings_section(
        'avpn-core-membership-application-notification-admin-options',         // ID used to identify this section and with which to register options
        '',                                                       // Title to be displayed on the administration page
        'avpn_core_membership_application_notification_admin_options_callback',                                                                    // Callback used to render the description of the section
        'avpn-core-membership-application-notification'                        // Page on which to add this section of options
    );

    add_settings_field(
        'avpn-core-membership-application-notification-admin-options-to',            // ID used to identify the field throughout the theme
        'To',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_application_notification_admin_options_to_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-application-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-application-notification-admin-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-application-notification',
        'avpn-core-membership-application-notification-admin-options-to'
    );

    add_settings_field(
        'avpn-core-membership-application-notification-admin-options-from',            // ID used to identify the field throughout the theme
        'From',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_application_notification_admin_options_from_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-application-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-application-notification-admin-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-application-notification',
        'avpn-core-membership-application-notification-admin-options-from'
    );

    add_settings_field(
        'avpn-core-membership-application-notification-admin-options-cc',            // ID used to identify the field throughout the theme
        'CC',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_application_notification_admin_options_cc_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-application-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-application-notification-admin-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-application-notification',
        'avpn-core-membership-application-notification-admin-options-cc'
    );

    add_settings_field(
        'avpn-core-membership-application-notification-admin-options-bcc',            // ID used to identify the field throughout the theme
        'BCC',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_application_notification_admin_options_bcc_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-application-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-application-notification-admin-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-application-notification',
        'avpn-core-membership-application-notification-admin-options-bcc'
    );

    add_settings_field(
        'avpn-core-membership-application-notification-admin-options-sbj',            // ID used to identify the field throughout the theme
        'Subject',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_application_notification_admin_options_sbj_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-application-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-application-notification-admin-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-application-notification',
        'avpn-core-membership-application-notification-admin-options-sbj'
    );

    add_settings_field(
        'avpn-core-membership-application-notification-admin-options-msg',            // ID used to identify the field throughout the theme
        'Message',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_application_notification_admin_options_msg_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-application-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-application-notification-admin-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-application-notification',
        'avpn-core-membership-application-notification-admin-options-msg'
    );
}
function avpn_core_membership_application_notification_admin_options_callback($args){
?>
    <p>Configure notification email to be sent out when a membership application is submitted.</p>
<?php
}
function avpn_core_membership_application_notification_admin_options_to_callback($args){
?>
    <input type="text" id="avpn-core-membership-application-notification-admin-options-to" name="avpn-core-membership-application-notification-admin-options-to" value="<?php echo get_option('avpn-core-membership-application-notification-admin-options-to'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_application_notification_admin_options_from_callback($args){
?>
    <input type="text" id="avpn-core-membership-application-notification-admin-options-from" name="avpn-core-membership-application-notification-admin-options-from" value="<?php echo get_option('avpn-core-membership-application-notification-admin-options-from'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_application_notification_admin_options_cc_callback($args){
?>
    <input type="text" id="avpn-core-membership-application-notification-admin-options-cc" name="avpn-core-membership-application-notification-admin-options-cc" value="<?php echo get_option('avpn-core-membership-application-notification-admin-options-cc'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_application_notification_admin_options_bcc_callback($args){
?>
    <input type="text" id="avpn-core-membership-application-notification-admin-options-bcc" name="avpn-core-membership-application-notification-admin-options-bcc" value="<?php echo get_option('avpn-core-membership-application-notification-admin-options-bcc'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_application_notification_admin_options_sbj_callback($args){
?>
    <input type="text" id="avpn-core-membership-application-notification-admin-options-sbj" name="avpn-core-membership-application-notification-admin-options-sbj" value="<?php echo get_option('avpn-core-membership-application-notification-admin-options-sbj'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_application_notification_admin_options_msg_callback($args){
    wp_editor(get_option('avpn-core-membership-application-notification-admin-options-msg'), 'avpn-core-membership-application-notification-admin-options-msg', array('media_buttons' => false));

}

?>