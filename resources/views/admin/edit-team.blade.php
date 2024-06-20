@extends('layouts.app')

@section('title', 'Edit Tim')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Tim</h1>
    </div>

    <form action="{{ route('team.update', $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="container mt-2">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 m-2">
                            <label for="namaKasus" class="form-label">Kasus<span style="color: red;">*</span></label>
                            <div class="dropdown-kasus">
                                <select name="kasus" class="form-select" id="kasusDropdown">
                                    <option value="" disabled>Pilih Nama Kasus...</option>
                                    @foreach ($cases as $case)
                                        <option value="{{ $case->id }}" {{ $case->id == $team->case_id ? 'selected' : '' }}>{{ $case->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="ketuaTeam" class="form-label">Penanggung Jawab Team<span style="color: red;">*</span></label>
                            <div class="dropdown-anggota">
                                <select name="ketua_team" class="form-select" id="ketuaTeamDropdown">
                                    <option value="" disabled>Pilih Penanggung Jawab Team...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $team->leader_id ? 'selected' : '' }}>{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota2" class="form-label">Anggota 2<span style="color: red;">*</span></label>
                            <div class="dropdown-anggota">
                                <select name="anggota2" class="form-select" id="anggota2Dropdown">
                                    <option value="" disabled>Pilih Anggota 2...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $team->member2_id ? 'selected' : '' }}>{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota3" class="form-label">Anggota 3<span style="color: red;">*</span></label>
                            <div class="dropdown-anggota">
                                <select name="anggota3" class="form-select" id="anggota3Dropdown">
                                    <option value="" disabled>Pilih Anggota 3...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $team->member3_id ? 'selected' : '' }}>{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota4" class="form-label">Anggota 4</label>
                            <div class="dropdown-anggota">
                                <select name="anggota4" class="form-select" id="anggota4Dropdown">
                                    <option value="" disabled {{ is_null($team->member4_id) ? 'selected' : '' }}>Pilih Anggota 4...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $team->member4_id ? 'selected' : '' }}>{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota5" class="form-label">Anggota 5</label>
                            <div class="dropdown-anggota">
                                <select name="anggota5" class="form-select" id="anggota5Dropdown">
                                    <option value="" disabled {{ is_null($team->member5_id) ? 'selected' : '' }}>Pilih Anggota 5...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $team->member5_id ? 'selected' : '' }}>{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Centering the button -->
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-main text-center btn-upload">Update Team</button>
            </div>
        </div>
    </form>
@endsection
