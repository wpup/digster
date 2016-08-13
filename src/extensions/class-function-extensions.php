<?php

namespace Frozzare\Digster\Extensions;

class Function_Extensions extends \Twig_Extension {

	/**
	 * Call PHP function.
	 *
	 * @return mixed
	 */
	public function call_function() {
		$args = func_get_args();
		$name = array_shift( $args );

		return call_user_func_array( trim( $name ), $args );
	}

	/**
	 * Call static method on class.
	 *
	 * @return mixed
	 */
	public function call_static() {
		$args  = func_get_args();
		$class = array_shift( $args );
		$name  = array_shift( $args );

		return call_user_func_array( [$class, $name], $args );
	}

	/**
	 * Get functions.
	 *
	 * @return array
	 */
	public function getFunctions() {
		$callables = [
			'__'                  => '__',
			'_n'                  => '_n',
			'action'              => 'do_action',
			'apply_filters'       => 'apply_filters',
			'body_class'          => 'body_class',
			'esc_html__'          => 'esc_html__',
			'esc_html_e'          => 'esc_html_e',
			'esc_attr__'          => 'esc_attr__',
			'esc_attr_e'          => 'esc_attr_e',
			'esc_js'              => 'esc_js',
			'esc_textarea'        => 'esc_textarea',
			'esc_url'             => 'esc_url',
			'esc_url_raw'         => 'esc_url_raw',
			'fn'                  => [$this, 'call_function'],
			'static'              => [$this, 'call_static'],
			'language_attributes' => 'language_attributes',
			'wp_head'             => 'wp_head',
			'wp_footer'           => 'wp_footer',
			'wp_title'            => 'wp_title'
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
