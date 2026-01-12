<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->latest()->paginate(20);

        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'verified' => User::whereNotNull('email_verified_at')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:customer,staff,admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully'
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function toggleStatus(User $user)
    {
        if ($user->email_verified_at) {
            $user->update(['email_verified_at' => null]);
            $message = 'User email unverified';
        } else {
            $user->update(['email_verified_at' => now()]);
            $message = 'User email verified';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}
