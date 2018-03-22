<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain;

class PropertyStrategyGetterChain
{
    private $first;

    public function __construct(
        EndpointPropertyStrategyGetter $endpointPropertyStrategyGetter,
        ServicePropertyStrategyGetter $servicePropertyStrategyGetter,
        NotFoundPropertyStrategyGetter $notFoundPropertyStrategyGetter
    )
    {
        $endpointPropertyStrategyGetter->setNext($notFoundPropertyStrategyGetter);
        $servicePropertyStrategyGetter->setNext($endpointPropertyStrategyGetter);
        $this->first = $servicePropertyStrategyGetter;
    }

    public function getStrategy(\ReflectionProperty $property)
    {
        return $this->first->getStrategy($property);
    }
}