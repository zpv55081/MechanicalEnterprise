<?php

namespace App\Tools;

/**
 * Складской материал
 */
interface StorageMaterial
{
    public function getWeight(): ?float;
}
