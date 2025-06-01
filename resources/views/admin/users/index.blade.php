@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-bold font-weight-bold">Manajemen Pengguna</h1>

        <!-- Tombol Tambah Pengguna -->
        <div class="text-right my-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Tambah Pengguna
            </a>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning d-inline-block mr-2">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let userId;

        // Menangani klik tombol hapus
        $('.delete-btn').click(function() {
            userId = $(this).data('id'); // Ambil ID pengguna dari data-id
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
                    // Mengirim permintaan AJAX untuk menghapus pengguna
                    $.ajax({
                        url: "/admin/users/" + userId, // URL untuk menghapus pengguna
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
                            Swal.fire("Gagal!", errorMessage, "error");
                        }
                    });
                }
            });
        });
    </script>
@endsection