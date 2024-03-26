<?php

namespace App\Tools;

trait Cost
{
    private ?float $cost;

    private ?float $foreignCurrencyCost;

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function getForeignCurrencyCost(): ?float
    {
        return $this->foreignCurrencyCost;
    }

    public function setCost(CurrencyExchange $ce)
    {
        return $this->cost / $ce->receiveRates()['USD'];
    }
}
