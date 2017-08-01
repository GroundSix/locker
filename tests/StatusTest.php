<?php
namespace GroundSix\Locker\Tests;

use GroundSix\Locker\Status;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testDefaultStatus()
    {
        $status = new Status('test');

        $this->assertEquals('test', $status->url(), 'Returned URL should be the same as the given URL');
        $this->assertFalse($status->isLocked(), 'Unknown pages are by default unlocked');
        $this->assertNull($status->lockedUntil(), 'Unknown pages have no locked until time');
        $this->assertNull($status->lockedBy(), 'Unknown pages are not locked by anyone');
    }

    public function testFilledStatus()
    {
        $status = new Status(
            'test',
            new \DateTime(time()+60),
            'anthony'
        );

        $this->assertEquals('test', $status->url(), 'Returned URL should be the same as the given URL');
        $this->assertTrue($status->isLocked(), 'Returned page should be locked');
        $this->assertInstanceOf(\DateTimeImmutable::class, $status->lockedUntil(), 'lockedUntil should be a DateTimeImmutable');
        $this->assertEquals('anthony', $status->lockedBy(), 'lockedBy should return the value passed into it');
    }
}
