<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Request;

use Psr\Http\Message\StreamInterface;

class StreamFactory implements IStreamFactory
{
    /**
     * @var StreamInterface
     */
    private $stream;

    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    public function make(?string $body = ''): StreamInterface
    {
        $this->stream->write($body);
        return $this->stream;
    }
}