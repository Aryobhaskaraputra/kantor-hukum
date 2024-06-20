@extends('layouts.app')

@section('title', 'Detail Kasus')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kasus {{ $legalCase->client->nama_depan }} {{ $legalCase->client->nama_belakang }}</h1>
        @if (Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master'))
            @if ($legalCase->status == 'Proses')
                <form action="{{ route('kasus.tutup', ['legalCase' => $legalCase]) }}" method="POST" class="d-inline"
                    id="tutupKasusForm">
                    @csrf
                    <button class="btn btn-success" type="button" onclick="confirmTutupKasus()">Tutup Kasus</button>
                </form>
            @endif
        @endif

    </div>

    <div class="card card-profile shadow">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="container d-flex align-items-center">
                        <div class="profile-info mx-4">
                            <h6>Nama Client,</h6>
                            {{-- diambil dari table client --}}
                            <h4>{{ $legalCase->client->nama_depan }} {{ $legalCase->client->nama_belakang }}</h4>
                        </div>

                        {{-- Status Alert --}}
                        @if ($legalCase->status == 'Proses')
                            <div class="alert alert-warning alert-status ms-auto">
                                <small class="text-center fw-medium">{{ $legalCase->status }}</small>
                            </div>
                        @else
                            <div class="alert alert-success alert-status ms-auto">
                                <small class="text-center fw-medium">{{ $legalCase->status }}</small>
                            </div>
                        @endif
                    </div>

                    <hr>
                    <div class="container">
                        <div class="row profile-info-util justify-content-between">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/images/phone-call.svg') }}" alt="phone icon">
                                    <span class="m-2">{{ $legalCase->client->phone_number }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/images/email.svg') }}" alt="">
                                    <span class="m-2">{{ $legalCase->client->email }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <a href="{{ route('client.index', ['id' => $legalCase->id, 'client_id' => $legalCase->client->id]) }}"
                                    class="btn btn btn-outline-light">Detail Client...</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card card-kasus">
                                        <div class="card-body d-flex align-items-center justify-content-center flex-column">
                                            <p><span>Kategori Kasus</span></p>
                                            {{-- diambil dari table case --}}
                                            <span class="fw-bold">{{ $legalCase->category->case_categories_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <p><span class="fw-bold">Tanggal Pengurusan Client :</span></p>
                                    <img src="{{ asset('storage/images/clockCountdown.svg') }}" alt="">
                                    {{-- diambil dari table case --}}
                                    <span class="ms-1">{{ $legalCase->created_at->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card mt-3 profile-card">
        <div class="card-body">
            <div class="profile-card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Deskripsi Kasus</h6>
                @if (Auth::check() && Auth::user()->isTeamMember($legalCase))
                    <a href="{{ route('deskripsi_kasus.edit', $legalCase->id) }}" class="btn btn-outline-light">Edit
                        Deskripsi Kasus</a>
                @endif
            </div>
            <div class="profile-card-body mt-2 profile-info-container">
                <div class="row">
                    <!-- Progress Tahapan -->
                    <div class="col-12 mb-2">
                        @if ($legalCase->progress_tahapan != null)
                            <strong class="mb-0">Progress Tahapan</strong>
                            <p>{{ $legalCase->progress_tahapan }}</p>
                        @else
                            <strong class="mb-0">Progress Tahapan</strong>
                            <p class="opacity-50">(Progress Tahapan belum di isi)</p>
                        @endif
                    </div>
                    <!-- Deskripsi Kasus -->
                    <div class="col-12 mb-2">
                        <strong class="mb-0">Deskripsi Kasus</strong>
                        {{-- diambil dari table case --}}
                        <p class="description">{{ $legalCase->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-between mt-4">
        <h5>File Dokumen Client</h5>
        @if (Auth::check() && Auth::user()->isTeamMember($legalCase))
            <a href="{{ route('file.unggah-dokumen') }}" class="btn btn-main btn-sm ms-3">
                <img src="{{ asset('storage/images/plus-icon.svg') }}" alt="Upload Icon" width="16" height="16">
                Unggah Dokumen
            </a>
        @endif
    </div>
    <div class="container mt-3">
        <div class="row">
            @foreach ($legalCase->files as $file)
                <div class="col-12 col-md-4 col-lg-3 mb-4 file-card">
                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="file-link">
                        <div class="card card-custom">
                            <div class="card-header-custom-doc">
                                <div class="d-flex align-items-center">
                                    @if ($file->file_extension == 'pdf')
                                        <img src="{{ asset('storage/images/FilePdf.svg') }}" alt="Icon">
                                    @elseif ($file->file_extension == 'docx')
                                        <img src="{{ asset('storage/images/docx-icon.svg') }}" alt="Icon">
                                    @else
                                        <img src="{{ asset('storage/images/png-icon.svg') }}" alt="Icon">
                                    @endif
                                    <span class="ml-2 file-name text-truncate ">{{ $file->file_name }}</span>
                                </div>
                            </div>
                            @if ($file->file_extension == 'pdf')
                                <img src="{{ asset('storage/images/pdf-thumbnail.svg') }}" class="text-center p-4"
                                    alt="Icon">
                            @elseif ($file->file_extension == 'docx')
                                <img src="{{ asset('storage/images/docx-thumbnail.svg') }}"class="text-center p-4"
                                    alt="Icon">
                            @else
                                <img src="{{ asset('storage/images/png-thumbnail.svg') }}"class="text-center p-4"
                                    alt="Icon">
                            @endif
                        </div>
                    </a>
                    @if (Auth::check() && Auth::user()->isTeamMember($legalCase))
                        <div class="d-flex justify-content-center mt-3">
                            <a href="{{ route('file.edit', ['id' => $file->id]) }}" class="text-decoration-none m-2">
                                <img src="{{ asset('storage/images/edit.svg') }}" alt="Edit Icon" class="icon-action">
                            </a>
                            @if (Auth::check() && (Auth::user()->role->role_name === 'Admin' || Auth::user()->role->role_name === 'Master'))
                                <form action="{{ route('file.destroy', ['file' => $file->id]) }}" method="POST"
                                    class="d-inline" id="hapusFile">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-link p-0 text-decoration-none m-2"
                                        onclick="confirmDelete()">
                                        <img src="{{ asset('storage/images/trash.svg') }}" alt="Trash Icon">
                                    </button>
                                </form>
                            @endif

                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- COMMENTS SECTION --}}
    @if (Auth::check() && Auth::user()->isTeamMember($legalCase))
        <div class="container">
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="profile-card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Komentar</h6>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body scrollable-card-body">
                                    <div class="row">
                                        @forelse ($legalCase->comments as $comment)
                                            <div class="col-md-6 mb-3 ">
                                                <label for="profileImage" class="avatar">
                                                    @if ($comment->user->profile_photo_url)
                                                    <img  src="{{ asset('storage/' . $comment->user->profile_photo_url) }}" alt="Foto Profil"
                                                        class="avatar">
                                                    @else
                                                    <img src="{{ asset('storage/images/profile-icon.svg') }}"
                                                        alt="Foto Profil" class="avatar">
                                                    @endif
                                                </label>
                                              <span class="fw-bold m-2">{{ $comment->user->nama_depan }} {{ $comment->user->nama_belakang }}</span>
                                                <p class="mt-2 mb-0">{{ $comment->content }}</p>
                                                <small
                                                    class="opacity-50 text-nowrap">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                            </div>
                                        @empty
                                            <div class="d-flex justify-content-center align-items-center">
                                                <p class="text-center opacity-50">Tidak ada komentar</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @if (Auth::check() && Auth::user()->isTeamMember($legalCase))
                                <form action="{{ route('comment.store', $legalCase->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group mt-2">
                                        <label for="content">Tambah Komentar</label>
                                        <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-main mt-3">Kirim</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- CASE LOG SESSION --}}
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="profile-card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Aktivitas Kasus</h6>
                        </div>
                        <div class="card-body">
                            <div class="col">
                                <div class="container card-logs">
                                    @if ($activityLogs->isNotEmpty())
                                        @foreach ($activityLogs as $log)
                                            @if ($log->event === null)
                                                <div class="list-group-item list-group-item-action d-flex gap-3 py-3"
                                                    aria-current="true">
                                                    <label for="profileImage" class="avatar">
                                                        @if ($log->causer->profile_photo_url)
                                                        <img  src="{{ asset('storage/' . $log->causer->profile_photo_url) }}" alt="Foto Profil"
                                                            class="avatar">
                                                        @else
                                                        <img src="{{ asset('storage/images/profile-icon.svg') }}"
                                                            alt="Foto Profil" class="avatar">
                                                        @endif
                                                    </label>
                                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                                        <div>
                                                            <h6 class="mb-0">{{ $log->causer->nama_depan ?? 'N/A' }}
                                                                {{ $log->causer->nama_belakang ?? 'N/A' }}</h6>
                                                            <small class="mb-0 opacity-75">{{ $log->description }}</small>
                                                        </div>
                                                        <div class="d-flex flex-column text-end">
                                                            <small
                                                                class="opacity-50 text-nowrap">{{ $log->created_at->format('H:i') }}</small>
                                                            <small
                                                                class="opacity-50 text-nowrap">{{ $log->created_at->format('d/m/Y') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="container">
                                            <h6 class="text-center opacity-50 fw-light m-3">Tidak ada aktivitas.</h6>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
