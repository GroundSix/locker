<?php
declare(strict_types=1);

namespace GroundSix\Locker;

class Status
{
    /** @var string $url */
    private $url;

    /** @var \DateTimeImmutable|null $lockedUntil */
    private $lockedUntil;

    /** @var string|null $lockedBy */
    private $lockedBy;

    public function __construct(string $url, ?\DateTimeInterface $lockedUntil = null, ?string $lockedBy = null)
    {
        $this->url = $url;

        if ($lockedUntil === null) {
            $this->lockedUntil = $lockedUntil;
        } else {
            $lockedTime = \DateTimeImmutable::createFromFormat(
                DATE_ATOM,
                $lockedUntil->format(DATE_ATOM),
                new \DateTimeZone('UTC')
            );
            $this->lockedUntil = $lockedTime;
        }

        $this->lockedBy = $lockedBy;
    }

    public function isLocked(): bool
    {
        if ($this->lockedUntil === null) {
            return false;
        }

        return $this->lockedUntil->format('U') > time();
    }

    public function url(): string
    {
        return $this->url;
    }

    public function lockedUntil(): ?\DateTimeImmutable
    {
        return $this->lockedUntil;
    }

    public function lockedBy(): ?string
    {
        return $this->lockedBy;
    }
}
