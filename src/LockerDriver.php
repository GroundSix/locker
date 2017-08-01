<?php
declare(strict_types=1);

namespace GroundSix\Locker;

interface LockerDriver
{
    /**
     * Returns a Status instance for the given URL
     *
     * @param string $url
     * @return Status
     */
    public function getURLStatus(string $url): Status;

    /**
     * Locks the given URL
     *
     * @param string $url An identifier for the page being locked, such as the URI or path to the page
     * @param string $lockedBy An identifier to show who currently owns the lock on the page, such as a user id
     * @param int $lockFor How long to lock the page for in seconds
     */
    public function lockURL(string $url, string $lockedBy, int $lockFor): void;

    /**
     * Unlocks the given URL
     *
     * @param string $url An identifier for the page being locked, such as the URI or path to the page. Must match the
     * value that was used to lock the page
     */
    public function unlockURL(string $url): void;
}
