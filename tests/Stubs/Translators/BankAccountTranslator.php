<?php
namespace Test\Stubs\Translators;

use Winker\Integration\Util\Model\Translation\Model\BankAccount;
use Winker\Integration\Util\Model\TranslatorDefinition;

class BankAccountTranslator extends TranslatorDefinition {

    public function winkerModelTranslation() {
        return BankAccount::class;
    }

    public function winkerFieldsTranslation() {
        return [
            'agency_number'                 => 'st_numero_agb',
            'agency_number_digit'           => 'st_numero_agb',
            'agency_address'                => null,
            'currency'                      => null,
            'name'                          => 'st_nome_banc+st_conta_cb',
            'bank_number'                   => 'st_numero_banc',
            'id_bank_account'               => 'id_contabanco_cb',
            'id_portal'                     => 'id_condominio_cond',
            'balance'                       => 'vl_saldo_cb',
            'account_number'                => 'st_conta_cb',
            'account_number_digit'          => 'st_conta_cb',
            'account_approved'              => null,
            'account_description'           => null,
            'accepted'                      => null,
            'billing_wallet'                => 'st_carteira_car',
            'billing_document_currency'     => 'st_especiedoc_car',
            'billing_payment_place'         => 'st_localpagamento_car',
            'billing_assignor_name'         => 'st_infocedente_cb',
            'billing_layout_type'           => function($data) {
                if (empty($data['nm_cnab_cb'])) {
                    return;
                }

                return "CNAB{$data['nm_cnab_cb']}";
            },
            'billing_bank_agreement'        => 'st_conveniobanco_cb',
            'billing_bank_agreement_digit'  => 'st_conveniobanco_cb',
            'enabled'                       => function() { return 1; },
        ];
    }

    public function vendorModelTranslation() {
        return null;
    }

    public function vendorFieldsTranslation() {
        return [];
    }
}