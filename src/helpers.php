<?php

if ( ! function_exists( 'view' ) ) {
	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param  string $view
	 * @param  array  $data
	 *
	 * @return \Frozzare\Digster\View
	 */
	function view( $view = null, $data = [] ) {
		$factory = \Frozzare\Digster\Digster::factory();

		if ( func_num_args() === 0 ) {
			return $factory;
		}

		return $factory->make( $view, $data );
	}
}
