<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies;

use Psr\Http\Message\ServerRequestInterface;
use Winker\IntegrationPipeline\Domain\Services\Request\Facades\RequestMaker\IRequestMaker;
use Winker\IntegrationPipeline\Domain\Services\RouteMatcher\IRouteMatcher;
use Winker\IntegrationPipeline\Domain\Services\Vendor\IVendor;

class EndpointPropertyStrategy implements IEndpointPropertyStrategy
{
    /**
     * @var IVendor
     */
    private $vendor;
    /**
     * @var IRequestMaker
     */
    private $requestMaker;
    /**
     * @var ServerRequestInterface
     */
    private $request;
    /**
     * @var \ReflectionProperty
     */
    private $property;
    /**
     * @var IRouteMatcher
     */
    private $routeMatcher;

    /**
     * EndpointPropertyStrategy constructor.
     * @param IVendor $vendor
     * @param IRequestMaker $requestMaker
     * @param ServerRequestInterface $request
     * @param IRouteMatcher $routeMatcher
     */
    public function __construct(
        IVendor $vendor,
        IRequestMaker $requestMaker,
        ServerRequestInterface $request,
        IRouteMatcher $routeMatcher
    )
    {
        $this->vendor = $vendor;
        $this->requestMaker = $requestMaker;
        $this->request = $request;
        $this->routeMatcher = $routeMatcher;
    }

    public function withProperty(\ReflectionProperty $property): IPropertyStrategy
    {
        $this->property = $property;
        return $this;
    }

    public function resolve()
    {
        $uri        = $this->getURI();
        $headers    = $this->getHeaders();
        $method     = $this->getMethod();
        $queryParams = $this->getQueryParams();
        $request    = $this->requestMaker->make($uri, $method, $headers, '', $queryParams);
        return $request;
    }

    private function getURI()
    {
        $uri = $this->getBaseURI();
        $uri = rtrim($uri,'/');
        $uri .= '/' . $this->property->getName();
        $uri .= $this->getArguments();

        return $uri;
    }

    private function getMethod()
    {
        return IEndpointPropertyStrategy::DEFAULT_METHOD;
    }

    private function getHeaders()
    {
        return $this->vendor->headers($this->request);
    }

    private function getBaseURI()
    {
        return $this->vendor->baseURI;
    }

    private function getArguments()
    {
        $uri = "";
        $path = $this->request->getUri()->getPath();
        $result = $this->routeMatcher->match($path);
        $route = $result->getRoute();
        if ($route->isReadRoute()) {
            $docComment = $this->property->getDocComment();
            $id = $result->getParam('id');
            preg_match('/@Read=(.*)/', $docComment, $match);
            if (!empty($match)) {
                $uriFormat = $match[1];
                $uri .= preg_replace('/@Id/', $id, $uriFormat);
            } else {
                $uri .= '/' . $id;
            }
        } elseif ($route->isByPortalRoute()) {
            $docComment = $this->property->getDocComment();
            $id = $result->getParam('id');
            preg_match('/@ByPortal=(.*)/', $docComment, $match);
            if (!empty($match)) {
                $uriFormat = $match[1];
                $uri .= preg_replace('/@Id/', $id, $uriFormat);
            } else {
                $uri .= '/portal/' . $id;
            }
        } elseif ($route->isCollectionRoute()) {
            $docComment = $this->property->getDocComment();
            $id = $result->getParam('id');
            preg_match('/@Collection=(.*)/', $docComment, $match);
            if (!empty($match)) {
                $uri .= $match[1];
            }
        }
        return $uri;
    }

    private function getQueryParams(): ?array
    {
        $queryParams = $this->vendor->queryParams($this->request);
        $requestedProperty = $this->property->getName();
        $propertyQueryParamsMethodName = $requestedProperty . 'QueryParams';
        if (method_exists($this->vendor, $propertyQueryParamsMethodName)) {
            $propertyQueryParams = $this->vendor->$propertyQueryParamsMethodName($this->request);
            $queryParams = array_merge($queryParams, $propertyQueryParams);
        }
        return $queryParams;
    }
}