<?php

namespace Digster\Tests;

/**
 * Unit tests to check so Digster is loaded correctly.
 */
class Digster_Test extends \WP_UnitTestCase {

    public function test_plugins_loaded_action() {
        $this->assertEquals( 0, has_action( 'plugins_loaded', 'digster' ) );
    }

	public function test_setup_actions() {
		$plugin_loader = \Digster\Plugin_Loader::instance();

		// Test `after_setup_theme` action.
		$this->assertEquals( 10, has_action( 'after_setup_theme', [$plugin_loader, 'load_extensions'] ) );
	}

}
