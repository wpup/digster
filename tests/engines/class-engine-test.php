<?php

namespace Frozzare\Tests\Digster;

use Frozzare\Digster\Digster;

class Engine_Test extends \WP_UnitTestCase {

	public function test_config() {
		$engine = Digster::factory()->engine();
		$engine->config( 'name', 'Fredrik' );
		$this->assertSame( $engine->config( 'name' ), 'Fredrik' );

		$engine->config( [
			'one' => 1,
			'two' => 2
		] );
		$this->assertSame( $engine->config( 'one' ), 1 );
		$this->assertSame( $engine->config( 'two' ), 2 );
	}

}
