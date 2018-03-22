<?php
namespace Test\Stubs\Translators;

use Winker\Integration\Util\Model\Translation\Model\Portal;
use Winker\Integration\Util\Model\TranslatorDefinition;

class PortalTranslator extends TranslatorDefinition {

    public function winkerModelTranslation() {
        return Portal::class;
    }

    public function winkerFieldsTranslation() {
        return [
            'unique_id'             => ['Portal' => 'id_condominio_cond'],
            'name'                  => ['st_fantasia_cond', 'st_nome_cond'],
            'doc_cnpj'              => 'st_cpf_cond',
            'phone'                 => 'st_telefone_cond',
            'adress'                => 'st_endereco_cond',
            'adress_complement'     => 'st_complemento_cond',
            'adress_neighborhood'   => 'st_bairro_cond',
            'adress_city'           => 'st_cidade_cond',
            'adress_state'          => 'st_estado_cond',
            'adress_zipcode'        => 'st_cep_cond',
            'email_portal'          => 'st_email_cond',
            'billing_due_date'      => 'dt_diavencimento_cond',
        ];
    }

    public function vendorModelTranslation() {
        return null;
    }

    public function vendorFieldsTranslation() {
        return [
            'id_condominio_cond'    => ['unique_id', 'Sub'],
            'st_fantasia_cond'      => 'name',
            'st_cpf_cond'           => 'doc_cnpj',
            'st_telefone_cond'      => 'phone',
            'st_endereco_cond'      => 'adress',
            'st_complemento_cond'   => 'adress_complement',
            'st_bairro_cond'        => 'adress_neighborhood',
            'st_cidade_cond'        => 'adress_city',
            'st_estado_cond'        => 'adress_state',
            'st_cep_cond'           => 'adress_zipcode',
            'st_email_cond'         => 'email_portal',
            'dt_diavencimento_cond' => 'billing_due_date'
        ];
    }
}