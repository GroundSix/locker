<?php

namespace Groundsix\Password\Tests\Fakes;

use GroundSix\Locker\LockerDriver;
use GroundSix\Locker\Status;

class ArrayDriver implements LockerDriver
{
    private $urls = [];

    public function lockURL(string $url, string $user, int $lockFor): void
    {
        $this->urls[$url] = [
            'url' => $url,
            'user' => $user,
            'lockedUntil' => \DateTimeImmutable::createFromFormat(
                'U',
                time() + $lockFor
            ),
        ];
    }

    public function unlockURL(string $url): void
    {
        unset($this->urls[$url]);
    }

    public function getURLStatus(string $url): Status
    {
        $status = $this->urls[$url] ?? null;

        if (!$status) {
            return new Status($url);
        }

        return new Status(
            $status['url'],
            $status['lockedUntil'],
            $status['user']
        );
    }
}
