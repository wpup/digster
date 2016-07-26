<?php

// Load composer.
require_once __DIR__ . '/../vendor/autoload.php';

// Load test data file.
WP_Test_Suite::load_files( __DIR__ . '/test-data.php' );

// Run the WordPress test suite.
WP_Test_Suite::run();
