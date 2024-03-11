<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceKind;
use App\Models\VehicleCategory;
use App\Services\CommercialOffer;
use App\Services\Maintenance;
use App\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UIController extends Controller
{
    /**
     * Сформировать коммерческое предложение
     * 
     * @param Request $request
     * @param CommercialOffer $commercialOffer
     * 
     * @throws ValidationException
     * 
     * @return ?string коммерческое предложение
     * 
     * @todo огранизовать view ком. предложения
     * 
     * @todo организовать нормальное отображение 
     * ошибок (в т.ч. валидации)
     */
    protected function generateCommercialOffer(
        Request $request,
        CommercialOffer $commercialOffer
    ): ?string {

        $validatedRequest = $request->validate([
            'kind' => 'alpha',
            'category' => 'alpha',
        ]);
        $requestedMaintenanceKind = $validatedRequest['kind'];
        $requestedVehicleCategory = $validatedRequest['category'];

        $veh = $this->defineVehicle($requestedVehicleCategory);
        
        // $wg = $veh->getWeight();   
        
        $maKin = MaintenanceKind::where(
            'code',
            $requestedMaintenanceKind
        )->first();

        $maintenance = new Maintenance;
        $maintenance->setMaintenanceKind($maKin)->setVehicle($veh);

        try {
            return $commercialOffer->generate(
                Carbon::now('UTC')->timestamp,
                $maintenance,
                null
            );
        } catch (Exception $e) {
            return 'Problem: ' . $e->getMessage();
        }
    }

    /**
     * Определить транспортное средство
     * @param string $vehicleCategoryCode символьный код категории ТС
     * @return Vehicle
     */
    private function defineVehicle(string $vehicleCategoryCode)
    {
        return new Vehicle(VehicleCategory::where(
            'code',
            $vehicleCategoryCode
        )->first());
    }
}
