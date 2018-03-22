<?php
namespace Test\Stubs\Translators;

use Winker\Integration\Util\Model\Translation\Model\Unit;
use Winker\Integration\Util\Model\TranslatorDefinition;

class UnitTranslator extends TranslatorDefinition {

    public function winkerModelTranslation() {
        return Unit::class;
    }

    public function winkerFieldsTranslation() {
        return [
            'id_portal'             => 'id_condominio_cond',
            'id_unit'               => 'id_unidade_uni',
            'division'              => 'st_bloco_uni',
            'name'                  => 'st_unidade_uni',
            'fractional_ownership'  => function($data) {
                if (empty($data['nm_fracao_uni'])) {
                    return;
                }

                return $data['nm_fracao_uni']/100;
            },
        ];
    }

    public function vendorModelTranslation() {
        return null;
    }

    public function vendorFieldsTranslation() {
        return [];
    }
}