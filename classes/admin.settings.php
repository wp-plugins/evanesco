<?php
/**
 * Admin : Plugins Hooking
 *
 * project	Query Monitor Extension - Checking Variables
 * version	3.0
 * Author: Sujin 수진 Choi
 * Author URI: http://www.sujinc.com/
 *
*/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

class evanesco extends WP_Admin_Page {
	function save_setting() {
		if ( !parent::save_setting() ) return false;

		foreach ( EVNSCO_Menus_Widgets::$default_menus as $value ) {
			EVNSCO_Menus_Widgets::$menus[$value[5]] = $_POST[$value[5]];
		}
		update_option( 'sj-evanesco-menus', EVNSCO_Menus_Widgets::$menus );

		foreach ( EVNSCO_Menus_Widgets::$default_widgets as $value ) {
			EVNSCO_Menus_Widgets::$widgets[$value->id_base] = $_POST["widget-" . $value->id_base];
		}
		update_option( 'sj-evanesco-widgets', EVNSCO_Menus_Widgets::$widgets );

		wp_redirect( $_SERVER['HTTP_REFERER'] );
	}
}