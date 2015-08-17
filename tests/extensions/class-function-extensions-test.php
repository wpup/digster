<?php

namespace Frozzare\Tests\Digster\Extensions;

use Frozzare\Digster\Digster;

class Function_Extensions_Test extends \WP_UnitTestCase {

    public function test_action() {
        add_action( 'my_action', function () {
            echo 'world';
        } );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {% do action("my_action") %}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

    public function test_apply_filters() {
        tests_add_filter( 'hello', function ( $name ) {
            return 'Hello, ' . $name . '!';
        } );

        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ apply_filters(\'hello\', \'world\') }}'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );

    }

    public function test_body_class() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ body_class() }}'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'class=""', $output );
    }

    public function test_fn() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ fn(\'fn_hello\', \'world\') }}'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

    public function test_language_attributes() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ language_attributes() }}'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'lang="en-US"', $output );
    }

    public function test_translate() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ __("world", "digster") }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

    public function test_wp_head() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ wp_head() }}'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertNotEmpty( $output );
    }

    public function test_wp_footer() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ wp_footer() }}'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertNotEmpty( $output );
    }

    public function test_wp_title() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ wp_title() }}'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertNotEmpty( $output );
    }

}
