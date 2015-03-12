<?php

/**
 * Plugin Name: Digster
 * Description: Twig templates for WordPress
 * Author: Fredrik Forsmo
 * Author URI: https://forsmo.me/
 * Plugin URI: https://github.com/frozzare/digster
 * Text Domain: digster
 * Version: 1.0.0
 */

// Make sure the plugin does not expose any info if called directly
defined('ABSPATH') || exit;

// Framework requires PHP 5.4 or newer
if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    exit('The Digster plugin for WordPress requires PHP version 5.4 or higher.');
}

// Load Composer autoloader.
require 'vendor/autoload.php';

/**
 * Get the Digster instance.
 *
 * @return \Digster\PluginLoader
 */

function digster()
{
    return \Digster\PluginLoader::instance();
}

// Initialize on plugins loaded
add_action('plugins_loaded', 'digster', 0, 0);
