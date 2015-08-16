<?php

namespace Digster\Tests;

use Digster\Digster;

class Helpers_Test extends \WP_UnitTestCase {

    public function test_view() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = view( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->assertEquals( 'Hello Fredrik!', $view->render() );
    }

}
