@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h2 mb-0 text-800 font-weight-bold">Edit Surat</h1>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('staff.agenda.update', $agenda->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Menggunakan PUT untuk update -->

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="asal">Asal Surat</label>
                                    <input type="text" name="asal" id="asal" class="form-control @error('asal') is-invalid @enderror" 
                                           value="{{ old('asal', $agenda->asal) }}" required>
                                    @error('asal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="hari_tanggal">Tanggal</label>
                                    <input type="date" name="hari_tanggal" id="hari_tanggal" class="form-control @error('hari_tanggal') is-invalid @enderror" 
                                    value="{{ old('hari_tanggal', \Carbon\Carbon::parse($agenda->hari_tanggal)->format('Y-m-d')) }}" required>
                                    @error('hari_tanggal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pukul">Pukul</label>
                                    <input type="text" name="pukul" id="pukul" class="form-control @error('pukul') is-invalid @enderror" 
                                           value="{{ old('pukul', $agenda->pukul) }}" required>
                                    @error('pukul')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="acara">Acara</label>
                                    <input type="text" name="acara" id="acara" class="form-control @error('acara') is-invalid @enderror" 
                                           value="{{ old('acara', $agenda->acara) }}" required>
                                    @error('acara')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tempat">Tempat</label>
                                    <input type="text" name="tempat" id="tempat" class="form-control @error('tempat') is-invalid @enderror" 
                                           value="{{ old('tempat', $agenda->tempat) }}" required>
                                    @error('tempat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="surat_id">No Surat</label>
                                    <select name="surat_id" id="surat_id" class="form-control @error('surat_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih No Surat --</option>
                                        @foreach ($surats as $surat)
                                            <option value="{{ $surat->id }}" 
                                                    {{ old('surat_id', $agenda->surat_id) == $surat->id ? 'selected' : '' }}>
                                                {{ $surat->no_surat }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('surat_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan & Batal -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ url()->previous() }}" id="btn-batal" class="btn btn-secondary mr-3">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
