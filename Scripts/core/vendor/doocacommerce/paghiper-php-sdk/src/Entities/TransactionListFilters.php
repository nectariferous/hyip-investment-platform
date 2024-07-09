<?php

namespace PagHipperSDK\Entities;

use PagHipperSDK\Auth;
use PagHipperSDK\Helpers;

class TransactionListFilters implements \JsonSerializable
{
    /**
     * Api key para autenticação.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Token para autenticação.
     *
     * @var string
     */
    protected $token;

    /**
     * Filtro por status do pedido.
     *
     * @var string
     */
    protected $status;

    /**
     * Filtro por data inicial.
     *
     * @example 2018-01-01
     *
     * @var string
     */
    protected $initial_date;

    /**
     * Filtro por data final.
     *
     * @example 2018-01-01
     *
     * @var string
     */
    protected $final_date;

    /**
     * Tipo do filtro de data.
     *
     * @var string <create_date|paid_date>
     */
    protected $filter_date;

    /**
     * Data de vencimento do boleto.
     *
     * @example 2018-01-17
     *
     * @var string
     */
    protected $due_date;

    /**
     * Código de referência da venda.
     *
     * @var string
     */
    protected $order_id;

    /**
     * Buscar pelo valor da transação.
     *
     * @var int
     */
    protected $value_cents;

    /**
     * Tipo de filtro.
     *
     * @var string - Possíveis valores =, >=, <=, >, <
     */
    protected $value_cents_filter;

    /**
     * Limitar número de transações retornadas (max 100).
     *
     * @var int
     */
    protected $limit;

    /**
     * Página do resultado.
     *
     * @var int
     */
    protected $page;

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        $this->setApiKey();
        $this->setToken();

        return get_object_vars($this);
    }

    /**
     * Setta a API key pela Auth.
     */
    protected function setApiKey(): void
    {
        $this->apiKey = Auth::getApiKey();
    }

    /**
     * Setta o token pela Auth.
     */
    protected function setToken(): void
    {
        $this->token = Auth::getToken();
    }

    /**
     * @param string $status
     *
     * @return TransactionListFilters
     */
    public function setStatus(string $status): TransactionListFilters
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $initial_date
     *
     * @return TransactionListFilters
     */
    public function setInitialDate(string $initial_date): TransactionListFilters
    {
        $this->initial_date = $initial_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getInitialDate()
    {
        return $this->initial_date;
    }

    /**
     * @param string $final_date
     *
     * @return TransactionListFilters
     */
    public function setFinalDate(string $final_date): TransactionListFilters
    {
        $this->final_date = $final_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getFinalDate()
    {
        return $this->final_date;
    }

    /**
     * @param string $filter_date
     *
     * @return TransactionListFilters
     */
    public function setFilterDate(string $filter_date): TransactionListFilters
    {
        $this->filter_date = $filter_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilterDate()
    {
        return $this->filter_date;
    }

    /**
     * @param string $due_date
     *
     * @return TransactionListFilters
     */
    public function setDueDate(string $due_date): TransactionListFilters
    {
        $this->due_date = $due_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->due_date;
    }

    /**
     * @param string $order_id
     *
     * @return TransactionListFilters
     */
    public function setOrderId(string $order_id): TransactionListFilters
    {
        $this->order_id = $order_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param float|null $value_cents
     *
     * @return TransactionListFilters
     */
    public function setValueCents(?float $value_cents): TransactionListFilters
    {
        $this->value_cents = Helpers::decimalToCents($value_cents);

        return $this;
    }

    /**
     * @return int
     */
    public function getValueCents()
    {
        return $this->value_cents;
    }

    /**
     * @param string $value_cents_filter
     *
     * @return TransactionListFilters
     */
    public function setValueCentsFilter(string $value_cents_filter): TransactionListFilters
    {
        $this->value_cents_filter = $value_cents_filter;

        return $this;
    }

    /**
     * @return string
     */
    public function getValueCentsFilter()
    {
        return $this->value_cents_filter;
    }

    /**
     * @param int $limit
     *
     * @return TransactionListFilters
     */
    public function setLimit(int $limit): TransactionListFilters
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $page
     *
     * @return TransactionListFilters
     */
    public function setPage(int $page): TransactionListFilters
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }
}
