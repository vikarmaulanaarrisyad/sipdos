@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>

            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h4 class="login-heading text-bold text-center">
                                    {{ $setting->nama_singkatan ?? config('app.name') }}</h4>
                                <h4 class="login-heading text-bold text-center mb-4">Politeknik Harapan Bersama</h4>
                                <p>{{ $setting->diskripsi_aplikasi ?? '' }}</p>
                                {{-- Form --}}
                                <form action="{{ route('register') }}" method="post">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label for="name">Nama <span class="text-danger"
                                                style="font-size: 0.84em">Mahasiswa</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" autocomplete="off">

                                        @error('name')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="nim">NIM <span class="text-danger"
                                                style="font-size: 0.84em">Mahasiswa</span></label>
                                        <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                            id="nim" name="nim" value="{{ old('nim') }}" autocomplete="off">

                                        @error('nim')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email">Email <span class="text-danger"
                                                style="font-size: 0.84em">Mahasiswa</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" autocomplete="off">

                                        @error('email')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="password">Password <span class="text-danger"
                                                style="font-size: 0.84em">Mahasiswa</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" autocomplete="off">

                                        @error('password')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password_confirmation">Konfirmasi Password <span class="text-danger"
                                                style="font-size: 0.84em">Mahasiswa</span></label>
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation">

                                        @error('password_confirmation')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group d-flex justify-content-between align-items-center mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label for="customCheck1" class="custom-control-label text-muted">show
                                                password</label>
                                        </div>
                                        {{-- <a href="#" class="small mt-1 text-muted">Lupa Password?</a> --}}
                                    </div>

                                    <div>
                                        <button class="btn btn-lg btn-primary btn-login mb-2">
                                            <i class="fas fa-sign-in-alt"></i> Register
                                        </button>
                                    </div>
                                    <div class="text-center mt-3">
                                        <div class="text-muted">
                                            Sudah punya akun silahkan login
                                            <a href="{{ route('login') }}" class="text-muted">disini</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<x-notif></x-notif>
