<?php

namespace App\Http\Controllers\Admin;

use App\Models\Surat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class AdminSuratController extends Controller
{
    // Surat Masuk
    public function indexMasuk(Request $request)
    {
        $search = $request->input('search');
        $kategori_id = $request->input('kategori_id');
    
        $surats = Surat::where('jenis_surat', 'masuk')
            ->when($search, function ($query) use ($search) {
                $query->where('no_surat', 'like', "%{$search}%")
                      ->orWhere('pengirim', 'like', "%{$search}%")
                      ->orWhereHas('kategori', function ($q) use ($search) {
                          $q->where('nama', 'like', "%{$search}%");
                      });
            })
            ->when($kategori_id, function ($query) use ($kategori_id) {
                $query->where('kategori_id', $kategori_id);
            })
            ->paginate(10);
    
        $kategoris = Kategori::all();
    
        return view('admin.transaksi-surat.masuk.index', compact('surats', 'kategoris', 'search', 'kategori_id'));
    }
    

    
   
    // Surat Keluar
public function indexKeluar(Request $request)
{
    $search = $request->input('search');
    $kategori_id = $request->input('kategori_id');

    $surats = Surat::where('jenis_surat', 'keluar')
    ->when($search, function ($query) use ($search) {
        $query->where('no_surat', 'like', "%{$search}%")
              ->orWhere('pengirim', 'like', "%{$search}%")
              ->orWhereHas('kategori', function ($q) use ($search) {
                  $q->where('nama', 'like', "%{$search}%");
              });
    })
    ->when($kategori_id, function ($query) use ($kategori_id) {
        $query->where('kategori_id', $kategori_id);
    })

    ->get(); // Pakai get() supaya tidak bentrok dengan DataTables
      


    $kategoris = Kategori::all();

    return view('admin.transaksi-surat.keluar.index', compact('surats', 'kategoris', 'search', 'kategori_id'));
}

    // Form Tambah Surat
    public function create()
{
    $kategoris = Kategori::pluck('nama', 'id'); 
    $jenis_surat = 'masuk'; // Atau 'keluar', tergantung pada logika Anda
    return view('admin.transaksi-surat.create', compact('kategoris', 'jenis_surat'));
}


    // Simpan Surat (Masuk/Keluar)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_surat' => 'required',
            'no_surat' => 'required',
            'pengirim' => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_diterima' => 'nullable|date',
            'perihal' => 'required',
            'kategori_id' => 'required',
            'lampiran' => 'required|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/surat'), $filename);
            $validatedData['lampiran'] = 'uploads/surat/' . $filename;
        }


        Surat::create($validatedData);
        if ($request->jenis_surat === 'masuk') {
            return redirect()->route('admin.surat.masuk')->with('success', 'Surat masuk berhasil ditambahkan!');
        } else {
            return redirect()->route('admin.surat.keluar')->with('success', 'Surat keluar berhasil ditambahkan!');
        }
    }

    // Hapus Surat
   

    public function destroy($id)
    {
        $surat = Surat::find($id);
        if (!$surat) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }
    
        // Hapus lampiran jika ada
        if ($surat->lampiran && file_exists(public_path($surat->lampiran))) {
            unlink(public_path($surat->lampiran));
        }
    
        // Hapus surat
        $surat->delete();
        return response()->json(['message' => 'Surat berhasil dihapus!']);
    }
    

    
// edit surat
    public function edit($id)
    {
        $surat = Surat::findOrFail($id);
        $kategoris = Kategori::pluck('nama', 'id');
        $jenis_surat = $surat->jenis_surat; // Ambil dari data surat
        return view('admin.transaksi-surat.edit', compact('surat', 'kategoris', 'jenis_surat'));
    }
    


 // Update Surat
 public function update(Request $request, Surat $surat)
 {
     $validatedData = $request->validate([
         'jenis_surat' => 'required',
         'no_surat' => 'required',
         'pengirim' => 'required',
         'tanggal_surat' => 'required|date',
         'tanggal_diterima' => 'nullable|date',
         'perihal' => 'required',
         'kategori_id' => 'required',
         'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
     ]);

     if ($request->hasFile('lampiran')) {
         if ($surat->lampiran && file_exists(public_path($surat->lampiran))) {
             unlink(public_path($surat->lampiran));
         }

         $file = $request->file('lampiran');
         $filename = time() . '_' . $file->getClientOriginalName();
         $file->move(public_path('uploads/surat'), $filename);
         $validatedData['lampiran'] = 'uploads/surat/' . $filename;
     }

     $surat->update($validatedData);

     return redirect()->route($surat->jenis_surat === 'masuk' ? 'admin.surat.masuk' : 'admin.surat.keluar')
         ->with('success', 'Surat berhasil diperbarui!');
 }

 public function cetak(Request $request)
 {
     $query = Surat::with('kategori'); // Pastikan kategori ikut di-load
 
     // Menyimpan tanggal filter dari request
     $dari_tanggal = $request->dari_tanggal;
     $sampai_tanggal = $request->sampai_tanggal;
 
     // Filter berdasarkan tanggal
     if ($dari_tanggal && $sampai_tanggal) {
         $query->whereBetween('tanggal_diterima', [$dari_tanggal, $sampai_tanggal]);
     }
 
     // Filter berdasarkan jenis surat
     if ($request->jenis_surat) {
         $query->where('jenis_surat', $request->jenis_surat);
     }
 
     $surats = $query->get(); // Ambil data dengan kategori sudah dimuat
 
     // Membuat file PDF dan meneruskan variabel ke dalam view
     $pdf = Pdf::loadView('pdf.surat', compact('surats', 'dari_tanggal', 'sampai_tanggal'))
               ->setPaper('a4', 'portrait');
 
     // Menambahkan tanggal dan waktu ke nama file
     $filename = 'laporan_surat_' . now()->format('Y-m-d_H-i-s') . '.pdf';
 
     return $pdf->download($filename);
 }
 





}
