<?php

namespace Digster\Tests;

use Digster\View;
use Digster\Engines\Twig_Engine;

/**
 * Unit tests to check so Digster is loaded correctly.
 */
class Twig_Engine_Test extends \WP_UnitTestCase {

    public function test_engine() {
        $this->assertEquals( View::engine(), Twig_Engine::instance() );

        $loader = new \Twig_Loader_Array( [
            'index.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Twig_Engine::instance();
        $engine->set_loader( $loader );

        $output = $engine->render( 'index.html', ['name' => 'Fredrik'] );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

    public function test_engine_dot() {
        $this->assertEquals( View::engine(), Twig_Engine::instance() );

        $loader = new \Twig_Loader_Array( [
            'admin/profile.html' => 'Hello, {{ name }}!'
        ] );

        $engine = Twig_Engine::instance();
        $engine->set_loader( $loader );

        $output = $engine->render( 'admin.profile.html', ['name' => 'Fredrik'] );
        $this->assertEquals( 'Hello, Fredrik!', $output );
    }

    public function test_extensions() {
        $engine = Twig_Engine::instance();

        $this->assertEquals( 'profile.twig', $engine->extension( 'profile' ) );
        $this->assertEquals( 'admin/profile.twig', $engine->extension( 'admin/profile' ) );
        $this->assertEquals( 'admin/profile.html', $engine->extension( 'admin/profile/html' ) );
        $this->assertEquals( 'admin/profile.twig', $engine->extension( 'admin/profile/twig' ) );
    }

    public function test_template() {
        $engine = Twig_Engine::instance();

        $this->assertEquals( 'profile.twig', $engine->template( 'profile' ) );
        $this->assertEquals( 'admin/profile.twig', $engine->template( 'admin/profile' ) );
        $this->assertEquals( 'admin/profile.twig', $engine->template( 'admin.profile' ) );
        $this->assertEquals( 'admin/profile.html', $engine->template( 'admin.profile.html' ) );
        $this->assertEquals( 'admin/profile.twig', $engine->template( 'admin.profile.twig' ) );
    }

}
