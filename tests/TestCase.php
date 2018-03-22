<?php
/**
 * Created by PhpStorm.
 * User: jp
 * Date: 10/03/18
 * Time: 17:25
 */

namespace Test;

use Test\Stubs\StubProvider;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;
use Winker\IntegrationPipeline\Infrastructure\Providers\IlluminateIntegrationPipelineProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @var ServiceContainerContract $container
     */
    protected $container;

    /**
     * @var ConfigProviderContract
     */
    protected $config;

    /**
     * @var StubProvider $stubProvider
     */
    protected $stubProvider;

    public function setUp()
    {
        parent::setUp();
        $this->container =& $this->app;
        $this->stubProvider = $this->container->get(StubProvider::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            IlluminateIntegrationPipelineProvider::class,
            TestProvider::class
        ];
    }
}