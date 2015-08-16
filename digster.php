<?php

/**
 * Plugin Name: Digster
 * Description: Twig templates for WordPress
 * Author: Fredrik Forsmo
 * Author URI: https://forsmo.me/
 * Plugin URI: https://github.com/frozzare/digster
 * Text Domain: digster
 * Version: 1.3.0-dev
 */

// Make sure the plugin does not expose any info if called directly
defined( 'ABSPATH' ) || exit;

// Load Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

// Register the Digster namespace with the WordPress autoload
// that understands `class-` prefix.
register_wp_autoload( 'Digster\\', __DIR__ . '/src' );

/**
 * Get the Digster instance.
 *
 * @return \Digster\Digster
 */
function digster() {
    return \Digster\Digster::instance();
}

/**
 * Load Digster plugin.
 *
 * @return \Digster\Digster
 */
add_action( 'plugins_loaded', 'digster' );
