<?php

namespace App;

abstract class Apparatus
{
    /**
     * Собственный вес
     * 
     * @var float
     */
    protected float $weight = 100.0;

    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * Задать собственный вес
     */
    abstract protected function setWeight(float $weightsValue): bool;
}
