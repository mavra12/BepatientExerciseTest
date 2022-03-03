<?php
namespace App\Services;

class BillCalculationService
{
    /**
     * Create a new BillCalculationService instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * params $unit -energyUnits
	 * 
	 * return float
     */
    public function calculateBill(int $units)
    {
        $first_unit_cost = 0.20;
        $second_unit_cost = 0.50;
        $third_unit_cost = 0.70;
        $fourth_unit_cost = 0.90;
    
        if($units <= 50) {
			$bill = $units * $first_unit_cost;
		}
		else if($units > 50 && $units <= 100) {
			$temp = 50 * $first_unit_cost;
			$remaining_units = $units - 50;
			$bill = $temp + ($remaining_units * $second_unit_cost);
		}
		else if($units > 100 && $units <= 100) {
			$temp = (50 * $first_unit_cost) + (100 * $second_unit_cost);
			$remaining_units = $units - 100;
			$bill = $temp + ($remaining_units * $third_unit_cost);
		}
		else {
			$temp = (50 * $first_unit_cost) + (100 * $second_unit_cost) + (100 * $third_unit_cost);
			$remaining_units = $units - 250;
			$bill = $temp + ($remaining_units * $fourth_unit_cost);
		}
		return number_format((float)$bill, 2, '.', '');
	}
}      

