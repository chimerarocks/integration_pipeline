<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Infrastructure\Contracts;


interface ConfigProviderContract
{
    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value = null): void;
}