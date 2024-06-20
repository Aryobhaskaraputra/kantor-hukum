@extends('layouts.app')

@section('title', 'Tambah Kasus')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Kasus</h1>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('kasus.store') }}" method="POST">
        @csrf

        <div class="card mt-2">
            <div class="card-body">
                <div class="container mt-3">
                    <div class="card mt-2 profile-card">
                        <div class="card-body">
                            <div class="profile-card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Informasi Kasus Client</h6>
                            </div>
                            <div class="profile-card-body mt-2 profile-info-container">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="judulKasus" class="form-label">Judul Kasus<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="judulKasus" id="judulKasus"
                                            placeholder="Masukan Judul Kasus..."value="{{ old('judulKasus') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kategoriKasus" class="form-label">
                                            Kasus<span style="color: red;">*</span>
                                        </label>
                                        <div class="dropdown-kasus">
                                            <select class="form-select shadow" name="kategoriKasus" id="kasusDropdown">
                                                <option disabled selected>Masukan Kategori Kasus...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('kategoriKasus') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->case_categories_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <label for="deskripsiKasus" class="form-label">Deskripsi Kasus<span
                                                style="color: red;">*</span></label>
                                        <textarea class="form-control" name="deskripsiKasus" id="deskripsiKasus" rows="3"
                                            placeholder="Masukan Deskripsi Kasus...">{{ old('deskripsiKasus') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2 profile-card">
                        <div class="card-body">
                            <div class="profile-card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Informasi Pribadi Client</h6>
                            </div>
                            <div class="profile-card-body mt-2 profile-info-container">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="namaDepan" class="form-label">Nama Depan<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="namaDepan" id="namaDepan"
                                            placeholder="Masukan Nama Depan Client..." value="{{ old('namaDepan') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="namaBelakang" class="form-label">Nama Belakang<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="namaBelakang" id="namaBelakang"
                                            placeholder="Masukan Nama Belakang Client..." value="{{ old('namaBelakang') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="email" class="form-label">Email<span
                                                style="color: red;">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Masukan Email Client..." value="{{ old('email') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="phone" class="form-label">No. Handphone<span
                                                style="color: red;">*</span></label>
                                        <input type="tel" class="form-control" name="phone" id="phone"
                                            placeholder="Masukan No.Handphone Client..." value="{{ old('phone') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="nik" class="form-label">Nomor Induk Kependudukan<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="nik" id="nik"
                                            placeholder="Masukan Nomor Induk Kependudukan Client..."value="{{ old('nik') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2 profile-card">
                        <div class="card-body">
                            <div class="profile-card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Alamat Client</h6>
                            </div>
                            <div class="profile-card-body mt-2 profile-info-container">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="alamat" class="form-label">Alamat Lengkap<span
                                                style="color: red;">*</span></label>
                                        <textarea class="form-control" name="alamat" id="alamat" rows="3"
                                            placeholder="Masukan Alamat Lengkap Client...">{{ old('alamat') }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="negara" class="form-label">Negara<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="negara" id="negara"
                                            placeholder="Masukan Negara Client..." value="{{ old('negara') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kota" class="form-label">Kota/Kabupaten<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="kota" id="kota"
                                            placeholder="Masukan Kota/Kabupaten Client..." value="{{ old('kota') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="kodePos" class="form-label">Kode Pos<span
                                                style="color: red;">*</span></label>
                                        <input type="text" class="form-control" name="kodePos" id="kodePos"
                                            placeholder="Masukan Kode Pos Client..." value="{{ old('kodePos') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-main text-center btn-upload">Buat Kasus</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
