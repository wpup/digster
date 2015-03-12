<?php

/**
 * Digister - Twig templates for WordPress.
 *
 * @package Digster
 * @license MIT
 * @version 1.0.0
 */

use Digster\View;

/**
 * Register composer with template engine.
 *
 * @param string|array $template
 * @param callable $fn
 * @since 1.0.0
 */

function digster_composer($template, $fn)
{
    View::composer($template, $fn);
}

/**
 * Fetch rendered template string.
 *
 * @param string $template
 * @param array $data
 * @since 1.0.0
 *
 * @return string
 */

function digster_fetch($template, $data = array())
{
    return View::fetch($template, $data);
}

/**
 * Reigster extension with template engine.
 *
 * @since 1.0.0
 */

function digster_register_extension()
{
    View::registerExtension(func_get_args());
}

/**
 * Render the view.
 *
 * @param string $template
 * @param array $data
 * @since 1.0.0
 */

function digster_render($template, $data = array())
{
    View::render($template, $data);
}
