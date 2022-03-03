<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\WordCountingService;
use Illuminate\Http\Request;

class WordCountController extends Controller
{
    
    /**
     * Calculate page content
     *
     * @return View
     */
    public function index()
    {
        return view('wordCounter.word-count-index');
    }

    /**
     *
     * @param Request $request
     * @return View
     */
    public function load(Request $request)
    {
        $requestData = $request->validate( 
            ['searchString' => 'required|string|max:200']);

        $searchString = $request->searchString;

        $wordCountingService = new WordCountingService();

        $output = $wordCountingService::countWords($searchString);

        return view('wordCounter.word-count-content', [
                'output' => $output
        ]);
        
    }
}