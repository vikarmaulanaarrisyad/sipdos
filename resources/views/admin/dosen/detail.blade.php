@extends('layouts.app')

@section('title', $dosen->name)

@section('breadcrumb')
@parent
<li class="breadcrumb-item"><a href="{{ route('dosen.index') }}">Data Dosen</a> </li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">

        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('AdminLTE/dist/img/ruangkelasicon.png') }}"
                        alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $dosen->name }}</h3>
                <p class="text-muted text-center">{{ $dosen->jenis_kel }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <button onclick="addFormMatkul(`{{ route('dosen.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                    class="fas fa-plus-circle"></i> Tambah Data Matkul</button>
            </div>
            <div class="card-body">


            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <button onclick="addFormKelas(`{{ route('dosen.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                    class="fas fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="card-body">
               

            </div>
        </div>
    </div>
</div>

<x-modal data-backdrop="static" data-keyboard="false" size="modal-md" class="modal-kelas">
    <x-slot name="title">
        Tambah Daftar Kelas
    </x-slot>

    @method('POST')

    <x-table class="matkul">
        <x-slot name="thead">
            <tr>
                <th>No</th>
                <th>Matkul</th>
            </tr>
        </x-slot>
    </x-table>
    

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-outline-primary" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-outline-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>

@endsection

@include('include.datatable')

@push('scripts')
    <script>
        let modalKelas = '.modal-kelas';
        let button = '#submitBtn';
        let matkul;

        $(function() {
            $('#spinner-border').hide();
        });

        matkul = $('.matkul').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('matakuliah.dosen') }}',
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },

                {
                    data: 'name'
                },
            ]
        });

        function addFormMatkul(url, title = "Tambah Matakuliah Ajar"){
            $(modalKelas).modal('show');
            $(modalKelas).modal('show');
            $(`${modalKelas} .modal-title`).text(title);
            $(`${modalKelas} form`).attr('action', url);
            $(`${modalKelas} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            $(button).prop('disabled', false);
            resetForm(`${modalKelas} form`);
        }
    </script>
@endpush
