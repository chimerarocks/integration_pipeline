<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Vendors\BasicVendor;
use Test\Stubs\Vendors\QueryParamsVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;

class EndpointPropertyStrategyTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_resolve_a_basic_request()
    {
        $this->stubProvider->bindVendor(BasicVendor::class);

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
            'portals',
            'GET',
            [],
            "",
            [ 'userId' => 23]
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
        $expectedUri = 'http://' . QueryParamsVendor::BASE_URI . '/condominios';
        $expectedQuery = [
            "ordenacao" => "ST_FANTASIA_COND%20ASC",
            "apenasOsQueTenhoAcesso" => "1",
            "somenteCondominiosAtivos" => "1",
            "itensPorPagina" => "50",
            "id" => "-1",
            "comDadosFechamento" => "1",
            "userId" => 23
        ];

        $this->assertInstanceOf($expectedClass, $result);
        $this->assertEquals($expectedUri, (string) $result->getUri());
        $this->assertEquals($expectedQuery, $result->getQueryParams());
    }
}