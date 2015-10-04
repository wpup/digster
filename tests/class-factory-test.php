<?php

namespace Frozzare\Tests\Digster;

use Frozzare\Digster\Digster;
use Frozzare\Digster\Engines\Twig_Engine;
use Frozzare\Digster\View;

class Factory_Engine_Test extends \WP_UnitTestCase {

    public function test_engine() {
        $this->assertTrue( Digster::factory()->engine() instanceof Twig_Engine );
    }

    public function test_composer() {
        $factory = Digster::factory();
        $loader  = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ name }}!'
        ] );

        $engine = $factory->engine();
        $engine->set_loader( $loader );

        $view = $factory->make( 'index.html', ['name' => 'Fredrik'] );

        $this->assertTrue( $view instanceof View );
        $this->assertSame( 'Hello, Fredrik!', $view->render() );
        $this->assertEmpty( $factory->get_composer( $view ) );

        Digster::composer( 'index.html', 'Fredrik' );

        $this->assertNotEmpty( $factory->get_composer( $view ) );
    }

    public function test_make() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::factory()->make( 'index.html', ['name' => 'Fredrik'] );

        $this->assertTrue( $view instanceof View );

        $this->assertSame( 'Hello, Fredrik!', $view->render() );

        $loader = new \Twig_Loader_Array( [
            'pages/index.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::factory()->make( 'pages.index.html', ['name' => 'Fredrik'] );

        $this->assertTrue( $view instanceof View );

        $this->assertSame( 'Hello, Fredrik!', $view->render() );
    }

    public function test_share() {
        $factory = Digster::factory();
        $factory->share( 'name', 'Fredrik' );
        $shared = $factory->get_shared();
        $this->assertSame( 'Fredrik', $shared['name'] );

        $factory->share( [
            'one' => 1,
            'two' => 2
        ] );

        $shared = $factory->get_shared();

        $this->assertSame( 1, $shared['one'] );
        $this->assertSame( 2, $shared['two'] );
    }

}
