<?php
/*
Plugin Name: RH Frontend Publishing Pro (Rehub Theme addition)
Plugin URI: http://wpfrontendpublishing.com/
Description: Allow your users to create, edit and delete posts directly from the WordPress frontend area.
Version: 3.19
Author: Hassan Akhtar, Wpsoul.com
Author URI: http://wpgurus.net/
Text Domain: wpfepp-plugin
Domain Path: /languages/
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-frontend-publishing-pro.php';

include('includes/global-functions.php');

$data_settings = get_option('wpfepp_payment_settings');
if( $data_settings && $data_settings['turn_on_payment'] ){
	include('includes/paid-functions.php');
}

function wpfepp_run_plugin() {
	$wpfepp = new Frontend_Publishing_Pro( "3.19" );
	$wpfepp->run();
}

wpfepp_run_plugin();

/**
 * Loads the plugin's text domain for localization.
 **/
function wpfepp_load_plugin_textdomain() {
	load_plugin_textdomain( 'wpfepp-plugin', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'wpfepp_load_plugin_textdomain' );

/**
 * Uses do_action to run plugin activation and initialization functions.
 **/
function wpfepp_activation(){
	do_action('wpfepp_activation');
}
register_activation_hook( __FILE__, 'wpfepp_activation' );

/**
 * Uses do_action to run hooked functions when plugin is uninstalled.
 **/
function wpfepp_uninstall(){
	do_action('wpfepp_uninstall');
}
register_uninstall_hook( __FILE__, 'wpfepp_uninstall' );

?>