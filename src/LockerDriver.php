<?php
declare(strict_types=1);

namespace GroundSix\Locker;

interface LockerDriver
{
    public function getURLStatus(string $url): Status;

    public function lockURL(string $url, string $lockedBy, int $lockFor): void;
}
