<?php

namespace App\Tools;

interface CostCorrector extends CostGetter
{
    public function setCost(Price $price);
}
