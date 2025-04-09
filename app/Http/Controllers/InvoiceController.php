<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index()
    {
        $invoices = Record::with('client')
            ->where('record_type', 'invoice')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'client_name' => $invoice->client->name,
                    'record_number' => $invoice->record_number,
                    'start_date' => $invoice->start_date->format('Y-m-d'),
                    'end_date' => $invoice->end_date->format('Y-m-d'),
                    'purchase_type' => $invoice->purchase_type,
                    'status' => $invoice->status,
                    'value_after_vat' => number_format($invoice->value_after_vat, 2),
                ];
            });

        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(Request $request)
    {
        $clients = Client::orderBy('name')
            ->get(['id', 'name']);

        $defaultData = [
            'record_type' => 'invoice'
        ];
        
        if ($request->has('client_id')) {
            $defaultData['client_id'] = $request->client_id;
        }

        return Inertia::render('Invoices/Create', [
            'clients' => $clients,
            'record' => $defaultData,
        ]);
    }

    /**
     * Store a newly created invoice in storage.
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
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'mrc_number' => 'nullable|string|max:255',
            'cdn_number' => 'nullable|string|max:255',
        ]);

        // Calculate values
        $value = $validated['quantity'] * $validated['unit_price'];
        $vat_amount = $value * ($validated['vat'] / 100);
        $value_after_vat = $value + $vat_amount;

        $invoice = Record::create([
            ...$validated,
            'record_type' => 'invoice',
            'value' => $value,
            'value_after_vat' => $value_after_vat,
        ]);

        return Redirect::route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Record $invoice)
    {
        if ($invoice->record_type !== 'invoice') {
            abort(403);
        }

        $invoice->load('client');

        return Inertia::render('Invoices/Show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Record $invoice)
    {
        if ($invoice->record_type !== 'invoice') {
            abort(403);
        }

        $clients = Client::orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Invoices/Edit', [
            'invoice' => $invoice,
            'clients' => $clients,
        ]);
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Record $invoice)
    {
        if ($invoice->record_type !== 'invoice') {
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
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'vat' => 'required|numeric|min:0',
            'mrc_number' => 'nullable|string|max:255',
            'cdn_number' => 'nullable|string|max:255',
        ]);

        // Calculate values
        $value = $validated['quantity'] * $validated['unit_price'];
        $vat_amount = $value * ($validated['vat'] / 100);
        $value_after_vat = $value + $vat_amount;

        $invoice->update([
            ...$validated,
            'record_type' => 'invoice',
            'value' => $value,
            'value_after_vat' => $value_after_vat,
        ]);

        return Redirect::route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Record $invoice)
    {
        if ($invoice->record_type !== 'invoice') {
            abort(403);
        }

        $invoice->delete();

        return Redirect::route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }
} 