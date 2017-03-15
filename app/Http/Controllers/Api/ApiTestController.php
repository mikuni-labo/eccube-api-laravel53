<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiTestController extends Controller
{
    private $request;
    
    public function __construct(Request $Request)
    {
        $this->request = $Request;
    }

    public function index()
    {
        dd($this->request);
    }

}
