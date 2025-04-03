<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Vendor::withCount('invoices')
            ->orderBy('name')
            ->get()
            ->map(function ($vendor) {
                return [
                    'id' => $vendor->id,
                    'name' => $vendor->name,
                    'contact_person' => $vendor->contact_person,
                    'email' => $vendor->email,
                    'phone' => $vendor->phone,
                    'invoices_count' => $vendor->invoices_count,
                    'is_active' => $vendor->is_active,
                ];
            });

        return Inertia::render('Vendors/Index', [
            'vendors' => $vendors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Vendors/Create');
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

        Vendor::create($validated);

        return Redirect::route('vendors.index')
            ->with('success', 'Vendor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        $vendor->load(['invoices' => function ($query) {
            $query->orderBy('invoice_date', 'desc')->limit(5);
        }]);

        return Inertia::render('Vendors/Show', [
            'vendor' => [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'contact_person' => $vendor->contact_person,
                'email' => $vendor->email,
                'phone' => $vendor->phone,
                'address' => $vendor->address,
                'notes' => $vendor->notes,
                'is_active' => $vendor->is_active,
                'created_at' => $vendor->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $vendor->updated_at->format('Y-m-d H:i:s'),
                'recent_invoices' => $vendor->invoices->map(function ($invoice) {
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
    public function edit(Vendor $vendor)
    {
        return Inertia::render('Vendors/Edit', [
            'vendor' => [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'contact_person' => $vendor->contact_person,
                'email' => $vendor->email,
                'phone' => $vendor->phone,
                'address' => $vendor->address,
                'notes' => $vendor->notes,
                'is_active' => $vendor->is_active,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
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

        $vendor->update($validated);

        return Redirect::route('vendors.show', $vendor)
            ->with('success', 'Vendor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        // Check if vendor has invoices
        if ($vendor->invoices()->count() > 0) {
            return Redirect::route('vendors.index')
                ->with('error', 'Cannot delete vendor with existing invoices.');
        }

        $vendor->delete();

        return Redirect::route('vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }
}
