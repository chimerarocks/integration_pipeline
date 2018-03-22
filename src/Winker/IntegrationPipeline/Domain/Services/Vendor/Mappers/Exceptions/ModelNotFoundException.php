<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\Exceptions;

class ModelNotFoundException extends \Exception
{
    public function __construct(string $propertyName)
    {
        $message = "There is no model defined to '$propertyName' property";
        parent::__construct($message);
    }
}