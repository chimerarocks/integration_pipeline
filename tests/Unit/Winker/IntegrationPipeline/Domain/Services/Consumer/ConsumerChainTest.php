<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Consumer;

use GuzzleHttp\Psr7\Response;
use Test\Stubs\Services\BankAccountService;
use Test\Stubs\Services\HttpClient;
use Test\Stubs\Vendors\BasicVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Consumer\IConsumerChain;
use Winker\IntegrationPipeline\Domain\Services\HttpClient\IHttpClient;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;

class ConsumerChainTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_consume_a_service_request()
    {
        $this->stubProvider->bindService('bancos', BankAccountService::class);
        $this->stubProvider->fakeRequest(
            BasicVendor::class,
            Routes::BankAccount,
            'GET',
            []
        );

        $property = new \ReflectionProperty(BasicVendor::class, 'bancos');

        /* @var $consumerChain IConsumerChain */
        $consumerChain = $this->container->get(IConsumerChain::class);

        /* @var $servicePropertyStrategy IServicePropertyStrategy*/
        $servicePropertyStrategy = $this->container->get(IServicePropertyStrategy::class);

        $servicePropertyStrategy->withProperty($property);
        $result = $consumerChain->consume($servicePropertyStrategy);

        $this->assertEquals($result, ['collection' => true]);
    }

    public function test_can_consume_a_basic_request()
    {
        $this->container->bind(IHttpClient::class, function() {
            $client = new HttpClient(['result' => true]);
            return $client;
        });

        $this->stubProvider->fakeRequest(
            BasicVendor::class,
            '/portal',
            'GET',
            []
        );

        $property = new \ReflectionProperty(BasicVendor::class, 'condominios');

        /* @var $consumerChain IConsumerChain */
        $consumerChain = $this->container->get(IConsumerChain::class);

        /* @var $endpointPropertyStrategy IEndpointPropertyStrategy */
        $endpointPropertyStrategy = $this->container->get(IEndpointPropertyStrategy::class);

        $endpointPropertyStrategy->withProperty($property);
        $result = $consumerChain->consume($endpointPropertyStrategy);
        $this->assertEquals(["result" => true], $result);
    }
}