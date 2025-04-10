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
        $user = Auth::user();

        // Fetch recent records (e.g., last 5)
        // Adjust the query based on your actual models and relationships
        $recentRecords = Record::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Calculate stats (replace with your actual logic)
        $totalRecords = Record::where('user_id', $user->id)->count();
        $pendingRecords = Record::where('user_id', $user->id)->where('status', 'pending')->count();
        $overdueRecords = Record::where('user_id', $user->id)->where('status', 'overdue')->count(); // Assuming you have an overdue status

        // Calculate amounts (replace with actual logic, possibly summing amounts)
        $totalAmount = Record::where('user_id', $user->id)->sum('value_after_vat'); // Corrected column
        $pendingAmount = Record::where('user_id', $user->id)->where('status', 'pending')->sum('value_after_vat'); // Corrected column
        $overdueAmount = Record::where('user_id', $user->id)->where('status', 'overdue')->sum('value_after_vat'); // Corrected column


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
