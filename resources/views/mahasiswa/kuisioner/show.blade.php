@extends('layouts.app')

@section('title', 'Kuesioner - ' . $dosen->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Kuesioner</li>
    <li class="breadcrumb-item active">Isi Kuesioner</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <form method="post">
                @csrf

                @method('POST')

                <input type="hidden" name="dosen_id" value="{{ $dosen->id }}">

                <x-card>
                    <x-slot name="header">
                        <p class="text-info">Anda sedang memberikan penilaian terhadap dosen :
                            <strong>{{ $dosen->name }}</strong>
                        </p>
                    </x-slot>
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach ($kuesioner as $key => $quis)
                                <input type="hidden" name="quis" value="{{ $quis->id }}">
                                <div class="form-group">
                                    <label for="quis_id">{{ $quis->quis }}</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="quis_id[{{ $quis->id }}]"
                                            class="custom-control-input" id="4 {{ $quis->id }}" value="4">
                                        <label class="custom-control-label font-weight-normal"
                                            for="4 {{ $quis->id }}">Sangat
                                            Baik</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="quis_id[{{ $quis->id }}]"
                                            class="custom-control-input" id="3 {{ $quis->id }}" value="3">
                                        <label class="custom-control-label font-weight-normal"
                                            for="3 {{ $quis->id }}">Baik</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="quis_id[{{ $quis->id }}]"
                                            class="custom-control-input" id="2 {{ $quis->id }}" value="2">
                                        <label class="custom-control-label font-weight-normal"
                                            for="2 {{ $quis->id }}">Cukup</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="quis_id[{{ $quis->id }}]"
                                            class="custom-control-input" id="1 {{ $quis->id }}" value="1">
                                        <label class="custom-control-label font-weight-normal"
                                            for="1 {{ $quis->id }}">Kurang</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <x-slot name="footer">
                        <button type="button" onclick="submitForm(this.form)" class="btn btn-primary btn-sm"><i
                                class="fas fa-save"></i>
                            Simpan</button>
                    </x-slot>
                </x-card>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function submitForm(originalForm) {
            $.post({
                    url: '{{ route('quis.store') }}',
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(function() {

                            window.location.href = '{{ route('quis.index') }}'
                        })

                    }
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }
    </script>
@endpush
