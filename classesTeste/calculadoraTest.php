<?php

require_once dirname(__FILE__) . '/../calculadora.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-10-10 at 16:37:32.
 */
class CalculadoraTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Calculadora
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Calculadora;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers Calculadora::somar
     * @todo   Implement testSomar().
     */
    //@group production
    public function testSomar() {
        // Remove the following lines when you implement this test.
        $this->assertEquals(
                2, $this->object->somar(1, 1)
        );
    }

    //@group development
    public function testSomar2() {
        // Remove the following lines when you implement this test.
        $this->assertEquals(
                4, $this->object->somar("de", 3)
        );
    }

}
