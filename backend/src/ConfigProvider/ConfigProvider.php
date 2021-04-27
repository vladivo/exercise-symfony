<?php

declare(strict_types=1);

namespace App\ConfigProvider;

interface ConfigProvider
{
    public const SEPARATOR = '.';

    public function get(string $name): mixed;
}
