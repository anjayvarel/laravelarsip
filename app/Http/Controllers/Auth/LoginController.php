<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Buat tampilan login
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'nip' => 'required',
        'password' => 'required'
    ]);

    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate(); // Tambahkan untuk keamanan sesi
        $user = Auth::user();

        // Set flash message
        session()->flash('success', 'Login berhasil!');

        return $user->role == 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('staff.dashboard');
    }

    return back()->withErrors(['nip' => 'NIP atau password salah']);
}

    
    

    
public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'Logout Berhasil!');
}

}

