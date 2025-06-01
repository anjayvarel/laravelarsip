<?php
namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    // Surat Masuk
public function indexMasuk(Request $request)
{
    $search = $request->input('search');
    $surats = Surat::where('jenis_surat', 'masuk')
        ->where(function ($query) use ($search) {
            $query->where('no_surat', 'like', "%$search%")
                ->orWhere('pengirim', 'like', "%$search%")
                ->orWhere('perihal', 'like', "%$search%");
        })
        ->get();

    return view('admin.transaksi-surat.masuk.index', compact('surats'));
}

// Surat Keluar
public function indexKeluar(Request $request)
{
    $search = $request->input('search');
    $surats = Surat::where('jenis_surat', 'keluar')
        ->where(function ($query) use ($search) {
            $query->where('no_surat', 'like', "%$search%")
                ->orWhere('pengirim', 'like', "%$search%")
                ->orWhere('perihal', 'like', "%$search%");
        })
        ->get();

    return view('admin.transaksi-surat.keluar.index', compact('surats'));
}

    // Simpan Surat (Masuk/Keluar)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_surat' => 'required',
            'no_surat' => 'required',
            'pengirim' => 'required',
            'pengirim' => 'required',
            'perihal' => 'required',
            'tanggal_surat' => 'required|date',
            'kategori_id' => 'required',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/surat'), $filename);
            $validatedData['lampiran'] = 'uploads/surat/' . $filename;
        }

        Surat::create($validatedData);

        return redirect()->back()->with('success', 'Surat berhasil ditambahkan!');
    }

    // Hapus Surat
    public function destroy(Surat $surat)
    {
        if ($surat->lampiran && file_exists(public_path($surat->lampiran))) {
            unlink(public_path($surat->lampiran));
        }

        $surat->delete();
        return redirect()->back()->with('success', 'Surat berhasil dihapus!');
    }
}
