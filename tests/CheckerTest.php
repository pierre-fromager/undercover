<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PFT;
use PierInfor\Undercover\Checker;
use PierInfor\Undercover\Args;

/**
 * @covers \PierInfor\Undercover\Checker::<public>
 */
class CheckerTest extends PFT
{

    const TEST_ENABLE = true;

    /**
     * instance
     *
     * @var Checker
     */
    protected $instance;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        if (!self::TEST_ENABLE) {
            $this->markTestSkipped('Test disabled.');
        }
        $this->instance = new Checker();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        $this->instance = null;
    }

    /**
     * get any method from a class to be invoked whatever the scope
     *
     * @param String $name
     * @return void
     */
    protected static function getMethod(string $name)
    {
        $class = new \ReflectionClass(Checker::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        unset($class);
        return $method;
    }

    /**
     * testInstance
     * @covers PierInfor\Undercover\Checker::__construct
     */
    public function testInstance()
    {
        $isCheckerInstance = $this->instance instanceof Checker;
        $this->assertTrue($isCheckerInstance);
    }

    /**
     * testRun
     * @covers PierInfor\Undercover\Checker::run
     * @covers PierInfor\Undercover\Checker::check
     * @covers PierInfor\Undercover\Checker::setResults
     */
    public function testRun()
    {
        $this->setOutputCallback(function () {
        });
        $stub = $this->getMockWithContent();
        $this->assertTrue($stub->run() instanceof Checker);
    }

    /**
     * testInit
     * @covers PierInfor\Undercover\Checker::init
     */
    public function testInit()
    {
        $in0 = self::getMethod('init')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue($in0 instanceof Checker);
    }

    /**
     * return a real coverage clover file content
     *
     * @return string
     */
    protected function getXmlFixturesContent(): string
    {
        return \file_get_contents(
            __DIR__ . '/fixtures/coverage.clover'
        );
    }

    /**
     * return a Check mock with getContent overided
     *
     * @return mixed
     */
    protected function getMockWithContent()
    {
        $stub = $this->getMockBuilder(Checker::class)
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getContent'])
            ->getMock();
        $stub->method('getContent')->willReturn(
            $this->getXmlFixturesContent()
        );
        return $stub;
    }

    /**
     * testParse
     * @covers PierInfor\Undercover\Checker::parse
     * @covers PierInfor\Undercover\Checker::getResults
     */
    public function testParse()
    {
        $stub = $this->getMockWithContent();
        $par = self::getMethod('parse')->invokeArgs(
            $stub,
            []
        );
        $this->assertTrue($par instanceof Checker);
        $ger = self::getMethod('getResults')->invokeArgs(
            $stub,
            []
        );
        $this->assertTrue(is_array($ger));
        $this->assertTrue(isset($ger[Args::_LINES]));
        $this->assertGreaterThan(50, $ger[Args::_LINES]);
        $this->assertTrue(isset($ger[Args::_METHODS]));
        $this->assertGreaterThan(50, $ger[Args::_METHODS]);
        $this->assertTrue(isset($ger[Args::_STATEMENTS]));
        $this->assertGreaterThan(50, $ger[Args::_STATEMENTS]);
        $this->assertTrue(isset($ger[Args::_CLASSES]));
        $this->assertGreaterThan(40, $ger[Args::_CLASSES]);
    }

    /**
     * testGetContent
     * @covers PierInfor\Undercover\Checker::getContent
     */
    public function testGetContent()
    {
        $gc = self::getMethod('getContent')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($gc));
        $this->assertEmpty($gc);
    }

    /**
     * returns  an xml element
     * with attributes populated
     * from the given array
     *
     * @param array $attributes
     * @return \SimpleXMLElement
     */
    protected function getXmlElementWithAttributes(array $attributes): \SimpleXMLElement
    {
        $xml = new \SimpleXMLElement('<metrics/>');
        foreach ($attributes as $name => $value) {
            $xml->addAttribute($name, $value);
        }
        return $xml;
    }

    /**
     * testGetElementsRatio
     * @covers PierInfor\Undercover\Checker::getElementsRatio
     */
    public function testGetElementsRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            Checker::COVERED_ELEMENTS => (float) 50,
            Checker::_ELEMENTS => (float) 50,
        ]);
        $ger = self::getMethod('getElementsRatio')->invokeArgs(
            $this->instance,
            [$xmlElements]
        );
        $this->assertTrue(is_float($ger));
        $this->assertEquals(100, $ger);
    }

    /**
     * testGetMethodsRatio
     * @covers PierInfor\Undercover\Checker::getMethodsRatio
     */
    public function testGetMethodsRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            Args::_METHODS => (float) 50,
            Checker::COVERED_METHODS => (float) 50,
        ]);
        $gmr = self::getMethod('getMethodsRatio')->invokeArgs(
            $this->instance,
            [$xmlElements]
        );
        $this->assertTrue(is_float($gmr));
        $this->assertEquals(100, $gmr);
    }

    /**
     * testGetStatementsRatio
     * @covers PierInfor\Undercover\Checker::getStatementsRatio
     */
    public function testGetStatementsRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            Args::_STATEMENTS => (float) 50,
            Checker::COVERED_STATEMENTS => (float) 50,
        ]);
        $gsr = self::getMethod('getStatementsRatio')->invokeArgs(
            $this->instance,
            [$xmlElements]
        );
        $this->assertTrue(is_float($gsr));
        $this->assertEquals(100, $gsr);
    }

    /**
     * testGetClassesRatio
     * @covers PierInfor\Undercover\Checker::getClassesRatio
     */
    public function testGetClassesRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            Args::_CLASSES => (float) 50,
        ]);
        $gcr = self::getMethod('getClassesRatio')->invokeArgs(
            $this->instance,
            [(float) 50, $xmlElements]
        );
        $this->assertTrue(is_float($gcr));
        $this->assertEquals(100, $gcr);
    }

    /**
     * testGetRatio
     * @covers PierInfor\Undercover\Checker::getRatio
     */
    public function testGetRatio()
    {
        $gt0 = self::getMethod('getRatio')->invokeArgs(
            $this->instance,
            [1, 1]
        );
        $this->assertTrue(is_float($gt0));
        $this->assertEquals(100, $gt0);
    }

    /**
     * testSetContent
     * @covers PierInfor\Undercover\Checker::setContent
     */
    public function testSetContent()
    {
        $ex0 = self::getMethod('setContent')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue($ex0 instanceof Checker);
    }

    /**
     * testExists
     * @covers PierInfor\Undercover\Checker::exists
     */
    public function testExists()
    {
        $ex0 = self::getMethod('exists')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_bool($ex0));
    }
}
