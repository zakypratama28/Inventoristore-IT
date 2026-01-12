<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->when(request('q'), function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . request('q') . '%')
                      ->orWhere('email', 'like', '%' . request('q') . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting self or other admins if strict
        if ($user->role !== 'customer') {
            return back()->with('error', 'Hanya akun pelanggan yang dapat dihapus.');
        }

        $user->delete();

        return back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}
