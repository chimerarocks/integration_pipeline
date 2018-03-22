<?php
namespace Test\Stubs\Translators;

use App\Services\SuperlogicaHelper;
use Winker\Integration\Util\Model\Translation\DateTranslation;
use Winker\Integration\Util\Model\Translation\Model\ManagerMandate;
use Winker\Integration\Util\Model\TranslatorDefinition;

class ManagerMandateTranslator extends TranslatorDefinition {

    public function winkerModelTranslation() {
        return ManagerMandate::class;
    }

    public function winkerFieldsTranslation() {
        $dateFormat = app(SuperlogicaHelper::class)->defaultDateFormat();

        return [
            'id_manager_mandate'    => 'id_sindico_sin',
            'id_portal'             => 'id_condominio_cond',
            'start'                 => new DateTranslation($dateFormat, 'dt_entrada_sin'),
            'end'                   => new DateTranslation($dateFormat, 'dt_saida_sin'),
            'email'                 => 'st_email_sin',
            'first_name'            => 'st_nome_sin',
            'last_name'             => null,
            'cellphone'             => 'st_celular_sin',
            'phone'                 => 'st_telefone_sin',
            'status'                => null
        ];
    }

    public function vendorModelTranslation() {
        return null;
    }

    public function vendorFieldsTranslation() {
        return [];
    }
}