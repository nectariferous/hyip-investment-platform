<?php

namespace PagHipperSDK\Response\Shared;

class BankSlip
{
    /**
     * @var string
     */
    protected $digitable_line;

    /**
     * @var string
     */
    protected $url_slip;

    /**
     * @var string
     */
    protected $url_slip_pdf;

    /**
     * Setta os objetos do bankSlip
     *
     * @param array $data
     * @return BankSlip
     */
    public static function populate(array $data)
    {
        $self = new self();
        $self->digitable_line = $data['digitable_line'];
        $self->url_slip = $data['url_slip'];
        $self->url_slip_pdf = $data['url_slip_pdf'];

        return $self;
    }

    /**
     * @return string
     */
    public function getDigitableLine(): string
    {
        return $this->digitable_line;
    }

    /**
     * @return string
     */
    public function getUrlSlip(): string
    {
        return $this->url_slip;
    }

    /**
     * @return string
     */
    public function getUrlSlipPdf(): string
    {
        return $this->url_slip_pdf;
    }
}
