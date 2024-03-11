<?php

namespace App\Tools;

interface CostGetter
{
    public function getCost(): ?float;

    public function getForeignCurrencyCost(): ?float;
}
