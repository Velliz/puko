<?php

class TestFramework extends PHPUnit_Framework_TestCase
{
    public function testPushAndPop()
    {
        $fixture = array();
        $this->assertEquals(0, count($fixture));
        array_push($fixture, 'foo');
        $this->assertEquals(1, count($fixture));
        $this->assertEquals('foo', $fixture[count($fixture) - 1]);
        $this->assertEquals('foo', array_pop($fixture));
        $this->assertEquals(0, count($fixture));
    }
}
