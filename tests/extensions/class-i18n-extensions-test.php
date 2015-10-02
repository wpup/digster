<?php

namespace Frozzare\Tests\Digster\Extensions;

use Frozzare\Digster\Digster;

class I18n_Extensions_Test extends \WP_UnitTestCase {

    public function test_trans_1() {
        add_action( 'my_action', function () {
            echo 'world';
        } );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {% trans "world" %}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

    public function test_trans_2() {
        add_action( 'my_action', function () {
            echo 'world';
        } );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {% trans %}world{% endtrans %}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html' );

        $this->assertEquals( 'Hello, world!', $output );
    }

}
