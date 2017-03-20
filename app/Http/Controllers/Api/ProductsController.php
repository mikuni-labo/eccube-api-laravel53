<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiTestController extends Controller
{
    private $request;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        dd($this->request);
    }

}
