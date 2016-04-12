<?php

use Puko\Core\Puko;

class Main extends PHPUnit_Framework_TestCase
{
    public function testPushAndPop()
    {
        // Allocate a test fixture.
        $fixture = array();
        // Assert initially empty, count() is 0.
        $this->assertEquals(0, count($fixture));

        // Test array_push().
        // Push an item into array.
        array_push($fixture, 'foo');
        // Assert one item, count() is 1.
        $this->assertEquals(1, count($fixture));
        // Assert item pushed.
        $this->assertEquals('foo', $fixture[count($fixture) - 1]);

        // Test array_pop().
        $this->assertEquals('foo', array_pop($fixture));
        $this->assertEquals(0, count($fixture));
    }

}
