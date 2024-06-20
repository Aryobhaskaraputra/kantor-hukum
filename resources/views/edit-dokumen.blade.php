@extends('layouts.app')

@section('title', 'Upload Dokumen')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Update Dokumen</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('file.update', ['id' => $file->id]) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="container mt-5">
            <div class="card card-form-document fw-bold">
                <div class="card-body d-flex align-items-center">
                    <img src="{{ asset('storage/images/document.svg') }}" alt="Document Icon" width="24" height="24">
                    <p class="ms-3 mb-0">{{ $file->file_name }}.{{ $file->file_extension }}</p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="col-md-6 m-2">
                        <div class="mb-2">
                            <label for="fileName" class="form-label">Nama File</label>
                            <input type="text" class="form-control" id="fileName" name="file_name"
                                placeholder="Masukkan nama file..." value="{{ $file->file_name }}">
                        </div>
                        <div class="mb-2">
                            <label for="kasusDropdown" class="form-label">Kasus</label>
                            <select class="form-select shadow" id="kasusDropdown" name="case_id" disabled>
                                <option value="{{ $case->id }}" selected>{{ $case->title }}</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="document" class="form-label">Dokumen Baru</label>
                            <br>
                            <input type="file" class="form-control" id="document" name="document">
                            <span style="color: red; font-size: 10px;">*Dokumen harus berformat PDF, PNG, atau DOCX dan
                                tidak melebihi 2MB.</span>
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
