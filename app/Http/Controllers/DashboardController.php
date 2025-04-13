<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Record; // Assuming you have a Record model
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard.
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        
        $recentRecords = Record::with('client')
            ->latest()
            ->take(5)
            ->get();

        // Calculate stats - removed user_id filters
        $totalRecords = Record::count();
        $pendingRecords = Record::where('status', 'pending')->count();
        $overdueRecords = Record::where('status', 'overdue')->count();

        // Calculate amounts - removed user_id filters
        $totalAmount = Record::sum('value_after_vat');
        $pendingAmount = Record::where('status', 'pending')->sum('value_after_vat');
        $overdueAmount = Record::where('status', 'overdue')->sum('value_after_vat');

        // Format amounts as currency if needed
        $formattedTotalAmount = number_format($totalAmount, 2);
        $formattedPendingAmount = number_format($pendingAmount, 2);
        $formattedOverdueAmount = number_format($overdueAmount, 2);

        $stats = [
            'totalRecords' => $totalRecords,
            'totalAmount' => '$' . $formattedTotalAmount,
            'pendingRecords' => $pendingRecords,
            'pendingAmount' => '$' . $formattedPendingAmount,
            'overdueRecords' => $overdueRecords,
            'overdueAmount' => '$' . $formattedOverdueAmount,
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentRecords' => $recentRecords,
        ]);
    }
}
