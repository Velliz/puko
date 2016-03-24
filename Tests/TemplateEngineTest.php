<?php

/**
 * Created by PhpStorm.
 * User: didit
 * Date: 3/24/2016
 * Time: 11:33 PM
 */
class TemplateEngineTest extends PHPUnit_Framework_TestCase
{

    public function testCanBeNegated()
    {
        // Arrange
        $a = new Money(1);

        // Act
        $b = $a->negate();

        // Assert
        $this->assertEquals(-1, $b->getAmount());
    }
}
