<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Record::with('client')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'client_name' => $record->client->name,
                    'record_number' => $record->record_number,
                    'record_type' => $record->record_type,
                    'start_date' => $record->start_date->format('Y-m-d'),
                    'end_date' => $record->end_date->format('Y-m-d'),
                    'purchase_type' => $record->purchase_type,
                    'status' => $record->status,
                    'value_after_vat' => number_format($record->value_after_vat, 2),
                ];
            });

        return Inertia::render('Records/Index', [
            'records' => $records,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'record_number' => 'required|string|max:255',
            'record_type' => 'required|string|in:invoice,bill',
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

        $record = Record::create([
            ...$validated,
            'user_id' => Auth::id(),
            'value' => $value,
            'value_after_vat' => $value_after_vat,
        ]);

        return Redirect::route('records.show', $record)
            ->with('success', 'Record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        if ($record->user_id !== Auth::id()) {
            abort(403);
        }

        $record->load('client');

        return Inertia::render('Records/Show', [
            'record' => $record,
        ]);
    }

}
