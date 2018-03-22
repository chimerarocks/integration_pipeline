<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

class ConsumerChain
{
    /** @var Consumer $first */
    private $first;

    public function __construct(
        EndpointConsumer $endpointConsumer,
        ServiceConsumer $serviceConsumer,
        NotFoundConsumer $notFoundConsumer
    )
    {
        $serviceConsumer->setNext($notFoundConsumer);
        $endpointConsumer->setNext($serviceConsumer);
        $this->first = $endpointConsumer;
    }

    public function consume(IPropertyStrategy $propertyStrategy): array
    {
        return $this->first->consume($propertyStrategy);
    }
}