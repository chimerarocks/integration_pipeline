<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Consumer\EndpointConsumerStrategy\EndpointConsumerStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IEndpointPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

class EndpointConsumer extends Consumer
{
    /**
     * @var EndpointConsumerStrategy
     */
    private $endpointConsumerStrategy;

    public function __construct(EndpointConsumerStrategy $endpointConsumerStrategy)
    {
        $this->endpointConsumerStrategy = $endpointConsumerStrategy;
    }

    protected function canConsume(IPropertyStrategy $propertyStrategy)
    {
        return $propertyStrategy instanceof IEndpointPropertyStrategy &&
            $propertyStrategy->resolve() instanceof ServerRequestInterface;
    }

    protected function resolve(IPropertyStrategy $propertyStrategy): array
    {
        return $this->endpointConsumerStrategy->consume($propertyStrategy->resolve());
    }
}