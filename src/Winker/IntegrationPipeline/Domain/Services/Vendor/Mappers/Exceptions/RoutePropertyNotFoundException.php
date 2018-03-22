<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\Exceptions;

class RoutePropertyNotFoundException extends \Exception
{
    public function __construct(string $path, string $className)
    {
        $message = "There is no property appointing to $className calling path '$path'";
        parent::__construct($message);
    }
}