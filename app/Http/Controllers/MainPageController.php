<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    
    /**
     * Calculate page content
     *
     * @return View
     */
    public function index()
    {
        return view('main-page-index');
    }
}