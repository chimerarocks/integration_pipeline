<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request;

use Psr\Http\Message\UriInterface;
use Winker\IntegrationPipeline\Domain\Services\Request\Exceptions\InvalidUriFormatException;

class UriFactory implements IUriFactory
{
    /**
     * @var UriInterface $uri
     */
    private $uri;

    /**
     * @var array $matches
     */
    private $matches;

    /**
     * @var string $scheme
     */
    private $scheme;

    /**
     * @var string $host
     */
    private $host;

    /**
     * @var string $port
     */
    private $port;

    /**
     * @var string $path
     */
    private $path;

    /**
     * @var string $query
     */
    private $query;

    /**
     * @var string $fragment
     */
    private $fragment;

    public function __construct(UriInterface $uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param $uri
     * @return UriInterface
     * @throws InvalidUriFormatException
     */
    public function make(string $uri): UriInterface
    {
        $this->matchAcceptedUriFormat($uri);
        $this->assignMatches();
        $this->hydrateUri();

        return $this->uri;
    }

    /**
     * @param string $uri
     * @throws InvalidUriFormatException
     */
    private function matchAcceptedUriFormat(string $uri): void
    {
        preg_match(IUriFactory::ACCEPTED_URI_FORMAT, $uri, $matches);

        if (empty($matches)) {
            throw new InvalidUriFormatException($uri);
        }

        $this->matches = $matches;
    }

    private function assignMatches()
    {
        $this->scheme     = empty($this->matches[2]) ?
            IUriFactory::DEFAULT_SCHEME : $this->matches[2];
        $this->host       = $this->matches[4] ?? null;
        $this->port       = $this->matches[6] ?? null;
        $this->path       = $this->matches[7] ?? null;
        $this->query      = $this->matches[9] ?? null;
        $this->fragment   = $this->matches[11] ?? null;
    }

    private function hydrateUri()
    {
        $this->uri = $this->uri->withScheme($this->scheme);
        $this->uri = $this->uri->withHost($this->host);

        if ($this->port) {
            $this->uri = $this->uri->withPort($this->port);
        }

        if ($this->path) {
            $this->uri = $this->uri->withPath($this->path);
        }

        if ($this->query) {
            $this->uri = $this->uri->withQuery($this->query);
        }

        if ($this->fragment) {
            $this->uri = $this->uri->withFragment($this->fragment);
        }
    }
}