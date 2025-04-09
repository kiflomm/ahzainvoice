<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::withCount('records')
            ->orderBy('name')
            ->get()
            ->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'address' => $client->address,
                    'phone' => $client->phone,
                    'tin_number' => $client->tin_number,
                    'vat_registration' => $client->vat_registration,
                    'registration_date' => $client->registration_date?->format('Y-m-d'),
                    'records_count' => $client->records_count,
                ];
            });

        return Inertia::render('Clients/Index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'tin_number' => 'nullable|string|max:255',
            'vat_registration' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
        ]);

        $client = Client::create($validated);

        return Redirect::route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load(['records' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(5);
        }]);

        return Inertia::render('Clients/Show', [
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'address' => $client->address,
                'phone' => $client->phone,
                'tin_number' => $client->tin_number,
                'vat_registration' => $client->vat_registration,
                'registration_date' => $client->registration_date?->format('Y-m-d'),
                'created_at' => $client->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $client->updated_at->format('Y-m-d H:i:s'),
                'recent_records' => $client->records->map(function ($record) {
                    return [
                        'id' => $record->id,
                        'record_number' => $record->record_number,
                        'record_type' => $record->record_type,
                        'start_date' => $record->start_date->format('Y-m-d'),
                        'end_date' => $record->end_date->format('Y-m-d'),
                        'value_after_vat' => number_format($record->value_after_vat, 2),
                        'status' => $record->status,
                    ];
                }),
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'address' => $client->address,
                'phone' => $client->phone,
                'tin_number' => $client->tin_number,
                'vat_registration' => $client->vat_registration,
                'registration_date' => $client->registration_date?->format('Y-m-d'),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'tin_number' => 'nullable|string|max:255',
            'vat_registration' => 'nullable|string|max:255',
            'registration_date' => 'nullable|date',
        ]);

        $client->update($validated);

        return Redirect::route('clients.show', $client)
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        // Check if client has records
        if ($client->records()->count() > 0) {
            return Redirect::route('clients.index')
                ->with('error', 'Cannot delete client with existing records.');
        }

        $client->delete();

        return Redirect::route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
