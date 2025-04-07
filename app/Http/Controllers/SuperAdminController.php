<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SuperAdminController extends Controller
{
    /**
     * Display the super admin dashboard with pending and verified employees.
     *
     * @return \Inertia\Response
     */
    public function dashboard(): Response
    {
        $pendingEmployees = User::where('role', 'employee')
            ->where('is_verified', false)
            ->latest()
            ->get();

        $verifiedEmployees = User::where('role', 'employee')
            ->where('is_verified', true)
            ->latest()
            ->get();

        return Inertia::render('SuperAdmin/Dashboard', [
            'pendingEmployees' => $pendingEmployees,
            'verifiedEmployees' => $verifiedEmployees,
        ]);
    }

    /**
     * Verify an employee account.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmployee(User $user): RedirectResponse
    {
        $user->update(['is_verified' => true]);
        return back()->with('success', 'Employee account verified successfully');
    }

    /**
     * Reject and remove an employee account.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectEmployee(User $user): RedirectResponse
    {
        $user->delete();
        return back()->with('success', 'Employee account rejected and removed');
    }

    /**
     * Remove an existing verified employee account.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeEmployee(User $user): RedirectResponse
    {
        $user->delete();
        return back()->with('success', 'Employee account removed successfully');
    }
}
