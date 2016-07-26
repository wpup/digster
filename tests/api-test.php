<?php

namespace Frozzare\Tests\Digster;

use Frozzare\Digster\Digster;

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

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$output = digster_fetch( 'index.html', [
			'post' => $post_id
		] );

		$this->assertNotFalse( strpos( $output, 'Hello Post title' ) );
	}

	public function test_digster_fetch() {
		$loader = new \Twig_Loader_Array( [
			'index.html' => 'Hello {{ name }}!'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$output = digster_fetch( 'index.html', [
			'name' => 'Fredrik'
		] );

		$this->assertSame( 'Hello Fredrik!', $output );
	}

	public function test_digster_register_extensions() {
		require_once __DIR__ . '/fixtures/class-test-extensions.php';
		$out = digster_register_extensions( new \Test_Extensions );
		$this->assertNull( $out );
	}

	public function test_digster_render() {
		$loader = new \Twig_Loader_Array( [
			'index.html' => 'Hello {{ name }}!'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		digster_render( 'index.html', [
			'name' => 'Fredrik'
		] );

		$this->expectOutputString( 'Hello Fredrik!' );
	}

	public function test_digster_share() {
		$loader = new \Twig_Loader_Array( [
			'index.html' => '{{ name }} works as {{ title }}!'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		digster_share( 'title', 'developer' );

		$view = digster_view( 'index.html', [
			'name' => 'Fredrik'
		] );

		$this->assertSame( 'Fredrik works as developer!', $view->render() );
	}

	public function test_digster_view() {
		$loader = new \Twig_Loader_Array( [
			'index.html' => 'Hello {{ name }}!'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$view = digster_view( 'index.html', [
			'name' => 'Fredrik'
		] );

		$this->assertSame( 'Hello Fredrik!', $view->render() );
	}

}
