<?php
declare(strict_types=1);

namespace Test\Stubs;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker\IRequestMaker;
use Winker\IntegrationPipeline\Domain\Services\Vendor\IVendor;
use Winker\IntegrationPipeline\Infrastructure\Contracts\ServiceContainerContract;

class StubProvider
{
    /**
     * @var ServiceContainerContract
     */
    private $container;

    public function __construct(ServiceContainerContract $container)
    {
        $this->container = $container;
    }

    public function bindServerRequest(string $uri, string $method, array $headers, string $stream = '', array $attributes = [])
    {
        $requestMaker = $this->container->get(IRequestMaker::class);

        /* @var ServerRequestInterface $request */
        $request = $requestMaker
            ->make($uri, $method, $headers, $stream);
        foreach ($attributes as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        $this->container->bind(ServerRequestInterface::class, function() use ($request) {
            return $request;
        });

        return $this;
    }

    public function bindVendor(string $className)
    {
        $this->container->bind(IVendor::class, $className);
        return $this;
    }

    public function bindService(string $propertyName, string $className)
    {
        $this->container->bind($propertyName, $className);
        return $this;
    }

    public function fakeRequest(string $className, string $uri, string $method, array $headers, string $stream = '', array $attributes = [])
    {
        $uri = ltrim($uri, '/');
        $uri = '/' . $uri;
        $this->bindServerRequest($uri, $method, $headers, $stream, $attributes);
        $this->bindVendor($className);
    }
}