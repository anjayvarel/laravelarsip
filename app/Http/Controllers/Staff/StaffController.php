<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;

class StaffController extends Controller
{
    public function index()
    {
        $totalSuratMasuk = Surat::where('jenis_surat', 'masuk')->count();
        $totalSuratKeluar = Surat::where('jenis_surat', 'keluar')->count();
        $totalPengguna = User::count();

        return view('staff.dashboard', compact('totalSuratMasuk', 'totalSuratKeluar', 'totalPengguna'));
    }
}
