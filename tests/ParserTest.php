<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PFT;
use PierInfor\Undercover\Parser;
use PierInfor\Undercover\Interfaces\IParser;
use PierInfor\Undercover\Args;
use PierInfor\Undercover\Interfaces\IArgs;

/**
 * @covers \PierInfor\Undercover\Parser::<public>
 */
class ParserTest extends PFT
{

    const TEST_ENABLE = true;
    const FIXTURE_PATH =  __DIR__ . '/fixtures/coverage.clover';

    /**
     * instance
     *
     * @var Parser
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
        $this->instance = new Parser();
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
        $class = new \ReflectionClass(Parser::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        unset($class);
        return $method;
    }

    /**
     * testInstance
     * @covers PierInfor\Undercover\Parser::__construct
     */
    public function testInstance()
    {
        $this->assertTrue($this->instance instanceof IParser);
    }

    /**
     * testGetArgs
     * @covers PierInfor\Undercover\Parser::getArgs
     */
    public function testGetArgs()
    {
        $this->assertTrue($this->instance->getArgs() instanceof IArgs);
    }

    /**
     * testGetParser
     * @covers PierInfor\Undercover\Parser::getParser
     */
    public function testGetParser()
    {
        $this->assertTrue($this->instance->getParser() instanceof IParser);
    }

    /**
     * testInit
     * @covers PierInfor\Undercover\Parser::init
     */
    public function testInit()
    {
        $in0 = self::getMethod('init')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue($in0 instanceof Parser);
    }

    /**
     * return a real coverage clover file content
     *
     * @return string
     */
    protected function getXmlFixturesContent(): string
    {
        return \file_get_contents(self::FIXTURE_PATH);
    }

    /**
     * return a Check mock with getContent overided
     *
     * @return mixed
     */
    protected function getMockWithContent()
    {
        $stub = $this->getMockBuilder(Parser::class)
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
     * @covers PierInfor\Undercover\Parser::parse
     * @covers PierInfor\Undercover\Parser::getResults
     */
    public function testParse()
    {
        $stub = $this->getMockWithContent();
        $par = $stub->parse();
        $this->assertTrue($par instanceof Parser);
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
     * @covers PierInfor\Undercover\Parser::getContent
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
     * testSetContent
     * @covers PierInfor\Undercover\Parser::setContent
     */
    public function testSetContent()
    {
        $ex0 = self::getMethod('setContent')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue($ex0 instanceof Parser);
    }

    /**
     * testExists
     * @covers PierInfor\Undercover\Parser::exists
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
