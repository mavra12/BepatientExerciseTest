<?php
namespace App\Services;
use GuzzleHttp\Client;

class VideoSearchService
{
    /**
     * GuzzleHttp client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;
    /**
     * Create a new VideoSearchService instance.
     *
     * @return void
     */
    public function __construct(Client $client = null)
    
    {
        //Set the client
        $this->client = $client ?: new Client();
    }

    /**
     * param string $searchString
     * param string $channelName
     * 
     * return json
     */
    public function searchVideos(string $searchString, string $channelName)
    {
        $headers = [
            'Content-type' => 'application/json',
            'Accept' => 'application/json'
        ];

        $response = $this->client->request('GET', 'https://api.dailymotion.com/videos/?channel='.$channelName.'&search=%22'.$searchString.'%22&page=1&limit=15', [
            'headers' => $headers
        ]);

        return json_decode($response->getBody(), true);
        

	}

    


}      

