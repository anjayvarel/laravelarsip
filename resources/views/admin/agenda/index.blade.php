@extends('layouts.app')

@section('content')
<div class="container">
<div class="container-fluid">
    <h1 class="mb-4 font-weight-bold">Agenda Acara</h1>

    <div class="text-end mb-3">
        <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Agenda
        </a>
    </div>

    <div id="calendar" class="agenda-calendar"></div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const events = {!! json_encode($agendas->map(function ($a) {
            return [
                'id' => $a->id,
                'title' => $a->acara . ' (' . $a->pukul . ')',
                'start' => $a->hari_tanggal,
                'extendedProps' => [
                    'asal' => $a->asal,
                    'pukul' => $a->pukul,
                    'tempat' => $a->tempat,
                    'acara' => $a->acara,
                    'surat' => optional($a->surat)->no_surat ?? '-'
                ]
            ];
        })->values()->all()) !!};

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 500,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            events: events,
            eventClick: function (info) {
                const event = info.event;

                Swal.fire({
                    title: event.extendedProps.acara,
                    html: `
                        <strong>Pengirim:</strong> ${event.extendedProps.asal}<br>
                        <strong>Tanggal:</strong> ${event.start.toLocaleDateString()}<br>
                        <strong>Pukul:</strong> ${event.extendedProps.pukul}<br>
                        <strong>Tempat:</strong> ${event.extendedProps.tempat}<br>
                        <strong>No Surat:</strong> ${event.extendedProps.surat}
                    `,
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Edit',
                    denyButtonText: 'Hapus',
                    cancelButtonText: 'Tutup'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `/admin/agenda/${event.id}/edit`;
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: 'Data yang dihapus tidak bisa dikembalikan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((confirmDelete) => {
                            if (confirmDelete.isConfirmed) {
                                fetch(`/admin/agenda/${event.id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    Swal.fire('Terhapus!', data.message, 'success');
                                    event.remove(); // hapus dari kalender
                                })
                                .catch(error => {
                                    Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                                });
                            }
                        });
                    }
                });
            }
        });

        calendar.render();
    });
</script>
@endsection
