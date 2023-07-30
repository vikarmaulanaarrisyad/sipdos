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

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <button id="btnTambah" onclick="addFormMatkul(`{{ route('dosen.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                    class="fas fa-plus-circle"></i> Tambah Data Matkul</button>
            </div>
            <div class="card-body">
                <x-table class="matakuliah-table">
                    <x-slot name="thead">
                        <tr>
                            <th>No</th>
                            <th>Matakuliah</th>
                            <th>Semester</th>
                            <th>AKsi</th>
                        </tr>
                    </x-slot>
                </x-table>
            </div>
        </div>

    </div>

    {{--  <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <button onclick="addFormKelas(`{{ route('dosen.store') }}`)" class="btn btn-outline-primary btn-sm"><i
                    class="fas fa-plus-circle"></i> Tambah Data</button>
            </div>
            <div class="card-body">


            </div>
        </div>
    </div>  --}}
</div>

@include('admin.dosen.add_matakuliah')
@endsection

@include('include.datatable')

@push('scripts')
    <script>
        let modal = '.modal-matakuliah';
        let button = '#submitBtn';
        let table1, table2;
        let matakuliah;

        $(function() {
            $('#spinner-border').hide();
        });

        table1 = $('.matkul').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('dosen.matakuliah.data', $dosen->id) }}',
            },
            columns: [
            {
                data: 'select_all',
                searchable: false,
                sortable: false
            },
            {
                data: 'DT_RowIndex',
                searchable: false,
                sortable: false
            },
            {
                data: 'name'
            },
            {
                data: 'semester'
            },
            ]
        });

        table2 = $('.matakuliah-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('dosen.matakuliah', $dosen->id) }}',
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'matakuliah'
                },
                {
                    data: 'semester'
                },
                {
                    data: 'aksi',
                    searchable: false,
                    sortable: false
                },
            ]
        });

        function addFormMatkul(url, title = "Tambah Matakuliah Ajar"){
            $(modal).modal('show');
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            $(button).prop('disabled', false);
            resetForm(`${modal} form`);
        }

        $("#select_all").on('click', function() {
            var isChecked = $("#select_all").prop('checked');

            $(".matakuliah_id").prop('checked', isChecked);
            $("#submitBtn").prop('disabled', !isChecked);
        });

        $('#btnTambah').on('click', function() {
            let checkbox = $('#modal-form #table tbody .matakuliah_id:checked');

            if (checkbox.length > 0) {
                $("#submitBtn").prop('disabled', false);
            }
            $("#submitBtn").prop('disabled', true);
        })

        $("#table tbody").on('click', '.matakuliah_id', function() {
            if ($(this).prop('checked') != true) {
                $("#select_all").prop('checked', false);
            }

            let semua_checkbox = $("#table tbody .matakuliah_id:checked")

            let matakuliah = (semua_checkbox.length > 0)

            $("#submitBtn").prop('disabled', !matakuliah)
        })

        function submitForm(url, dosenId) {

            $('#spinner-border').show();
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menginputkan matakuliah terpilih.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let checkbox_terpilih = $('#modal-form #table tbody .matakuliah_id:checked')
                    let semua_id = []

                    $.each(checkbox_terpilih, function(index, elm) {
                        semua_id.push(elm.value)
                    });

                    $(button).prop('disabled', true);

                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            'matakuliah_id': semua_id,
                            'dosen_id': dosenId
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            }
                            $(modal).modal('hide');
                            $(button).prop('disabled', false);
                            $('#spinner-border').hide();

                            table1.ajax.reload();
                            table2.ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            // Menyembunyikan spinner loading
                            $('#spinner-border').hide();

                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            });

                            // Refresh tabel atau lakukan operasi lain yang diperlukan
                            table1.ajax.reload();
                            table2.ajax.reload();

                        }
                    });
                }
            });
        }

        function deleteMatakuliah(url) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Apakah anda yakin?',
                text: 'Anda akan menghapus matakuliah terpilih.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Iya !',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "delete",
                        url: url,
                        dataType: "json",
                        success: function(response) {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            }
                            table2.ajax.reload();
                            table1.ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan error
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal',
                                text: xhr.responseJSON.message,
                                showConfirmButton: true,
                            });

                            // Refresh tabel atau lakukan operasi lain yang diperlukan
                            table2.ajax.reload();
                            table1.ajax.reload();

                        }
                    });
                }
            });
        }
    </script>
@endpush
