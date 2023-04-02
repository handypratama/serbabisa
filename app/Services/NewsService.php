<?php

namespace App\Services;

use App\Traits\ConsumeExternalServices;
use App\Traits\InteractWithNewsApiResponse;


class NewsService
{

    use ConsumeExternalServices,InteractWithNewsApiResponse;
    
    /**
     * The URL to send the requests
     * @var string
     */
    protected $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.news.base_uri');
    }

    
    /**
     * Obtains all top news from Indonesia
     * @return stdClass 
    */

    public function getIndonesia()
    {
        return $this->makeRequest('GET','top-headlines','country=id'.'&apiKey='.config('services.news.api_key'));

    }








    
}

?>