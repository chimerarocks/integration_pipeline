<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request\Exceptions;

use Winker\IntegrationPipeline\Domain\Services\Request\IUriFactory;

class InvalidUriFormatException extends \Exception
{
    public function __construct($uri)
    {
        $message = "Invalid uri passed to parse: $uri; Expected format: ";
        $message .= "'" . IUriFactory::ACCEPTED_URI_FORMAT . "'";
        parent::__construct($message);
    }
}