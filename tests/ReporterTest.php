<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PFT;
use PierInfor\Undercover\Reporter;
use PierInfor\Undercover\Interfaces\IReporter;
use PierInfor\Undercover\Interfaces\IArgs;

/**
 * @covers \PierInfor\Undercover\Reporter::<public>
 */
class ReporterTest extends PFT
{

    const TEST_ENABLE = true;

    /**
     * instance
     *
     * @var Reporter
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
        $this->instance = new Reporter();
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
        $class = new \ReflectionClass(Reporter::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        unset($class);
        return $method;
    }

    /**
     * testInstance
     * @covers PierInfor\Undercover\Reporter::__construct
     */
    public function testInstance()
    {
        $this->assertTrue(
            $this->instance instanceof IReporter
        );
    }

    /**
     * testReport
     * @covers PierInfor\Undercover\Reporter::report
     */
    public function testReport()
    {
        $results = $this->getFakeResults();
        $thresholds = $results;
        $thresholds[IArgs::_LINES] = 90;
        $this->assertTrue(
            $this->instance->report($results, $thresholds)
                instanceof
                IReporter
        );
    }

    /**
     * testGetMsgLine
     * @covers PierInfor\Undercover\Reporter::getMsgLine
     */
    public function testGetMsgLine()
    {
        $gml = self::getMethod('getMsgLine')->invokeArgs(
            $this->instance,
            [IArgs::_LINES, (float) 10, true]
        );
        $this->assertTrue(is_string($gml));
        $this->assertNotEmpty($gml);
    }

    /**
     * testGetHeader
     * @covers PierInfor\Undercover\Reporter::getHeader
     */
    public function testGetHeader()
    {
        $ghdr = self::getMethod('getHeader')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($ghdr));
        $this->assertNotEmpty($ghdr);
    }

    /**
     * testGetFooter
     * @covers PierInfor\Undercover\Reporter::getFooter
     */
    public function testGetFooter()
    {
        $gftr = self::getMethod('getFooter')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($gftr));
        $this->assertNotEmpty($gftr);
    }

    /**
     * testGetBody
     * @covers PierInfor\Undercover\Reporter::getBody
     */
    public function testGetBody()
    {
        $gbdy = self::getMethod('getBody')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($gbdy));
        $this->assertEmpty($gbdy);
        $results = $this->getFakeResults();
        $thresholds = $results;
        $thresholds[IArgs::_LINES] = 90;
        $this->instance->report($results, $thresholds);
        $gbdy1 = self::getMethod('getBody')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($gbdy1));
        $this->assertNotEmpty($gbdy1);
    }

    /**
     * testGetReport
     * @covers PierInfor\Undercover\Reporter::getReport
     */
    public function testGetReport()
    {
        $grpt = self::getMethod('getReport')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($grpt));
        $this->assertNotEmpty($grpt);
    }

    /**
     * testGetResults
     * @covers PierInfor\Undercover\Reporter::getResults
     */
    public function testGetResults()
    {
        $gres = self::getMethod('getResults')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_array($gres));
    }

    /**
     * testGetThresholds
     * @covers PierInfor\Undercover\Reporter::getThresholds
     */
    public function testGetThresholds()
    {
        $gtres = self::getMethod('getThresholds')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_array($gtres));
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
