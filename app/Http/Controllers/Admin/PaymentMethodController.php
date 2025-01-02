<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::all();
        return view('admin.payment-methods', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment_methods-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'details' => 'nullable|string',
        ]);

        PaymentMethod::create($request->all());

        return redirect()->route('admin.payment-methods')->with('success', 'Payment method added successfully.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods-edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'details' => 'nullable|string',
        ]);

        $paymentMethod->update($request->all());

        return redirect()->route('admin.payment-methods')->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods')->with('success', 'Payment method deleted successfully.');
    }


    public function checkout()
    {
        $paymentMethods = PaymentMethod::all(); // Fetch all payment methods
        return view('checkout', compact('paymentMethods'));
    }
}

