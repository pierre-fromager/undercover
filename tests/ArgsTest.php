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
     * get any method from a class to be invoked whatever the scope
     *
     * @param String $name
     * @return void
     */
    protected static function setProp(string $name, $value)
    {
        $class = new \ReflectionClass(Args::class);
        $prop = $class->getProperty($name);
        $prop->setAccessible(true);
        $prop->setValue($class, $value);
        unset($class);
        return $prop;
    }

    /**
     * return normal case options usage
     *
     * @return array
     */
    protected function getMockedOptions(): array
    {
        return [
            Args::_FILE => __FILE__,
            Args::_F => __FILE__,
            Args::_LINES => 10,
            Args::_L => 10,
            Args::_METHODS => 20,
            Args::_M => 20,
            Args::_STATEMENTS => 30,
            Args::_S => 30,
            Args::_CLASSES => 40,
            Args::_C => 40
        ];
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
     * @covers PierInfor\Undercover\Args::setOptions
     */
    public function testGetFilename()
    {
        $fn = self::getMethod('getFilename')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($fn));
        $this->assertNotEmpty($fn);
        $mockedOptions = $this->getMockedOptions();
        self::getMethod('setOptions')->invokeArgs(
            $this->instance,
            [$mockedOptions]
        );
        $fn0 = self::getMethod('getFilename')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($fn0));
        $this->assertNotEmpty($fn0);
        unset($mockedOptions[Args::_F]);
        self::getMethod('setOptions')->invokeArgs(
            $this->instance,
            [$mockedOptions]
        );
        $fn1 = self::getMethod('getFilename')->invokeArgs(
            $this->instance,
            []
        );
        $this->assertTrue(is_string($fn1));
        $this->assertNotEmpty($fn1);
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
        $gtm = self::getMethod('setOptions')->invokeArgs(
            $this->instance,
            [$this->getMockedOptions()]
        );
        $this->assertTrue($gtm instanceof Args);
    }

    /**
     * testGetThresholdByKeys
     * @covers PierInfor\Undercover\Args::getThresholdByKeys
     * @covers PierInfor\Undercover\Args::setOptions
     */
    public function testGetThresholdByKeys()
    {
        $gdt = self::getMethod('getThresholdByKeys')->invokeArgs(
            $this->instance,
            ['missing1',  'missing2']
        );
        $this->assertTrue(\is_float($gdt));
        $this->assertEquals(Args::DEFAULT_THRESHOLD, $gdt);
        $mockedOptions = $this->getMockedOptions();
        self::getMethod('setOptions')->invokeArgs(
            $this->instance,
            [$mockedOptions]
        );
        $gdt0 = self::getMethod('getThresholdByKeys')->invokeArgs(
            $this->instance,
            [Args::_L,  'missing2']
        );
        $this->assertTrue(\is_float($gdt0));
        $this->assertEquals($mockedOptions[Args::_L], $gdt0);
        $gdt1 = self::getMethod('getThresholdByKeys')->invokeArgs(
            $this->instance,
            ['missing1',  Args::_LINES]
        );
        $this->assertTrue(\is_float($gdt1));
        $this->assertEquals($mockedOptions[Args::_LINES], $gdt1);
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
        $mockedOptions = $this->getMockedOptions();
        self::getMethod('setOptions')->invokeArgs(
            $this->instance,
            [$mockedOptions]
        );
        $gtm0 = self::getMethod('floatOption')->invokeArgs(
            $this->instance,
            [Args::_L]
        );
        $this->assertTrue(\is_float($gtm0));
        $this->assertEquals($mockedOptions[Args::_L], $gtm0);
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
