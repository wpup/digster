<?php

namespace Digster\Tests\Extensions;

use Digster\View;

class Function_Extensions_Test extends \WP_UnitTestCase {

    public function test__() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ __("world", "digster") }}!'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

    public function test_action() {
        add_action( 'my_action', function () {
            echo 'world';
        } );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {% do action("my_action") %}!'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

    public function test_apply_filters() {
        tests_add_filter( 'hello', function ( $name ) {
            return 'Hello, ' . $name . '!';
        } );

        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ apply_filters(\'hello\', \'world\') }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );

    }

    public function test_body_class() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ body_class() }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertEquals( 'class=""', $output );
    }

    public function test_fn() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ fn(\'fn_hello\', \'world\') }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

    public function test_language_attributes() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ language_attributes() }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertEquals( 'lang="en-US"', $output );
    }

    public function test_wp_head() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ wp_head() }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertNotEmpty( $output );
    }

    public function test_wp_footer() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ wp_footer() }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertNotEmpty( $output );
    }

    public function test_wp_title() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ wp_title() }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html' );

        $this->assertNotEmpty( $output );
    }

}
