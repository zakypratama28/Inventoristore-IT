<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display all users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role if provided
        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.users.form');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,staff,admin',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['password', 'password_confirmation', 'avatar']);
        $data['password'] = Hash::make($request->password);
        $data['email_verified_at'] = now(); // Auto-verify admin-created users

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')
                       ->with('success', 'User created successfully');
    }

    /**
     * Show edit form
     */
    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:customer,staff,admin',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['password', 'password_confirmation', 'avatar']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                       ->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                           ->with('error', 'You cannot delete yourself');
        }

        // Delete avatar
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                       ->with('success', 'User deleted successfully');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('admin.users.index')
                       ->with('success', "User {$status} successfully");
    }
}
