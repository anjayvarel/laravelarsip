@extends('layouts.app')

@section('content')
{{-- SweetAlert2 CDN (kalau belum ada di layout) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil Login!',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h2 mb-0  font-weight-bold">Dashboard</h1>
    </div>
    <div>
        <p class=" my-1 text-muted">Selamat Datang, <strong>{{ Auth::user()->nama }}</strong></p>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow-sm h-100 py-3 rounded">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Surat Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSuratMasuk}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-reply fa-3x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow-sm h-100 py-3 rounded">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Surat Keluar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSuratKeluar }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-share fa-3x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow-sm h-100 py-3 rounded">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPengguna}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-3x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Form Card -->
    <div class="card shadow-lg mt-4 rounded">
        <div class="card-body">
            <h3 class="card-title font-weight-bold">Cetak Laporan Surat</h3>
            <div class="card-subtitle">
                <p>Surat Dicetak Berdasarkan Tanggal Surat Diterima/Dibuat</p>
            </div>
            <form action="{{ route('admin.surat.cetak') }}" method="GET" target="_blank">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Dari Tanggal</label>
                        <input type="date" name="dari_tanggal" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" class="form-control">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Jenis Surat</label>
                        <select name="jenis_surat" class="form-control">
                            <option value="">Semua</option>
                            <option value="masuk">Surat Masuk</option>
                            <option value="keluar">Surat Keluar</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Cetak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
