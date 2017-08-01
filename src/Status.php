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

    /**
     * Creates a new Status instance
     *
     * @param string $url The Identifier of the page to lock. Either the path or some other unique identifier
     * @param \DateTimeInterface|null $lockedUntil A DateTimeInterface that holds the date for how long the page should
     * be locked for
     * @param null|string $lockedBy A unique identifier to show who locked the page.
     */
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

    /**
     * Is the page currently locked? True if yes, otherwise false
     *
     * @return bool
     */
    public function isLocked(): bool
    {
        if ($this->lockedUntil === null) {
            return false;
        }

        $lockedUntil = $this->lockedUntil->format('U');
        $now = (new \DateTime('now', new \DateTimeZone('UTC')))->format('U');

        return $lockedUntil >$now;
    }

    /**
     * Returns the pages unique identifier
     *
     * @return string
     */
    public function url(): string
    {
        return $this->url;
    }

    /**
     * Returns the how long the page is locked for as a DateTimeImmutable
     *
     * @return \DateTimeImmutable|null
     */
    public function lockedUntil(): ?\DateTimeImmutable
    {
        return $this->lockedUntil;
    }

    /**
     * Returns the unique identifier for the person who locked the page
     *
     * @return null|string
     */
    public function lockedBy(): ?string
    {
        return $this->lockedBy;
    }
}
