<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

class IlluminatePackageProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(IlluminateIntegrationPipelineProvider::class);
        $this->app->register(IlluminateRoutesProvider::class);
    }

    public function boot()
    {
        $configPath = '';
        $appPath = '';
        $routesPath = '';

        if (function_exists('base_path')) {
            $configPath = base_path() . '/config';
            $appPath    = base_path() . '/app';
            $routesPath = base_path() . '/routes';
        }
        else if (method_exists($this->app, 'basePath'))
        {
            $configPath = $this->app->basePath() . '/config';
            $appPath    = $this->app->basePath() . '/app';
            $routesPath = $this->app->basePath() . '/routes';
        }

        if (!is_dir($configPath)) {
            mkdir($configPath);
        }

        $this->publishes([
            __DIR__ . '/../pipeline.php'            => $configPath  . '/pipeline.php',
            __DIR__ . '/../Stubs/Vendor.php'        => $appPath     . '/Vendor.php',
            __DIR__ . '/../Stubs/routes.php'    => $routesPath  . '/pipeline.php'
        ]);
    }
}