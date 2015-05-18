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
defined( 'ABSPATH' ) || exit;

// Framework requires PHP 5.4 or newer
if ( version_compare( PHP_VERSION, '5.4.0', '<' ) ) {
    exit( 'The Digster plugin for WordPress requires PHP version 5.4 or higher.' );
}

if ( ! defined( 'WP_AUTOLOAD_PREFIX' ) ) {
    define( 'WP_AUTOLOAD_PREFIX', 'Digster\\' );
}

if ( ! defined( 'WP_AUTOLOAD_BASE_DIR' ) ) {
    define( 'WP_AUTOLOAD_BASE_DIR', __DIR__ . '/src' );
}

// Load Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

/**
 * Load Digster plugin.
 *
 * @return \Digster\Plugin_Loader
 */

add_action( 'plugins_loaded', function () {
    return \Digster\Plugin_Loader::instance();
} );
