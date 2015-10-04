<?php

namespace Frozzare\Tests\Digster;

use Frozzare\Digster\Digster;

class View_Test extends \WP_UnitTestCase {

    public function test_nest() {
        $loader = new \Twig_Loader_Array( [
            'index.html'   => 'Hello {{ profile }}!',
            'profile.html' => 'Fredrik'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::view( 'index.html' )
            ->nest( 'profile', 'profile.html' );

        $this->assertSame( 'Hello Fredrik!', $view->render() );
    }

    public function test_with_array() {
        $loader = new \Twig_Loader_Array( [
            'index.html'   => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::view( 'index.html' )
            ->with( [
                'name' => 'Fredrik'
            ] );

        $this->assertSame( 'Hello Fredrik!', $view->render() );
    }

    public function test_with_key_value() {
        $loader = new \Twig_Loader_Array( [
            'index.html'   => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::view( 'index.html' )
            ->with( 'name', 'Fredrik' );

        $this->assertSame( 'Hello Fredrik!', $view->render() );
    }

    public function test_array_data() {
        $loader = new \Twig_Loader_Array( [
            'index.html'   => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::view( 'index.html' );
        $view['name'] = 'Fredrik';

        $this->assertSame( 'Fredrik', $view['name'] );
        $this->assertSame( 'Hello Fredrik!', $view->render() );
        $this->assertTrue( isset( $view['name'] ) );

        unset( $view['name'] );
        $this->assertSame( 'Hello !', $view->render() );
    }

    public function test_object_data() {
        $loader = new \Twig_Loader_Array( [
            'index.html'   => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::view( 'index.html' );
        $view->name = 'Fredrik';

        $this->assertSame( 'Fredrik', $view->name );
        $this->assertSame( 'Hello Fredrik!', $view->render() );
        $this->assertTrue( isset( $view->name ) );

        unset( $view->name );
        $this->assertSame( 'Hello !', $view->render() );
    }
}
