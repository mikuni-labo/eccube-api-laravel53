<?php

namespace App\Http\Controllers\Sample\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EccubeApiController extends Controller
{
    private $request;
    
    public function __construct(Request $Request)
    {
        $this->request = $Request;
    }

    public function index()
    {
        return view('sample.api.index');
    }

}
