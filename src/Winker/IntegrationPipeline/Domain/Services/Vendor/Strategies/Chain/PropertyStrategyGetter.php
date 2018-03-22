<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

abstract class PropertyStrategyGetter
{
    /**
     * @var PropertyStrategyGetter
     */
    private $next;

    public function setNext(PropertyStrategyGetter $next)
    {
        $this->next = $next;
    }

    public function getStrategy(\ReflectionProperty $property): ?IPropertyStrategy
    {
        if ($this->canResolve($property)) {
            return $this->makeStrategy($property);
        }
        return $this->next->getStrategy($property);
    }

    abstract protected function canResolve(\ReflectionProperty $property);

    abstract protected function makeStrategy(\ReflectionProperty $property);
}