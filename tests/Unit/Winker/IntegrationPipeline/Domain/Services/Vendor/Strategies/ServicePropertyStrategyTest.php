<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

use Test\Stubs\Services\BankAccountService;
use Test\Stubs\Vendors\BasicVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Contracts\ServiceContract;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;

class ServicePropertyStrategyTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_resolve_a_basic_request()
    {
        $this->stubProvider->bindService('bancos', BankAccountService::class);
        $this->stubProvider->bindVendor(BasicVendor::class);

        /**
         * @var IServicePropertyStrategy $servicePropertyStrategy
         */
        $servicePropertyStrategy =
            $this->container->get(IServicePropertyStrategy::class);
        $property = new \ReflectionProperty(BasicVendor::class, 'bancos');

        $servicePropertyStrategy->withProperty($property);

        /* @var ServiceContract $result */
        $result = $servicePropertyStrategy->resolve();

        $expectedClass = ServiceContract::class;

        $this->assertInstanceOf($expectedClass, $result);
    }
}