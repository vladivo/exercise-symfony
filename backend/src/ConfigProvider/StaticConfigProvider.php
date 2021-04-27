<?php

declare(strict_types=1);

namespace App\ConfigProvider;

use function explode;
use function is_array;

final class StaticConfigProvider implements ConfigProvider
{
    public function __construct(
        private array $config,
    ) {}

    public function get(string $name): mixed
    {
        $current = $this->config;
        foreach (explode(self::SEPARATOR, $name) as $key) {
            if (!is_array($current) || !isset($current[$key])) {
                return null;
            }

            $current = $current[$key];
        }

        return $current;
    }
}
