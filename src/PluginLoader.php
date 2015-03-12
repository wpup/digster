<?php

/**
 * Digster - Twig templates for WordPress.
 *
 * @package Digster
 * @license MIT
 * @version 1.0.0
 */

namespace Digster;

/**
 * Hook the WordPress plugin into the appropriate WordPress actions and filters.
 *
 * @package Digster
 * @since 1.0.0
 */

final class PluginLoader
{
    /**
     * The instance of Plugin loader class.
     *
     * @var object
     * @since 1.0.0
     */

    private static $instance;

    /**
     * Get Plugin boilerplate loader instance.
     *
     * @since 1.0.0
     *
     * @return object
     */

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
            self::$instance->setupActions();
        }

        return self::$instance;
    }

    /**
     * Load Digster extensions.
     *
     * @since 1.0.0
     */

    public function loadExtensions()
    {
        $extensions = [
            new \Digster\Extensions\FiltersExtension(),
            new \Digster\Extensions\FunctionsExtension(),
            new \Digster\Extensions\GlobalsExtension()
        ];

        $extensions = apply_filters('digster/extensions', $extensions);

        View::registerExtension($extensions);
    }

    /**
     * Setup actions.
     *
     * @since 1.0.0
     */

    private function setupActions()
    {
        add_action('after_setup_theme', [$this, 'loadExtensions']);
    }
}
