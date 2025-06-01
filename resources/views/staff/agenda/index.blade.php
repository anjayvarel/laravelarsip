
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-bold font-weight-bold">Agenda Acara</h1>

       <!-- Form Pencarian -->
       <div class="row mb-3">
     
    </div>
    
        <!-- Tombol Tambah agenda-->
        <div class="text-right my-2">
            <a href="{{ route('staff.agenda.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>Tambah agenda Acara
            </a>
        </div>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Agenda Acara</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengirim</th>
                                <th>Tanggal</th>
                                <th>Pukul</th>
                                <th>Tempat</th>
                                <th>Acara</th>
                                <th>No Surat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agendas as $agenda)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $agenda->asal }}</td>
                                    <td>{{ \Carbon\Carbon::parse($agenda->hari_tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $agenda->pukul }}</td>
                                    <td>{{ $agenda->tempat }}</td>
                                    <td>{{ $agenda->acara }}</td>
                                    <td>{{ $agenda->surat->no_surat }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('staff.agenda.edit', $agenda->id) }}" class="btn btn-sm btn-warning d-inline-block mr-2">
                                                <i class="fas fa-pen"></i>
                                            </a>
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

    <!-- Script untuk Modal Lampiran -->
    <script>
        $('#lampiranModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var lampiranUrl = button.data('lampiran');
            var modal = $(this);
            modal.find('#lampiranFrame').attr('src', lampiranUrl);
        });
    </script>
@endsection

