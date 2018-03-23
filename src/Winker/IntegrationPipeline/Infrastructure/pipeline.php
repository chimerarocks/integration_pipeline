<?php

use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\ConsumePropertiesMapper;

return [
    'vendor'                        => 'App\Vendor',

    /**
     * Estratégia para configuração do
     * client para fazer as requisições
     * em endpoints.
     *
     *  'driver' ou 'psr'
     */
    'endpoint_consumer_strategy'    => 'psr',

    /**
     * Classe que irá implementar o driver
     * em caso de o campo 'endpoint_consumer_strategy'
     * for iniciado como 'driver'
     */
    'driver'                        => '',
];