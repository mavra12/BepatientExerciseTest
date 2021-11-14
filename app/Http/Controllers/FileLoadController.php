<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\FileLoadService;
use Illuminate\Http\Request;

class FileLoadController extends Controller
{
    /**
     * File Load page content
     *
     * @return View
     */
    public function index()
    {
        return view('file-load-index');
    }

    /**
     * Upload file and process it
     * 1. Get data from file and validate it
     * 2. Show data in table
     *
     * @param Request $request
     * @return View
     */
    public function load(Request $request)
    {
        $request->validate([
            'FileToLoad' => [
                'required',
                'file',
                'mimes:csv,txt',
            ]
        ]);

        $file = $request->file('FileToLoad');
        $fileLoadService = new FileLoadService();

        if(!$fileLoadService->processFile($file)) {
            return response()->json(["message" => "Unable to process file"], 500);
        }

        $dataArray = $fileLoadService->getData();
        $dataSortedArray = $fileLoadService->sortDataByDate($dataArray);
        return view('file-data-content', [
                'data' => $dataSortedArray
        ]);
        
    }
}