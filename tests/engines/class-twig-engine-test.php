<?php

namespace Digster\Tests;

use Digster\Digster;
use Digster\Engines\Twig_Engine;

class Twig_Engine_Test extends \WP_UnitTestCase {

    public function test_engine() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html', ['name' => 'Fredrik'] );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

    public function test_engine_dot() {
        $loader = new \Twig_Loader_Array( [
            'admin/profile.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'admin.profile.html', ['name' => 'Fredrik'] );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

}
