<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Cors implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do nothing before the controller is executed
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Set CORS headers
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        
        // Handle OPTIONS request
        if ($request->getMethod() === 'options') {
            $response->setStatusCode(200);
            $response->setBody('');
        }
        
        return $response;
    }
}
