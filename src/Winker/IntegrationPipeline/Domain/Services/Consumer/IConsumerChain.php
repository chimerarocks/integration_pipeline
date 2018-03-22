<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

interface IConsumerChain
{
    public function consume(IPropertyStrategy $propertyStrategy): array;
}