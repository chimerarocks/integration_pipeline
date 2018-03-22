<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer;

use Winker\IntegrationPipeline\Domain\Contracts\ServiceContract;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IServicePropertyStrategy;

class ServiceConsumer extends Consumer
{
    protected function canConsume(IPropertyStrategy $propertyStrategy)
    {
        return $propertyStrategy instanceof IServicePropertyStrategy &&
            $propertyStrategy->resolve() instanceof ServiceContract;
    }

    protected function resolve(IPropertyStrategy $propertyStrategy): array
    {
        /* @var ServiceContract $service */
        $service = $propertyStrategy->resolve();

        return $service->run();
    }
}