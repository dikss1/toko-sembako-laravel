<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')->latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:30',
        ]);

        $customer->update($data);

        // sinkronkan nama user juga
        $customer->user->update(['name' => $data['nama']]);

        return redirect()->route('customers.index')->with('success','Customer diupdate.');
    }
}
