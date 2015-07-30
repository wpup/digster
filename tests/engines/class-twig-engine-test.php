<?php

namespace Digster\Tests;

use Digster\View;
use Digster\Engines\Twig_Engine;

/**
 * Unit tests to check so Digster is loaded correctly.
 */
class Twig_Engine_Test extends \WP_UnitTestCase {

    public function test_engine() {
        $this->assertEquals( View::engine(), Twig_Engine::instance() );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Twig_Engine::instance();
        $engine->set_loader( $loader );

        $output = $engine->render( 'index.html', ['name' => 'Fredrik'] );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

}
