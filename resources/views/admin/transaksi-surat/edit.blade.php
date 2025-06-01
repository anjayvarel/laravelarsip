@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h2 mb-0 text-800 font-weight-bold">Edit Surat</h1>
    </div>

    <div class="row">
        <div class="col-md-10 mx-auto"> <!-- Agar Form Tidak Terlalu Melebar -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jenis_surat">Jenis Surat</label>
                                    <select name="jenis_surat" id="jenis_surat" class="form-control">
                                        <option value="masuk" {{ $surat->jenis_surat == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                                        <option value="keluar" {{ $surat->jenis_surat == 'keluar' ? 'selected' : '' }}>Surat Keluar</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="no_surat">No Surat</label>
                                    <input type="text" name="no_surat" id="no_surat" class="form-control @error('no_surat') is-invalid @enderror" value="{{ old('no_surat', $surat->no_surat) }}" required>
                                    @error('no_surat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="pengirim">Pengirim</label>
                                    <input type="text" name="pengirim" id="pengirim" class="form-control @error('pengirim') is-invalid @enderror" value="{{ old('pengirim', $surat->pengirim) }}" required>
                                    @error('pengirim')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="tanggal_surat">Tanggal Surat</label>
                                    <input type="date" name="tanggal_surat" id="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" value="{{ old('tanggal_surat', $surat->tanggal_surat) }}" required>
                                    @error('tanggal_surat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_diterima">{{ $jenis_surat == 'keluar' ? 'Tanggal Dibuat' : 'Tanggal Diterima' }}</label>
                                    <input type="date" name="tanggal_diterima" id="tanggal_diterima" class="form-control @error('tanggal_diterima') is-invalid @enderror" value="{{ old('tanggal_diterima', $surat->tanggal_diterima ?? '') }}">
                                    @error('tanggal_diterima')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                           

                                <div class="form-group mb-3">
                                    <label for="kategori_id">Kategori Surat</label>
                                    <select name="kategori_id" id="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($kategoris as $id => $nama)
                                            <option value="{{ $id }}" {{ $surat->kategori_id == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="perihal">Perihal</label>
                                    <input type="text" name="perihal" id="perihal" class="form-control @error('perihal') is-invalid @enderror" value="{{ old('perihal', $surat->perihal) }}">
                                    @error('perihal')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="lampiran">Lampiran (PDF, DOCX, JPG, PNG)</label>
                                    <input type="file" name="lampiran" id="lampiran" class="form-control @error('lampiran') is-invalid @enderror" accept=".pdf,.doc,.docx,.jpg,.png">
                                    <small class="text-muted">Lampiran sebelumnya: <a href="{{ url('uploads/surat/' . basename($surat->lampiran)) }}" data-toggle="modal" data-target="#lampiranModal" data-lampiran="{{ url('uploads/surat/' . basename($surat->lampiran)) }}">>Lihat</a>
                                    </small>
                                    
                                    @error('lampiran')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Simpan & Batal -->
                        <div class="card-footer">
                            <div class="d-flex justify-content-end mt-3">
                                <a href="{{ url()->previous() }}" id="btn-batal" class="btn btn-secondary mr-3" style="gap: 10px;">Batal</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Lampiran --}}
    <div class="modal fade" id="lampiranModal" tabindex="-1" role="dialog" aria-labelledby="lampiranModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
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

    <script>
         $(document).ready(function () {
      $('#lampiranModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var lampiranUrl = button.data('lampiran');
                var modal = $(this);
                modal.find('#lampiranFrame').attr('src', lampiranUrl);
            });

        });        
    </script>

@endsection
