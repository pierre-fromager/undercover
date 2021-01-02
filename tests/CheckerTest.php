<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PFT;
use PierInfor\Undercover\Checker;

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
}
