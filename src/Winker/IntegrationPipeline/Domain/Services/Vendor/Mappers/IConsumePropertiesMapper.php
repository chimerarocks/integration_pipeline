<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers;

use ReflectionProperty;
use Winker\Integration\Util\Model\Translation\Model\BankAccount;
use Winker\Integration\Util\Model\Translation\Model\BillingUnit;
use Winker\Integration\Util\Model\Translation\Model\ManagerMandate;
use Winker\Integration\Util\Model\Translation\Model\Portal;
use Winker\Integration\Util\Model\Translation\Model\Unit;
use Winker\Integration\Util\Model\Translation\Model\UserUnit;
use Winker\Integration\Util\Model\TranslatorDefinition;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

interface IConsumePropertiesMapper
{
    const MAPPING = [
        Routes::Portal              => Portal::class,
        Routes::BankAccount         => BankAccount::class,
        Routes::Unit                => Unit::class,
        Routes::UserUnit            => UserUnit::class,
        Routes::BillingUnit         => BillingUnit::class,
        Routes::ManagerMandate      => ManagerMandate::class
    ];

    const ANNOTATION_REFERENCE = '@Consume';

    public function getRequestedProperty(string $path): ReflectionProperty;

    public function getRequestedPropertyName(string $path): string;

    public function getRequestedPropertyStrategy(string $path): IPropertyStrategy;

    public function getRequestedPropertyTranslator(string $path): TranslatorDefinition;
}

