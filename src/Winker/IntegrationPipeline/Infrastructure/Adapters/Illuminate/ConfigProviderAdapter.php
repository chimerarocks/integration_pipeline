<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Infrastructure\Adapters\Illuminate;

use Illuminate\Foundation\Application;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ConfigProviderContract;

class ConfigProviderAdapter implements ConfigProviderContract
{
    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->app['config']->get($key, $default);
    }

    public function set(string $key, mixed $value = null): void
    {
        return $this->app['config']->set($key, $value);
    }
}