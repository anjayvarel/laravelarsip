<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    // Update profil user
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
    
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:users,nip,' . $user->id,
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('new_password') && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }
    
        // Update nama dan NIP
        $user->nama = $request->nama;
        $user->nip = $request->nip;
    
        // Jika user ingin mengganti password
        if ($request->filled('new_password')) {
            // Cek apakah password lama cocok
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama salah.']);
            }
    
            // Simpan password baru
            // Simpan password baru
$user->password = $request->new_password;
$user->save();

// Logout pengguna setelah password diganti
Auth::logout();
session()->invalidate();
session()->regenerate();

// Redirect ke login dengan pesan sukses
return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');

            // Simpan perubahan user
            $user->save();
    
            // Setelah logout, redireksi agar pengguna login kembali dengan password baru
            return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
        }
    
        // Simpan perubahan user selain password
        $user->save();
    
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
    
}
