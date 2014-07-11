<?php
/*
Plugin Name: Users Ultra Lite
Plugin URI: http://usersultra.com
Description: This is a powerful user profiles plugin for WordPress.
Version: 1.0.96
Author: Users Ultra
Author URI: http://usersultra.com
*/

define('xoousers_url',plugin_dir_url(__FILE__ ));
define('xoousers_path',plugin_dir_path(__FILE__ ));
define('xoousers_template','basic');

// Get plugin version from header
function xoousersultra_get_plugin_version()
{
    $default_headers = array( 'Version' => 'Version' );
    $plugin_data = get_file_data( __FILE__, $default_headers, 'plugin' );
    return $plugin_data['Version'];
}


$plugin = plugin_basename(__FILE__);

/* Loading Function */
require_once (xoousers_path . 'functions/functions.php');

/* Init */
require_once (xoousers_path . 'init/init.php');

/* Master Class  */
require_once (xoousers_path . 'xooclasses/xoo.userultra.class.php');

$xoouserultra = new XooUserUltra();
$xoouserultra->plugin_init();

/* load addons */
require_once xoousers_path . 'addons/photocategories/index.php';