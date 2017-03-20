<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customers\TestRequest;

class CustomersController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(TestRequest $TestRequest)
    {
        $this->request = new TestRequest();
        dd($this->request->getValidatorInstance());
    }

}
