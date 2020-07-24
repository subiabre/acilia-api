<?php

namespace App\Service;

/**
 * Converts values in one currency to another,
 * built using the https://exchangeratesapi.io/ API
 */
class CurrencyConverter
{
    const API = 'https://api.exchangeratesapi.io/latest';

    /**
     * @var float Amount of base currency
     */
    private $value;

    /**
     * @var string Base currency abbreviation
     */
    private $base;

    /**
     * @var array Target currency abbreviations
     */
    private $symbols = [];

    /**
     * Set the base to exchange from
     * @param float $value Amount of the currency
     * @param string $currency Currency abbreviation
     */
    public function from(float $value, string $currency): self
    {
        $this->value = $value;
        $this->base = $currency;

        return $this;
    }

    /**
     * Add to the list of target currencies to exchange to
     * @param string $currency Currency abbreviation
     */
    public function to(string $currency): self
    {
        \array_push($this->symbols, $currency);

        return $this;
    }

    /**
     * Join the path to the endpoint with the appropriate data
     * @return string
     */
    public function getApi(): string
    {
        $base = $this->base;
        $symbols = \implode(',', $this->symbols);

        return self::API . "?base=$base&symbols=$symbols";
    }
}
