<?php

namespace App;

use App\Tools\Cargo;
use App\Tools\CostGetter;
use App\Tools\StorageMaterial;

/**
 * Запчасть
 */
class Part implements
    Cargo,
    StorageMaterial,
    CostGetter
{
    use Tools\Cost;

    /**
     * Масса запчасти
     */
    private float $weight;

    /**
     * Артикул
     */
    private string $vendorCode;

    /**
     * Стоимость
     */
    private $cost;

    protected function getVendorCode(): string
    {
        return $this->vendorCode;
    }

    protected function setVendorCode($vendorCode): ?bool
    {
        if ($this->vendorCode = $vendorCode) {
            return true;
        };
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }
}
