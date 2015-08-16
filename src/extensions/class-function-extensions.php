<?php

namespace Digster\Extensions;

class Function_Extensions extends \Twig_Extension {

    /**
     * Call WordPress filter.
     *
     * @return mixed
     */
    public function apply_filters() {
        return call_user_func_array( 'apply_filters', func_get_args() );
    }

    /**
     * Call PHP function.
     */
    public function call_function() {
        $args = func_get_args();
        $name = array_shift( $args );
        return call_user_func_array( trim( $name ), $args );
    }

    /**
     * Call WordPress action.
     */
    public function do_action() {
        call_user_func_array( 'do_action', func_get_args() );
    }

    /**
     * Get functions.
     *
     * @return array
     */
    public function getFunctions() {
        $callables = [
            '__'                  => [$this, 'translate'],
            'action'              => [$this, 'do_action'],
            'apply_filters'       => [$this, 'apply_filters'],
            'body_class'          => 'body_class',
            'fn'                  => [$this, 'call_function'],
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

    /**
     * Retrieves the translated string from the WordPress `__` function.
     *
     * @return string
     */
    public function translate() {
        return call_user_func_array( '__', func_get_args() );
    }

}
