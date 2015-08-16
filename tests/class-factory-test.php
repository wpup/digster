<?php

namespace Digster\Tests;

use Digster\Digster;
use Digster\Engines\Twig_Engine;
use Digster\View;

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
        $this->assertEquals( 'Hello, Fredrik!', $view->render() );
        $this->assertEmpty( $factory->get_composer( $view ) );

        Digster::composer( 'index.html', function( $vars ) {
            return $vars;
        } );

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

        $this->assertEquals( 'Hello, Fredrik!', $view->render() );
    }

    public function test_view() {
        $factory = Digster::factory();
        $this->assertEquals( 'profile.twig', $factory->view( 'profile' ) );
        $this->assertEquals( 'admin/profile.twig', $factory->view( 'admin/profile' ) );
        $this->assertEquals( 'admin/profile.twig', $factory->view( 'admin.profile' ) );
        $this->assertEquals( 'admin/profile.html', $factory->view( 'admin.profile.html' ) );
        $this->assertEquals( 'admin/profile.twig', $factory->view( 'admin.profile.twig' ) );
    }

}
