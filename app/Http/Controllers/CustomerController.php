<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('company_name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('responsible_person') && $request->responsible_person != '') {
            $query->where('responsible_person', $request->responsible_person);
        }

        if ($request->has('position') && $request->position != '') {
            $query->where('position', $request->position);
        }

        $customers = $query->get();

        return view('customers.index', compact('customers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:customers,email',
            'responsible_person' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'responsible_phone' => 'required|string|max:20',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Müştəri uğurla əlavə edildi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'responsible_person' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'responsible_phone' => 'required|string|max:20',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Müştəri uğurla yeniləndi!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Müştəri silindi!');
    }

}
