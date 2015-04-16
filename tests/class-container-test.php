<?php

namespace Digster\Tests;

use Digster\Container;

/**
 * Unit tests to check so Digster is loaded correctly.
 *
 * @since 1.0.0
 */

class Container_Test extends \WP_UnitTestCase {

    /**
     * Setup the test.
     *
     * @since 1.0.0
     */

    public function setUp() {
        parent::setUp();
        $this->container = new Container;
    }

    /**
     * Check if `Class` exists in the container or not.
     *
     * @since 1.0.0
     */

    public function testExists() {
        $this->assertFalse( $this->container->exists( 'Class' ) );
    }

    /**
     * Test container bind and make.
     *
     * @since 1.0.0
     */

    public function testBindAndMake() {
        $this->container->bind( 'Class', new \stdClass );
        $this->assertTrue( is_object( $this->container->make( 'Class' ) ) );
    }

}
