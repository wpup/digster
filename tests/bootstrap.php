<?php

// Load Composer autoload.
require __DIR__ . '/../vendor/autoload.php';

// Load test data file.
WP_Test_Suite::load_files( __DIR__ . '/test-data.php' );

// Load Digster loader file as a plugin.
WP_Test_Suite::load_plugins( __DIR__ . '/../digster.php' );

// Run the WordPress test suite.
WP_Test_Suite::run();
