<?php

namespace Digster\Tests;

/**
 * Unit tests to check so Digster is loaded correctly.
 */

class Digster_Test extends \WP_UnitTestCase {

    /**
     * The action `plugins_loaded` should have the `boilerplate` hook
     * and should have a default priority of 0.
     */

    public function testPluginsLoadedAction() {
        $this->assertEquals( 0, has_action( 'plugins_loaded', 'digster' ) );
    }

}
