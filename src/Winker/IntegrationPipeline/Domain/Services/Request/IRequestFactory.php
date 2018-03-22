<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

interface IRequestFactory
{
    const DEFAULT_HEADERS = [
        "user-agent" => [
            'Symfony'
        ],
        "accept" => [
             'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
        ],
        "accept-language" => [
             'en-us,en;q=0.5'
        ],
        "accept-charset" => [
             'ISO-8859-1,utf-8;q=0.7,*;q=0.7'
        ]
    ];

    public function make(UriInterface $uri, string $method, ?array $headers = [], ?StreamInterface $stream = null): ServerRequestInterface;
}