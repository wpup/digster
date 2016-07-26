<?php

namespace Frozzare\Tests\Digster;

use Frozzare\Digster\Digster;

class Helpers_Test extends \WP_UnitTestCase {

	public function test_view() {
		$this->assertSame( view(), Digster::factory() );

		$loader = new \Twig_Loader_Array( [
			'index.html' => 'Hello {{ name }}!'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$view = view( 'index.html', [
			'name' => 'Fredrik'
		] );

		$this->assertSame( 'Hello Fredrik!', $view->render() );
	}

	public function test_view_model_data() {
		require_once __DIR__ . '/fixtures/class-model-data.php';

		$this->assertSame( view(), Digster::factory() );

		$loader = new \Twig_Loader_Array( [
			'index.html' => 'Hello {{ name }}!'
		] );

		$engine = Digster::factory()->engine();
		$engine->set_loader( $loader );

		$model = new \Model_Data;
		$view  = view( 'index.html', $model );

		$this->assertSame( 'Hello Fredrik!', $view->render() );
	}
}
