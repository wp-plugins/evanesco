<?php
/**
 * Initialize
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

class EVNSCO {
	private static $__instance;

	private static $style_path;
	private static $script_path;

	private $EVNSCO_AdminPage;

	function __construct() {
		if ( is_admin() ) {
			self::$style_path = EVNSCO_ASSETS_URL . 'css/evanesco.css';
			self::$script_path = EVNSCO_ASSETS_URL . 'min/evanesco-min.js';

			# Script and Style
			add_action( 'admin_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );

			# Get Menus and Widgets
			EVNSCO_Menus_Widgets::launch();

			# Set Options Page
			$EVNSCO_AdminPage = new evanesco( array(
				'name' => 'Evanesco!',
				'dir_name' => EVNSCO_PLUGIN_NAME,
				'metabox' => array(
					'donation' => array(
						'position' => 'side',
						'template' => EVNSCO_VIEW_DIR . 'admin.metabox.donation.php'
					),
					'save settings' => array(
						'position' => 'side',
						'template' => EVNSCO_VIEW_DIR . 'admin.metabox.save.php'
					),
					'option' => array(
						'template' => EVNSCO_VIEW_DIR . 'admin.metabox.option.php'
					),
				)
			) );
		}
	}

	function wp_enqueue_scripts() {
		wp_enqueue_style( 'evanesco', self::$style_path, false, '1.0' );
		wp_enqueue_script( 'evanesco', self::$script_path, array( 'jquery' ), '1.0' );
	}

	/**
	 * initialize
	 *
	 * @since 3.0
	 * @access public
	 */
	public static function initialize(){
		EVNSCO::getInstance();
	}

	/**
	 * Return Instance
	 *
	 * @since 3.0
	 * @access public
	 */
	public static function getInstance() {
		// check if instance is avaible
		if ( self::$__instance==null ) {
			// create new instance if not
			self::$__instance = new self();
		}
		return self::$__instance;
	}
}
