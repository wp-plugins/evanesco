<?php
/**
 * EVNSCO_Menus_Widgets
 *
 * project	Evanesco!
 * version	1.1.0
 * Author: Sujin 수진 Choi
 * Author URI: http://www.sujinc.com/
 *
*/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

class EVNSCO_Menus_Widgets {
	static $default_menus;
	static $default_widgets;

	static $menus;
	static $widgets;

	static function launch() {
		add_action('admin_menu', array( EVNSCO_Menus_Widgets, 'get_data' ), 15);

		global $pagenow;
		if ( $pagenow == "widgets.php" ) {
			add_action( 'widgets_init', array( EVNSCO_Menus_Widgets, 'remove_widgets' ) );
		}
	}

	static function get_data() {
		self::$menus = get_option( 'sj-evanesco-menus' );

		global $pagenow, $wp_widget_factory, $menu;

		self::$default_menus = $menus_temp = $menu;
		self::$default_widgets = $wp_widget_factory->widgets;

		foreach( $menus_temp as $key => $value ) {
			if ( $value[4] == "wp-menu-separator" || $value[5] == "menu-settings" ) {
				unset( self::$default_menus[$key]);
			} else {
				$sep = explode( "<span", $value[0] );
				self::$default_menus[$key][0] = $sep[0];
			}

			if ( !empty( $value[5] ) && !empty( self::$menus[$value[5]] ) && self::$menus[$value[5]] == "hide") {
				unset($menu[$key]);
			}
		}
	}

	static function remove_widgets() {
		self::$widgets = get_option( 'sj-evanesco-widgets' );
		global $wp_widget_factory;

		if ( function_exists( 'unregister_widget' ) ) {
			foreach ( $wp_widget_factory->widgets as $key => $widget ) {
				if ( self::$widgets[$widget->id_base] == "hide" ) {
					unregister_widget( $key );
				}
			}
		}
	}
}
