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
 * Digster globals extension.
 *
 * @package Digster
 * @since 1.0.0
 */

class GlobalsExtension extends \Twig_Extension
{
    /**
     * Get global variable.
     *
     * @since 1.0.0
     *
     * @return array
     */

    public function getGlobals()
    {
        return [
            'body_class' => implode(' ', get_body_class()),
            'post'       => get_post(get_the_ID())
        ];
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
        return 'digster-globals';
    }
}
