<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Surat;
use Illuminate\Http\Request;

class StaffAgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::with('surat')->get();
        return view('staff.agenda.index', compact('agendas')); // Menggunakan 'agendas' agar sesuai dengan variabel
    }

    public function create()
    {
        $surats = Surat::pluck('no_surat', 'id'); // Ambil no_surat sebagai value dan id sebagai key
        return view('staff.agenda.create', compact('surats'));
        
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

        return redirect()->route('staff.agenda.index')->with('success', 'Agenda berhasil ditambahkan');
    }

    public function edit(Agenda $agenda)
    {
        $surats = Surat::all();
        return view('staff.agenda.edit', compact('agenda', 'surats'));
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

        return redirect()->route('staff.agenda.index')->with('success', 'Agenda berhasil diperbarui');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('staff.agenda.index')->with('success', 'Agenda berhasil dihapus');
    }
}
