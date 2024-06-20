@extends('layouts.app')

@section('title', 'home')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{-- upload document section --}}
            <div class="card mb-4 card-document shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col d-flex align-items-center justify-content-between">
                            <p class="fw-bold mb-0">Unggah Dokumen Cepat</p>
                            <a href="{{ route('file.unggah-dokumen') }}" class="btn btn-main btn-sm ms-3">
                                <img src="storage/images/plus-icon.svg" alt="Upload Icon" width="16" height="16">
                                Unggah Dokumen
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            {{-- informasi kasus section --}}
            <div class="card mb-4 shadow">
                <div class="col d-flex align-items-center justify-content-between">
                    <p class="fw-bold m-3">Informasi Kasus Terbaru</p>
                    <a href="{{ route('kasus.index') }}" class="btn btn-lihat-semua m-3">Lihat Semua</a>
                </div>
                @foreach ($cases as $case)
                    <div class="card mx-3 mb-2 card-informasi-client">
                        <div class="document">
                            <div class="card-header profile-card-header">
                                {{ $case->title }}
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p><span class="fw-bold">Nama Client:</span> {{ $case->client->nama_depan }} {{ $case->client->nama_belakang }}</p>
                                        <p><span class="fw-bold">Kategori Kasus:</span>
                                            @foreach ($categories as $category)
                                                @if ($category->id == $case->category_id)
                                                    {{ $category->case_categories_name }}
                                                @endif
                                            @endforeach
                                        </p>
                                        <p><span class="fw-bold">Tanggal Pengurusan Client: </span> {{ $case->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                    </div>
                                        <div class="d-flex">
                                            <a href="{{ route('kasus.show', ['legalCase' => $case->id]) }}" class="btn btn-main">Detail Kasus</a>
                                        </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- team activities section --}}
        <div class="col-md-4">
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <div class="card card-role">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <p>Kasus Anda yang Sedang Berlangsung: </p>
                            <p class="fw-bold fs-3">{{ $ongoingCase->count() }} Kasus</p>
                            <small class="opacity-50">*Anda dapat memeriksanya di halaman Tim</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4 shadow">
                <div class="card-body">
                    <div class="card card-role">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <p >Kasus Anda yang Telah Selesai:</p>
                            <p class="fw-bold fs-3">{{ $completedCasesCount['count'] }} Kasus</p>
                            <small class="opacity-50">*Anda dapat memeriksanya di halaman Tim</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
