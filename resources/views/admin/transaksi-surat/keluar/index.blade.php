@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-bold font-weight-bold">Surat Keluar</h1>

        <!-- Form Pencarian -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('admin.surat.keluar') }}" method="GET">
                    <div class="input-group">
                        <label class="mr-2 mt-2" for="kategori">Filter:</label>
                        <select name="kategori_id" id="kategori" class="form-control" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    
        <div class="text-right my-2">
            <a href="{{ route('admin.surat.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Surat Keluar
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Surat Keluar</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Surat</th>
                                <th>Pengirim</th>
                                <th>Kategori</th>
                                <th>Tanggal Surat</th>
                                <th>Tanggal Dibuat</th>
                                <th>Perihal</th>
                                <th>Lampiran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surats as $surat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $surat->no_surat }}</td>
                                    <td>{{ $surat->pengirim }}</td>
                                    <td>{{ $surat->kategori->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_diterima)->format('d-m-Y') }}</td>
                                    <td>{{ $surat->perihal }}</td>
                                    <td>
                                        @if($surat->lampiran)
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#lampiranModal" data-lampiran="{{ asset($surat->lampiran) }}">
                                                Lihat Lampiran
                                            </button>
                                        @else
                                            Tidak ada lampiran
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.surat.edit', $surat->id) }}" class="btn btn-sm btn-warning d-inline-block mr-2">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $surat->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal Lampiran -->
    <div class="modal fade" id="lampiranModal" tabindex="-1" aria-labelledby="lampiranModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lampiranModalLabel">Lampiran Surat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <iframe id="lampiranFrame" src="" width="100%" height="500px"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
    
            // Menangani klik tombol hapus
            $('.delete-btn').click(function() {
                let suratId = $(this).data('id');
    
                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/surat/" + suratId,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire("Terhapus!", response.message, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                                Swal.fire("Gagal!", "Terjadi kesalahan saat menghapus data.", "error");
                            }
                        });
                    }
                });
            });
    
            // Menangani tampilan lampiran
            $('#lampiranModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var lampiranUrl = button.data('lampiran');
                var modal = $(this);
                modal.find('#lampiranFrame').attr('src', lampiranUrl);
            });
    
        });
    </script>
@endsection