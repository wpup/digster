<?php

namespace Digster;

/**
 * Hook the WordPress plugin into the appropriate WordPress actions and filters.
 *
 * @package Digster
 */

final class Plugin_Loader {

	/**
	 * The instance of Plugin loader class.
	 *
	 * @var object
	 */

	private static $instance;

	/**
	 * Get Plugin boilerplate loader instance.
	 *
	 * @return object
	 */

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
			self::$instance->setup_actions();
		}

		return self::$instance;
	}

	/**
	 * Load Digster extensions.
	 */

	public function load_extensions() {
		$extensions = [
			new \Digster\Extensions\Filter_Extensions(),
			new \Digster\Extensions\Function_Extensions(),
			new \Digster\Extensions\Global_Extensions()
		];

		$extensions = apply_filters( 'digster/extensions', $extensions );

		View::register_extensions( $extensions );
	}

	/**
	 * Setup actions.
	 */

	private function setup_actions() {
		add_action( 'after_setup_theme', [$this, 'load_extensions'] );
	}

}
