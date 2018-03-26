<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\RouteMatcher;

class RouterMatcherException extends \Exception
{
    public function __construct(string $path)
    {
        $message = "The path $path was not found.";
        parent::__construct($message);
    }
}