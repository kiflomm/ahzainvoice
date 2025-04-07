<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('client')
            ->orderBy('invoice_date', 'desc')
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'client' => [
                        'id' => $invoice->client->id,
                        'name' => $invoice->client->name,
                    ],
                    'invoice_date' => $invoice->invoice_date->format('Y-m-d'),
                    'due_date' => $invoice->due_date ? $invoice->due_date->format('Y-m-d') : null,
                    'total_amount' => number_format($invoice->total_amount, 2),
                    'status' => $invoice->status,
                ];
            });

        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Invoices/Create', [
            'clients' => $clients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'subtotal_amount' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string',
            'status' => 'required|string|in:pending,paid,overdue,cancelled',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|in:cash,cheque',
            'cheque_number' => 'nullable|string|max:255',
            'approver_name' => 'nullable|string|max:255',
            'cashier_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_number' => 'nullable|string',
            'items.*.description' => 'required|string',
            'items.*.unit' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        // Calculate subtotal, tax, and total if not provided
        if (!isset($validated['tax_rate'])) {
            $validated['tax_rate'] = 15.00; // Default 15% VAT for Ethiopia
        }

        if (!isset($validated['subtotal_amount']) && isset($validated['items'])) {
            $validated['subtotal_amount'] = collect($validated['items'])->sum('amount');
        }

        if (!isset($validated['tax_amount'])) {
            $validated['tax_amount'] = round($validated['subtotal_amount'] * ($validated['tax_rate'] / 100), 2);
        }

        if (!isset($validated['total_amount'])) {
            $validated['total_amount'] = $validated['subtotal_amount'] + $validated['tax_amount'];
        }

        // Generate amount in words if not provided
        if (!isset($validated['amount_in_words'])) {
            $validated['amount_in_words'] = $this->convertNumberToWords($validated['total_amount']);
        }

        // Add authenticated user ID
        $validated['user_id'] = Auth::id();

        // Handle file upload if present
        if ($request->hasFile('invoice_file')) {
            $path = $request->file('invoice_file')->store('invoices', 'private');
            $validated['file_path'] = $path;
        }

        // Create invoice
        $invoice = Invoice::create($validated);

        // Create invoice items if any
        if (isset($validated['items']) && is_array($validated['items'])) {
            foreach ($validated['items'] as $index => $item) {
                // Set item number if not provided
                if (empty($item['item_number'])) {
                    $item['item_number'] = sprintf('%02d', $index + 1);
                }

                // Set unit if not provided
                if (empty($item['unit'])) {
                    $item['unit'] = 'Pcs';
                }

                // Add tax information to each item
                $item['tax_rate'] = $validated['tax_rate'];
                $item['tax_amount'] = round($item['amount'] * ($validated['tax_rate'] / 100), 2);

                $invoice->items()->create($item);
            }
        }

        return Redirect::route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load(['client',  'items', 'user']);

        return Inertia::render('Invoices/Show', [
            'invoice' => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'client' => $invoice->client,
                'invoice_date' => $invoice->invoice_date->format('Y-m-d'),
                'due_date' => $invoice->due_date ? $invoice->due_date->format('Y-m-d') : null,
                'total_amount' => $invoice->total_amount,
                'tax_amount' => $invoice->tax_amount,
                'status' => $invoice->status,
                'payment_date' => $invoice->payment_date ? $invoice->payment_date->format('Y-m-d') : null,
                'notes' => $invoice->notes,
                'items' => $invoice->items,
                'file_path' => $invoice->file_path,
                'created_at' => $invoice->created_at->format('Y-m-d H:i:s'),
                'user' => [
                    'id' => $invoice->user->id,
                    'name' => $invoice->user->name,
                ],
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $invoice->load(['client',  'items']);

        $clients = Client::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);


        return Inertia::render('Invoices/Edit', [
            'invoice' => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'client_id' => $invoice->client_id,
                'invoice_date' => $invoice->invoice_date->format('Y-m-d'),
                'due_date' => $invoice->due_date ? $invoice->due_date->format('Y-m-d') : null,
                'total_amount' => $invoice->total_amount,
                'tax_amount' => $invoice->tax_amount,
                'status' => $invoice->status,
                'payment_date' => $invoice->payment_date ? $invoice->payment_date->format('Y-m-d') : null,
                'notes' => $invoice->notes,
                'items' => $invoice->items,
                'file_path' => $invoice->file_path,
            ],
            'clients' => $clients,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date',
            'subtotal_amount' => 'required|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'tax_amount' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'amount_in_words' => 'nullable|string',
            'status' => 'required|string|in:pending,paid,overdue,cancelled',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|in:cash,cheque',
            'cheque_number' => 'nullable|string|max:255',
            'approver_name' => 'nullable|string|max:255',
            'cashier_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:invoice_items,id',
            'items.*.item_number' => 'nullable|string',
            'items.*.description' => 'required|string',
            'items.*.unit' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.amount' => 'required|numeric|min:0',
        ]);

        // Calculate subtotal, tax, and total if not provided
        if (!isset($validated['tax_rate'])) {
            $validated['tax_rate'] = 15.00; // Default 15% VAT for Ethiopia
        }

        if (!isset($validated['subtotal_amount']) && isset($validated['items'])) {
            $validated['subtotal_amount'] = collect($validated['items'])->sum('amount');
        }

        if (!isset($validated['tax_amount'])) {
            $validated['tax_amount'] = round($validated['subtotal_amount'] * ($validated['tax_rate'] / 100), 2);
        }

        if (!isset($validated['total_amount'])) {
            $validated['total_amount'] = $validated['subtotal_amount'] + $validated['tax_amount'];
        }

        // Generate amount in words if not provided
        if (!isset($validated['amount_in_words'])) {
            $validated['amount_in_words'] = $this->convertNumberToWords($validated['total_amount']);
        }

        // Handle file upload if present
        if ($request->hasFile('invoice_file')) {
            // Delete old file if exists
            if ($invoice->file_path) {
                Storage::disk('private')->delete($invoice->file_path);
            }

            $path = $request->file('invoice_file')->store('invoices', 'private');
            $validated['file_path'] = $path;
        }

        // Update invoice
        $invoice->update($validated);

        // Update invoice items
        if (isset($validated['items']) && is_array($validated['items'])) {
            // Get current item IDs
            $existingItemIds = $invoice->items->pluck('id')->toArray();
            $updatedItemIds = [];

            foreach ($validated['items'] as $index => $itemData) {
                if (isset($itemData['id'])) {
                    // Update existing item
                    $item = $invoice->items->find($itemData['id']);

                    if ($item) {
                        // Set unit if not provided
                        if (empty($itemData['unit'])) {
                            $itemData['unit'] = 'Pcs';
                        }

                        // Add tax information to the item
                        $itemData['tax_rate'] = $validated['tax_rate'];
                        $itemData['tax_amount'] = round($itemData['amount'] * ($validated['tax_rate'] / 100), 2);

                        $item->update($itemData);
                        $updatedItemIds[] = $item->id;
                    }
                } else {
                    // Create new item
                    // Set item number if not provided
                    if (empty($itemData['item_number'])) {
                        $itemData['item_number'] = sprintf('%02d', $index + 1);
                    }

                    // Set unit if not provided
                    if (empty($itemData['unit'])) {
                        $itemData['unit'] = 'Pcs';
                    }

                    // Add tax information to the item
                    $itemData['tax_rate'] = $validated['tax_rate'];
                    $itemData['tax_amount'] = round($itemData['amount'] * ($validated['tax_rate'] / 100), 2);

                    $newItem = $invoice->items()->create($itemData);
                    $updatedItemIds[] = $newItem->id;
                }
            }

            // Delete items that are no longer in the updated list
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                $invoice->items()->whereIn('id', $itemsToDelete)->delete();
            }
        }

        return Redirect::route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return Redirect::route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Export invoices to CSV
     */
    public function exportCsv(Request $request)
    {
        $invoices = Invoice::with(['client'])
            ->orderBy('invoice_date', 'desc')
            ->get();

        $filename = 'invoices_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($invoices) {
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'Invoice Number',
                'Client',
                'Date',
                'Due Date',
                'Amount',
                'Tax',
                'Status',
                'Notes',
            ]);

            // Add invoice data
            foreach ($invoices as $invoice) {
                fputcsv($handle, [
                    $invoice->invoice_number,
                    $invoice->client->name,
                    $invoice->invoice_date->format('Y-m-d'),
                    $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A',
                    $invoice->total_amount,
                    $invoice->tax_amount,
                    $invoice->status,
                    $invoice->notes,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Convert a number to words for the amount
     */
    private function convertNumberToWords($number)
    {
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $words = ucfirst($f->format($number));

        // Handle decimal part
        $parts = explode('.', (string)$number);
        if (count($parts) > 1 && $parts[1] != '00') {
            $words .= ' and ' . $parts[1] . '/100';
        }

        return $words;
    }
}
