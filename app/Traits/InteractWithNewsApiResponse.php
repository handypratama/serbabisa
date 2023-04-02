<?php 

namespace App\Traits;

trait InteractWithNewsApiResponse
{
     /**
     * Decode corresponsdingly the response
     * @return stdClass
     */
    public function decodeResponse($response)
    {
        $decodeResponse = json_decode($response);
        return $decodeResponse->data ?? $decodeResponse;

    }
    public function checkIfErrorResponse()
    {
        if(isset($response->error)){
            throw new \Exception("Something failed:{$response->error}");
        }
    }


}




?>