<?php

namespace PagHipperSDK\Entities;

use PagHipperSDK\Helpers;

class Payer implements \JsonSerializable
{
    /**
     * E-mail valido do cliente pagador
     * REQUIRED.
     *
     * @var string
     */
    protected $payer_email;

    /**
     * Nome ou Razão social do cliente pagador
     * REQUIRED.
     *
     * @var string
     */
    protected $payer_name;

    /**
     * CPF ou CNPJ do pagador
     * REQUIRED.
     *
     * @var string
     */
    protected $payer_cpf_cnpj;

    /**
     * Número de telefone ou celular do cliente DDD + NUMERO.
     *
     * @var int
     */
    protected $payer_phone;

    /**
     * Endereço do cliente pagador.
     *
     * @var string
     */
    protected $payer_street;

    /**
     * Número do endereço do cliente pagador.
     *
     * @var int
     */
    protected $payer_number;

    /**
     * Complemento do endereço do cliente pagador.
     *
     * @var string
     */
    protected $payer_complement;

    /**
     * Bairro do cliente pagador.
     *
     * @var string
     */
    protected $payer_district;

    /**
     * Cidade do cliente pagador.
     *
     * @var string
     */
    protected $payer_city;

    /**
     * Estado do cliente pagador.
     *
     * @var string
     */
    protected $payer_state;

    /**
     * CEP do cliente pagador.
     *
     * @var int
     */
    protected $payer_zip_code;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getPayerEmail()
    {
        return $this->payer_email;
    }

    /**
     * @param string $payer_email
     *
     * @return $this
     */
    public function setPayerEmail(string $payer_email)
    {
        $this->payer_email = $payer_email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerName()
    {
        return $this->payer_name;
    }

    /**
     * @param string $payer_name
     *
     * @return $this
     */
    public function setPayerName(string $payer_name)
    {
        $this->payer_name = $payer_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerCpfCnpj()
    {
        return $this->payer_cpf_cnpj;
    }

    /**
     * @param int|string $payer_cpf_cnpj
     *
     * @return $this
     */
    public function setPayerCpfCnpj($payer_cpf_cnpj): Payer
    {
        $this->payer_cpf_cnpj = Helpers::sanitizeNumber($payer_cpf_cnpj);

        return $this;
    }

    /**
     * @return int
     */
    public function getPayerPhone()
    {
        return $this->payer_phone;
    }

    /**
     * @param int|string $payer_phone
     *
     * @return $this
     */
    public function setPayerPhone($payer_phone): Payer
    {
        $this->payer_phone = (int) Helpers::sanitizeNumber($payer_phone);

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerStreet()
    {
        return $this->payer_street;
    }

    /**
     * @param string $payer_street
     *
     * @return $this
     */
    public function setPayerStreet(string $payer_street): Payer
    {
        $this->payer_street = $payer_street;

        return $this;
    }

    /**
     * @return int
     */
    public function getPayerNumber()
    {
        return $this->payer_number;
    }

    /**
     * @param int|string $payer_number
     *
     * @return $this
     */
    public function setPayerNumber($payer_number): Payer
    {
        $this->payer_number = Helpers::sanitizeNumber($payer_number);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPayerComplement()
    {
        return $this->payer_complement;
    }

    /**
     * @param string|null $payer_complement
     *
     * @return Payer
     */
    public function setPayerComplement(?string $payer_complement): Payer
    {
        $this->payer_complement = $payer_complement;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerDistrict()
    {
        return $this->payer_district;
    }

    /**
     * @param string $payer_district
     *
     * @return $this
     */
    public function setPayerDistrict(string $payer_district): Payer
    {
        $this->payer_district = $payer_district;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerCity()
    {
        return $this->payer_city;
    }

    /**
     * @param string $payer_city
     *
     * @return $this
     */
    public function setPayerCity(string $payer_city): Payer
    {
        $this->payer_city = $payer_city;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayerState()
    {
        return $this->payer_state;
    }

    /**
     * @param string $payer_state
     *
     * @return $this
     */
    public function setPayerState(string $payer_state): Payer
    {
        $this->payer_state = $payer_state;

        return $this;
    }

    /**
     * @return int
     */
    public function getPayerZipCode()
    {
        return $this->payer_zip_code;
    }

    /**
     * @param string|int $payer_zip_code
     *
     * @return $this
     */
    public function setPayerZipCode($payer_zip_code): Payer
    {
        $this->payer_zip_code = (int) Helpers::sanitizeNumber($payer_zip_code);

        return $this;
    }
}
