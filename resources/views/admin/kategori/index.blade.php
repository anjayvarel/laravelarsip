@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-bold font-weight-bold">Kelola Kategori</h1>

        <!-- Form Pencarian -->
        <div class="text-right my-2">
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Kategori
            </a>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Kategori</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategoris as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $item->id }}">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let kategoriId;

        // Menangani klik tombol hapus
        $('.delete-btn').click(function() {
            kategoriId = $(this).data('id'); // Ambil ID kategori dari data-id
            // Menampilkan dialog konfirmasi
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
                    // Mengirim permintaan AJAX untuk menghapus kategori
                    $.ajax({
                        url: "/admin/kategori/" + kategoriId, // URL untuk menghapus kategori
                        type: "DELETE", // Pastikan ini adalah DELETE
                        data: {
                            _token: "{{ csrf_token() }}" // Sertakan token CSRF
                        },
                        success: function(response) {
                            Swal.fire("Terhapus!", response.message, "success");
                            setTimeout(function() {
                                location.reload(); // Reload halaman setelah penghapusan
                            }, 1000);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText); // Cek respons jika ada kesalahan
                            let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Terjadi kesalahan saat menghapus data.";
                            Swal.fire("Gagal!", errorMessage, "error"); // Tampilkan pesan error
                        }
                    });
                }
            });
        });
    </script>
@endsection