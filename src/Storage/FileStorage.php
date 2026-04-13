<?php

namespace Driftex\Storage;

class FileStorage implements StorageInterface
{
    private string $dir;

    public function __construct()
    {
        $this->dir = sys_get_temp_dir() . '/driftex';

        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
    }

    public function increment(string $key, int $ttl): int
    {
        $file = $this->dir . '/' . md5($key) . '.json';

        $data = [
            'count' => 0,
            'expires' => time() + $ttl
        ];

        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);

            if ($data['expires'] < time()) {
                $data = [
                    'count' => 0,
                    'expires' => time() + $ttl
                ];
            }
        }

        $data['count']++;

        file_put_contents($file, json_encode($data));

        return $data['count'];
    }
}