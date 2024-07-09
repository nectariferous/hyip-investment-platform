<?php

namespace PagHipperSDK\Response;

use PagHipperSDK\Exception\ErrorException;
use PagHipperSDK\Helpers;

class GetTransaction extends TransactionAbstract
{
    /**
     * @var string
     */
    protected $status_date;

    /**
     * Valor final da transação, contendo juros e multas, ou desconto de pagamento antecipado.
     * Esse campo só será retornado se a transação estiver com status de paid, ou completed.
     *
     * @var float
     */
    protected $value_cents_paid;

    /**
     * Percentual da multa
     * Esse campo só será retornado se na requisição do Boleto foi configurado a opção Multa.
     *
     * @var int
     */
    protected $late_payment_fine;

    /**
     * Juros por atraso
     * Esse campo só será retornado se na requisição do Boleto foi configurado a opção Juros.
     *
     * @var bool
     */
    protected $per_day_interest;

    /**
     * Número de dias em que o pagamento pode ser realizado com antecedência recebendo o desconto extra.
     * Esse campo só será retornado se na requisição do Boleto foi configurado a opção desconto por antecipação.
     * @var int
     */
    protected $early_payment_discounts_days;

    /**
     * Valor do desconto, que será aplicado caso o pagamento ocorra de forma antecipada.
     * Esse campo só será retornado se na requisição do Boleto foi configurado a opção desconto por antecipação.
     *
     * @var float
     */
    protected $early_payment_discounts_cents;

    /**
     * Número máximo de dias em que o boleto poderá ser pago após o vencimento.
     * (Prática comum para quem opta por cobrar juros e multas).
     * Esse campo só será retornado se o Boleto foi configurado, para ficar em aberto após o vencimento.
     *
     * @var int
     */
    protected $open_after_day_due;

    /**
     * Setta as propriedades da consulta de transição.
     *
     * @param array $data
     * @return GetTransaction
     * @throws ErrorException
     */
    public static function populate(array $data)
    {
        $data = $data['status_request'] ?? null;

        if (is_null($data)) {
            // Caso não encontre resposta
            throw new ErrorException('Undefined Error', 400);
        }

        if (201 !== $data['http_code']) {
            // Caso de erro ao criar transação
            $errorMessage = $data['response_message'] ?? null;
            throw new ErrorException($errorMessage, $data['http_code']);
        }

        // Instancia a classe que ta extendendo a abstrata
        $class = new self();

        $class->result = $data['result'];
        $class->response_message = $data['response_message'];
        $class->order_id = $data['order_id'];
        $class->status = $data['status'];
        $class->status_date = $data['status_date'];
        $class->due_date = $data['due_date'];
        $class->value_cents = Helpers::centsToDecimal($data['value_cents']);
        $class->value_cents_paid = isset($data['value_cents_paid']) ? Helpers::centsToDecimal($data['value_cents_paid']) : null; // phpcs.ignore
        $class->late_payment_fine = isset($data['late_payment_fine']) ? (int) $data['late_payment_fine'] : null;
        $class->per_day_interest = isset($data['per_day_interest']) ? (bool) $data['per_day_interest'] : null;
        $class->early_payment_discounts_days = isset($data['per_day_interest']) ? (int) $data['per_day_interest'] : null; // phpcs.ignore
        $class->early_payment_discounts_cents = isset($data['early_payment_discounts_cents']) ? Helpers::centsToDecimal($data['early_payment_discounts_cents']) : null; // phpcs.ingore
        $class->open_after_day_due = isset($data['open_after_day_due']) ? (int) $data['open_after_day_due'] : null;
        $class->bank_slip = Shared\BankSlip::populate($data['bank_slip']);
        $class->http_code = (int) $data['http_code'];

        return $class;
    }

    /**
     * @return string
     */
    public function getStatusDate(): string
    {
        return $this->status_date;
    }

    /**
     * @return float|null
     */
    public function getValueCentsPaid()
    {
        return $this->value_cents_paid;
    }

    /**
     * @return int|null
     */
    public function getLatePaymentFine()
    {
        return $this->late_payment_fine;
    }

    /**
     * @return bool|null
     */
    public function isPerDayInterest()
    {
        return $this->per_day_interest;
    }

    /**
     * @return int|null
     */
    public function getEarlyPaymentDiscountsDays()
    {
        return $this->early_payment_discounts_days;
    }

    /**
     * @return float|null
     */
    public function getEarlyPaymentDiscountsCents()
    {
        return $this->early_payment_discounts_cents;
    }

    /**
     * @return int|null
     */
    public function getOpenAfterDayDue()
    {
        return $this->open_after_day_due;
    }
}
