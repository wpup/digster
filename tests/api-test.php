<?php

namespace Digster\Tests;

use Digster\View;

class API_Test extends \WP_UnitTestCase {

    /**
     * Test `digster_composer` function.
     */

    public function test_digster_composer() {
        $post_id = $this->factory->post->create();

        digster_composer( 'any', function ( $vars ) {
            if ( isset( $vars['post'] ) ) {
                $vars['post'] = isset( $vars['post'] ) && is_numeric( $vars['post'] ) ?  get_page( $vars['post'] ) : $vars['post'];
            }

            return $vars;
        } );

        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello {{ post.post_title }}!'
        ) );

        $engine = View::engine();

        $engine->set_loader( $loader );
        $output = $engine->render( 'index.html', [
            'post' => $post_id
        ] );

        $this->assertNotFalse( preg_match( '/Hello\sPost\s\title\s\d+/', $output ) );
    }

    /**
     * Test `digster_fetch` function.
     */

    public function test_digster_fetch() {
        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello {{ name }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        $output = digster_fetch( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->assertEquals( 'Hello Fredrik!', $output );
    }

    /**
     * Test `digster_render` function.
     */

    public function test_digster_render() {
        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello {{ name }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        digster_render( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->expectOutputString( 'Hello Fredrik!' );
    }

    /**
     * Test `digster_register_extensions` function.
     */

    public function test_digster_register_extensions() {
        require_once __DIR__ . '/fixtures/class-name-extension.php';

        $loader = new \Twig_Loader_Array( array(
            'index.html' => 'Hello, {{ name() }}!'
        ) );

        $engine = View::engine();
        $engine->set_loader( $loader );

        try {
            digster_register_extensions( new \Digster\Tests\Fixtures\Name_Extension() );
        } catch(Exception $e) {
        }

        $output = View::fetch( 'index.html' );
        $this->assertEquals( 'Hello, World!', $output );
    }

}
