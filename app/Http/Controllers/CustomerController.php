<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json((new CustomerCollection(Customer::paginate(50)))->response()->getData(), Response::HTTP_OK);
    }

    /**
     * Display the specified customer.
     *
     * @param  Customer $customer
     * @return JsonResponse
     */
    public function show(Customer $customer)
    {
        return response()->json(new CustomerResource($customer), Response::HTTP_OK);
    }
}
