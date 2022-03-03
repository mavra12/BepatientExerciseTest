<?php
namespace App\Services;

class WordCountingService
{
    /**
     * Create a new wordCounting instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * param string $searchString
     * 
     * return array
     */
    public static function countWords(string $searchString)
    {
        $input = str_replace(' ', '', $searchString);

        $characters = str_split($input);

        $outputs = [];

        foreach ($characters as $char)
        {
            if(!isset($outputs[$char])){
                $outputs[$char] = 1;
            } else {
                $outputs[$char] += 1;
            }
        }

        return $outputs;
    }
}      

