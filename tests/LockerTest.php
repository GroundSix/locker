<?php
namespace GroundSix\Locker\Tests;

use GroundSix\Locker\Locker;
use GroundSix\Locker\Status;
use Groundsix\Password\Tests\Fakes\ArrayDriver;
use PHPUnit\Framework\TestCase;

class LockerTest extends TestCase
{
    /** @var Locker $locker */
    private $locker;

    public function setUp()
    {
        $this->locker = new Locker(new ArrayDriver());
    }

    public function testIsLocked()
    {
        $this->assertFalse($this->locker->isLocked('test'), 'defaults to false');
        $this->locker->lock('test', 'anthony', 60);
        $this->assertTrue($this->locker->isLocked('test'), 'updated to true');
    }

    public function testGetStatus()
    {
        $status = $this->locker->getURLStatus('test');
        $this->assertInstanceOf(Status::class, $status);
    }

    public function testLock()
    {
        $this->locker->lock('test', 'anthony', 60);
        $this->assertTrue($this->locker->isLocked('test'), 'Anthony has locked "test"');

        $this->locker->lock('test2', 'james', 30);
        $this->assertTrue($this->locker->isLocked('test2', 'james has locked "test2"'));

        $this->locker->lock('test', 'james', 10);
        $this->assertEquals(
            'james',
            $this->locker->getURLStatus('test')->lockedBy(),
            'james has overridden the lock on "test"'
        );
    }
}
