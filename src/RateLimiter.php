<?php

namespace Driftex;

use Driftex\Storage\StorageInterface;

class RateLimiter
{
    public function __construct(private StorageInterface $storage)
    {
    }

    public function allow(string $key, int $maxRequests, int $ttl): bool
    {
        $count = $this->storage->increment($key, $ttl);

        return $count <= $maxRequests;
    }
}