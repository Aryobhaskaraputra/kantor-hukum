@extends('layouts.app')
@section('title', 'Ubah Password')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Kata Sandi</h1>
    </div>
    <div class="card mt-2 profile-card">
        <div class="card-body">
            <div class="profile-card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Data Kata Sandi</h6>
            </div>
            <div class="profile-card-body mt-2 profile-info-container">
                <form action="{{ route('change-password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Kata Sandi Lama</label>
                        <input type="password" class="form-control @error('oldPassword') is-invalid @enderror" id="oldPassword" name="oldPassword">
                        @error('oldPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Kata Sandi Baru</label>
                        <input type="password" class="form-control @error('newPassword') is-invalid @enderror" id="newPassword" name="newPassword">
                        @error('newPassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="newPassword_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="form-control" id="newPassword_confirmation" name="newPassword_confirmation">
                    </div>

                    <button type="submit" class="btn btn-main">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    
@endsection
