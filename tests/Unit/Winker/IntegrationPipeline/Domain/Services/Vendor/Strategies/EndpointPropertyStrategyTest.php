<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Vendors\BasicVendor;
use Test\Stubs\Vendors\QueryParamsVendor;
use Test\Stubs\Vendors\UniqueRoutesCustomVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\IConsumePropertiesMapper;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;

class EndpointPropertyStrategyTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_resolve_a_basic_request()
    {
        $this->stubProvider->fakeRequest(
           BasicVendor::class,
           Routes::Portal,
           'GET',
           []
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);
        $property = new \ReflectionProperty(BasicVendor::class, 'condominios');

        $endpointPropertyStrategy->withProperty($property);
        /* @var ServerRequestInterface $result */
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . BasicVendor::BASE_URI . '/condominios';

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }

    public function test_can_resolve_a_request_with_query_params()
    {
        $this->stubProvider->fakeRequest(
            QueryParamsVendor::class,
            Routes::Portal,
            'GET',
            [],
            ""
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);

        $property = new \ReflectionProperty(QueryParamsVendor::class, 'condominios');

        /* @var ServerRequestInterface $result */
        $endpointPropertyStrategy->withProperty($property);
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . QueryParamsVendor::BASE_URI . '/condominios?userId=23&comDadosFechamento=1';
        $expectedQuery = [
            "comDadosFechamento" => "1",
            "userId" => 23
        ];

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }

    public function test_can_resolve_a_request_to_read_route()
    {
        $this->stubProvider->fakeRequest(
            UniqueRoutesCustomVendor::class,
            Routes::Unit . '/23',
            'GET',
            [],
            ""
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);

        $property = new \ReflectionProperty(UniqueRoutesCustomVendor::class, 'unidades');

        /* @var ServerRequestInterface $result */
        $endpointPropertyStrategy->withProperty($property);
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . UniqueRoutesCustomVendor::BASE_URI . '/unidades/23';

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }

    public function test_can_resolve_a_request_to_by_portal_route()
    {
        $this->stubProvider->fakeRequest(
            UniqueRoutesCustomVendor::class,
            '/unit/portal/23',
            'GET',
            [],
            ""
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);

        $property = new \ReflectionProperty(UniqueRoutesCustomVendor::class, 'unidades');

        /* @var ServerRequestInterface $result */
        $endpointPropertyStrategy->withProperty($property);
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . UniqueRoutesCustomVendor::BASE_URI . '/unidades/portal/23';

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }

    public function test_can_resolve_a_request_to_read_route_with_custom_argument()
    {
        $this->stubProvider->fakeRequest(
            UniqueRoutesCustomVendor::class,
            '/portal/23',
            'GET',
            [],
            ""
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);

        $property = new \ReflectionProperty(UniqueRoutesCustomVendor::class, 'condominios');

        /* @var ServerRequestInterface $result */
        $endpointPropertyStrategy->withProperty($property);
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . UniqueRoutesCustomVendor::BASE_URI . '/condominios/test/23';

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }

    public function test_can_resolve_a_request_to_by_portal_route_with_custom_argument()
    {
        $this->stubProvider->fakeRequest(
            UniqueRoutesCustomVendor::class,
            '/bank_account/portal/23',
            'GET',
            [],
            ""
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);

        $property = new \ReflectionProperty(UniqueRoutesCustomVendor::class, 'bancos');

        /* @var ServerRequestInterface $result */
        $endpointPropertyStrategy->withProperty($property);
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . UniqueRoutesCustomVendor::BASE_URI . '/bancos/test?portalId=23';

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }

    public function test_can_resolve_a_request_to_collection_route_with_custom_argument()
    {
        $this->stubProvider->fakeRequest(
            UniqueRoutesCustomVendor::class,
            '/bank_account',
            'GET',
            [],
            ""
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);

        $property = new \ReflectionProperty(UniqueRoutesCustomVendor::class, 'bancos');

        /* @var ServerRequestInterface $result */
        $endpointPropertyStrategy->withProperty($property);
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . UniqueRoutesCustomVendor::BASE_URI . '/bancos/test';

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }

    public function test_can_resolve_a_request_to_read_route_with_custom_argument_and_query_params()
    {
        $this->stubProvider->fakeRequest(
            UniqueRoutesCustomVendor::class,
            '/billing_unit/23',
            'GET',
            [],
            ""
        );

        /**
         * @var IEndpointPropertyStrategy $endpointPropertyStrategy
         */
        $endpointPropertyStrategy =
            $this->container->get(IEndpointPropertyStrategy::class);

        $property = new \ReflectionProperty(UniqueRoutesCustomVendor::class, 'cobrancas');

        /* @var ServerRequestInterface $result */
        $endpointPropertyStrategy->withProperty($property);
        $result = $endpointPropertyStrategy->resolve();

        $expectedClass = ServerRequestInterface::class;
        $expectedUri = 'http://' . UniqueRoutesCustomVendor::BASE_URI . '/cobrancas/test?portalId=23&queryParam=1';

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
    }
}