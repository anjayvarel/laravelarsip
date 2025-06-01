<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use App\Models\Kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

    

class AdminController extends Controller
{

    public function index()
    {
        $totalSuratMasuk = Surat::where('jenis_surat', 'masuk')->count();
        $totalSuratKeluar = Surat::where('jenis_surat', 'keluar')->count();
        $totalPengguna = User::count();
        $kategoris = Kategori::all(); // Tambahkan ini
    
        return view('admin.dashboard', compact('totalSuratMasuk', 'totalSuratKeluar', 'totalPengguna', 'kategoris'));
    }
    



}
