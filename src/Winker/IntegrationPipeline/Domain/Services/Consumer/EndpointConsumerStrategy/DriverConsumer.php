<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Consumer\EndpointConsumerStrategy;

use Psr\Http\Message\ServerRequestInterface;
use Winker\Integration\Util\Http\Client;
use Winker\Integration\Util\Http\Client\Driver;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Facade\IVendorFacade;

class DriverConsumer implements EndpointConsumerStrategy
{
    /**
     * @var Driver
     */
    private $driver;
    /**
     * @var Client
     */
    private $client;

    public function __construct(
        Client $client,
        Driver $driver,
        IVendorFacade $vendorFacade
    )
    {
        $this->driver = $driver;
        $this->client = $client;
    }

    /**
     * @param ServerRequestInterface $request
     * @return array|mixed|null|string
     * @throws \Winker\Integration\Util\Http\Exception\RequestException
     */
    public function consume(ServerRequestInterface $request): array
    {
        $this->client->setDriver($this->driver);
        return $this->client->request(
            $request->getMethod(),
            $request->getUri(),
            (string) $request->getBody()
        );
    }
}