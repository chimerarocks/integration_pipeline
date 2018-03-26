<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request;


use Psr\Http\Message\UriInterface;
use Winker\IntegrationPipeline\Domain\Services\Request\Exceptions\InvalidUriFormatException;

interface IUriFactory
{
    const ACCEPTED_URI_FORMAT = "/^(([^:\/?#]+):\/\/)?(([^\/?#:]*))(:([0-9]+))?([^:?#]*)(\?([^#]*))?(#(.*))?$/";

    const DEFAULT_SCHEME = 'http';

    /**
     * @param string $uri
     * @param array $queryParams
     * @return UriInterface
     */
    public function make(string $uri, array $queryParams = []): UriInterface;
}