<?php

namespace App\Services;

use App\Models\MaintenanceKind;
use App\Models\MaintenanceSpecification;
use App\Vehicle;

/**
 * Техническое обслуживание ТС
 * 
 * @param MaintenanceKind $maintenanceKind вид обслуживания
 * @param Vehicle $vehicle транспортное средство
 * 
 * (собирает и предоставляет сведения о ТО ТС)
 */

class Maintenance implements Estimate
{
    private MaintenanceKind $maintenanceKind;

    private Vehicle $vehicle;

    public function setMaintenanceKind(MaintenanceKind $maKin) :Maintenance
    {
        $this->maintenanceKind = $maKin;

        return $this;
    }

    public function setVehicle(Vehicle $veh) :Maintenance
    {
        $this->vehicle = $veh;

        return $this;
    }

    /**
     * Вычислить смету техобслуживания 
     * 
     * (бизнес-логика)
     * 
     * @todo ценообразование
     */
    public function evaluate(): array
    {
        $vehicleCategoryId = $this->vehicle->getCategory()->id;
        $maintenanceKindCode = $this->maintenanceKind->code;

        $maint_specif = MaintenanceSpecification::select(
            'catalog.name',
            'maintenance_specifications.quantity',
            'units.designation'
        )
            ->join('catalog', 'maintenance_specifications.catalog_id', '=', 'catalog.id')
            ->join('units', 'maintenance_specifications.units_id', '=', 'units.id')
            ->where([
                'maintenance_kinds_code' => $maintenanceKindCode,
                'vehicle_categories_id' => $vehicleCategoryId
            ])
            ->get()
            ->toArray();
        
        return $maint_specif;
    }
}
