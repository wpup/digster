<?php

namespace Frozzare\Tests\Digster\Extensions;

use Frozzare\Digster\Digster;
use Frozzare\Digster\Factory;
use Frozzare\Digster\Engines\Twig_Engine;
use Frozzare\Digster\Extensions\Filter_Extensions;

class Filter_Extensions_Test extends \WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
	}

	public function replace_hello( $text ) {
		return str_replace( 'Hello', 'Hej', $text );
	}

	public function test_excerpt() {
		$loader = new \Twig_Loader_Array( [
			'index.html' => 'Hello, {{ text | excerpt }}'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$output = Digster::fetch( 'index.html', [
			'text' => 'Minim sunt ex leo nunclorem ac. Sagittis habitant turpis. Torquent magna massa praesent. Nisi eiusmod elit iaculis penatibus. Tincidunt facilisis aliquam blandit cras aliquet. Rhoncus ac vel. Eiusmod nisi nostrud nulla vestibulum. Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.'
		] );

		$this->assertSame( 'Hello, Minim sunt ex leo nunclorem ac. Sagittis habitant turpis. Torquent magna massa praesent. Nisi eiusmod elit iaculis penatibus. Tincidunt facilisis aliquam blandit cras aliquet. Rhoncus ac vel. Eiusmod nisi nostrud nulla vestibulum. Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec orci risus.Esse habitant anim. At urna luctus praesent fames. Velit ipsum nec&amp;hellip;', $output );
	}

	public function test_excerpt2() {
		add_shortcode( 'footag', function( $atts ) {
			return "foo = {$atts['foo']}";
		} );

		$loader = new \Twig_Loader_Array( [
			'index.html' => 'Hello, {{ text | shortcodes | raw }}'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$output = Digster::fetch( 'index.html', [
			'text' => '[footag foo="bar"]'
		] );

		$this->assertSame( 'Hello, foo = bar', $output );
	}

	public function test_wpautop() {
		$loader = new \Twig_Loader_Array( [
			'index.html' => '{{ text | wpautop | raw }}'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$output = Digster::fetch( 'index.html', [
			'text' => 'Hello, world!'
		] );

		$this->assertSame( '<p>Hello, world!</p>', trim( $output ) );
	}

	public function test_custom_filter() {
		$loader = new \Twig_Loader_Array( [
			'index.html' => '{{ text | hej | raw }}'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$output = Digster::fetch( 'index.html', [
			'text' => 'Hello, world!'
		] );

		$this->assertSame( 'Hej, world!', trim( $output ) );
	}
}
