<?php

namespace PagHipperSDK\Entities;

use PagHipperSDK\Helpers;

class Item implements \JsonSerializable
{
    /**
     * Id do item.
     *
     * @var string
     */
    protected $item_id;

    /**
     * Item description.
     *
     * @var string
     */
    protected $description;

    /**
     * Quantidade de itens.
     *
     * @var int
     */
    protected $quantity;

    /**
     * Preço do produto.
     *
     * @var int
     */
    protected $price_cents;

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param string $item_id
     *
     * @return $this
     */
    public function setItemId(string $item_id): Item
    {
        $this->item_id = $item_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description): Item
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int|string $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity): Item
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriceCents()
    {
        return $this->price_cents;
    }

    /**
     * @param float $price_cents
     *
     * @return $this
     */
    public function setPriceCents(?float $price_cents): Item
    {
        $this->price_cents = Helpers::decimalToCents($price_cents);

        return $this;
    }
}
