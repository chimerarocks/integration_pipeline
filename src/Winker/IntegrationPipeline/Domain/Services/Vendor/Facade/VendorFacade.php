<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Facade;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker\IRequestMaker;
use Winker\IntegrationPipeline\Domain\Services\Vendor\IVendor;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\IConsumePropertiesMapper;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

class VendorFacade implements IVendorFacade
{
    private $vendor;

    private $consumePropertiesMapper;

    private $requestedPath;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(
        ServerRequestInterface $request,
        IConsumePropertiesMapper $consumePropertiesMapper,
        IVendor $vendor,
        IRequestMaker $requestMaker,
        ContainerInterface $container
    )
    {
        $this->vendor = $vendor;
        $this->requestedPath = $request->getUri()->getPath();
        $this->consumePropertiesMapper = $consumePropertiesMapper;
        $this->request = $request;
    }

    public function resolve(): IPropertyStrategy
    {
        return $this->getRequestedPropertyStrategy();
    }

    public function transformData(array $data)
    {
        $translator = $this->consumePropertiesMapper
            ->getRequestedPropertyTranslator($this->requestedPath);

        $translation = $translator->toWinker($data);
        return $translation;
    }

    private function getRequestedPropertyStrategy()
    {
        return $this->consumePropertiesMapper->getRequestedPropertyStrategy($this->requestedPath);
    }
}