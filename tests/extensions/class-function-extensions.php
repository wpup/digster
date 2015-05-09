<?php

namespace Digster\Tests\Extensions;

use Digster\View;

class Function_Extensions_Test extends \WP_UnitTestCase {

    /**
     * Test `action` function.
     */

    public function test_action() {
        add_action('my_action', function () {
            echo 'world';
        });

        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello, {% do action("my_action") %}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html');

        $this->assertEquals( 'Hello, world!', $output );
    }

}
