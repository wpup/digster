<?php

/**
 * Bootstrap the plugin unit testing environment.
 */

// Discover the WordPress testing framework.
if (getenv('WP_TESTS_DIR') !== false) {
    $test_dir = getenv('WP_TESTS_DIR');
} elseif (false !== getenv('WP_DEVELOP_DIR')) {
    $test_dir = getenv('WP_DEVELOP_DIR') . 'tests/phpunit';
} elseif (file_exists('../../../../../tests/phpunit/includes/bootstrap.php')) {
    $test_dir = '../../../../../tests/phpunit';
} elseif (file_exists('/tmp/wordpress-tests-lib/includes/bootstrap.php')) {
    $test_dir = '/tmp/wordpress-tests-lib';
}

// @link https://core.trac.wordpress.org/browser/trunk/tests/phpunit/includes/functions.php
require $test_dir . '/includes/functions.php';

// Activate the plugin.
tests_add_filter('muplugins_loaded', function() {
    include_once dirname(dirname(__FILE__)) . '/digster.php';
});

// Load phpunit
require $test_dir . '/includes/bootstrap.php';
