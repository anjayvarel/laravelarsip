<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Surat;
use Illuminate\Http\Request;

class AdminAgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::with('surat')->get();
        $surats = Surat::pluck('no_surat', 'id'); // Tambahkan ini
        return view('admin.agenda.index', compact('agendas', 'surats')); // Kirim $surats juga
    }
    

    public function create()
    {
        $surats = Surat::pluck('no_surat', 'id'); // Ambil no_surat sebagai value dan id sebagai key
        return view('admin.agenda.create', compact('surats'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'asal' => 'required',
            'hari_tanggal' => 'required|date',
            'pukul' => 'required',
            'acara' => 'required',
            'tempat' => 'required',
            'surat_id' => 'required|exists:surats,id'
        ]);

        Agenda::create($request->all());

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan');
    }

    public function edit(Agenda $agenda)
    {
        $surats = Surat::all();
        return view('admin.agenda.edit', compact('agenda', 'surats'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'asal' => 'required',
            'hari_tanggal' => 'required|date',
            'pukul' => 'required',
            'acara' => 'required',
            'tempat' => 'required',
            'surat_id' => 'required|exists:surats,id'
        ]);

        $agenda->update($request->all());

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui');
    }

    public function destroy($id)
{
    $agenda = Agenda::findOrFail($id);
    $agenda->delete();

    return response()->json(['message' => 'Agenda berhasil dihapus.']);
}
public function getEvents()
{
    $agendas = Agenda::with('surat')->get();

    $events = $agendas->map(function ($agenda) {
        return [
            'id' => $agenda->id,
            'title' => $agenda->acara,
            'start' => $agenda->hari_tanggal,
            'extendedProps' => [
                'asal' => $agenda->asal,
                'pukul' => $agenda->pukul,
                'tempat' => $agenda->tempat,
                'surat_id' => $agenda->surat_id,
                'no_surat' => optional($agenda->surat)->no_surat,
            ],
        ];
    });

    return response()->json($events);
}

public function ajaxStoreOrUpdate(Request $request)
{
    $request->validate([
        'asal' => 'required',
        'hari_tanggal' => 'required|date',
        'pukul' => 'required',
        'acara' => 'required',
        'tempat' => 'required',
        'surat_id' => 'required|exists:surats,id'
    ]);

    $agenda = Agenda::updateOrCreate(
        ['id' => $request->id],
        $request->all()
    );

    return response()->json(['message' => 'Agenda berhasil disimpan', 'agenda' => $agenda]);
}

}
