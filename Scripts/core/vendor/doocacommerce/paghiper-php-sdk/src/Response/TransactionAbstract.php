<?php

namespace PagHipperSDK\Response;

abstract class TransactionAbstract
{
    /**
     * @var string
     */
    protected $result;

    /**
     * @var string
     */
    protected $response_message;

    /**
     * @var string
     */
    protected $value_cents;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $order_id;

    /**
     * @var string
     */
    protected $due_date;

    /**
     * @var Shared\BankSlip
     */
    protected $bank_slip;

    /**
     * @var int
     */
    protected $http_code;

    /**
     * @var string
     */
    protected $qrcode_image_url;

    /**
     * @var string
     */
    protected $bacen_url;

    /**
     * @var string
     */
    protected $emv;



    /**
     * @param array $response
     * @return mixed
     */
    abstract public static function populate(array $response);

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getResponseMessage(): string
    {
        return $this->response_message;
    }


    /**
     * @return string
     */
    public function getValueCents(): string
    {
        return $this->value_cents;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->order_id;
    }

    /**
     * @return Shared\BankSlip
     */
    public function getBankSlip(): Shared\BankSlip
    {
        return $this->bank_slip;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->due_date;
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->http_code;
    }

    /**
     * @return string
     */
    public function getQrcodeImageUrl(): string
    {
        return $this->qrcode_image_url;
    }

    /**
     * @return string
     */
    public function getBacenUrl(): string
    {
        return $this->bacen_url;
    }

    /**
     * @return string
     */
    public function getEmv(): string
    {
        return $this->emv;
    }

}
