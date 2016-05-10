<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

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
