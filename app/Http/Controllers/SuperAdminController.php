<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $pendingAdmins = User::where('role', 'admin')
            ->where('is_verified', false)
            ->latest()
            ->get();

        $verifiedAdmins = User::where('role', 'admin')
            ->where('is_verified', true)
            ->latest()
            ->get();

        return Inertia::render('SuperAdmin/Dashboard', [
            'pendingAdmins' => $pendingAdmins,
            'verifiedAdmins' => $verifiedAdmins,
        ]);
    }

    public function verifyAdmin(User $user)
    {
        $user->update(['is_verified' => true]);
        return back()->with('success', 'Admin account verified successfully');
    }

    public function rejectAdmin(User $user)
    {
        $user->delete();
        return back()->with('success', 'Admin account rejected and removed');
    }

    public function removeAdmin(User $user)
    {
        $user->delete();
        return back()->with('success', 'Admin account removed successfully');
    }
}
