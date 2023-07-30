@extends('layouts.app')

@section('title', 'Laporan Kuesioner')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <x-card>
                <x-slot name="header">
                    Laporan Nilai
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <th>No</th>
                            <th>Nama Dosen</th>
                            <th>Jml Pengisi</th>
                            <th>Jml Nilai</th>
                            <th>Rata-rata</th>
                            <th>Keterangan</th>
                        </tr>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
@endsection

@include('include.datatable')

@push('scripts')
    <script>
        let table;

        table = $('.table').DataTable({
             processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('report.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'name'
                },

                {
                    data: 'jmlpengisi'
                },

                {
                    data: 'nilai'
                },
                
                {
                    data: 'nilai'
                },
                {
                    data: 'nilai'
                },
            ]
        });
    </script>
@endpush
