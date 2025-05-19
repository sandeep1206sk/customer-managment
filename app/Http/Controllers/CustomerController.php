<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;

class CustomerController extends Controller
{
    public function index()
    {
        // Sirf un customers ko fetch karein jinke paas due_amount > 0 ho
        $customers = Customer::where('due_amount', '>', 0)->get();
    
        // Total Amount aur Due Amount ka SUM nikalna
        $totalAmountSum = Customer::sum('total_amount'); // Pure Table ka sum
        $dueAmountSum = Customer::sum('due_amount'); // Due ka sum
    
        return view('customers.index', compact('customers', 'totalAmountSum', 'dueAmountSum'));
    }

    public function noDueCustomers()
{
    $customers = Customer::where('due_amount', 0)->get();
    return view('customers.complate_customer', compact('customers'));
}

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Customer Create
        $customer = Customer::create($request->all());
    
        // Payment Table Me Bhi Entry Karein
        Payment::create([
            'customer_id'     => $customer->id,
            'received_amount' => $customer->total_amount - $customer->due_amount,
            'payment_date'    => now(), // Current Date
            'payment_method'  => 'Online',
        ]);
    
        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function updatePayment(Request $request, Customer $customer)
    {
        $payment = Payment::create([
            'customer_id' => $customer->id,
            'received_amount' => $request->received_amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
        ]);

        $customer->due_amount -= $request->received_amount;
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Payment updated successfully.');
    }

    public function Payment_history($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        $payments = Payment::where('customer_id', $customer_id)->orderBy('payment_date', 'desc')->get();
        return view('payments.index', compact('customer', 'payments'));
    }
}

