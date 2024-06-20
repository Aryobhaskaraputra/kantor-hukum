@extends('layouts.app')

@section('title', 'Upload Dokumen')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload Dokumen</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container mt-5">
            <div class="card card-form-document " id="uploadCard">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <img src="{{ asset('storage/images/document.svg') }}" alt="Upload Document Icon">
                    <p class="fw-bold">Upload Document</p>
                    <span style="color: red; font-size:10px;">Dokumen harus berformat PDF, PNG, atau DOCX dan tidak melebihi 2MB.</span>
                    <input type="file" name="document" class="form-control mt-3" id="fileInput" style="display: none;">
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">

                    <div class="col-md-6 m-2">
                        <div class="col-md-6 mb-2">
                            <label for="fileName" class="form-label">Nama File<span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="fileName" name="file_name"
                                placeholder="Masukan nama file...">
                        </div>
                        <label for="kasusDropdown" class="form-label">Kasus<span style="color: red;">*</span></label>
                        <div class="dropdown dropdown-kasus">
                            <select class="form-select shadow" id="kasusDropdown" name="kasusDropdown">
                                <!-- Contoh data kasus, sesuaikan dengan data dari database -->
                                @foreach ($cases as $case)
                                    <option value="{{ $case->id }}">{{ $case->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-main text-center btn-upload">Upload Dokumen</button>
            </div>
        </div>
    </form>
@endsection
