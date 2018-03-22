<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class EndpointPropertyStrategyGetter extends PropertyStrategyGetter
{
    /**
     * @var ServiceContainerContract
     */
    private $container;

    public function __construct(
        ServiceContainerContract $container
    )
    {
        $this->container = $container;
    }

    protected function canResolve(\ReflectionProperty $property)
    {
        $doc = $property->getDocComment();
        $regex = "/" . IEndpointPropertyStrategy::ANNOTATION_REFERENCE . "/";
        return preg_match($regex, $doc);
    }

    protected function makeStrategy(\ReflectionProperty $property)
    {
        $strategy = $this->container->get(IEndpointPropertyStrategy::class);
        return $strategy->withProperty($property);
    }

}