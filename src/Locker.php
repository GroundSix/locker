<?php
declare(strict_types=1);

namespace GroundSix\Locker;

class Locker
{
    /** @var LockerDriver $driver */
    private $driver;

    /**
     * Creates a new Locker instance
     *
     * @param LockerDriver $driver The instance of the LockerDriver to use to check the state of locked pages
     */
    public function __construct(LockerDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Is the specified URL locked?
     *
     * @param string $url The URL to check the lock status for
     * @return bool true if locked, otherwise false
     */
    public function isLocked(string $url): bool
    {
        $status = $this->driver->getURLStatus($url);
        return $status->isLocked();
    }

    /**
     * Gets the full status of a page
     *
     * @param string $url
     * @return Status
     */
    public function getURLStatus(string $url): Status
    {
        return $this->driver->getURLStatus($url);
    }

    /**
     * Locks the given URL for a specified amount of time
     *
     * @param string $url The URL to lock
     * @param string $lockedBy The identifier of the user locking the page
     * @param int $lockFor The amount of seconds to lock the page for
     */
    public function lock(string $url, string $lockedBy, int $lockFor): void
    {
        $this->driver->lockURL($url, $lockedBy, $lockFor);
    }

    /**
     * Unlocks the given URL
     *
     * @param string $url The URL to unlock
     */
    public function unlock(string $url): void
    {
        $this->driver->unlockURL($url);
    }
}
