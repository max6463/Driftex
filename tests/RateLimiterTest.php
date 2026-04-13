<?php

use PHPUnit\Framework\TestCase;
use Driftex\RateLimiter;
use Driftex\Storage\FileStorage;

class RateLimiterTest extends TestCase
{
    public function test_allows_requests_under_limit()
    {
        $limiter = new RateLimiter(new FileStorage());

        $result = $limiter->allow('test-key', 5, 60);

        $this->assertTrue($result);
    }

    public function test_blocks_after_limit()
    {
        $limiter = new RateLimiter(new FileStorage());

        $key = 'test-block';

        for ($i = 0; $i < 5; $i++) {
            $limiter->allow($key, 5, 60);
        }

        $this->assertFalse($limiter->allow($key, 5, 60));
    }
}