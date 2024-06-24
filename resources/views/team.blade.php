@extends('layouts.app')

@section('title', 'Tim')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Team</h1>
        @if (Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master'))
            <a href="{{ route('team.create') }}" class="btn btn-main">
                <img src="{{ asset('storage/images/plus-icon.svg') }}" class="me-2" alt="Dashboard Icon" width="16"
                    height="16">
                Buat Tim
            </a>
        @endif
    </div>

    <div class="card card-profile shadow">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="container d-flex align-items-center">

                        <label for="profileImage" class="icon-profile">
                            @if ($user->profile_photo_url)
                                <img src="{{ asset('storage/' . $user->profile_photo_url) }}" alt="Profile Picture"
                                    width="60" height="60">
                            @else
                                <img src="{{ asset('storage/images/profile-icon.svg') }}" alt="Profile Picture"
                                    width="60" height="60">
                            @endif
                        </label>

                        <div class="profile-info mx-4">
                            <h6>Hello,</h6>
                            <h4>{{ $user->nama_depan }} {{ $user->nama_belakang }}</h4>
                        </div>
                    </div>
                    <hr>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-4">
                                <img src="storage/images/IdentificationBadge.svg" alt="">
                                {{-- diambil dari id user --}}
                                <span class="ms-1">{{ $user->id }}</span>
                            </div>
                            <div class="col">
                                <img src="storage/images/email.svg" alt="">
                                {{-- diambil dari email user --}}
                                <span class="ms-1">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="card card-role">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <p class="fw-bold">Jumlah Tim:</p>
                                    <p>{{ $teamCount }} tim</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <form class="w-100 my-3" action="{{ route('team.index') }}" method="GET">
                <div class="input-group shadow-sm">
                    <input type="search" name="filter" value="{{ $filter }}"
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
            <form action="{{ route('team.index') }}" method="GET">
                <select class="form-select" id="filter" name="filter" onchange="this.form.submit()">
                    <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Semua</option>
                    <option value="selesai" {{ request('filter') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="belum_selesai" {{ request('filter') == 'belum_selesai' ? 'selected' : '' }}>Proses
                    </option>
                </select>
            </form>
        </div>
    </div>
    @if ($teams->isEmpty())
        <div class="alert alert-light" role="alert">
            Anda belum terdaftar di tim manapun.
        </div>
    @else
        <div class="container mt-4">

            @foreach ($teams as $key => $team)
                <div class="accordion mt-3" id="documentAccordion {{ $key }}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $key }}">
                            <button
                                class="accordion-button collapsed card-header-team d-flex justify-content-between align-items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                aria-expanded="false" aria-controls="collapse{{ $key }}">
                                <span>{{ $team->title }}</span>
                                @if ($team->status == 'Proses')
                                    <div class="alert alert-warning alert-status mb-0 ms-3 p-1">
                                        <small class="text-center fw-medium">{{ $team->status }}</small>
                                    </div>
                                @else
                                    <div class="alert alert-success alert-status mb-0 ms-3 p-1">
                                        <small class="text-center fw-medium">{{ $team->status }}</small>
                                    </div>
                                @endif
                            </button>
                        </h2>
                        <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $key }}"
                            data-bs-parent="#documentAccordion{{ $key }}">
                            <div class="accordion-body card-body">
                                {{-- diambil dari table tim --}}
                                <p>Penanggung Jawab Tim: <strong>{{ $team->team->leader->nama_depan }}
                                        {{ $team->team->leader->nama_belakang }}
                                        ({{ $team->team->leader->id }})
                                    </strong></p>
                                <p>Anggota Tim: <strong>
                                        @foreach (['member2', 'member3', 'member4', 'member5'] as $memberKey)
                                            @php
                                                $member = $team->team->$memberKey;
                                            @endphp
                                            @if ($member)
                                                <li>{{ $member->nama_depan }} {{ $member->nama_belakang }}
                                                    ({{ $member->id }})</li>
                                            @endif
                                        @endforeach
                                    </strong>
                                </p>
                                <p>Tanggal pembentukan tim: <strong>{{ $team->created_at->format('d/m/Y H:i') }}</strong>
                                </p>
                                <p>Dibuat Oleh: <strong>{{ $team->team->creator->nama_depan }}
                                        {{ $team->team->creator->nama_belakang }}
                                        ({{ $team->team->creator->role->role_name }})</strong></p>
                                <div class="d-flex">
                                    @if (Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master'))
                                        <a href="{{ route('team.edit', ['team' => $team->team->id]) }}"
                                            class="btn btn-warning text-center mx-2">Update
                                            Tim</a>
                                    @endif
                                    <a href="{{ route('kasus.show', ['legalCase' => $team->id]) }}"
                                        class="btn btn-main">Detail Kasus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="d-flex align-items-center">
                    <nav aria-label="Page navigation">
                        {{ $teams->links() }}
                    </nav>
                </div>
            </div>
        </div>
    @endif
@endsection
