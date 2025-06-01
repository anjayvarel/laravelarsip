<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Surat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 11px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            margin: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            white-space: pre-line;
        }

        th {
            background-color: #eee;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Surat UPTD Badung Utara</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($dari_tanggal)->format('d-m-Y') }} Sampai Dengan {{ \Carbon\Carbon::parse($sampai_tanggal)->format('d-m-Y') }}</p>
        <p>Diunduh Pada Tanggal: {{ date('d-m-Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 17%;">No Surat</th>
                <th style="width: 15%;">Pengirim</th>
                <th style="width: 10%;">Tgl Surat</th>
                <th style="width: 13%;">Tgl Diterima/Dibuat</th>
                <th style="width: 22%;">Perihal</th>
                <th style="width: 10%;">Jenis</th>
                <th style="width: 10%;">Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($surats as $key => $surat)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $surat->no_surat }}</td>
                    <td>{{ $surat->pengirim }}</td>
                    <td>{{ date('d-m-Y', strtotime($surat->tanggal_surat)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($surat->tanggal_diterima)) }}</td>
                    <td>{{ $surat->perihal }}</td>
                    <td>{{ ucfirst($surat->jenis_surat) }}</td>
                    <td>{{ $surat->kategori ? $surat->kategori->nama : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Terima kasih atas perhatian Anda.</p>
    </div>
</body>
</html>
