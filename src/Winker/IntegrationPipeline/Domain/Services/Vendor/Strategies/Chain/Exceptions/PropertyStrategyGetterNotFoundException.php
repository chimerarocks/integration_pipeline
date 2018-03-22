<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain\Exceptions;

class PropertyStrategyGetterNotFoundException extends \Exception
{
    public function __construct(\ReflectionProperty $property)
    {
        $message = 'Was not found a property strategy getter which can make this property: ';
        $message .= $property->getName();
        parent::__construct($message);
    }
}