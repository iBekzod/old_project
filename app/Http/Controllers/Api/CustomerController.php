<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CustomerResource;
use App\Customer;

class CustomerController extends Controller
{
    public function show($id)
    {
        return new CustomerResource(Customer::find($id));
    }
}
