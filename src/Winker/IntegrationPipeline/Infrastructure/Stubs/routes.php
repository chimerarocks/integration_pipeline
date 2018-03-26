<?php

$this->app->router->group([
    'namespace' => 'Winker\IntegrationPipeline',
], function($router) {
    $router->get('portal', 'IntegrationPipeline@process');
    $router->get('portal/{id}', 'IntegrationPipeline@process');
    $router->get('bank_account', 'IntegrationPipeline@process');
    $router->get('bank_account/{id}', 'IntegrationPipeline@process');
    $router->get('bank_account/portal/{id}', 'IntegrationPipeline@process');
    $router->get('unit', 'IntegrationPipeline@process');
    $router->get('unit/{id}', 'IntegrationPipeline@process');
    $router->get('unit/portal/{id}', 'IntegrationPipeline@process');
    $router->get('user_unit', 'IntegrationPipeline@process');
    $router->get('user_unit/{id}', 'IntegrationPipeline@process');
    $router->get('user_unit/portal/{id}', 'IntegrationPipeline@process');
    $router->get('billing_unit', 'IntegrationPipeline@process');
    $router->get('billing_unit/{id}', 'IntegrationPipeline@process');
    $router->get('billing_unit/portal/{id}', 'IntegrationPipeline@process');
    $router->get('manager_mandate', 'IntegrationPipeline@process');
    $router->get('manager_mandate/{id}', 'IntegrationPipeline@process');
    $router->get('manager_mandate/portal/{id}', 'IntegrationPipeline@process');
});