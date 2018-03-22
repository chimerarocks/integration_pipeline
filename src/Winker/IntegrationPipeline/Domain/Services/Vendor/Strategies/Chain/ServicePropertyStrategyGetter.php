<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class ServicePropertyStrategyGetter extends PropertyStrategyGetter
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
        $regex = "/" . IServicePropertyStrategy::ANNOTATION_REFERENCE . "/";
        return preg_match($regex, $doc);
    }

    protected function makeStrategy(\ReflectionProperty $property)
    {
        $strategy = $this->container->get(IServicePropertyStrategy::class);
        return $strategy->withProperty($property);
    }
}