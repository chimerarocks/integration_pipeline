<?php
declare(strict_types=1);

namespace Test;

use Illuminate\Support\ServiceProvider;
use Test\Stubs\StubProvider;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class TestProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['config']->set('pipeline', [
            'vendor' => 'test',
            'endpoint_consumer_strategy' => 'psr'
        ]);

        $this->app->bind(StubProvider::class, function($app) {
            $container = $app->get(ServiceContainerContract::class);
            return new StubProvider($container);
        });
    }
}