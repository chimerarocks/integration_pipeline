<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\Exceptions;

class PathNotFoundException extends \Exception
{
    public function __construct(string $path)
    {
        $message = "There is no path defined to '$path'";
        parent::__construct($message);
    }
}