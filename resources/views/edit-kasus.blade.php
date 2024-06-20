@extends('layouts.app')

@section('title', 'Edit Deskripsi Kasus')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Deskripsi Kasus</h1>
    </div>
    <form action="{{ route('deskripsi_kasus.update', $legalCase->id) }}" enctype="multipart/form-data" method="POST">
        @method('PATCH')
        @csrf
        @if ($errors->any())
            <div class="error-message" style="color: white;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="card mt-2 profile-card">
            <div class="card-body">
                <div class="profile-card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Deskripsi Kasus</h6>
                </div>
                <div class="profile-card-body mt-2 profile-info-container">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <label for="progress_tahapan" class="form-label">Nama Depan</label>
                            @if ($legalCase->progress_tahapan != null)
                                <input type="text" class="form-control" id="progress_tahapan" name="progress_tahapan"
                                    value="{{ $legalCase->progress_tahapan }}">
                            @else
                                <input type="text" class="form-control" id="progress_tahapan" name="progress_tahapan"
                                    placeholder="(Progress Tahapan belum di isi)">
                            @endif
                        </div>
                        <div class="col-12 mb-2">
                            <label for="description" class="form-label">Deskripsi Kasus</label>
                            <input type="text" class="form-control" id="description" name="description"
                                value="{{ $legalCase->description }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <button type="submit" class="btn btn-main text-center btn-upload">Simpan Perubahan</button>
        </div>

    </form>
@endsection
