<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

class IlluminatePackageProvider extends ServiceProvider
{
    public function boot()
    {
        $configPath = '';
        $appPath = '';

        if (function_exists('base_path')) {
            $configPath = base_path() . '/config';
            $appPath    = base_path() . '/app';
        }
        else if (method_exists($this->app, 'basePath'))
        {
            $configPath = $this->app->basePath() . '/config';
            $appPath    = $this->app->basePath() . '/app';
        }

        if (!is_dir($configPath)) {
            mkdir($configPath);
        }

        $this->publishes([
            __DIR__ . '/../pipeline.php'        => $configPath . '/pipeline.php',
            __DIR__ . '/../Stubs/Vendor.php'    => $appPath . '/Vendor.php'
        ]);
    }
}