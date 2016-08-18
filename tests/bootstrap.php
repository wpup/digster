<?php

// Load composer.
require_once __DIR__ . '/../vendor/autoload.php';

// Load test data file.
WP_Test_Suite::load_files( __DIR__ . '/test-data.php' );

// Load Digster.
WP_Test_Suite::load_plugins( __DIR__ . '/../digster.php' );

// Run the WordPress test suite.
WP_Test_Suite::run();
