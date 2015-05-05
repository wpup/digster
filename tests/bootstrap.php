<?php

define( 'WP_AUTOLOAD_PREFIX', 'Digster\\' );
define( 'WP_AUTOLOAD_BASE_DIR', dirname( __DIR__ ) . '/src' );

/**
 * Load Composer autoloader.
 */

require dirname( __DIR__ ) . '/vendor/autoload.php';

/**
 * Load Papi loader file as plugin.
 */

WP_Test_Suite::load_plugins( dirname( __DIR__ ) . '/digster.php' );

/**
 * Run the WordPress test suite.
 */

WP_Test_Suite::run();
