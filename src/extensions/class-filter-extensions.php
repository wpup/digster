<?php

namespace Frozzare\Digster\Extensions;

class Filter_Extensions extends \Twig_Extension {

	/**
	 * Call WordPress filter.
	 *
	 * @return mixed
	 */
	public function apply_filters() {
		$args = func_get_args();
		$tag  = current( array_splice( $args, 1, 1 ) );
		return apply_filters_ref_array( $tag, $args );
	}

	/**
	 * Get filters.
	 *
	 * @return array
	 */
	public function getFilters() {
		$filters = [
			'apply_filters' => [$this, 'apply_filters'],
			'excerpt'       => 'wp_trim_words',
			'shortcodes'    => 'do_shortcode',
			'wpautop'       => 'wpautop'
		];

		/**
		 * Modify filters or add custom.
		 *
		 * @param array $callables
		 */
		$filters = apply_filters( 'digster/filters', $filters );
		$filters = is_array( $filters ) ? $filters : [];

		// Add filters.
		foreach ( $filters as $filter => $callable ) {
			if ( is_string( $filter ) && is_callable( $callable ) ) {
				$filters[$filter] = new \Twig_SimpleFilter( $filter, $callable );
			}
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
