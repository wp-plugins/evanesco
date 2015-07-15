<?php
/**
 * Make wp_redirect even after header sent
 *
 * @author Sujin 수진 Choi
 * @package wp-hacks
 * @version 1.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( !class_exists('WP_Redirect' ) ) {
	class WP_Redirect {
		public function __construct() {
			add_filter( 'wp_redirect', array( $this, 'wp_redirect' ) );
		}

		public function wp_redirect( $location ) {
			if ( headers_sent() ) {
				printf( '<meta http-equiv="refresh" content="0; url=%s">', $location );
				printf( '<script>window.location="%s"</script>', $location );

				die;
			}

			return $location;
		}

	}
	new WP_Redirect;
}

