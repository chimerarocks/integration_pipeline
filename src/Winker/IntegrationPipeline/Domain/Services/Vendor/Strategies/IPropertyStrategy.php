<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

interface IPropertyStrategy
{
    public function withProperty(\ReflectionProperty $property): IPropertyStrategy;

    public function resolve();
}