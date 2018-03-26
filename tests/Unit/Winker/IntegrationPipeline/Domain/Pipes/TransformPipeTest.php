<?php
declare(strict_types=1);

namespace Test\Unit\Winker\IntegrationPipeline\Domain\Pipes;

use Psr\Http\Message\ServerRequestInterface;
use Test\Stubs\Vendors\BasicVendor;
use Test\TestCase;
use Winker\IntegrationPipeline\Domain\Pipes\IConsumePipe;
use Winker\IntegrationPipeline\Domain\Pipes\ITransformPipe;
use Winker\IntegrationPipeline\Domain\Services\Routing\Routes;
use Winker\IntegrationPipeline\Domain\Services\Vendor\Mappers\ConsumePropertiesMapper;

class TransformPipeTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_can_handle_a_basic_vendor()
    {
        $this->stubProvider->fakeRequest(
            BasicVendor::class,
            Routes::Portal,
            'GET',
            [],
            '',
            [ 'userId' => 123 ]
        );

        $data = [
            'id_condominio_cond'        => 'test_id_condominio_cond',
            'st_fantasia_cond'          => 'test_st_fantasia_cond',
            'st_nome_cond'              => 'test_st_nome_cond',
            'st_cpf_cond'               => '1234',
            'st_telefone_cond'          => 'test_st_telefone_cond',
            'st_endereco_cond'          => 'test_st_endereco_cond',
            'st_complemento_cond'       => 'test_st_complemento_cond',
            'st_bairro_cond'            => 'test_st_bairro_cond',
            'st_cidade_cond'            => 'test_st_cidade_cond',
            'st_estado_cond'            => 'test_st_estado_cond',
            'st_cep_cond'               => '123456789',
            'st_email_cond'             => 'test_st_email_cond',
            'dt_diavencimento_cond'     => 'test_dt_diavencimento_cond'
        ];

        $pipe = $this->container->get(ITransformPipe::class);
        $request = $this->container->get(ServerRequestInterface::class);
        $request = $request->withAttribute(IConsumePipe::class, $data);

        $result = $pipe->handle($request, function(ServerRequestInterface $request) {
            return $request->getAttribute(ITransformPipe::class);
        });

        $expectedTransformedData = [
            'unique_id'                 => 'Portal:test_id_condominio_cond',
            'name'                      => 'test_st_fantasia_cond',
            'doc_cnpj'                  => '1234',
            'phone'                     => 'test_st_telefone_cond',
            'adress'                    => 'test_st_endereco_cond',
            'adress_complement'         => 'test_st_complemento_cond',
            'adress_neighborhood'       => 'test_st_bairro_cond',
            'adress_city'               => 'test_st_cidade_cond',
            'adress_state'              => 'test_st_estado_cond',
            'adress_zipcode'            => '123456789',
            'email_portal'              => 'test_st_email_cond',
            'billing_due_date'          => 'test_dt_diavencimento_cond'
        ];

        $this->assertEquals($expectedTransformedData, $result);
    }
}