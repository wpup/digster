<?php

namespace Digster\Tests;

use Digster\View;

/**
 * Unit tests to check so Digster is loaded correctly.
 */

class ViewTest extends \WP_UnitTestCase {

    /**
     * Test static `fetch` method.
     */

    public function test_composer() {
        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello, {{ firstname }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        View::composer( 'index.html', function( $vars ) {
            $vars['firstname'] = 'Fredrik';
            return $vars;
        } );

        $output = View::fetch( 'index.html' );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

    /**
     * Test static `engine` method.
     */

    public function test_engine() {
        $this->assertTrue( is_object( View::engine() ) );

        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello, {{ name }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = $engine->render( 'index.html', ['name' => 'Fredrik'] );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

    /**
     * Test static `fetch` method.
     */

    public function test_fetch() {
        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello, {{ name }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html', ['name'=>'Fredrik'] );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

    /**
     * Test locations config value.
     */

    public function test_locations() {
        $locations = View::config( 'locations' );
        $this->assertNotEmpty( $locations );
        $this->assertTrue( strpos( $locations[0], '/views' ) !== false );

        View::config( 'locations', '/path/to/views' );
        $this->assertEquals( View::config( 'locations' ), '/path/to/views' );
    }

    /**
     * Test static `render` method.
     */

    public function test_render() {
        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello, {{ name }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        View::render( 'index.html', ['name'=>'Fredrik'] );
        $this->expectOutputString( 'Hello, Fredrik!' );
    }

    /**
     * Test static `register_extensions` method.
     */

    public function test_register_extensions() {
        require_once __DIR__ . '/fixtures/class-name-extension.php';

        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello, {{ name() }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        try {
            View::register_extensions( new \Digster\Tests\Fixtures\Name_Extension() );
        } catch(Exception $e) {
        }

        $output = View::fetch( 'index.html' );
        $this->assertEquals( 'Hello, World!', $output );
    }

}
