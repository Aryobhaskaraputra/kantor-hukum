@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Profil Klien</h1>
    </div>
    <form action="{{ route('client.update', $client->id) }}" enctype="multipart/form-data" method="POST">
        @method('PATCH')
        @csrf
        @if ($errors->any())
            <div class="error-message" style="color: white;">
                {{ $errors->first() }}
            </div>
        @endif
        <input type="hidden" name="id" value="{{ $legalCase->id }}">
        <div class="card mt-2">
            <div class="card-body">
                <div class="container mt-3">
                    <div class="card mt-2 profile-card">
                        <div class="card-body">
                            <div class="profile-card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Informasi Personal</h6>
                            </div>
                            <div class="profile-card-body mt-2 profile-info-container">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="nama_depan" class="form-label">Nama Depan</label>
                                        <input type="text" class="form-control" id="nama_depan" name="nama_depan"
                                            value="{{ $client->nama_depan }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="nama_belakang" class="form-label">Nama Belakang</label>
                                        <input type="text" class="form-control" id="nama_belakang" name="nama_belakang"
                                            value="{{ $client->nama_belakang }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $client->email }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="phone_number" class="form-label">No. Handphone</label>
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                            value="{{ $client->phone_number }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="nomor_induk_kependudukan" class="form-label">Nomor Induk
                                            Kependudukan</label>
                                        <input type="text" class="form-control" id="nomor_induk_kependudukan"
                                            name="nomor_induk_kependudukan" value="{{ $client->nomor_induk_kependudukan }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2 profile-card">
                        <div class="card-body">
                            <div class="profile-card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="profile-card-body mt-2 profile-info-container">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                                        <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3">{{ $client->alamat_lengkap }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="negara" class="form-label">Negara</label>
                                        <input type="text" class="form-control" id="negara" name="negara"
                                            value="{{ $client->negara }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kota_kabupaten" class="form-label">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" id="kota_kabupaten"
                                            name="kota_kabupaten" value="{{ $client->kota_kabupaten }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                            value="{{ $client->kode_pos }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-main text-center btn-upload">Simpan Perubahan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
