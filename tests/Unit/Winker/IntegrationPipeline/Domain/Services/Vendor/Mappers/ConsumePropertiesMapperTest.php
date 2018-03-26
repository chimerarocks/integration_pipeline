<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers;

use Test\Stubs\Vendors\BasicVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\IConsumePropertiesMapper;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;

class ConsumePropertiesMapperTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_get_requested_endpoint_property()
    {
        $this->stubProvider->bindVendor(BasicVendor::class);

        /* @var IConsumePropertiesMapper $routePropertyMapper */
        $routePropertyMapper = $this->container->get(IConsumePropertiesMapper::class);

        $requestedPropertyName = $routePropertyMapper
            ->getRequestedPropertyName(Routes::Portal);

        $requestedPropertyType = $routePropertyMapper
            ->getRequestedPropertyStrategy(Routes::Portal);

        $this->assertEquals('condominios', $requestedPropertyName);

        $this->assertInstanceOf(IEndpointPropertyStrategy::class, $requestedPropertyType);
    }

    public function test_can_get_requested_service_property()
    {
        $this->stubProvider->bindVendor(BasicVendor::class);

        /* @var IConsumePropertiesMapper $routePropertyMapper */
        $routePropertyMapper = $this->container->get(IConsumePropertiesMapper::class);

        $requestedPropertyName = $routePropertyMapper
            ->getRequestedPropertyName(Routes::BankAccount);

        $requestedPropertyType = $routePropertyMapper
            ->getRequestedPropertyStrategy(Routes::BankAccount);

        $this->assertEquals('bancos', $requestedPropertyName);

        $this->assertInstanceOf(IServicePropertyStrategy::class, $requestedPropertyType);
    }
}