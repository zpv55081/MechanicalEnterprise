<?php

namespace App;

use App\Tools\Cargo;
use App\Tools\CostCorrector;
use App\Tools\CostGetter;
use App\Tools\StorageMaterial;

/**
 * техническая жидкость
 */
class TechnicalLiquid implements
    Cargo,
    StorageMaterial,
    CostGetter,
    CostCorrector,
    Tools\Product
{
    use Tools\Cost;

    /**
     * Плотность вещества
     */
    private ?float $density;

    /**
     * Объём 
     */
    private ?float $volume;

    /**
     * Дата производства
     */
    private string $productionDate;

    protected function getDensity(): ?float
    {
        return $this->density;
    }

    protected function getVolume(): ?float
    {
        return $this->volume;
    }

    public function setDensity(?float $density): TechnicalLiquid
    {
        $this->density = $density;

        return $this;
    }

    public function setVolume(?float $volume): TechnicalLiquid
    {
        $this->volume = $volume;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->density * $this->volume;
    }

    public function getProductionDate(): string
    {
        return $this->productionDate;
    }
}
