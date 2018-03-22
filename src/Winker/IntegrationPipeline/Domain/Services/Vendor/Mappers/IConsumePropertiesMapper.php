<?php
declare(strict_types=1);

namespace Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers;


use ReflectionProperty;
use Winker\Integration\Util\Model\Translation\Model\BankAccount;
use Winker\Integration\Util\Model\Translation\Model\Portal;
use Winker\Integration\Util\Model\TranslatorDefinition;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Strategies\IPropertyStrategy;

interface IConsumePropertiesMapper
{
    const PORTAL_ROUTE = '/portals';

    const BANK_ACCOUNTS_ROUTE = '/bank_accounts';

    const MAPPING = [
        IConsumePropertiesMapper::PORTAL_ROUTE => Portal::class,
        IConsumePropertiesMapper::BANK_ACCOUNTS_ROUTE => BankAccount::class
    ];

    const ANNOTATION_REFERENCE = '@Consume';

    public function getRequestedProperty(string $path): ReflectionProperty;

    public function getRequestedPropertyName(string $path): string;

    public function getRequestedPropertyStrategy(string $path): IPropertyStrategy;

    public function getRequestedPropertyTranslator(string $path): TranslatorDefinition;
}