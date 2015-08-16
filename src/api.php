<?php

use Digster\Digster;

/**
 * Register composer with template engine.
 *
 * @param array|string $views
 * @param \Closure $callback
 */
function digster_composer( $views, $callback ) {
    Digster::composer( $views, $callback );
}

/**
 * Fetch rendered view string.
 *
 * @param string $view
 * @param array $data
 *
 * @return string
 */
function digster_fetch( $view, array $data = [] ) {
    return Digster::fetch( $view, $data );
}

/**
 * Reigster extensions with view engine.
 */
function digster_register_extensions() {
    Digster::register_extensions( func_get_args() );
}

/**
 * Render the view.
 *
 * @param string $view
 * @param array $data
 */
function digster_render( $view, array $data = [] ) {
    echo Digster::render( $view, $data );
}
