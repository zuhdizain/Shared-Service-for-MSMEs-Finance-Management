<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        $customer = Customer::all();

        return view('Sales_Apps.pages.customer.index', compact('customer'));
    }

    public function addCustomerpage() {
        return view('Sales_Apps.pages.customer.addCustomer');
    }

    public function addCustomer(Request $request) {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
        ]);

        Customer::create([
            'customer_name' => $validation['name'],
            'customer_email' => $validation['email'],
            'customer_phone' => $validation['phone'],
            'customer_address' => $validation['address'],
        ])->save();

        return redirect()->route('customer.index');
    }

    public function deleteCustomer($id) {
        Customer::findOrFail($id)->delete();

        return redirect()->back();
    }

    public function customerData($id) {
        $customer = Customer::find($id);

        return response($customer);
    }
}
