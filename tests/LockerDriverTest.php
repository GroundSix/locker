<?php
namespace GroundSix\Locker\Tests;

use GroundSix\Locker\LockerDriver;
use Groundsix\Password\Tests\Fakes\ArrayDriver;
use PHPUnit\Framework\TestCase;

class LockerDriverTest extends TestCase
{
    /** @var LockerDriver $driver */
    private $driver;

    public function setUp()
    {
        $this->driver = new ArrayDriver();
    }

    public function testDefaultsToUnlocked()
    {
        $status = $this->driver->getURLStatus('test');

        $this->assertFalse($status->isLocked(), 'URLs should default to unlocked, even if they dont exist.');
    }

    public function testLockUrl()
    {
        // Check it is unlocked to begin with
        $status = $this->driver->getURLStatus('test');
        $this->assertFalse($status->isLocked());

        // Lock it
        $this->driver->lockURL('test', 'anthony', 60);

        // Ensure it is locked
        $status = $this->driver->getURLStatus('test');
        $this->assertTrue($status->isLocked(), 'Locking a URL should mark it locked');
    }
}
