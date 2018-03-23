<?php

use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\ConsumePropertiesMapper;

$router->get(ConsumePropertiesMapper::PORTAL_ROUTE, 'IntegrationPipeline@process');
$router->get(ConsumePropertiesMapper::BANK_ACCOUNTS_ROUTE, 'IntegrationPipeline@process');