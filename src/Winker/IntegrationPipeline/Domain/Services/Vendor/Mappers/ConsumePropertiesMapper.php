<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers;

use ReflectionProperty;
use Winker\Integration\Util\Model\TranslatorDefinition;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\Exceptions\ModelNotFoundException;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\Exceptions\PathNotFoundException;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\Exceptions\RoutePropertyNotFoundException;
use Winker\IntegrationPipeline\Domain\Services\Vendor\IVendor;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\Chain\PropertyStrategyGetterChain;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

class ConsumePropertiesMapper implements IConsumePropertiesMapper
{
    private $propertiesMapping;

    private $vendor;

    private $requestedProperty;

    private $requestedPropertyName;

    private $requestedPropertyStrategy;

    private $propertyStrategyGetterChain;

    /**
     * ConsumePropertiesMapper constructor.
     * @param IVendor $vendor
     * @param PropertyStrategyGetterChain $propertyStrategyGetterChain
     * @throws ModelNotFoundException
     */
    public function __construct(
        IVendor $vendor,
        PropertyStrategyGetterChain $propertyStrategyGetterChain
    )
    {
        $this->vendor = $vendor;
        $this->propertyStrategyGetterChain = $propertyStrategyGetterChain;
        $this->init();
    }


    /**
     * @param $path
     * @return mixed
     * @throws PathNotFoundException
     * @throws RoutePropertyNotFoundException
     */
    public function getRequestedProperty(string $path): ReflectionProperty
    {
        $this->assignIfEmpty($this->requestedProperty, $path, function($property) {
            return $property;
        });
        return $this->requestedProperty;
    }

    /**
     * @param string $path
     * @return string
     * @throws PathNotFoundException
     * @throws RoutePropertyNotFoundException
     */
    public function getRequestedPropertyName(string $path): string
    {
        $this->assignIfEmpty($this->requestedPropertyName, $path, function(ReflectionProperty $property) {
           return $property->getName();
        });
        return $this->requestedPropertyName;
    }

    /**
     * @param string $path
     * @return IPropertyStrategy
     * @throws PathNotFoundException
     * @throws RoutePropertyNotFoundException
     */
    public function getRequestedPropertyStrategy(string $path): IPropertyStrategy
    {
        $this->assignIfEmpty($this->requestedPropertyStrategy, $path, function(ReflectionProperty $property) {
            $strategy = $this->propertyStrategyGetterChain->getStrategy($property);
            return $strategy;
        });
        return $this->requestedPropertyStrategy;
    }

    /**
     * @param string $path
     * @return TranslatorDefinition
     * @throws PathNotFoundException
     * @throws RoutePropertyNotFoundException
     */
    public function getRequestedPropertyTranslator(string $path): TranslatorDefinition
    {
        $propertyName = $this->getRequestedPropertyName($path);
        return new $this->vendor->$propertyName;
    }

    /**
     * @throws ModelNotFoundException
     */
    private function init()
    {
        $reflector = new \ReflectionObject($this->vendor);
        $this->mapProperties(...$reflector
            ->getProperties(
                ReflectionProperty::IS_PUBLIC |
                ReflectionProperty::IS_PROTECTED
            )
        );
    }

    /**
     * @param ReflectionProperty[] ...$properties
     * @throws ModelNotFoundException
     */
    private function mapProperties(ReflectionProperty ...$properties): void
    {
        foreach ($properties as $property) {
            if ($this->isRouteProperty($property)) {
                $className = $this->getModelNameAppointedByVendorProperty($property->name);
                $this->propertiesMapping[$className] = $property;
            }
        }
    }

    private function isRouteProperty(\ReflectionProperty $property)
    {
        $regex = '/' . IConsumePropertiesMapper::ANNOTATION_REFERENCE . '/';
        return $property->getDocComment() &&
            preg_match($regex, $property->getDocComment());
    }

    /**
     * @param string $propertyName
     * @return string
     * @throws ModelNotFoundException
     */
    private function getModelNameAppointedByVendorProperty(string $propertyName): string
    {
        $property = $this->vendor->$propertyName;
        if (is_string($property)) {
            /* @var TranslatorDefinition $translator */
            $translator = new $property;
            if ($translator instanceof TranslatorDefinition) {
                return $translator->winkerModelTranslation();
            }
        }
        throw new ModelNotFoundException($propertyName);
    }

    /**
     * @param string $path
     * @return mixed
     * @throws PathNotFoundException
     */
    private function getAppointedClassByRoute(string $path)
    {
        if (!isset(IConsumePropertiesMapper::MAPPING[$path])) {
            throw new PathNotFoundException($path);
        }

        return IConsumePropertiesMapper::MAPPING[$path];
    }

    /**
     * @param string $property
     * @param string $path
     * @param \Closure $param
     * @return mixed
     * @throws PathNotFoundException
     * @throws RoutePropertyNotFoundException
     */
    private function assignIfEmpty(&$property, string $path, \Closure $param): void
    {
        if (empty($property)) {
            $className = $this->getAppointedClassByRoute($path);
            if (!isset($this->propertiesMapping[$className])) {
                throw new RoutePropertyNotFoundException($path, $className);
            }
            $property = $param($this->propertiesMapping[$className]);
        }
    }

}