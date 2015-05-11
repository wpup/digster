<?php

namespace Digster\Extensions;

/**
 * Digster functions extension.
 *
 * @package Digster
 */

class Function_Extensions extends \Twig_Extension {

	/**
	 * Call WordPress action
	 */

	public function doAction() {
		call_user_func_array( 'do_action', func_get_args() );
	}

	/**
	 * Get functions.
	 *
	 * @return array
	 */

	public function getFunctions() {
		$callables = [
			'action'    => [$this, 'doAction'],
			'wp_head'   => 'wp_head',
			'wp_footer' => 'wp_footer'
		];

		foreach ( $callables as $fn => $callable ) {
			$callables[$fn] = new \Twig_SimpleFunction( $fn, $callable );
		}

		return $callables;
	}

	/**
	 * Get the extension name.
	 *
	 * @return string
	 */

	public function getName() {
		return 'digster-functions';
	}

}
