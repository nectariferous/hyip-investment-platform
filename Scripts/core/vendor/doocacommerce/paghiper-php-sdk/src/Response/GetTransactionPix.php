<?php

namespace PagHipperSDK\Response;

use PagHipperSDK\Exception\ErrorException;
use PagHipperSDK\Helpers;

class GetTransactionPix extends TransactionAbstract
{
    /**
     * @var string
     */
    protected $status_date;


    /**
     * Setta as propriedades da consulta de transição.
     *
     * @param array $data
     * @return GetTransactionPix
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
        $class->value_cents = Helpers::centsToDecimal($data['value_cents']);
        $class->status = $data['status'];
        $class->order_id = $data['order_id'];
        $class->due_date = $data['due_date'];
        $class->qrcode_image_url = $data['pix_code']['qrcode_image_url'];
        $class->emv = $data['pix_code']['emv'];
        $class->bacen_url = $data['pix_code']['bacen_url'];
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
}
