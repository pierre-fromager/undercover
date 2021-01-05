<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PFT;
use PierInfor\Undercover\Checker;
use PierInfor\Undercover\Args;
use PierInfor\Undercover\Interfaces\IArgs;
use PierInfor\Undercover\Interfaces\IChecker;

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
     */
    public function testRun()
    {
        $this->assertTrue(is_int($this->instance->run()));
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
     * testGetMsgLine
     * @covers PierInfor\Undercover\Checker::getMsgLine
     */
    public function testGetMsgLine()
    {
        $gml = self::getMethod('getMsgLine')->invokeArgs(
            $this->instance,
            [Args::_LINES, (float) 10, true]
        );
        $this->assertTrue(is_string($gml));
        $this->assertNotEmpty($gml);
    }

    /**
     * testCheck
     * @covers PierInfor\Undercover\Checker::check
     */
    public function testCheck()
    {
        $chk0 = self::getMethod('check')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue($chk0 instanceof IChecker);
        $stub = $this->getMockWithResults();
        $chk1 = self::getMethod('check')->invokeArgs(
            $stub,
            []
        );
        $this->assertTrue($chk1 instanceof IChecker);
    }

    /**
     * testGetResults
     * @covers PierInfor\Undercover\Checker::getResults
     */
    public function testGetResults()
    {
        $gr0 = self::getMethod('getResults')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_array($gr0));
    }

    /**
     * testIsBlocking
     * @covers PierInfor\Undercover\Checker::isBlocking
     */
    public function testIsBlocking()
    {
        $gr = self::getMethod('isBlocking')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_bool($gr));
    }

    /**
     * return a Check mock with fake getResults
     *
     * @return mixed
     */
    protected function getMockWithResults()
    {
        $stub = $this->getMockBuilder(Checker::class)
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->setMethods(['getResults'])
            ->getMock();
        $stub->method('getResults')->willReturn(
            $this->getFakeResults()
        );
        return $stub;
    }

    /**
     * return fake results
     *
     * @return array
     */
    protected function getFakeResults(): array
    {
        return [
            IArgs::_LINES => 50,
            IArgs::_METHODS => 50,
            IArgs::_STATEMENTS => 50,
            IArgs::_CLASSES => 10
        ];
    }
}
