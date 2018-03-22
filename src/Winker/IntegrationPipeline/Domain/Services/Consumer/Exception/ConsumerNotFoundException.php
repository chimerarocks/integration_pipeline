<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer\Exception;

use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

class ConsumerNotFoundException extends \Exception
{
    public function __construct(IPropertyStrategy $propertyStrategy)
    {
        $message = 'Was not found a consumer which can consume this kind of property strategy: ';
        $message .= get_class($propertyStrategy);
        parent::__construct($message);
    }
}