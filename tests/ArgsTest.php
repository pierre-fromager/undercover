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
     * testInstance
     * @covers PierInfor\Undercover\Args::__construct
     */
    public function testInstance()
    {
        $isGeoInstance = $this->instance instanceof Args;
        $this->assertTrue($isGeoInstance);
    }
}
