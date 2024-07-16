<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Customer::query(); // Get all customers
        $sortField = request("sort_field", "customer_name");
        $sortDirection = request("sort_direction", "asc");
    
        if (request("name")){
            $query->where("customer_name", "LIKE", "%".request("name")."%");
        }
        if (request("town")) {
            $query->whereHas('town', function($q) {
                $q->where('town_name', 'LIKE', '%' . request('town') . '%');
            });
        }
    
        // Handle sorting fields
        if ($sortField === 'town') {
            $query->join('towns', 'customers.town_id', '=', 'towns.town_id')
                  ->select('customers.*')
                  ->orderBy('towns.town_name', $sortDirection);
        } elseif ($sortField === 'customer_type') {
            $query->join('customer_types', 'customers.customer_type_id', '=', 'customer_types.customer_type_id')
                  ->select('customers.*')
                  ->orderBy('customer_types.customer_type_name', $sortDirection);
        } else {
            $query->orderBy($sortField, $sortDirection);
        }
    
        // Paginate customers
        $customers = $query->paginate(10)->onEachSide(1);
    
        return inertia('Customers/Index', [
            "customers" => CustomerResource::collection($customers),
            'queryParams' => request()->query() ?: null,
        ]);
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }
        

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
