@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="text-bold font-weight-bold">Tambah Kategori</h1>

    <!-- Card untuk Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kategori</h6>
        </div>
        <div class="card-body">
            <!-- Form -->
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf

                <!-- Input Nama Kategori -->
                <div class="form-group">
                    <label for="nama">Nama Kategori</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama Kategori" required>

                    @error('nama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
