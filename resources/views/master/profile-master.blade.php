@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Profil</h1>
        <a href="{{ route('master.profile.edit', ['id' => $user->id]) }}" class="btn btn-main">
            <img src="{{ asset('storage/images/edit.svg') }}" class="me-2" alt="Dashboard Icon" width="16" height="16">
            Edit Profile
        </a>

    </div>

    <div class="card mt-2">
        <div class="card-body">
            <div class="container mt-3">
                <div class="card profile-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center profile-header-container">
                            <label for="profileImage" class="icon-profile">
                                @if ($user->profile_photo_url)
                                    <img src="{{ asset('storage/' . $user->profile_photo_url) }}" alt="Profile Picture" width="60" height="60">
                                @else
                                    <img src="{{ asset('storage/images/profile-icon.svg') }}" alt="Profile Picture" width="60" height="60">
                                @endif
                                <input type="file" id="profileImage" name="profile_photo" class="d-none" accept="image/*">
                            </label>
                            <div class="ms-2">
                                <h5 class="mb-0">{{ $user->nama_depan }} {{ $user->nama_belakang }}</h5>
                                <p class="mb-0">
                                    @foreach ($roles as $role)
                                        @if ($role->id == $user->role_id)
                                            {{ $role->role_name }}
                                        @endif
                                    @endforeach
                                </p>
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
                                    <p class="mb-0">Nama Depan</p>
                                    <strong>{{ $user->nama_depan }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Nama Belakang</p>
                                    <strong>{{ $user->nama_belakang }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Email</p>
                                    <strong>{{ $user->email }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Nomer Handphone</p>
                                    <strong>{{ $user->phone_number }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Nomor Induk Anggota</p>
                                    <strong>{{ $user->nomor_induk_anggota }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Nomor Induk Kependudukan</p>
                                    <strong>{{ $user->nomor_induk_kependudukan }}</strong>
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
                                    <p class="mb-0">Alamat Lengkap</p>
                                    <strong>{{ $user->alamat_lengkap }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Negara</p>
                                    <strong>{{ $user->negara }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Kota/Kabupaten</p>
                                    <strong>{{ $user->kota_kabupaten }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Kode Pos</p>
                                    <strong>{{ $user->kode_pos }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
