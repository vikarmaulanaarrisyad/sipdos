@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kuisioner</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Penilaian Dosen</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <x-table class="list-dosen">
                        <x-slot name="thead">
                            <tr>
                                <th style="width: 6%">NO</th>
                                <th>NAMA DOSEN</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </x-slot>
                    </x-table>
                </div>

            </div>
        </div>
    </div>
@endsection

@include('include.datatable')

@push('scripts')
    <script>
        let table;

        table = $('.list-dosen').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('quis.data') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },

                {
                    data: 'dosen'
                },
                {
                    data: 'status'
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ]
        });
    </script>
@endpush
