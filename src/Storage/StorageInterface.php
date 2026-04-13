<?php

namespace Driftex\Storage;

interface StorageInterface
{
    public function increment(string $key, int $ttl): int;
}