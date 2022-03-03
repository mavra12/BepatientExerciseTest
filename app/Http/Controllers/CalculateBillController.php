<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\BillCalculationService;
use Illuminate\Http\Request;

class CalculateBillController extends Controller
{
    /**
     * Calculate page content
     *
     * @return View
     */
    public function index()
    {
        return view('billCalculator.calculate-bill-index');
    }

    /**
     *
     * @param Request $request
     * @return View
     */
    public function load(Request $request)
    {
        $request->validate([
            'EnergyUnits' => [
                'required'
            ]
        ]);

        $energyUnits = $request->EnergyUnits;
        $energyBillCalculationService = new BillCalculationService();

        $totalBill = $energyBillCalculationService->calculateBill($energyUnits);

        return view('billCalculator.calculate-bill-content', [
                'totalBill' => $totalBill
        ]);
        
    }
}