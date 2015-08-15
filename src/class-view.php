<?php

namespace Digster;

use Digster\Engines\Twig_Engine;

/**
 * View class.
 *
 * The view is responsible for rendering a template.
 *
 * @package Digster
 */
class View {

	/**
	 * The template key.
	 *
	 * @var string
	 */
	private $template;

	/**
	 * The constructor.
	 *
	 * @param string $template
	 *
	 * @throws InvalidArgumentException if an argument is not of the expected type.
	 */
	public function __construct( $template ) {
		if ( ! is_string( $template ) ) {
			throw new InvalidArgumentException( 'Invalid argument. Must be string.' );
		}

		$this->template = $template;
	}

	/**
	 * Register composer with templates.
	 *
	 * @param array|string $template
	 * @param mixed $value
	 */
	public static function composer( $template, $value = null ) {
		if ( ! is_string( $template ) ) {
			throw new InvalidArgumentException( 'Invalid argument. `$template` must be string.' );
		}

		if ( is_string( $value ) && class_exists( $value ) ) {
			$value = function ( $vars ) use( $template, $value ) {
				$class = new $value();
				$class->compose( new View( $template ) );
			};
		}

		self::engine()->composer( $template, $value );
	}

	/**
	 * Get or set configuration value.
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public static function config( $key, $value = null ) {
		return self::engine()->config( $key, $value );
	}

	/**
	 * Get template directories.
	 *
	 * @return array
	 */
	public static function engine() {
		return Twig_Engine::instance();
	}

	/**
	 * Fetch the view to a string.
	 *
	 * @param string $template
	 * @param array $data
	 *
	 * @return string
	 */
	public static function fetch( $template, array $data = [] ) {
		return self::engine()->render( $template, $data );
	}

	/**
	 * Render the view.
	 *
	 * @param string $template
	 * @param array $data
	 */
	public static function render( $template, array $data = [] ) {
		echo self::fetch( $template, $data );
	}

	/**
	 * Register extensions with template engine.
	 */
	public static function register_extensions() {
		self::engine()->register_extensions( func_get_args() );
	}

	/**
	 * Add composer from a composer class.
	 *
	 * @param string $key
	 * @param mixed $value
	 *
	 * @throws InvalidArgumentException if an argument is not of the expected type.
	 */
	public function with( $key, $value ) {
		if ( ! is_string( $key ) ) {
			throw new InvalidArgumentException( 'Invalid argument. `$key` must be string.' );
		}

		if ( $value instanceof Closure === false ) {
			$value = function( $vars ) use( $key, $value ) {
				$vars[$key] = $value;
				return $vars;
			};
		}

		self::composer( $this->template, $value );
	}

}
