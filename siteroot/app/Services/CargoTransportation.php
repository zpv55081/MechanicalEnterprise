<?php

namespace App\Services;

/**
 * Грузоперевозка
 * 
 * (собирает и предоставляет сведения о перевозке груза)
 */

class CargoTransportation implements Estimate
{
    /**
     * Вычислить смету грузоперевозки 
     */
    public function evaluate(): array
    {
        return [];
    }
}
