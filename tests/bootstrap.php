<?php

// Load Composer autoload.
require __DIR__ . '/../vendor/autoload.php';

// Register autoloader.
register_wp_autoload( 'Frozzare\\Digster\\', __DIR__ . '/../src' );

// Load test data file.
WP_Test_Suite::load_files( __DIR__ . '/test-data.php' );

// Load Papi loader file as plugin.
WP_Test_Suite::load_plugins( __DIR__ . '/../digster.php' );

// Run the WordPress test suite.
WP_Test_Suite::run();
