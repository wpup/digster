<?php

namespace Digster\Tests;

use Digster\Container;

/**
 * Unit tests to check so Digster is loaded correctly.
 */

class Container_Test extends \WP_UnitTestCase {

    /**
     * Setup the test.
     */

    public function setUp() {
        parent::setUp();
        $this->container = new Container;
    }

    /**
     * Check if `Class` key exists in the container or not.
     */

    public function testExists() {
        $this->assertFalse( $this->container->exists( 'Class' ) );
    }

    /**
     * Test container bind and make.
     */

    public function testBindAndMake() {
        $this->container->bind( 'Class', new \stdClass );
        $this->assertTrue( is_object( $this->container->make( 'Class' ) ) );
    }

}
