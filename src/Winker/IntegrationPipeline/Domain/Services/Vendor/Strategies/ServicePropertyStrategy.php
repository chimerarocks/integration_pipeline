<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class ServicePropertyStrategy implements IServicePropertyStrategy
{
    /**
     * @var ServiceContainerContract
     */
    private $container;

    /**
     * @var \ReflectionProperty
     */
    private $property;

    public function __construct(ServiceContainerContract $container)
    {
        $this->container = $container;
    }

    public function withProperty(\ReflectionProperty $property): IPropertyStrategy
    {
        $this->property = $property;
        return $this;
    }

    public function resolve()
    {
        $service = $this->property->getName();
        return $this->container->get($service);
    }
}