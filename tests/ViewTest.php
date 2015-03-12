<?php

namespace Digster\Tests;

use Digster\View;

/**
 * Unit tests to check so Digster is loaded correctly.
 *
 * @since 1.0.0
 */

class ViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The action `plugins_loaded` should have the `boilerplate` hook
     * and should have a default priority of 0.
     *
     * @since 1.0.0
     */

    public function testNullConfig()
    {
        $this->assertEquals(null, View::config('null'));
    }

    /**
     * Test key with value.
     *
     * @since 1.0.0
     */

    public function testNameConfig()
    {
        View::config('name', 'Fredrik');
        $this->assertEquals('Fredrik', View::config('name'));
    }

    /**
     * Test locations path
     *
     * @since 1.0.0
     */

    public function testLocations()
    {
        $locations = View::config('locations');
        $this->assertFalse(empty($locations));
    }
}
