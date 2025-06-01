@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Tambah Agenda</h1>
    <form action="{{ route('admin.agenda.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- Kolom Kiri --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="asal" class="form-label">Pengirim</label>
                    <input type="text" name="asal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="hari_tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="hari_tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="pukul" class="form-label">Pukul</label>
                    <input type="text" name="pukul" class="form-control" required>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tempat" class="form-label">Tempat</label>
                    <input type="text" name="tempat" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="acara" class="form-label">Acara</label>
                    <input type="text" name="acara" class="form-control" required>
                </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="surat_id" class="form-label">Nomor Surat</label>
                            <select name="surat_id" class="form-select" required>
                                <option value="">-- Pilih Nomor Surat --</option>
                                @foreach ($surats as $id => $no_surat)
                                    <option value="{{ $id }}" 
                                        {{ (isset($agenda) && $id == $agenda->surat_id) ? 'selected' : '' }}>
                                        {{ $no_surat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
