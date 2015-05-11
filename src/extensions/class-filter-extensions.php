<?php

namespace Digster\Extensions;

/**
 * Digster filter extension.
 *
 * @package Digster
 */

class Filter_Extensions extends \Twig_Extension {

	/**
	 * Get filters.
	 *
	 * @return array
	 */

	public function getFilters() {
		$filters = [
			'excerpt'    => 'wp_trim_words',
			'shortcodes' => 'do_shortcode',
			'wpautop'    => 'wpautop'
		];

		foreach ( $filters as $filter => $callable ) {
			$filters[$filter] = new \Twig_SimpleFilter( $filter, $callable );
		}

		return $filters;
	}

	/**
	 * Get the extension name.
	 *
	 * @return string
	 */

	public function getName() {
		return 'digster-filters';
	}

}
