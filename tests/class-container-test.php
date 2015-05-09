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
     * Tear down test.
     */

     public function tearDown() {
         parent::tearDown();
         unset( $this->container );
     }

    /**
     * Test `bind` method.
     */

    public function test_bind() {
        $this->container->bind( 'Class', new \stdClass );
        $this->assertTrue( $this->container->exists( 'Class' ) );
        $this->assertTrue( is_object( $this->container->make( 'Class' ) ) );
        $this->container->bind( 'Class', null );
        $this->assertNull( $this->container->make( 'Class' ) );
    }

    /**
     * Check if `Class` key exists in the container or not.
     */

    public function test_exists() {
        $this->container->bind( 'Class2', new \stdClass );
        $this->assertTrue( $this->container->exists( 'Class2' ) );
        $this->assertFalse( $this->container->exists( 'fake' ) );
    }

    /**
     * Test `make` method.
     *
     * @expectedException InvalidArgumentException
     */

    public function test_make() {
        $this->container->bind( 'Class3', new \stdClass );
        $this->assertTrue( is_object( $this->container->make( 'Class3' ) ) );

        try {
            $this->container->make( 'fake' );
            $this->fail( 'Expected InvalidArgumentException not thrown' );
        } catch( InvalidArgumentException $e ) {
            $this->assertEquals( 'InvalidArgumentException: Identifier [fake] is not defined', $e->getMessage() );
        }
    }

    /**
     * Test `offsetExists` method.
     */

    public function test_offset_exists() {
        $this->container->bind( 'Class4', new \stdClass );
        $this->assertTrue( isset( $this->container['Class4'] ) );
        $this->assertFalse( isset( $this->container['fake'] ) );
    }

    /**
     * Test `offsetGet` method.
     *
     * @expectedException InvalidArgumentException
     */

    public function test_offset_get() {
        $this->container->bind( 'Class5', new \stdClass );
        $this->assertTrue( is_object( $this->container['Class5'] ) );

        try {
            $this->container['fake'];
            $this->fail( 'Expected InvalidArgumentException not thrown' );
        } catch( InvalidArgumentException $e ) {
            $this->assertEquals( 'InvalidArgumentException: Identifier [fake] is not defined', $e->getMessage() );
        }
    }

    /**
     * Test `offsetGet` method.
     */

    public function test_offset_set() {
        $this->container['Class5'] = new \stdClass;
        $this->assertTrue( $this->container->exists( 'Class5' ) );
        $this->assertTrue( is_object( $this->container['Class5'] ) );
        $this->container['Class5'] = null;
        $this->assertNull( $this->container['Class5'] );
    }

    /**
     * Test `offsetUnset` method.
     */

    public function test_offset_unset() {
        $this->container->bind( 'Class6', new \stdClass );
        $this->assertTrue( $this->container->exists( 'Class6' ) );
        $this->assertTrue( is_object( $this->container['Class6'] ) );
        unset( $this->container['Class6'] );
        $this->assertFalse( $this->container->exists( 'Class6' ) );
    }

}
