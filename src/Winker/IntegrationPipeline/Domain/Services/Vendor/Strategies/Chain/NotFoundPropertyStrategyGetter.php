<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain\Exceptions\PropertyStrategyGetterNotFoundException;

class NotFoundPropertyStrategyGetter extends PropertyStrategyGetter
{
    protected function canResolve(\ReflectionProperty $property)
    {
        return true;
    }

    /**
     * @param \ReflectionProperty $property
     * @throws PropertyStrategyGetterNotFoundException
     */
    protected function makeStrategy(\ReflectionProperty $property)
    {
        throw new PropertyStrategyGetterNotFoundException($property);
    }

}