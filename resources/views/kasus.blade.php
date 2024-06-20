@extends('layouts.app')

@section('title', 'Kasus Client')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kasus Client</h1>
        @if (Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master'))
            <a href="{{ route('kasus.create') }}" class="btn btn-main">
                <img src="{{ asset('storage/images/plus-icon.svg') }}" class="me-2" alt="Dashboard Icon" width="16"
                    height="16">
                Tambah Kasus
            </a>
        @endif
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <form class="w-100 my-3" action="{{ route('kasus.search') }}" method="GET">
                <div class="input-group shadow-sm">
                    <input type="search" name="search"
                        class="form-control form-control-dark text-bg-light border-0 rounded-start"
                        placeholder="Cari disini..." aria-label="Search" aria-describedby="basic-addon1"
                        style="border: none;">
                    <button
                        class="input-group-text bg-white border-0 rounded-end d-flex align-items-center justify-content-center"
                        style="min-width: 50px;">
                        <img src="{{ asset('storage/images/MagnifyingGlass.svg') }}" alt="Search Icon" width="16"
                            height="16">
                    </button>
                </div>
            </form>
        </div>
    </nav>

    <div class="row mb-3">
        <div class="col-auto">
            <label class="col-form-label">Filter:</label>
        </div>
        <div class="col-auto">
            <form action="{{ route('kasus.index') }}" method="GET">
                <select class="form-select" id="filter" name="filter" onchange="this.form.submit()">
                    <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Semua</option>
                    <option value="selesai" {{ request('filter') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="belum_selesai" {{ request('filter') == 'belum_selesai' ? 'selected' : '' }}>Proses
                    </option>
                </select>
            </form>
        </div>
    </div>


    <div class="container mt-4">
        @if ($cases->isEmpty())
            <div class="alert alert-light" role="alert">
                Data tidak ditemukan.
            </div>
        @else
            @foreach ($cases as $case)
                <div class="card mb-3">
                    <div class="card-header p-3 card-header-custom d-flex justify-content-between align-items-center">
                        <h5>{{ $case->title }}</h5>
                        @if ($case->status == 'Proses')
                            <div class="alert alert-warning alert-status">
                                <small class="text-center fw-medium">{{ $case->status }}</small>
                            </div>
                        @else
                            <div class="alert alert-success alert-status">
                                <small class="text-center fw-medium">{{ $case->status }}</small>
                            </div>
                        @endif
                    </div>
                    <div class="card-body card-body-custom">
                        <div class="container container-custom d-flex mb-4">
                            <div class="team-info">
                                <img src="storage/images/team.svg" alt="">
                                <small>Lawyer & Partner</small>
                            </div>
                            <div class="vertical-line"></div>
                            @if ($case->team)
                                <div class="team-members d-flex align-items-center">
                                    @php
                                        $teamExists = false;
                                    @endphp
                                    @foreach (['leader', 'member2', 'member3', 'member4', 'member5'] as $member)
                                        @if ($case->team->$member)
                                            @php
                                                $teamExists = true;
                                            @endphp
                                            @if (!$loop->first)
                                                <div class="vertical-line"></div>
                                            @endif
                                            <div class="team-member">
                                                <small>{{ $case->team->$member->id }} -
                                                    {{ $case->team->$member->nama_depan }}
                                                    {{ $case->team->$member->nama_belakang }}</small>
                                            </div>
                                        @endif
                                    @endforeach
                                    @unless ($teamExists)
                                        <small>(Tim belum terdaftar)</small>
                                    @endunless
                                </div>
                            @else
                                <small class="opacity-50">(Tim belum terdaftar)</small>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="info-box text-center">
                                    <p class="info-box-title">Kategori</p>
                                    <p class="info-box-content">
                                        @foreach ($categories as $category)
                                            @if ($category->id == $case->category_id)
                                                {{ $category->case_categories_name }}
                                            @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="info-box text-center">
                                    <p><span class="fw-bold">Tanggal Pengurusan Client :</span></p>
                                    <img src="storage/images/clockCountdown.svg" alt="">
                                    <span class="ms-1">{{ $case->created_at->translatedFormat('d F Y') }}</span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="info-box text-center">
                                    <p class="info-box-title">Progres Tahapan</p>
                                    @if ($case->progress_tahapan != null)
                                        <p class="info-box-content">{{ $case->progress_tahapan }}</p>
                                    @else
                                        <p class="info-box-content opacity-50">(Progress Tahapan belum di isi)</p>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <small class="opacity-50">Aktivitas Terakhir:
                                    {{ $case->updated_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <a href="{{ route('kasus.show', ['legalCase' => $case->id]) }}" class="btn btn-main"> Detail
                                kasus
                                <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
