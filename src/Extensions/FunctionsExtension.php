<?php

/**
 * Digster - Twig templates for WordPress.
 *
 * @package Digister
 * @license MIT
 * @version 1.0.0
 */

namespace Digster\Extensions;

/**
 * Digster functions extension.
 *
 * @package Digster
 * @since 1.0.0
 */

class FunctionsExtension extends \Twig_Extension
{
    /**
     * Call WordPress action
     *
     * @since 1.0.0
     */

    public function doAction()
    {
        call_user_func_array('do_action', func_get_args());
    }

    /**
     * Get functions.
     *
     * @since 1.0.0
     *
     * @return array
     */

    public function getFunctions()
    {
        $callables = [
            'action'    => [$this, 'doAction'],
            'wp_head'   => 'wp_head',
            'wp_footer' => 'wp_footer'
        ];

        foreach ($callables as $fn => $callable) {
            $callables[$fn] = new \Twig_SimpleFunction($fn, $callable);
        }

        return $callables;
    }

    /**
     * Get the extension name.
     *
     * @since 1.0.0
     *
     * @return string
     */

    public function getName()
    {
        return 'digster-functions';
    }
}
