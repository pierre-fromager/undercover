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
     * testInstance
     * @covers PierInfor\Undercover\Checker::__construct
     */
    public function testInstance()
    {
        $isCheckerInstance = $this->instance instanceof Checker;
        $this->assertTrue($isCheckerInstance);
    }
}
