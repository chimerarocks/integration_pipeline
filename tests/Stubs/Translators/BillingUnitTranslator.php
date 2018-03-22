<?php
namespace Test\Stubs\Translators;

use App\Services\SuperlogicaHelper;
use Winker\Integration\Util\Model\Translation\Model\BillingUnit;
use Winker\Integration\Util\Model\Translation\DateTranslation;
use Winker\Integration\Util\Model\TranslatorDefinition;

class BillingUnitTranslator extends TranslatorDefinition {

    public function winkerModelTranslation() {
        return BillingUnit::class;
    }

    public function winkerFieldsTranslation() {
        $dateFormat = app(SuperlogicaHelper::class)->defaultDateFormat();

        return [
            'id_portal'             => 'id_condominio_cond',
            'id_unit'               => 'id_unidade_uni',
            'id_bank_account'       => 'id_contabanco_cb',
            'id_billing_unit'       => 'id_recebimento_recb',

            'amount'            => 'vl_emitido_recb',
            'due_date'          => new DateTranslation($dateFormat, 'dt_vencimento_recb'),
            'created_date'      => new DateTranslation($dateFormat, 'dt_geracao_recb'),
            'reference_date'    => new DateTranslation([$dateFormat => 'Ym'], 'dt_competencia_recb'),
            'cancel_date'       => new DateTranslation($dateFormat, 'dt_cancelamento_recb'),
            'document_number'   => 'id_recebimento_recb',

            'url_billing_file'  => 'link_segundavia',

            'payment_date'          => new DateTranslation($dateFormat, 'dt_liquidacao_recb'),
            'amount_paid'           => function($data) {
                if (!empty($data['vl_total_recb']) & !empty($data['dt_liquidacao_recb'])) {
                    return $data['vl_total_recb'];
                }
            },
            'amount_interest_paid' => function($data) {
                if (!empty($data['receita_apropriacao'])) {
                    foreach ($data['receita_apropriacao'] as $row) {
                        if (trim($row['st_descricao_cont']) === 'Juros') {
                            return $row['vl_valor_reca'];
                        }
                    }
                }
            },
            'amount_fine_paid' => function($data) {
                if (!empty($data['receita_apropriacao'])) {
                    foreach ($data['receita_apropriacao'] as $row) {
                        if (trim($row['st_descricao_cont']) === 'Multas') {
                            return $row['vl_valor_reca'];
                        }
                    }
                }
            },
            'amount_discount_paid' => function($data) {
                if (!empty($data['receita_apropriacao'])) {
                    foreach ($data['receita_apropriacao'] as $row) {
                        if (trim($row['st_descricao_cont']) === 'Descontos') {
                            if ($row['vl_valor_reca'] < 0) {
                                return -$row['vl_valor_reca'];
                            } else {
                                return $row['vl_valor_reca'];
                            }
                        }
                    }
                }
            },
            'amount_restatement' => function($data) {
                if (!empty($data['receita_apropriacao'])) {
                    foreach ($data['receita_apropriacao'] as $row) {
                        if (trim($row['st_descricao_cont']) === 'Atualização Monetária') {
                            return $row['vl_valor_reca'];
                        }
                    }
                }
            }
        ];
    }

    public function vendorModelTranslation() {
        return null;
    }

    public function vendorFieldsTranslation() {
        return [];
    }
}