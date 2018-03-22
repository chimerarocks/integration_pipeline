<?php
namespace Test\Stubs\Translators;

use App\Services\SuperlogicaHelper;
use Winker\Integration\Util\Model\Translation\Model\UserUnit;
use Winker\Integration\Util\Model\Translation\OptionsTranslation;
use Winker\Integration\Util\Model\TranslatorDefinition;

class UserUnitTranslator extends TranslatorDefinition {

    public function winkerModelTranslation() {
        return UserUnit::class;
    }

    public function winkerFieldsTranslation() {
        return [
            'id_unit'               => 'id_unidade_uni',
            'id_portal'             => 'id_condominio_cond',
            'id_user_unit'          => 'id_contato_con',
            'name'                  => 'st_nome_con',
            'phone'                 => 'st_telefone_con',
            'cellphone'             => 'st_fax_con',
            'email'                 => 'st_email_con',
            'doc_cpf'               => 'st_cpf_con',
            'doc_rg'                => 'st_rg_con',
            'profile'               => 
                new OptionsTranslation([
                    'Proprietário' => 'Owner', 'Proprietário Residente' => 'Owner', 
                    'Residente' => 'Tenant'], 
                'st_nometiporesp_tres'),
            'adress'                => 'st_endereco_con',
            'adress_neighborhood'   => 'st_bairro_con',
            'adress_zipcode'        => 'st_cep_con',
            'adress_city'           => 'st_cidade_con',
            'adress_state'          => new OptionsTranslation(app(SuperlogicaHelper::class)->states(), 'id_uf_uf')
        ];
    }

    public function vendorModelTranslation() {
        return null;
    }

    public function vendorFieldsTranslation() {
        return [];
    }
}