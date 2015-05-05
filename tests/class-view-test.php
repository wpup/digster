<?php

namespace Digster\Tests;

use Digster\View;

/**
 * Unit tests to check so Digster is loaded correctly.
 */

class ViewTest extends \WP_UnitTestCase {

    /**
     * Test static `engine` method.
     */

    public function test_engine() {
        $this->assertTrue( is_object( View::engine() ) );

        $loader = new \Twig_Loader_Array(array(
            'index.html' => 'Hello, {{ name }}!'
        ));

        $engine = View::engine();
        $engine->set_loader($loader);

        $output = $engine->render('index.html', ['name' => 'Fredrik']);
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

    /**
     * Test locations config value.
     */

    public function test_locations() {
        $locations = View::config( 'locations' );
        $this->assertNotEmpty( $locations );
        $this->assertTrue( strpos( $locations[0], '/views' ) !== false );
    }

}
