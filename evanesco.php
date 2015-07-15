<?php
/**
 * Plugin Name: Evanesco! : Admin Menu and Widget Controller
 * Plugin URI: http://www.sujinc.com/
 * Description: Turn Wordpress menus and widgets on and off
 * Version: 2.0
 * Author: Sujin 수진 Choi
 * Author URI: http://www.sujinc.com/
 * License: GPLv2 or later
 * Text Domain: evanesco
 */

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

# Definitions
if ( !defined( 'EVNSCO_PLUGIN_NAME' ) ) {
	$basename = trim( dirname( plugin_basename( __FILE__ ) ), '/' );
	if ( !is_dir( WP_PLUGIN_DIR . '/' . $basename ) ) {
		$basename = explode( '/', $basename );
		$basename = array_pop( $basename );
	}

	define( 'EVNSCO_PLUGIN_NAME', $basename );

	if ( !defined( 'EVNSCO_PLUGIN_BASE' ) )
		define( 'EVNSCO_PLUGIN_BASE', WP_PLUGIN_DIR . '/' . EVNSCO_PLUGIN_NAME . '/' . basename(__FILE__) );

	if ( !defined( 'EVNSCO_PLUGIN_DIR' ) )
		define( 'EVNSCO_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . EVNSCO_PLUGIN_NAME );

	if ( !defined( 'EVNSCO_CLASS_DIR' ) )
		define( 'EVNSCO_CLASS_DIR', WP_PLUGIN_DIR . '/' . EVNSCO_PLUGIN_NAME . '/classes/' );

	if ( !defined( 'EVNSCO_VIEW_DIR' ) )
		define( 'EVNSCO_VIEW_DIR', WP_PLUGIN_DIR . '/' . EVNSCO_PLUGIN_NAME . '/views/' );

	if ( !defined( 'EVNSCO_ASSETS_URL' ) )
		define( 'EVNSCO_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/' );
}

# Load Classes
include_once( EVNSCO_CLASS_DIR . 'wp-hack/abstract.admin_page.php');
include_once( EVNSCO_CLASS_DIR . 'wp-hack/class.redirection.php');

include_once( EVNSCO_CLASS_DIR . 'admin.settings.php');
include_once( EVNSCO_CLASS_DIR . 'menus_widgets.php');
include_once( EVNSCO_CLASS_DIR . 'init.php');

EVNSCO::initialize();


// require_once('functions.php');