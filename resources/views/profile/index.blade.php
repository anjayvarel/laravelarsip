@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 font-weight-bold">Profil Saya</h2>

    <!-- Alert jika berhasil update -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf

                <!-- Nama -->
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $user->nama) }}" required>
                    @error('nama')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIP -->
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror"
                        value="{{ old('nip', $user->nip) }}" required>
                    @error('nip')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Info: Kosongkan jika tidak ingin ganti password -->
                <p class="text-muted"><small>Kosongkan kolom password jika tidak ingin mengubahnya.</small></p>

                <!-- Password Lama -->
                <div class="form-group">
                    <label for="current_password">Password Lama</label>
                    <div class="input-group">
                        <input type="password" name="current_password" id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary toggle-password" data-target="#current_password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <!-- Password Baru -->
                <div class="form-group">
                    <label for="new_password">Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password"
                            class="form-control @error('new_password') is-invalid @enderror">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary toggle-password" data-target="#new_password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    @error('new_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="form-group">
                    <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                            class="form-control">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary toggle-password" data-target="#new_password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Script untuk toggle visibility password
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            let target = document.querySelector(this.dataset.target);
            if (target.type === "password") {
                target.type = "text";
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                target.type = "password";
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });
</script>
@endsection
