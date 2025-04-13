<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Get current admin ID to exclude from results
        $currentAdminId = Auth::id();

        $pendingEmployees = User::where('id', '!=', $currentAdminId)
            ->where('is_verified', false)
            ->latest()
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role ?? 'user',
                    'is_verified' => $user->is_verified,
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at->format('Y-m-d'),
                ];
            });

        $verifiedEmployees = User::where('id', '!=', $currentAdminId)
            ->where('is_verified', true)
            ->latest()
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role ?? 'user',
                    'is_verified' => $user->is_verified,
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at->format('Y-m-d'),
                ];
            });

        return Inertia::render('Users/Index', [
            'pendingEmployees' => $pendingEmployees,
            'verifiedEmployees' => $verifiedEmployees,
        ]);
    }

    /**
     * Verify a user.
     */
    public function verify(User $user)
    {
        if ($user->is_verified) {
            return back()->with('error', 'User is already verified.');
        }

        $user->update([
            'is_verified' => true,
            'role' => $user->role ?? 'employee', // Default to employee role if none set
        ]);

        return back()->with('success', 'User verified successfully.');
    }

    /**
     * Reject an unverified user.
     */
    public function reject(User $user)
    {
        if ($user->is_verified) {
            return back()->with('error', 'Cannot reject a verified user.');
        }

        $user->delete();

        return back()->with('success', 'User rejected and removed successfully.');
    }

    /**
     * Remove a verified user.
     */
    public function remove(User $user)
    {
        $user->delete();

        return back()->with('success', 'User removed successfully.');
    }
} 