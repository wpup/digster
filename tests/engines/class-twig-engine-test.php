<?php

namespace Frozzare\Tests\Digster;

use Frozzare\Digster\Digster;
use Frozzare\Digster\Engines\Twig_Engine;

class Twig_Engine_Test extends \WP_UnitTestCase {

    public function test_add_extensions() {
        require_once __DIR__ . '/../fixtures/class-test-extensions.php';
        $engine = Digster::factory()->engine();
        $out = $engine->add_extension( new \Test_Extensions );
        $this->assertNull( $out );
        $out = $engine->add_extension( new \Test_Extensions );
        $this->assertNull( $out );
    }

    public function test_engine() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html', ['name' => 'Fredrik'] );
        $this->assertSame( 'Hello, Fredrik!', $output );
    }

    public function test_engine_dot() {
        $loader = new \Twig_Loader_Array( [
            'admin/profile.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'admin.profile.html', ['name' => 'Fredrik'] );
        $this->assertSame( 'Hello, Fredrik!', $output );
    }

    public function test_register_extensions() {
        require_once __DIR__ . '/../fixtures/class-test-extensions.php';
        $engine = Digster::factory()->engine();
        $out = $engine->register_extensions( new \Test_Extensions );
        $this->assertNull( $out );
        $out = $engine->register_extensions( '\\Test_Extensions' );
        $this->assertNull( $out );
        $out = $engine->register_extensions( [new \Test_Extensions, new \Test_Extensions] );
        $this->assertNull( $out );
    }

}
