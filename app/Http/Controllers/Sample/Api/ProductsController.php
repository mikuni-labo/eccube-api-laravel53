<?php

namespace App\Http\Controllers\Sample\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        dd('here');
//         return view('sample.api.index');
    }

}
