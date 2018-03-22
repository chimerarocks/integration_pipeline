<?php
/**
 * Created by PhpStorm.
 * User: jp
 * Date: 11/03/18
 * Time: 16:02
 */

namespace Winker\IntegrationPipeline\Infrastructure\Providers;

use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\ServiceProvider;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Winker\Integration\Util\Http\Client\Driver;
use Winker\IntegrationPipeline\Domain\Contracts\IntegrationPipelineContract;
use Winker\IntegrationPipeline\Domain\Pipes\FinishPipe;
use Winker\IntegrationPipeline\Domain\Pipes\IFinishPipe;
use Winker\IntegrationPipeline\Domain\Pipes\IConsumePipe;
use Winker\IntegrationPipeline\Domain\Pipes\ITransformPipe;
use Winker\IntegrationPipeline\Domain\Pipes\ConsumePipe;
use Winker\IntegrationPipeline\Domain\Pipes\TransformPipe;
use Winker\IntegrationPipeline\Domain\Services\Consumer\ConsumerChain;
use Winker\IntegrationPipeline\Domain\Services\Consumer\EndpointConsumerStrategy\DriverConsumer;
use Winker\IntegrationPipeline\Domain\Services\Consumer\EndpointConsumerStrategy\EndpointConsumerStrategy;
use Winker\IntegrationPipeline\Domain\Services\Consumer\EndpointConsumerStrategy\PsrClientConsumer;
use Winker\IntegrationPipeline\Domain\Services\Consumer\IConsumerChain;
use Winker\IntegrationPipeline\Domain\Services\HttpClient\GuzzleHttpClient;
use Winker\IntegrationPipeline\Domain\Services\HttpClient\IHttpClient;
use Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker\IRequestMaker;
use Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker\RequestMaker;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Facade\IVendorFacade;
use Winker\IntegrationPipeline\Domain\Services\Request\IRequestFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\IStreamFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\IUriFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\RequestFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\StreamFactory;
use Winker\IntegrationPipeline\Domain\Services\Request\UriFactory;
use Winker\IntegrationPipeline\Domain\Services\Vendor\IVendor;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\IConsumePropertiesMapper;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\ConsumePropertiesMapper;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Facade\VendorFacade;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\EndpointPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\ServicePropertyStrategy;
use Winker\IntegrationPipeline\Infrastructure\Adapters\Illuminate\ConfigProviderAdapter;
use Winker\IntegrationPipeline\Infrastructure\Adapters\Illuminate\ServiceContainerAdapter;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ConfigProviderContract;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;
use Winker\IntegrationPipeline\IntegrationPipeline;

class IlluminateIntegrationPipelineProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $app =& $this->app;

        $this->app->singleton(ServiceContainerContract::class, function() use (&$app) {
            return new ServiceContainerAdapter($app);
        });
        $vendorClass = $this->app['config']['pipeline.vendor'];

        $this->app->bind(IVendor::class, $vendorClass);

        $endpointConsumerStrategy = $this->app['config']['pipeline.endpoint_consumer_strategy'];

        $this->app->bind(EndpointConsumerStrategy::class, PsrClientConsumer::class);

        if ($endpointConsumerStrategy == 'driver') {
            $driver = $this->app['config']['pipeline.driver'];
            $this->app->bind(EndpointConsumerStrategy::class, DriverConsumer::class);
            $this->app->bind(Driver::class, $driver);
        }

        $this->app->singleton(ConfigProviderContract::class, ConfigProviderAdapter::class);
        $this->app->bind(IntegrationPipelineContract::class, IntegrationPipeline::class);
        $this->app->bind(IVendorFacade::class, VendorFacade::class);
        $this->app->bind(IConsumePropertiesMapper::class, ConsumePropertiesMapper::class);
        $this->app->bind(IHttpClient::class, GuzzleHttpClient::class);
        $this->app->bind(UriInterface::class, Uri::class);
        $this->app->bind(StreamInterface::class, function($app, $params) {
            $stream = fopen('php://temp', 'r+');
            return new Stream($stream);
        });

        $this->app->bind(IUriFactory::class, UriFactory::class);
        $this->app->bind(IStreamFactory::class, StreamFactory::class);
        $this->app->bind(IRequestFactory::class, RequestFactory::class);
        $this->app->bind(IRequestMaker::class, RequestMaker::class);

        $this->app->bind(IConsumePipe::class, ConsumePipe::class);
        $this->app->bind(ITransformPipe::class, TransformPipe::class);
        $this->app->bind(IFinishPipe::class, FinishPipe::class);

        $this->app->bind(IEndpointPropertyStrategy::class, EndpointPropertyStrategy::class);
        $this->app->bind(IServicePropertyStrategy::class, ServicePropertyStrategy::class);


        $this->app->bind(IConsumerChain::class, ConsumerChain::class);
    }
}