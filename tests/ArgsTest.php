<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PFT;
use PierInfor\Undercover\Args;

/**
 * @covers \PierInfor\Undercover\Args::<public>
 */
class ArgsTest extends PFT
{

    const TEST_ENABLE = true;

    /**
     * instance
     *
     * @var Args
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
        $this->instance = new Args();
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
        $class = new \ReflectionClass(Args::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        unset($class);
        return $method;
    }

    /**
     * testInstance
     * @covers PierInfor\Undercover\Args::__construct
     */
    public function testInstance()
    {
        $isArgsInstance = $this->instance instanceof Args;
        $this->assertTrue($isArgsInstance);
    }

    /**
     * testGetFilename
     * @covers PierInfor\Undercover\Args::getFilename
     */
    public function testGetFilename()
    {
        $fn = self::getMethod('getFilename')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($fn));
        $this->assertNotEmpty($fn);
    }

    /**
     * testGetThresholds
     * @covers PierInfor\Undercover\Args::getThresholds
     */
    public function testGetThresholds()
    {
        $gt = self::getMethod('getThresholds')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_array($gt));
        $this->assertNotEmpty($gt);
    }

    /**
     * testSetOptions
     * @covers PierInfor\Undercover\Args::setOptions
     */
    public function testSetOptions()
    {
        $gt = self::getMethod('setOptions')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue($gt instanceof Args);
    }

    /**
     * testGetThresholdByKeys
     * @covers PierInfor\Undercover\Args::getThresholdByKeys
     */
    public function testGetThresholdByKeys()
    {
        $gdt = self::getMethod('getThresholdByKeys')->invokeArgs(
            $this->instance,
            ['k1', 'k2']
        );
        $this->assertTrue(\is_float($gdt));
        $this->assertEquals(Args::DEFAULT_THRESHOLD, $gdt);
    }

    /**
     * testHasOption
     * @covers PierInfor\Undercover\Args::hasOption
     */
    public function testHasOption()
    {
        $gdt = self::getMethod('hasOption')->invokeArgs(
            $this->instance,
            ['key']
        );
        $this->assertTrue(\is_bool($gdt));
        $this->assertFalse($gdt);
    }

    /**
     * testFloatOption
     * @covers PierInfor\Undercover\Args::floatOption
     */
    public function testFloatOption()
    {
        $gdt = self::getMethod('floatOption')->invokeArgs(
            $this->instance,
            ['key']
        );
        $this->assertTrue(\is_float($gdt));
        $this->assertEquals(0, $gdt);
    }

    /**
     * testGetDefaultThreshold
     * @covers PierInfor\Undercover\Args::getDefaultThreshold
     */
    public function testGetDefaultThreshold()
    {
        $gdt = self::getMethod('getDefaultThreshold')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(\is_float($gdt));
        $this->assertNotEmpty($gdt);
    }
}
