<?php

namespace App\Services;

/**
 * Интерфейс Смета
 */
interface Estimate
{
    /**
     * Вычислить
     */
    public function evaluate(): array;
}
