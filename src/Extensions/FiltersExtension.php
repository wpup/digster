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
 * Digster filter extension.
 *
 * @package Digster
 * @since 1.0.0
 */

class FiltersExtension extends \Twig_Extension
{
    /**
     * Get filters.
     *
     * @since 1.0.0
     *
     * @return array
     */

    public function getFilters()
    {
        $filters = [
            'excerpt'    => 'wp_trim_words',
            'shortcodes' => 'do_shortcode',
            'wpautop'    => 'wpautop'
        ];

        foreach ($filters as $filter => $callable) {
            $filters[$filter] = new \Twig_SimpleFilter($filter, $callable);
        }

        return $filters;
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
        return 'digster-filters';
    }
}
