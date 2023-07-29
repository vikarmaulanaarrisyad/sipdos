@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard mahasiswa</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            {{--  @dd($kuisionerDetail)  --}}
            @if ($kuisionerDetail->isNotEmpty())
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Terimakasih!</h5>
                    {{ $user->name }} sudah melakukan pengisian kuisioner ini.
                </div>
                @else

                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Maaf!</h5>
                    {{ $user->name }} belum melakukan pengisian kuisioner.
                </div>
            @endif
        </div>
    </div>
@endsection
