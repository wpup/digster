<?php

namespace Digster\Tests;

use Digster\View;
use Digster\Engines\Twig_Engine;

/**
 * Unit tests to check so Digster is loaded correctly.
 */

class Twig_Engine_Test extends \WP_UnitTestCase {

    /**
     * Test static `engine` method.
     */

    public function test_engine() {
        $this->assertEquals( View::engine(), Twig_Engine::instance() );
    }

}
