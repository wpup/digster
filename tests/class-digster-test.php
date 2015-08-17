<?php

namespace Frozzare\Tests\Digster;

use Frozzare\Digster\Digster;

class Digster_Test extends \WP_UnitTestCase {

    public function test_config() {
        $locations = Digster::config( 'locations' );
        $this->assertNotEmpty( $locations );
        $this->assertTrue( strpos( $locations[0], '/views' ) !== false );

        Digster::config( 'locations', '/path/to/views' );
        $this->assertEquals( Digster::config( 'locations' ), '/path/to/views' );
    }


    public function test_composer() {
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

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html', [
            'post' => $post_id
        ] );

        $this->assertNotFalse( strpos( $output, 'Hello Post title' ) );
    }

    public function test_fetch() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $output = Digster::fetch( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->assertEquals( 'Hello Fredrik!', $output );
    }

    public function test_render() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        Digster::render( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->expectOutputString( 'Hello Fredrik!' );
    }
    public function test_plugins_loaded_action() {
        $this->assertGreaterThan( 0, has_action( 'plugins_loaded', 'digster' ) );
    }

	public function test_setup_actions() {
		$plugin_loader = Digster::instance();
		$this->assertEquals( 10, has_action( 'after_setup_theme', [$plugin_loader, 'load_extensions'] ) );
	}

    public function test_share() {
        $loader = new \Twig_Loader_Array( [
            'index.html' => '{{ name }} works as {{ title }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        Digster::share( 'title', 'developer' );

        $view = digster_view( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->assertEquals( 'Fredrik works as developer!', $view->render() );
    }

    public function test_view() {
        $this->assertEquals( Digster::view(), Digster::factory() );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello {{ name }}!'
        ] );

        $engine = Digster::factory()->engine();
        $engine->set_loader( $loader );

        $view = Digster::view( 'index.html', [
            'name' => 'Fredrik'
        ] );

        $this->assertEquals( 'Hello Fredrik!', $view->render() );
    }

}
