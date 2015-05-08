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
     * Register composer with templates.
     *
     * @param array|string $template
     * @param callable $fn
     */

    public static function composer( $template, $fn = null ) {
        self::engine()->composer( $template, $fn );
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

    public static function fetch( $template, $data = array() ) {
        return self::engine()->render( $template, $data );
    }

    /**
     * Render the view.
     *
     * @param string $template
     * @param array $data
     */

    public static function render( $template, $data = array() ) {
        echo self::fetch( $template, $data );
    }

    /**
     * Register extensions with template engine.
     */

    public static function register_extensions() {
        self::engine()->register_extensions( func_get_args() );
    }

}
