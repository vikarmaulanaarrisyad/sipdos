<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penilaian Dosen</title>

    <link rel="stylesheet" href="{{ public_path('/AdminLTE/dist/css/adminlte.min.css') }}">
</head>

<body>

    <h4 class="text-center">Laporan Penilaian Dosen</h4>

    <table class="table table-bordered table-sm" style="width: 100%">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Nama Dosen</th>
                <th style="text-align: center;">Jumlah Pengisi</th>
                <th style="text-align: center;">Jumlah Nilai</th>
                <th style="text-align: center;">Peringkat</th>
                <th style="text-align: center;">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $row->name }}</td>
                  <td style="text-align: center">{{ $row->jumlahPengisi  }}</td>
                  <td style="text-align: center">{{ $row->nilai }}</td>
                  <td style="text-align: center">{{ $row->peringkat }}</td>
                  <td style="text-align: center">{{ $row->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <p class="text-right mr-4" style="margin-bottom: 0">Tegal, {{ tanggal_indonesia(Date('Y-m-d')) }}</p>
        <p class="text-right mr-5" style="margin-bottom: 0">Disahkan Oleh</p>
        <p class="text-right text-bold" style="margin-right: 4.5em">Ka Prodi</p>
        <p class="text-right mr-1" style="margin-right: 4.5em; margin-top: 4em; text-decoration: underline; margin-bottom: 0px;">Ida Afriliana, S.T., M.Kom</p>
        <p class="text-right" style="margin-right: 2.5em">NIPY. 12.013.168</p>
    </div>

</body>

</html>
