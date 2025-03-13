<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ResponseController extends BaseController
{
    public function index()
    {
        return view('servicedesk/response');
    }
}
