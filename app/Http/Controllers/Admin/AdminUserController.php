<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,staff'
        ]);

        User::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nip' => 'required|string|max:255|unique:users,nip,' . $user->id,
        'password' => $request->filled('password') ? 'required|min:6' : '',
        'role' => 'required|in:admin,staff',
    ]);

    if ($request->filled('password')) {  
        $user->password = $request->password; // Model akan otomatis hash
    }

    $user->nama = $request->nama;
    $user->nip = $request->nip;
    $user->role = $request->role;
    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
}
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['message' => 'Pengguna berhasil dihapus.']);
}
}
