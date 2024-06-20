@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Profil</h1>
    </div>
    <form action="{{ route('master.profile.update', ['id' => $user->id]) }}" enctype="multipart/form-data" method="POST">
        @method('PATCH')
        @csrf
        @if ($errors->any())
            <div class="error-message" style="color: white;">
                {{ $errors->first() }}
            </div>
        @endif
        <div class="card mt-2">
            <div class="card-body">
                <div class="container mt-3">
                    <div class="card profile-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center profile-header-container">
                                <label for="profileImage" class="profile-avatar">
                                    @if ($user->profile_photo_url)
                                        <img src="{{ asset('storage/' . $user->profile_photo_url) }}" alt="Profile Picture"
                                            width="60" height="60">
                                    @else
                                        <img src="{{ asset('storage/images/profile-icon.svg') }}" alt="Profile Picture"
                                            width="60" height="60">
                                    @endif
                                    <input type="file" id="profileImage" name="profile_photo" class="d-none"
                                        accept="image/*">
                                </label>
                                <div class="ms-2">
                                    <h5 class="mb-0">{{ $user->nama_depan }} {{ $user->nama_belakang }}</h5>
                                    <div class="mb-2 me-2">
                                        <label for="role" class="form-label">Role:</label>
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-auto">
                                                <select class="form-select form-select-sm" id="role" name="role_id">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $role->id == $user->role_id ? 'selected' : '' }}>
                                                            {{ $role->role_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <p class="mb-0">{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            value="{{ $user->nama_depan }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="nama_belakang" class="form-label">Nama Belakang</label>
                                        <input type="text" class="form-control" id="nama_belakang" name="nama_belakang"
                                            value="{{ $user->nama_belakang }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="phone_number" class="form-label">No. Handphone</label>
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number"
                                            value="{{ $user->phone_number }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="nomor_induk_anggota" class="form-label">Nomor Induk Anggota</label>
                                        <input type="text" class="form-control" id="nomor_induk_anggota"
                                            name="nomor_induk_anggota" value="{{ $user->nomor_induk_anggota }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="nomor_induk_kependudukan" class="form-label">Nomor Induk
                                            Kependudukan</label>
                                        <input type="text" class="form-control" id="nomor_induk_kependudukan"
                                            name="nomor_induk_kependudukan" value="{{ $user->nomor_induk_kependudukan }}">
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
                                        <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3">{{ $user->alamat_lengkap }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="negara" class="form-label">Negara</label>
                                        <input type="text" class="form-control" id="negara" name="negara"
                                            value="{{ $user->negara }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kota_kabupaten" class="form-label">Kota/Kabupaten</label>
                                        <input type="text" class="form-control" id="kota_kabupaten"
                                            name="kota_kabupaten" value="{{ $user->kota_kabupaten }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" id="kode_pos" name="kode_pos"
                                            value="{{ $user->kode_pos }}">
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
