<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ReturnsHttpResponse
{

    /**
     * Returns a standard response structure.
     * @param  string   $message              The client user friendly message.
     * @param  integer  $status               The integer for the http status you want to use.
     * @param  array    $data                 The optional array of data you want to return (will be converted to json).
     *                                        [ ['type'=> <headertype>, 'value' => <value>, 'force' => <boolean>] ]
     * @return Illuminate\Http\Response
     */
    public function response($message, $status, $data = [], $additionalHeaders = [])
    {
        $content = ['message' => $message, 'data' => $data];
        $response = new Response($content, $status);
        return $response;
    }

}
