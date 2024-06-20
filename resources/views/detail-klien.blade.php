@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Profil Klien</h1>
        @if (Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master'))
            <a href="{{ route('client.edit', ['id' => $legalCase->id, 'client_id' => $legalCase->client->id]) }}"
                class="btn btn-main">
                <img src="{{ asset('storage/images/edit.svg') }}" class="me-2" alt="Dashboard Icon" width="16"
                    height="16">
                Edit Profil Klien
            </a>
        @endif

    </div>

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
                                    <p class="mb-0">Nama Depan</p>
                                    <strong>{{ $client->nama_depan }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Nama Belakang</p>
                                    <strong>{{ $client->nama_belakang }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Email</p>
                                    <strong>{{ $client->email }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Nomer Handphone</p>
                                    <strong>{{ $client->phone_number }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Nomor Induk Kependudukan</p>
                                    <strong>{{ $client->nomor_induk_kependudukan }}</strong>
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
                                    <strong>{{ $client->alamat_lengkap }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Negara</p>
                                    <strong>{{ $client->negara }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Kota/Kabupaten</p>
                                    <strong>{{ $client->kota_kabupaten }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p class="mb-0">Kode Pos</p>
                                    <strong>{{ $client->kode_pos }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
