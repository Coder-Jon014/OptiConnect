<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomersExport implements FromQuery, WithHeadings, ShouldAutoSize
{
    public function query()
    {
        return Customer::query()
            ->join('towns', 'customers.town_id', '=', 'towns.town_id')
            ->join('customer_types', 'customers.customer_type_id', '=', 'customer_types.customer_type_id')
            ->select('customers.customer_id', 'customers.customer_name', 'customers.telephone', 'towns.town_name as town_name', 'customer_types.customer_type_name as customer_type_name')
            ->orderBy('customers.customer_id', 'asc');
    }

    public function headings(): array
    {
        return [
            'Customer ID',
            'Customer Name',
            'Telephone',
            'Town',
            'Customer Type'
        ];
    }
}
