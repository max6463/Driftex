<?php

require __DIR__ . '/../vendor/autoload.php';

use Driftex\RateLimiter;
use Driftex\Storage\FileStorage;

$limiter = new RateLimiter(new FileStorage());

$key = 'ip:' . ($_SERVER['REMOTE_ADDR'] ?? 'cli');

if (!$limiter->allow($key, 5, 60)) {
    http_response_code(429);
    exit('Too many requests');
}

echo "OK";