<?php

/**
 * Digster - Twig templates for WordPress.
 *
 * @package Digister
 * @license MIT
 * @version 1.0.0
 */

namespace Digster;

use Digster\Engines\TwigEngine;

/**
 * View.
 *
 * The view is responsible for rendering a template.
 *
 * @package Digster
 * @since 1.0.0
 */

class View
{
    /**
     * Get or set configuration value.
     *
     * @param string $key
     * @param mixed $value
     * @since 1.0.0
     *
     * @return mixed
     */

    public static function config($key, $value = null)
    {
        return self::engine()->config($key, $value);
    }

    /**
     * Get template directories.
     *
     * @since 1.0.0
     *
     * @return array
     */

    private static function engine()
    {
        return TwigEngine::instance();
    }

    /**
     * Render the view.
     *
     * @param string $template
     * @param array $data
     * @since 1.0.0
     */

    public static function render($template, $data = array())
    {
        echo self::fetch($template, $data);
    }

    /**
     * Fetch the view to a string.
     *
     * @param string $template
     * @param array $data
     * @since 1.0.0
     *
     * @return string
     */

    public static function fetch($template, $data = array())
    {
        return self::engine()->render($template, $data);
    }

    /**
     * Register composer with templates.
     *
     * @param array|string $template
     * @param callable $fn
     * @since 1.0.0
     */

    public static function composer($template, $fn = null)
    {
        self::engine()->composer($template, $fn);
    }

    /**
     * Register extensions with template engine.
     *
     * @since 1.0.0
     */

    public static function registerExtension()
    {
        self::engine()->registerExtension(func_get_args());
    }
}
