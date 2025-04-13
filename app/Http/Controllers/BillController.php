<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BillController extends Controller
{
    /**
     * Display a listing of the bills.
     */
    public function index()
    {
        $bills = Record::with('client')
            ->where('record_type', 'bill')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($bill) {
                return [
                    'id' => $bill->id,
                    'client_name' => $bill->client->name,
                    'record_number' => $bill->record_number,
                    'start_date' => $bill->start_date->format('Y-m-d'),
                    'end_date' => $bill->end_date->format('Y-m-d'),
                    'purchase_type' => $bill->purchase_type,
                    'status' => $bill->status,
                    'value_after_vat' => number_format($bill->value_after_vat, 2),
                ];
            });

        return Inertia::render('Bills/Index', [
            'bills' => $bills,
        ]);
    }

    /**
     * Show the form for creating a new bill.
     */
    public function create(Request $request)
    {
        $clients = Client::orderBy('name')
            ->get(['id', 'name']);

        $defaultData = [
            'id' => null,
            'client_id' => $request->client_id ?? 0,
            'record_number' => Record::generateNextBillNumber(),
            'start_date' => '',
            'end_date' => '',
            'purchase_type' => '',
            'status' => '',
            'description' => '',
            'unit' => '',
            'quantity' => 1,
            'unit_price' => 0,
            'vat' => 0,
            'mrc_number' => '',
            'cdn_number' => '',
            'record_type' => 'bill'
        ];

        return Inertia::render('Bills/Create', [
            'clients' => $clients,
            'record' => $defaultData,
        ]);
    }

    /**
     * Store a newly created bill in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'record_number' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'purchase_type' => 'required|string|in:goods,services',
            'status' => 'required|string|in:pending,paid,overdue',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:1|max:9999',
            'unit_price' => 'required|numeric|min:0|max:9999.99',
            'vat' => 'required|numeric|min:0|max:100',
            'mrc_number' => 'nullable|string|max:255',
            'cdn_number' => 'nullable|string|max:255',
        ]);

        // Calculate values
        $value = $validated['quantity'] * $validated['unit_price'];
        $vat_amount = $value * ($validated['vat'] / 100);
        $value_after_vat = $value + $vat_amount;

        // Additional check for calculated values
        if ($value > 99999999.99 || $value_after_vat > 99999999.99) {
            return back()->withErrors(['error' => 'Total value exceeds maximum allowed amount'])->withInput();
        }

        $bill = Record::create([
            ...$validated,
            'record_type' => 'bill',
            'value' => $value,
            'value_after_vat' => $value_after_vat,
            'user_id' => Auth::id(),
        ]);

        return Redirect::route('bills.show', $bill)
            ->with('success', 'Bill created successfully.');
    }

    /**
     * Display the specified bill.
     */
    public function show(Record $bill)
    {
        if ($bill->record_type !== 'bill') {
            abort(403);
        }

        $bill->load('client');

        return Inertia::render('Bills/Show', [
            'bill' => $bill,
        ]);
    }

    /**
     * Show the form for editing the specified bill.
     */
    public function edit(Record $bill)
    {
        if ($bill->record_type !== 'bill') {
            abort(403);
        }

        $clients = Client::orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Bills/Edit', [
            'bill' => $bill,
            'clients' => $clients,
        ]);
    }

    /**
     * Update the specified bill in storage.
     */
    public function update(Request $request, Record $bill)
    {
        if ($bill->record_type !== 'bill') {
            abort(403);
        }

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'record_number' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'purchase_type' => 'required|string|in:goods,services',
            'status' => 'required|string|in:pending,paid,overdue',
            'description' => 'nullable|string',
            'unit' => 'required|string|max:50',
            'quantity' => 'required|integer|min:1|max:9999',
            'unit_price' => 'required|numeric|min:0|max:9999.99',
            'vat' => 'required|numeric|min:0|max:100',
            'mrc_number' => 'nullable|string|max:255',
            'cdn_number' => 'nullable|string|max:255',
        ]);

        // Calculate values
        $value = $validated['quantity'] * $validated['unit_price'];
        $vat_amount = $value * ($validated['vat'] / 100);
        $value_after_vat = $value + $vat_amount;

        // Additional check for calculated values
        if ($value > 99999999.99 || $value_after_vat > 99999999.99) {
            return back()->withErrors(['error' => 'Total value exceeds maximum allowed amount'])->withInput();
        }

        $bill->update([
            ...$validated,
            'record_type' => 'bill',
            'value' => $value,
            'value_after_vat' => $value_after_vat,
            'user_id' => Auth::id(),
        ]);

        return Redirect::route('bills.show', $bill)
            ->with('success', 'Bill updated successfully.');
    }

    /**
     * Remove the specified bill from storage.
     */
    public function destroy(Record $bill)
    {
        if ($bill->record_type !== 'bill') {
            abort(403);
        }

        $bill->delete();

        return Redirect::route('bills.index')
            ->with('success', 'Bill deleted successfully.');
    }
} 