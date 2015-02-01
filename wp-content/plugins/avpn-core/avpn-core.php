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
  if ( is_page('Investment Showcase')){
  	$classes[] = 'full-width';
  }
  return $classes;
}

add_action( 'body_class', 'bp_members_component_full_width');
function bp_members_component_full_width( $classes ){
  global $post;
  if ( bp_current_component('members')){
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

  if ( is_page( 'Apply for Membership' )) {

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
/**
 * @param $post_id
 * @return int|WP_Error
 */
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

  $username = $_POST['fields']['field_54b2ad2fd1d7e'];
  $user_email = $_POST['fields']['field_53dfe693365cc'];
  $organisation_name = $_POST['fields']['field_53e005437ca34'];
  $organisation_url = get_permalink($post_id);
  $all_fields = html_show_array($_POST['fields']);
 
  if(!username_exists( $username )) {

    // Generate the password and create the user
    // NOTE: this is for the sake of registering user using bp_core_signup_user function, the password will be regenerated again during activate_membership. (the password need to be forward to user upon activation)
    // TODO: is there any other way to only generate once? 
    $password = wp_generate_password( 12, false );

    
    // have to put these before bp_core_signup_user because of the redirect
    $admin_to = get_option('avpn-core-membership-admin-notification-options-to');
    $admin_subject = str_replace("{organisation_name}", $organisation_name, get_option('avpn-core-membership-admin-notification-options-sbj'));
    $admin_message = str_replace("{organisation_url}", $organisation_url, get_option('avpn-core-membership-admin-notification-options-msg'));
    $admin_message = str_replace("{all_fields}", $all_fields, $admin_message);
    $admin_headers = "MIME-Version: 1.0\r\n";
    $admin_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    // variable placeholders
    $organisation_admin_first_name = $_POST['fields']['field_53dfe627365ca'];
    $organisation_admin_last_name = $_POST['fields']['field_53dfe662365cb'];

    // user notification fields
    $user_to = $user_email;
    $user_subject = get_option('avpn-core-membership-user-notification-options-sbj');
    $user_subject = str_replace("{organisation_name}", $organisation_name, $user_subject);
    $user_message = get_option('avpn-core-membership-user-notification-options-msg');
    $user_message = str_replace("{first_name}", $organisation_admin_first_name, $user_message);
    $user_message = str_replace("{last_name}", $organisation_admin_last_name, $user_message);
    $user_message = str_replace("{organisation_name}", $organisation_name, $user_message);

    // Send admin notification
    wp_mail(
      $admin_to,
      $admin_subject,
      $admin_message,
      $admin_headers
    );

    // Send organisation contact user email notification
    wp_mail(
      $user_to,
      $user_subject,
      $user_message
    );

    $user_id = bp_core_signup_user( $username, $password, $user_email, null);

  } // end if

  // return the new ID
  return $post_id;
}

// post-action after admin activate pending membership
add_action('bp_core_activated_user','activate_membership');
function activate_membership($user_id){
  $user = get_user_by('id', $user_id);
  $username = $user->user_login;
  $user_email = $user->user_email;
  $user_first_name = $user->first_name;
  $user_last_name = $user->last_name;
  $display_name = $user->display_name;

  $loop = new WP_Query( array( 'post_type' => 'organisation') );
  while ( $loop->have_posts() ){
    $loop->the_post();

    $organisation_name = get_the_title();

    if($user_email == get_field('membership_admin_contact_email') && $username == get_field('membership_admin_contact_username')){
      // is one of the organisation moderator account

      // Set the nickname & default role
      wp_update_user(
        array(
          'ID'          =>    $user_id,
          'nickname'    =>    $username,
          'role'        =>    'membership_profile_moderator'
        )
      );

      global $coauthors_plus;
      $coauthors_plus->add_coauthors( get_the_ID(), array($username), true );

      // Regenerate random user password
      $password = wp_generate_password( 12, false );
      wp_set_password($password, $user_id);

      $user_to = $user_email;
      $user_subject = get_option('avpn-core-membership-user-notification-options-approval-sbj');
      $user_subject = str_replace("{organisation_name}", $organisation_name, $user_subject);
      $user_message = get_option('avpn-core-membership-user-notification-options-approval-msg');
      $user_message = str_replace("{first_name}", $user_first_name, $user_message);
      $user_message = str_replace("{last_name}", $user_last_name, $user_message);
      $user_message = str_replace("{organisation_name}", $organisation_name, $user_message);
      $user_message = str_replace("{username}", $username, $user_message);
      $user_message = str_replace("{password}", $password, $user_message);


      // Email the user & password
      wp_mail(
        $user_to,
        $user_subject,
        $user_message
      ); 

      // early return if found
      return;
    }
  }

  // is a regular account, since early return is not executing and the loop is exhausted
  // Regenerate random user password
  $password = wp_generate_password( 12, false );
  wp_set_password($password, $user_id);

  $user_to = $user_email;
  $user_subject = get_option('avpn-core-membership-user-reg-notification-options-approval-sbj');
  $user_message = get_option('avpn-core-membership-user-reg-notification-options-approval-msg');
  //$user_message = str_replace("{first_name}", $user_first_name, $user_message);
  //$user_message = str_replace("{last_name}", $user_last_name, $user_message);
  $user_message = str_replace("{display_name}", $display_name, $user_message);
  $user_message = str_replace("{username}", $username, $user_message);
  $user_message = str_replace("{password}", $password, $user_message);

  // Email the user & password
  wp_mail(
    $user_to,
    $user_subject,
    $user_message
  );

}

// Redefine user notification function, disable built in wp notification
if ( !function_exists('wp_new_user_notification') ) {

  function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
    return false;
  }
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
/*
add_filter('acf/load_field/name=avpn_internal_notes', 'apply_for_memberships_hide_field');
add_filter('acf/load_field/name=annual_fee', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=membership_start_date', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=founder_member', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=supporting_member', 'apply_for_memberships_hide_field'); 
add_filter('acf/load_field/name=partner_network', 'apply_for_memberships_hide_field'); 
*/
add_filter('acf/load_field/name=featured_image', 'submit_investment_showcase_hide_field');
add_filter('acf/load_field/name=featured_image', 'apply_for_memberships_hide_field');
function submit_investment_showcase_hide_field ( $field  )
{ 
  if( is_page( 'Submit New Investment Showcase' )){
    return false;
  }else{
    return $field;
  }
}
function apply_for_memberships_hide_field ( $field  )
{ 
  //if it's currently at backend acf form, return the field
  // TODO: PROBABLY not working properly, returning false without proper condition causes both/either frontend and backend unable to display the field
  if( is_page( 'Apply for Memberships' )){
    return false;
  }else{
    return $field;
  }
  // Unused code (wrong logic...for future reference only)
  /*else if(is_admin()){
    // is administrator and has access to backend edit
    return $field;
  }else if(is_coauthor_for_post(get_current_user_id(), get_the_ID()) && $_GET['action']=='edit'){
    // is coauthor and has access to frontend edit
    return $field;
  }else if()*/
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
    'Featured Flexslider', 

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
        <a href="?page=avpn-core-membership-application-notification&tab=avpn-core-membership-admin-notification-tab" class="nav-tab <?php echo $active_tab == 'avpn-core-membership-admin-notification-tab' || !isset($active_tab) ? 'nav-tab-active' : ''; ?>">Admin Notification</a>
        <a href="?page=avpn-core-membership-application-notification&tab=avpn-core-membership-user-notification-tab" class="nav-tab <?php echo $active_tab == 'avpn-core-membership-user-notification-tab' || !isset($active_tab) ? 'nav-tab-active' : ''; ?>">User Notification (Organisation)</a>
        <a href="?page=avpn-core-membership-application-notification&tab=avpn-core-membership-user-reg-notification-tab" class="nav-tab <?php echo $active_tab == 'avpn-core-membership-user-reg-notification-tab' || !isset($active_tab) ? 'nav-tab-active' : ''; ?>">User Notification (Regular)</a>
    </h2>
    <form method="post" action="options.php">
      <?php
        if( $active_tab == 'avpn-core-membership-admin-notification-tab' || !isset($active_tab)) {
          settings_fields( 'avpn-core-membership-admin-notification' );
          do_settings_sections( 'avpn-core-membership-admin-notification' );
          submit_button(); 
        }else if( $active_tab == 'avpn-core-membership-user-notification-tab' || !isset($active_tab)) {
          settings_fields( 'avpn-core-membership-user-notification' );
          do_settings_sections( 'avpn-core-membership-user-notification' );
          submit_button();
        }else if( $active_tab == 'avpn-core-membership-user-reg-notification-tab' || !isset($active_tab)){
          settings_fields( 'avpn-core-membership-user-reg-notification' );
          do_settings_sections( 'avpn-core-membership-user-reg-notification' );
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
// admin tab
add_action('admin_init', 'avpn_core_membership_admin_notification_settings');
function avpn_core_membership_admin_notification_settings() {
 
    // First, we register a section. This is necessary since all future options must belong to one.
    add_settings_section(
        'avpn-core-membership-admin-notification-options',         // ID used to identify this section and with which to register options
        'New Application',                                                       // Title to be displayed on the administration page
        'avpn_core_membership_admin_notification_options_callback',                                                                    // Callback used to render the description of the section
        'avpn-core-membership-admin-notification'                        // Page on which to add this section of options
    );

    add_settings_field(
        'avpn-core-membership-admin-notification-options-to',            // ID used to identify the field throughout the theme
        'To',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_admin_notification_options_to_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-admin-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-admin-notification-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-admin-notification',
        'avpn-core-membership-admin-notification-options-to'
    );

    add_settings_field(
        'avpn-core-membership-admin-notification-options-from',            // ID used to identify the field throughout the theme
        'From',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_admin_notification_options_from_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-admin-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-admin-notification-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-admin-notification',
        'avpn-core-membership-admin-notification-options-from'
    );
    add_settings_field(
        'avpn-core-membership-admin-notification-options-sbj',            // ID used to identify the field throughout the theme
        'Subject',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_admin_notification_options_sbj_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-admin-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-admin-notification-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-admin-notification',
        'avpn-core-membership-admin-notification-options-sbj'
    );

    add_settings_field(
        'avpn-core-membership-admin-notification-options-msg',            // ID used to identify the field throughout the theme
        'Message',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_admin_notification_options_msg_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-admin-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-admin-notification-options',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-admin-notification',
        'avpn-core-membership-admin-notification-options-msg'
    );
}
function avpn_core_membership_admin_notification_options_callback($args){
?>
    <p><strong>Admin</strong> email notification when a new application is received.</p>
<?php
}
function avpn_core_membership_admin_notification_options_to_callback($args){
?>
    <input type="text" id="avpn-core-membership-admin-notification-options-to" name="avpn-core-membership-admin-notification-options-to" value="<?php echo get_option('avpn-core-membership-admin-notification-options-to'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_admin_notification_options_from_callback($args){
?>
    <input type="text" id="avpn-core-membership-admin-notification-options-from" name="avpn-core-membership-admin-notification-options-from" value="<?php echo get_option('avpn-core-membership-admin-notification-options-from'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_admin_notification_options_sbj_callback($args){
?>
    <input type="text" id="avpn-core-membership-admin-notification-options-sbj" name="avpn-core-membership-admin-notification-options-sbj" value="<?php echo get_option('avpn-core-membership-admin-notification-options-sbj'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_admin_notification_options_msg_callback($args){
    wp_editor(get_option('avpn-core-membership-admin-notification-options-msg'), 'avpn-core-membership-admin-notification-options-msg', array('media_buttons' => false));
}

//user
// user tab
add_action('admin_init', 'avpn_core_membership_user_notification_settings');
function avpn_core_membership_user_notification_settings() {
 
    // First, we register a section. This is necessary since all future options must belong to one.
    // Application Approval
    add_settings_section(
        'avpn-core-membership-user-notification-options-approval',         // ID used to identify this section and with which to register options
        'Application Approval',                                                       // Title to be displayed on the useristration page
        'avpn_core_membership_user_notification_options_approval_callback',                                                                    // Callback used to render the description of the section
        'avpn-core-membership-user-notification'                        // Page on which to add this section of options
    );

    add_settings_field(
        'avpn-core-membership-user-notification-options-approval-from',            // ID used to identify the field throughout the theme
        'From',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_user_notification_options_approval_from_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-user-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-user-notification-options-approval',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-user-notification',
        'avpn-core-membership-user-notification-options-approval-from'
    );

    add_settings_field(
        'avpn-core-membership-user-notification-options-approval-sbj',            // ID used to identify the field throughout the theme
        'Subject',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_user_notification_options_approval_sbj_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-user-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-user-notification-options-approval',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-user-notification',
        'avpn-core-membership-user-notification-options-approval-sbj'
    );

    add_settings_field(
        'avpn-core-membership-user-notification-options-approval-msg',            // ID used to identify the field throughout the theme
        'Message',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_user_notification_options_approval_msg_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-user-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-user-notification-options-approval',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-user-notification',
        'avpn-core-membership-user-notification-options-approval-msg'
    );
}

function avpn_core_membership_user_notification_options_sbj_callback($args){
?>
    <input type="text" id="avpn-core-membership-user-notification-options-sbj" name="avpn-core-membership-user-notification-options-sbj" value="<?php echo get_option('avpn-core-membership-user-notification-options-sbj'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_user_notification_options_msg_callback($args){
    wp_editor(get_option('avpn-core-membership-user-notification-options-msg'), 'avpn-core-membership-user-notification-options-msg', array('media_buttons' => false));
}
function avpn_core_membership_user_notification_options_approval_callback($args){
?>
    <p><strong>User</strong> email notification for the outcome of the application. (Send upon user account is activated.)</p>
<?php
}
function avpn_core_membership_user_notification_options_approval_from_callback($args){
?>
    <input type="text" id="avpn-core-membership-user-notification-options-approval-from" name="avpn-core-membership-user-notification-options-approval-from" value="<?php echo get_option('avpn-core-membership-user-notification-options-approval-from'); ?>" style="width:100%;"/>
<?php
}

function avpn_core_membership_user_notification_options_approval_sbj_callback($args){
?>
    <input type="text" id="avpn-core-membership-user-notification-options-approval-sbj" name="avpn-core-membership-user-notification-options-approval-sbj" value="<?php echo get_option('avpn-core-membership-user-notification-options-approval-sbj'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_user_notification_options_approval_msg_callback($args){
    wp_editor(get_option('avpn-core-membership-user-notification-options-approval-msg'), 'avpn-core-membership-user-notification-options-approval-msg', array('media_buttons' => false));
}

//user
// user tab
add_action('admin_init', 'avpn_core_membership_user_reg_notification_settings');
function avpn_core_membership_user_reg_notification_settings() {
 
    // First, we register a section. This is necessary since all future options must belong to one.
    // Application Approval
    add_settings_section(
        'avpn-core-membership-user-reg-notification-options-approval',         // ID used to identify this section and with which to register options
        'Application Approval',                                                       // Title to be displayed on the useristration page
        'avpn_core_membership_user_reg_notification_options_approval_callback',                                                                    // Callback used to render the description of the section
        'avpn-core-membership-user-reg-notification'                        // Page on which to add this section of options
    );

    add_settings_field(
        'avpn-core-membership-user-reg-notification-options-approval-from',            // ID used to identify the field throughout the theme
        'From',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_user_reg_notification_options_approval_from_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-user-reg-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-user-reg-notification-options-approval',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-user-reg-notification',
        'avpn-core-membership-user-reg-notification-options-approval-from'
    );
    add_settings_field(
        'avpn-core-membership-user-reg-notification-options-approval-sbj',            // ID used to identify the field throughout the theme
        'Subject',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_user_reg_notification_options_approval_sbj_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-user-reg-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-user-reg-notification-options-approval',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-user-reg-notification',
        'avpn-core-membership-user-reg-notification-options-approval-sbj'
    );

    add_settings_field(
        'avpn-core-membership-user-reg-notification-options-approval-msg',            // ID used to identify the field throughout the theme
        'Message',                                                                        // The label to the left of the option interface element
        'avpn_core_membership_user_reg_notification_options_approval_msg_callback',   // The name of the function responsible for rendering the option interface
        'avpn-core-membership-user-reg-notification',                             // The page on which this option will be displayed
        'avpn-core-membership-user-reg-notification-options-approval',               // The name of the section to which this field belongs
        array(null)                                                                  // The array of arguments to pass to the callback. In this case, just a description.
    );
    register_setting(
        'avpn-core-membership-user-reg-notification',
        'avpn-core-membership-user-reg-notification-options-approval-msg'
    );
}
function avpn_core_membership_user_reg_notification_options_approval_callback($args){
?>
    <p><strong>User</strong> email notification for the outcome of the application. (Send upon user account is activated.)</p>
<?php
}
function avpn_core_membership_user_reg_notification_options_approval_from_callback($args){
?>
    <input type="text" id="avpn-core-membership-user-reg-notification-options-approval-from" name="avpn-core-membership-user-reg-notification-options-approval-from" value="<?php echo get_option('avpn-core-membership-user-reg-notification-options-approval-from'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_user_reg_notification_options_approval_sbj_callback($args){
?>
    <input type="text" id="avpn-core-membership-user-reg-notification-options-approval-sbj" name="avpn-core-membership-user-reg-notification-options-approval-sbj" value="<?php echo get_option('avpn-core-membership-user-reg-notification-options-approval-sbj'); ?>" style="width:100%;"/>
<?php
}
function avpn_core_membership_user_reg_notification_options_approval_msg_callback($args){
    wp_editor(get_option('avpn-core-membership-user-reg-notification-options-approval-msg'), 'avpn-core-membership-user-reg-notification-options-approval-msg', array('media_buttons' => false));
}

// Send an notification email to regular account.
add_action('bp_core_signup_user', 'avpn_core_post_registration_redirect', 100, 5);
function avpn_core_post_registration_redirect( $user_id, $user_login, $user_password, $user_email, $usermeta) {
  
  $account_type = $_POST['signup_account_type'];

  if($account_type == "regular"){

    $user = get_user_by( 'id', $user_id );

    $admin_to = get_option('avpn-core-membership-admin-notification-options-to');
    $admin_subject = str_replace("{organisation_name}", $user->display_name . ' (Personal Account)', get_option('avpn-core-membership-admin-notification-options-sbj'));
    $admin_message = str_replace("{organisation_url}", home_url('wp-admin/users.php?page=bp-signups'), get_option('avpn-core-membership-admin-notification-options-msg'));

    wp_mail(
      $admin_to,
      $admin_subject,
      $admin_message
    );

    wp_mail(
      $user_email,
      '[AVPN] Thank you for signing up with AVPN!',
      'Dear ' . $user->display_name . ',<br/><br/>' . 'Thank you for signing up with us! Your application is currently pending for approval. Our membership service committee will review your application shortly.<br/><br/><br/><br/>Best regards,<br/>AVPN Membership team<br/>33a Circular Road, Singapore 049389'
    );

    bp_core_redirect(home_url('/registration-successful'));
  }
}

// Activation is not used, disabled buddypress user activation & the related pages
// Redirect any form of access to home page instead
add_action('wp','avpn_core_redirect_to_home');
function avpn_core_redirect_to_home() {
  global $bp;
  
  if ( bp_is_activation_page()) {
    bp_core_redirect( home_url());
    exit();
  }
}

// Restrict access to media library, view only own post's media or uploaded to that particular post. (Except administrator role)
add_action('pre_get_posts','avpn_core_restrict_media_library');
function avpn_core_restrict_media_library( $wp_query_obj ) {
  global $current_user, $pagenow;
  if( !is_a( $current_user, 'WP_User') )
  return;
  if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
  return;
  if( !current_user_can('manage_media_library') )
  $wp_query_obj->set('author', $current_user->ID );
  return;
}

add_action( 'bp_setup_nav', 'bp_remove_nav_item' ,999);
function bp_remove_nav_item() {
    global $bp;

    bp_core_remove_nav_item( 'events' );
    bp_core_remove_subnav_item('groups', 'group-events');
    // NOTE: disable for individual group pages events at CSS #forums-groups-li
}

add_action( 'really_simple_csv_importer_save_meta', 'avpn_core_rscism_filter', 10, 3);
function avpn_core_rscism_filter($meta, $post, $is_update) {
  /*$meta_array = array();

  foreach($meta as $key => $value){
    if($key == 'which_are_the_main_countries_that_your_company_operate_in'){
      $meta_array['field_53c336259c1ac'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'my_organisation_is_registered_as'){
      $meta_array['field_53c3322a88013'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'country'){
      $meta_array['field_53dfe525fed8a'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'billing_address_country'){
      $meta_array['field_53dfe827365d5'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'avpn_membership_type'){
      $meta_array['field_53c334af9c1a8'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'my_organisaions_relevent_activity_is'){
      $meta_array['field_53c335439c1a9'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'which_are_the_main_countries_that_your_company_operate_in'){
      $meta_array['field_53c336259c1ac'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'which_social_sectors_do_you_support'){
      $meta_array['field_53c3368f9c1ad'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'what_is_the_average_amount_per_investee_that_you_fund'){
      $meta_array['field_53c336c29c1ae'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'what_is_your_annual_funding_target'){
      $meta_array['field_53c3373b9c1af'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'how_many_transactions_do_you_target_per_year'){
      $meta_array['field_53dfefe2760cf'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'what_main_types_of_financing_do_you_offer'){
      $meta_array['field_53c337799c1b0'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'what_types_of_services_do_you_provide'){
      $meta_array['field_53c337ae9c1b1'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'what_is_your_preferred_type_of_target_organisations'){
      $meta_array['field_53c338b375df3'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'what_is_the_preferred_stage_of_development_of_target_organisations'){
      $meta_array['field_53c338f375df4'] = serialize(preg_split("/,+/", $value));
    }else if($key == 'how_would_you_rate_your_hands-on_involvement_with_investees'){
      $meta_array['field_53c3393475df5'] = serialize(preg_split("/,+/", $value)); 
    }else{
      $meta_array[$key] = $value;
    }
  }*/

  if(isset($meta['field_53c336259c1ac'])) $meta['field_53c336259c1ac'] = preg_split("/,+/", $meta['field_53c336259c1ac']);
  if(isset($meta['field_53c3322a88013'])) $meta['field_53c3322a88013'] = preg_split("/,+/", $meta['field_53c3322a88013']);
  if(isset($meta['field_53dfe525fed8a'])) $meta['field_53dfe525fed8a'] = preg_split("/,+/", $meta['field_53dfe525fed8a']);
  if(isset($meta['field_53dfe827365d5'])) $meta['field_53dfe827365d5'] = preg_split("/,+/", $meta['field_53dfe827365d5']);
  if(isset($meta['field_53c334af9c1a8'])) $meta['field_53c334af9c1a8'] = preg_split("/,+/", $meta['field_53c334af9c1a8']);
  if(isset($meta['field_53c335439c1a9'])) $meta['field_53c335439c1a9'] = preg_split("/,+/", $meta['field_53c335439c1a9']);
  if(isset($meta['field_53c3368f9c1ad'])) $meta['field_53c3368f9c1ad'] = preg_split("/,+/", $meta['field_53c3368f9c1ad']);
  if(isset($meta['field_53c336c29c1ae'])) $meta['field_53c336c29c1ae'] = preg_split("/,+/", $meta['field_53c336c29c1ae']);
  if(isset($meta['field_53c3373b9c1af'])) $meta['field_53c3373b9c1af'] = preg_split("/,+/", $meta['field_53c3373b9c1af']);
  if(isset($meta['field_53dfefe2760cf'])) $meta['field_53dfefe2760cf'] = preg_split("/,+/", $meta['field_53dfefe2760cf']);
  if(isset($meta['field_53c337799c1b0'])) $meta['field_53c337799c1b0'] = preg_split("/,+/", $meta['field_53c337799c1b0']);
  if(isset($meta['field_53c337ae9c1b1'])) $meta['field_53c337ae9c1b1'] = preg_split("/,+/", $meta['field_53c337ae9c1b1']);
  if(isset($meta['field_53c338b375df3'])) $meta['field_53c338b375df3'] = preg_split("/,+/", $meta['field_53c338b375df3']);
  if(isset($meta['field_53c338f375df4'])) $meta['field_53c338f375df4'] = preg_split("/,+/", $meta['field_53c338f375df4']);
  if(isset($meta['field_53c3393475df5'])) $meta['field_53c3393475df5'] = preg_split("/,+/", $meta['field_53c3393475df5']);
  if(isset($meta['field_53c32a2c0c0bc'])) $meta['field_53c32a2c0c0bc'] = preg_split("/,+/", $meta['field_53c32a2c0c0bc']);
  if(isset($meta['field_53c32f3d9675e'])) $meta['field_53c32f3d9675e'] = preg_split("/,+/", $meta['field_53c32f3d9675e']);


  return $meta;
}

// Register logo sizes for member list and investment showcase
add_action('init', 'avpn_core_add_image_size');
function avpn_core_add_image_size(){
	add_image_size('organisation_logo_fw_vh', 150); 
}

//multidimensional array to html table functions
function do_offset($level){
  $offset = "";             // offset for subarry
  for ($i=1; $i<$level;$i++){
    $offset = $offset . "<td></td>";
  }
  return $offset;
}

function show_array($array, $level, $sub){

  if (is_array($array) == 1){          // check if input is an array
    $html = '';
    foreach($array as $key_val => $value) {
      $offset = "";
      if (is_array($value) == 1){   // array is multidimensional
        $html .= "<tr>";
        $offset = do_offset($level);
        $html .= $offset . '<td width="200" style="font-size:10pt;font-weight: bold;">' . get_field_object($key_val)['label'] . "</td>";
        $html .= show_array($value, $level+1, 1);
      }
      else{                        // (sub)array is not multidim
        if ($sub != 1){          // first entry for subarray
          $html .= "<tr nosub>";
          $offset = do_offset($level);
        }
        $sub = 0;
        $html .= $offset . "<td main ".$sub.' width="200" style="font-size:10pt; background-color: #EEEEEE;font-weight:bold;">' . get_field_object($key_val)['label'] .
            '</td><td width="200" style="font-size:10pt;">' . $value . "</td>";
        $html .= "</tr>\n";
      }
    } //foreach $array
    return $html;
  }
  else{ // argument $array is not an array
    return;
  }
}

function html_show_array($array){
  $html = '';
  $html .= "<table cellspacing=\"0\" border=\"2\">\n";
  $html .= show_array($array, 1, 0);
  $html .= "</table>\n";

  return $html;
}

?>
