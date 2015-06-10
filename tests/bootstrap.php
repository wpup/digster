<?php

/**
 * Load Composer autoloader.
 */

require dirname( __DIR__ ) . '/vendor/autoload.php';

/**
 * Register autoloader.
 */

register_wp_autoload( 'Digster\\', __DIR__ . '/src' );

/**
 * Load test data file.
 */

WP_Test_Suite::load_files( __DIR__ . '/test-data.php' );

/**
 * Load Papi loader file as plugin.
 */

WP_Test_Suite::load_plugins( dirname( __DIR__ ) . '/digster.php' );

/**
 * Run the WordPress test suite.
 */

WP_Test_Suite::run();
