<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer;

use Winker\IntegrationPipeline\Domain\Services\Consumer\Exception\ConsumerNotFoundException;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

class NotFoundConsumer extends Consumer
{
    protected function canConsume(IPropertyStrategy $propertyStrategy)
    {
        return true;
    }

    /**
     * @param IPropertyStrategy $propertyStrategy
     * @return array
     * @throws ConsumerNotFoundException
     */
    protected function resolve(IPropertyStrategy $propertyStrategy): array
    {
        throw new ConsumerNotFoundException($propertyStrategy);
    }
}