<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PFT;
use PierInfor\Undercover\Processor;
use PierInfor\Undercover\Interfaces\IProcessor;
use PierInfor\Undercover\Interfaces\IArgs;

/**
 * @covers \PierInfor\Undercover\Processor::<public>
 */
class ProcessorTest extends PFT
{

    const TEST_ENABLE = true;
    const XML_METRICS_TAG = '<metrics/>';

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
        $this->instance = new Processor();
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
        $class = new \ReflectionClass(Processor::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        unset($class);
        return $method;
    }

    /**
     * testInstance
     * @covers PierInfor\Undercover\Processor::__construct
     */
    public function testInstance()
    {
        $this->assertTrue(
            $this->instance instanceof IProcessor
        );
    }

    /**
     * testProcess
     * @covers PierInfor\Undercover\Processor::process
     */
    public function testProcess()
    {
        $metrics = $this->getXmlElementWithAttributes(
            $this->getFakeMetrics()
        );
        $pr = $this->instance->process(10, $metrics);
        $this->assertTrue($pr instanceof IProcessor);
    }

    /**
     * retrun fake metrics
     *
     * @return array
     */
    protected function getFakeMetrics(): array
    {
        return [
            IProcessor::COVERED_ELEMENTS => (float) 50,
            IProcessor::_ELEMENTS => (float) 50,
            IArgs::_METHODS => (float) 50,
            IProcessor::COVERED_METHODS => (float) 50,
            IArgs::_STATEMENTS => (float) 50,
            IProcessor::COVERED_STATEMENTS => (float) 50,
            IArgs::_CLASSES => (float) 50,
        ];
    }

    /**
     * testInit
     * @covers PierInfor\Undercover\Processor::init
     */
    public function testInit()
    {
        $in0 = self::getMethod('init')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue($in0 instanceof IProcessor);
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
        $xml = new \SimpleXMLElement(self::XML_METRICS_TAG);
        foreach ($attributes as $name => $value) {
            $xml->addAttribute($name, $value);
        }
        return $xml;
    }

    /**
     * testGetResults
     * @covers PierInfor\Undercover\Processor::getResults
     */
    public function testGetResults()
    {
        $gr = self::getMethod('getResults')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_array($gr));
    }

    /**
     * testGetElementsRatio
     * @covers PierInfor\Undercover\Processor::getElementsRatio
     */
    public function testGetElementsRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            IProcessor::COVERED_ELEMENTS => (float) 50,
            IProcessor::_ELEMENTS => (float) 50,
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
     * @covers PierInfor\Undercover\Processor::getMethodsRatio
     */
    public function testGetMethodsRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            IArgs::_METHODS => (float) 50,
            IProcessor::COVERED_METHODS => (float) 50,
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
     * @covers PierInfor\Undercover\Processor::getStatementsRatio
     */
    public function testGetStatementsRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            IArgs::_STATEMENTS => (float) 50,
            IProcessor::COVERED_STATEMENTS => (float) 50,
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
     * @covers PierInfor\Undercover\Processor::getClassesRatio
     */
    public function testGetClassesRatio()
    {
        $xmlElements = $this->getXmlElementWithAttributes([
            IArgs::_CLASSES => (float) 50,
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
     * @covers PierInfor\Undercover\Processor::getRatio
     */
    public function testGetRatio()
    {
        $gt0 = self::getMethod('getRatio')->invokeArgs(
            $this->instance,
            [1, 1]
        );
        $this->assertTrue(is_float($gt0));
        $this->assertEquals(100, $gt0);
        $gt1 = self::getMethod('getRatio')->invokeArgs(
            $this->instance,
            [1, 0]
        );
        $this->assertTrue(is_float($gt1));
        $this->assertEquals(0, $gt1);
    }
}
