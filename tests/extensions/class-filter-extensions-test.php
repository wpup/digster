<?php

namespace Digster\Tests\Extensions;

use Digster\View;

class Filter_Extensions_Test extends \WP_UnitTestCase {

    public function test_excerpt() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ text | excerpt }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html', [
            'text' => 'Minim sunt ex leo nunclorem ac. Sagittis habitant turpis. Torquent magna massa praesent. Nisi eiusmod elit iaculis penatibus. Tincidunt facilisis aliquam blandit cras aliquet. Rhoncus ac vel. Eiusmod nisi nostrud nulla vestibulum. Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.'
        ] );

        $this->assertEquals( 'Hello, Minim sunt ex leo nunclorem ac. Sagittis habitant turpis. Torquent magna massa praesent. Nisi eiusmod elit iaculis penatibus. Tincidunt facilisis aliquam blandit cras aliquet. Rhoncus ac vel. Eiusmod nisi nostrud nulla vestibulum. Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec&amp;hellip;', $output );
    }

    public function test_excerpt2() {
        add_shortcode('footag', function($atts) {
            return "foo = {$atts['foo']}";
        });

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ text | shortcodes | raw }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html', [
            'text' => '[footag foo="bar"]'
        ] );

        $this->assertEquals( 'Hello, foo = bar', $output );
    }

    public function test_wpautop() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ text | wpautop | raw }}'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = View::fetch( 'index.html', [
            'text' => 'Hello, world!'
        ] );

        $this->assertEquals( '<p>Hello, world!</p>', trim( $output ) );
    }

}
