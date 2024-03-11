<?php

namespace App\Tools;

interface Product
{
    public function setCost(\App\Tools\Price $price);

    public function getCost(): ?float;

    public function getProductionDate(): string;
}
