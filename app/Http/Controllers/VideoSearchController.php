<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\VideoSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideoSearchController extends Controller
{
    protected $postFieldsArray;
    
    public function __construct() {        
        $this->postFieldsArray = request()->post();        
    }

    /**
     * video Search page content
     *
     * @return View
     */
    public function index()
    {
        return view('videoSearch.video-search-index');
    }

    /**
     *
     * @param Request $request
     * @return View
     */
    public function load(Request $request)
    {

        $rules = [
            'channelName' => 'in:"lifestyle", "auto", "videogames", "music", "news"',
           ];


        $validator = Validator::make($this->postFieldsArray, $rules);
        
        if ($validator->fails()) {
            return response()->json(["message" => "Only channel names 'lifestyle', 'auto','videogames', 'music' and 'news' are allowed."], 500);
        }

        $searchString = $request->searchString;
        $channelName = $request->channelName;

        $videoSearchService = new VideoSearchService();

        $body = $videoSearchService->searchVideos($searchString, $channelName);

        return view('videoSearch.video-search-content', [
                'searchString' => $body
        ]);
        
    }
}