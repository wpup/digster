<?php

namespace Frozzare\Digster\Extensions;

class Global_Extensions extends \Twig_Extension implements \Twig_Extension_GlobalsInterface {

	/**
	 * Get global variable.
	 *
	 * @return array
	 */
	public function getGlobals() {
		$globals = [
			'post' => get_post( get_the_ID() )
		];

		/**
		 * Modify globals or add custom.
		 *
		 * @param array $globals
		 */
		$globals = apply_filters( 'digster/globals', $globals );
		$globals = is_array( $globals ) ? $globals : [];

		return $globals;
	}

	/**
	 * Get the extension name.
	 *
	 * @return string
	 */
	public function getName() {
		return 'digster-globals';
	}
}
