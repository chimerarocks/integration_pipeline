<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\IConsumePropertiesMapper;

class IlluminateRoutesProvider extends ServiceProvider
{
    public function boot()
    {
        $routesPath = '';
        if (function_exists('base_path')) {
            $routesPath = base_path() . '/routes';
        }
        else if (method_exists($this->app, 'basePath'))
        {
            $routesPath = $this->app->basePath() . '/routes';
        }
        if (file_exists($routesPath . "/pipeline.php")) {
            require $routesPath . "/pipeline.php";
        }
    }
}