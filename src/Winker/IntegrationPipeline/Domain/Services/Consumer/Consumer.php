<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

abstract class Consumer
{
    /**
     * @var Consumer $next
     */
    protected $next;

    public function setNext(Consumer $next)
    {
        $this->next = $next;
    }

    public function consume(IPropertyStrategy $propertyStrategy): array
    {
        if ($this->canConsume($propertyStrategy)) {
            return $this->resolve($propertyStrategy);
        }
        return $this->next->consume($propertyStrategy);
    }

    abstract protected function canConsume(IPropertyStrategy $propertyStrategy);

    abstract protected function resolve(IPropertyStrategy $propertyStrategy): array;
}