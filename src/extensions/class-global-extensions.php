<?php

namespace Digster\Extensions;

/**
 * Digster globals extension.
 *
 * @package Digster
 */

class Global_Extensions extends \Twig_Extension {

	/**
	 * Get global variable.
	 *
	 * @return array
	 */

	public function getGlobals() {
		return [
			'post' => get_post( get_the_ID() )
		];
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
