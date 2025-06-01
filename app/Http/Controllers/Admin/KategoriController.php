<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all(); // Ubah nama variabel agar sesuai
        return view('admin.kategori.index', compact('kategoris')); // Sesuaikan dengan yang ada di Blade
    }
    

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategoris,nama',
        ]);

        Kategori::create($request->all());

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function destroy($id)
{
    $kategori = kategori::findOrFail($id);
    $kategori->delete();

    return response()->json(['message' => 'Pengguna berhasil dihapus.']);
}
}
