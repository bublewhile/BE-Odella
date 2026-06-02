<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with(['pesanans' => fn($q) => $q->latest()->take(5)])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan hapus admin sendiri
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun admin');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
