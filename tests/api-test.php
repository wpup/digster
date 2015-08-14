<?php

namespace Digster\Tests;

use Digster\View;

class API_Test extends \WP_UnitTestCase {

    public function test_digster_composer() {
        $post_id = $this->factory->post->create();

        digster_composer( '*', function ( $vars ) {
            if ( isset( $vars['post'] ) ) {
                $vars['post'] = isset( $vars['post'] ) && is_numeric( $vars['post'] ) ?  get_page( $vars['post'] ) : $vars['post'];
            }

            return $vars;
        } );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello {{ post.post_title }}!'
        ] );

        $engine = View::engine();

        $engine->set_loader( $loader );
        $output = $engine->render( 'index.html', [
            'post' => $post_id
        ] );

        $this->assertNotFalse( strpos( $output, 'Hello Post title' ) );
    }

    public function test_digster_fetch() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello {{ name }}!'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = digster_fetch( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->assertEquals( 'Hello Fredrik!', $output );
    }

    public function test_digster_render() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello {{ name }}!'
        ] );

        $engine = View::engine();
        $engine->set_loader( $loader );

        digster_render( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->expectOutputString( 'Hello Fredrik!' );
    }

}
