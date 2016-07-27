<?php

/**
 * Plugin Name: Digster
 * Description: Twig templates for WordPress
 * Author: Fredrik Forsmo
 * Author URI: https://frozzare.com
 * Plugin URI: https://github.com/frozzare/digster
 * Text Domain: digster
 * Version: 1.7.0
 */

// Load Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

/**
 * Get the Digster instance.
 *
 * @return \Frozzare\Digster\Digster
 */
function digster() {
	return \Frozzare\Digster\Digster::instance();
}

/**
 * Load Digster plugin.
 */
if ( function_exists( 'idx_add_action' ) ) {
	idx_add_action( 'plugins_loaded', 'digster' );
} else {
	add_action( 'plugins_loaded', 'digster' );
}
