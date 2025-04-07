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
        $clients = Client::withCount('invoices')
            ->orderBy('name')
            ->get()
            ->map(function ($client) {
                return [
                    'id' => $client->id,
                    'name' => $client->name,
                    'contact_person' => $client->contact_person,
                    'email' => $client->email,
                    'phone' => $client->phone,
                    'invoices_count' => $client->invoices_count,
                    'is_active' => $client->is_active,
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
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Client::create($validated);

        return Redirect::route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load(['invoices' => function ($query) {
            $query->orderBy('invoice_date', 'desc')->limit(5);
        }]);

        return Inertia::render('Clients/Show', [
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'contact_person' => $client->contact_person,
                'email' => $client->email,
                'phone' => $client->phone,
                'address' => $client->address,
                'notes' => $client->notes,
                'is_active' => $client->is_active,
                'created_at' => $client->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $client->updated_at->format('Y-m-d H:i:s'),
                'recent_invoices' => $client->invoices->map(function ($invoice) {
                    return [
                        'id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'invoice_date' => $invoice->invoice_date->format('Y-m-d'),
                        'total_amount' => number_format($invoice->total_amount, 2),
                        'status' => $invoice->status,
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
                'contact_person' => $client->contact_person,
                'email' => $client->email,
                'phone' => $client->phone,
                'address' => $client->address,
                'notes' => $client->notes,
                'is_active' => $client->is_active,
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
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
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
        // Check if client has invoices
        if ($client->invoices()->count() > 0) {
            return Redirect::route('clients.index')
                ->with('error', 'Cannot delete client with existing invoices.');
        }

        $client->delete();

        return Redirect::route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
