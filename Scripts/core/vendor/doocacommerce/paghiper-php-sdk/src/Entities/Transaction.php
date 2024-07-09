<?php

namespace PagHipperSDK\Entities;

use PagHipperSDK\Auth;
use PagHipperSDK\Exception\ValidationException;
use PagHipperSDK\Helpers;

class Transaction implements \JsonSerializable
{
    /**
     * Api key para autenticação
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Token para autenticação
     *
     * @var string
     */
    protected $token;

    /**
     * Id da transacão, utilizado para consultar
     *
     * @var string
     */
    protected $transaction_id;

    /*
     * Id da notificação, utilizado para consultar notificações
     *
     * @var string
     */
    protected $notification_id;

    /**
     * Utilizado para cancelar transação
     *
     * @var string
     */
    protected $status;

    /*
     * Define um código para referenciar o pagamento
     * REQUIRED
     *
     * @var string
     */
    protected $order_id;

    /**
     * E-mail valido do cliente pagador
     * REQUIRED
     *
     * @var string
     */
    protected $payer_email;

    /**
     * Nome ou Razão social do cliente pagador
     * REQUIRED
     *
     * @var string
     */
    protected $payer_name;

    /**
     * CPF ou CNPJ do pagador
     * REQUIRED
     *
     * @var string
     */
    protected $payer_cpf_cnpj;

    /**
     * Número de telefone ou celular do cliente DDD + NUMERO
     *
     * @var integer
     */
    protected $payer_phone;

    /**
     * Endereço do cliente pagador.
     *
     * @var string
     */
    protected $payer_street;

    /**
     * Número do endereço do cliente pagador
     *
     * @var integer
     */
    protected $payer_number;

    /**
     * Complemento do endereço do cliente pagador
     *
     * @var string
     */
    protected $payer_complement;

    /**
     * Bairro do cliente pagador
     *
     * @var string
     */
    protected $payer_district;

    /**
     * Cidade do cliente pagador
     *
     * @var string
     */
    protected $payer_city;

    /**
     * Estado do cliente pagador
     *
     * @var string
     */
    protected $payer_state;

    /**
     * CEP do cliente pagador
     *
     * @var integer
     */
    protected $payer_zip_code;

    /**
     * Dias corridos até o vencimento
     * REQUIRED
     *
     * @var integer
     */
    protected $days_due_date;

    /**
     * Formato do boleto bancário
     * REQUIRED
     *
     * @var string
     */
    protected $type_bank_slip = 'boletoA4';

    /**
     * URL de retorno automático de dados
     *
     * @var string
     */
    protected $notification_url;

    /**
     * Valor total do desconto da compra em centavos
     *
     * @var integer
     */
    protected $discount_cents;

    /**
     * Valor total do frete em centavos
     *
     * @var integer
     */
    protected $shipping_price_cents;

    /**
     * Método de entrega
     *
     * @var string
     */
    protected $shipping_methods;

    /**
     * Id do parceiro
     *
     * @var string
     */
    protected $partners_id;

    /**
     * Número da nota fiscal
     *
     * @var string
     */
    protected $number_ntfiscal;

    /**
     * Frase fixa
     *
     * @var boolean
     */
    protected $fixed_description;

    /**
     * Percentual da multa
     *
     * @var integer
     */
    protected $late_payment_fine;

    /**
     * Juros por atraso
     *
     * @var boolean
     */
    protected $per_day_interest;

    /**
     * Número de dias em que o pagamento pode ser realizado com antecedência recebendo o desconto extra.
     *
     * @var integer
     */
    protected $early_payment_discounts_days;

    /**
     * Valor do desconto em centavos que será aplicado caso o pagamento ocorra de forma antecipada.
     *
     * @var integer
     */
    protected $early_payment_discounts_cents;

    /**
     * Número máximo de dias em que o boleto poderá ser pago após o vencimento
     *
     * @var integer
     */
    protected $open_after_day_due;

    /**
     * Array de items
     * REQUIRED
     *
     * @var Item[]
     */
    protected $items;

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
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transaction_id;
    }

    /**
     * @param string $transaction_id
     * @return $this
     */
    public function setTransactionId(string $transaction_id): Transaction
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationId(): string
    {
        return $this->notification_id;
    }

    /**
     * @param $notification_id
     * @return $this
     */
    public function setNotificationId(string $notification_id): Transaction
    {
        $this->notification_id = $notification_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->order_id;
    }

    /**
     * @param string $order_id
     * @return $this
     */
    public function setOrderId($order_id): Transaction
    {
        $this->order_id = (string) $order_id;

        return $this;
    }

    /**
     * @param Payer $payer
     * @return $this
     */
    public function setPayer(Payer $payer): Transaction
    {
        $this->payer_email = $payer->getPayerEmail();
        $this->payer_name = $payer->getPayerName();
        $this->payer_cpf_cnpj = $payer->getPayerCpfCnpj();
        $this->payer_phone = $payer->getPayerPhone();
        $this->payer_street = $payer->getPayerStreet();
        $this->payer_number = $payer->getPayerNumber();
        $this->payer_complement = $payer->getPayerComplement();
        $this->payer_district = $payer->getPayerDistrict();
        $this->payer_city = $payer->getPayerCity();
        $this->payer_state = $payer->getPayerState();
        $this->payer_zip_code = $payer->getPayerZipCode();

        return $this;
    }

    /**
     * @return int
     */
    public function getDaysDueDate()
    {
        return $this->days_due_date;
    }

    /**
     * @param int $days_due_date
     * @return $this
     */
    public function setDaysDueDate($days_due_date): Transaction
    {
        $this->days_due_date = (int) $days_due_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getTypeBankSlip()
    {
        return $this->type_bank_slip;
    }

    /**
     * @param string $type_bank_slip
     * @return $this
     */
    public function setTypeBankSlip(string $type_bank_slip): Transaction
    {
        $this->type_bank_slip = $type_bank_slip;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationUrl()
    {
        return $this->notification_url;
    }

    /**
     * @param string $notification_url
     * @return $this
     */
    public function setNotificationUrl(string $notification_url): Transaction
    {
        $this->notification_url = $notification_url;

        return $this;
    }

    /**
     * @return integer
     */
    public function getDiscountCents()
    {
        return $this->discount_cents;
    }

    /**
     * @param float $discount_cents
     * @return $this
     */
    public function setDiscountCents(?float $discount_cents): Transaction
    {
        $this->discount_cents = Helpers::decimalToCents($discount_cents);

        return $this;
    }

    /**
     * @return int
     */
    public function getShippingPriceCents()
    {
        return $this->shipping_price_cents;
    }

    /**
     * @param float $shipping_price_cents
     * @return $this
     */
    public function setShippingPriceCents(?float $shipping_price_cents): Transaction
    {
            $this->shipping_price_cents = Helpers::decimalToCents($shipping_price_cents);

        return $this;
    }

    /**
     * @return string
     */
    public function getShippingMethods()
    {
        return $this->shipping_methods;
    }

    /**
     * @param string $shipping_methods
     * @return $this
     */
    public function setShippingMethods(string $shipping_methods): Transaction
    {
        $this->shipping_methods = $shipping_methods;

        return $this;
    }

    /**
     * @return string
     */
    public function getPartnersId()
    {
        return $this->partners_id;
    }

    /**
     * @param string $partners_id
     * @return $this
     */
    public function setPartnersId(string $partners_id): Transaction
    {
        $this->partners_id = $partners_id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getNumberNtfiscal()
    {
        return $this->number_ntfiscal;
    }

    /**
     * @param int $number_ntfiscal
     * @return $this
     */
    public function setNumberNtfiscal(int $number_ntfiscal): Transaction
    {
        $this->number_ntfiscal = $number_ntfiscal;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFixedDescription()
    {
        return $this->fixed_description;
    }

    /**
     * @param bool $fixed_description
     * @return $this
     */
    public function setFixedDescription(bool $fixed_description): Transaction
    {
        $this->fixed_description = $fixed_description;

        return $this;
    }

    /**
     * @return int
     */
    public function getLatePaymentFine()
    {
        return $this->late_payment_fine;
    }

    /**
     * @param int $late_payment_fine
     * @return $this
     */
    public function setLatePaymentFine($late_payment_fine): Transaction
    {
        $this->late_payment_fine = (int) $late_payment_fine;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPerDayInterest()
    {
        return $this->per_day_interest;
    }

    /**
     * @param bool $per_day_interest
     * @return $this
     */
    public function setPerDayInterest(bool $per_day_interest): Transaction
    {
        $this->per_day_interest = $per_day_interest;

        return $this;
    }

    /**
     * @return int
     */
    public function getEarlyPaymentDiscountsDays()
    {
        return $this->early_payment_discounts_days;
    }

    /**
     * @param int $early_payment_discounts_days
     * @return $this
     */
    public function setEarlyPaymentDiscountsDays(int $early_payment_discounts_days): Transaction
    {
        $this->early_payment_discounts_days = $early_payment_discounts_days;

        return $this;
    }

    /**
     * @return int
     */
    public function getEarlyPaymentDiscountsCents()
    {
        return $this->early_payment_discounts_cents;
    }

    /**
     * @param float $early_payment_discounts_cents
     * @return $this
     */
    public function setEarlyPaymentDiscountsCents(float $early_payment_discounts_cents): Transaction
    {
        $this->early_payment_discounts_cents = $early_payment_discounts_cents;

        return $this;
    }

    /**
     * @return int
     */
    public function getOpenAfterDayDue()
    {
        return $this->open_after_day_due;
    }

    /**
     * @param int $open_after_day_due
     * @return $this
     */
    public function setOpenAfterDayDue(int $open_after_day_due): Transaction
    {
        $this->open_after_day_due = $open_after_day_due;

        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Settar um item
     *
     * @param Item $item
     * @return $this
     */
    public function setItem(Item $item): Transaction
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Settar multiplos items
     *
     * @param array $items
     * @return Transaction
     * @throws ValidationException
     */
    public function setItems(array $items): Transaction
    {
        foreach ($items as $item) {
            if (!($item instanceof Item)) {
                throw new ValidationException('Item must be an instance of Item', 400);
            }

            $this->items[] = $item;
        }

        return $this;
    }

    /**
     * @param string $status
     * @return Transaction
     */
    public function setStatus(string $status): Transaction
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Setta a API key pela Auth
     */
    protected function setApiKey(): void
    {
        $this->apiKey = Auth::getApiKey();
    }

    /**
     * Setta o token pela Auth
     */
    protected function setToken(): void
    {
        $this->token = Auth::getToken();
    }
}
