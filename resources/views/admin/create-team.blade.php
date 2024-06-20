@extends('layouts.app')

@section('title', 'Buat Team')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Buat Team</h1>
    </div>

    <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container mt-2">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 m-2">
                            <label for="namaKasus" class="form-label">Kasus<span style="color: red;">*</span></label>
                            <div class="dropdown-kasus">
                                <select name="kasus" class="form-select" id="kasusDropdown">
                                    <option value="" disabled selected>Pilih Nama Kasus...</option>
                                    @foreach ($cases as $case)
                                        <option value="{{ $case->id }}">{{ $case->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        <div class="col-md-6 m-2">
                            <label for="ketuaTeam" class="form-label">Penanggung Jawab Team<span style="color: red;">*</span></label>
                            <div class="dropdown-anggota">
                                <select name="ketua_team" class="form-select" id="ketuaTeamDropdown">
                                    <option value="" disabled selected>Pilih Penanggung Jawab Team...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota2" class="form-label">Anggota 2<span style="color: red;">*</span></label>
                            <div class="dropdown-anggota">
                                <select name="anggota2" class="form-select" id="anggota2Dropdown">
                                    <option value="" disabled selected>Pilih Anggota 2...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota3" class="form-label">Anggota 3<span style="color: red;">*</span></label>
                            <div class="dropdown-anggota">
                                <select name="anggota3" class="form-select" id="anggota3Dropdown">
                                    <option value="" disabled selected>Pilih Anggota 3...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota4" class="form-label">Anggota 4</label>
                            <div class="dropdown-anggota">
                                <select name="anggota4" class="form-select" id="anggota4Dropdown">
                                    <option value="" disabled selected>Pilih Anggota 4...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 m-2">
                            <label for="anggota5" class="form-label">Anggota 5</label>
                            <div class="dropdown-anggota">
                                <select name="anggota5" class="form-select" id="anggota5Dropdown">
                                    <option value="" disabled selected>Pilih Anggota 5...</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->nama_depan }} {{ $user->nama_belakang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Centering the button -->
            <div class="d-flex justify-content-center mt-3">
                <button type="submit" class="btn btn-main text-center btn-upload">Buat Team</button>
            </div>
        </div>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#kasusDropdown').select2();
            $('#ketuaTeamDropdown').select2();
            $('#anggota2Dropdown').select2();
            $('#anggota3Dropdown').select2();
            $('#anggota4Dropdown').select2();
            $('#anggota5Dropdown').select2();

            // Add search functionality to the input fields
            function setupSearch(inputId, dropdownId) {
                $(inputId).on('input', function() {
                    var searchValue = $(this).val().toLowerCase();
                    $(dropdownId).find('option').each(function() {
                        var text = $(this).text().toLowerCase();
                        if (text.includes(searchValue)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                    $(dropdownId).select2();
                });
            }

            setupSearch('#kasusSearch', '#kasusDropdown');
            setupSearch('#ketuaTeamSearch', '#ketuaTeamDropdown');
            setupSearch('#anggota2Search', '#anggota2Dropdown');
            setupSearch('#anggota3Search', '#anggota3Dropdown');
            setupSearch('#anggota4Search', '#anggota4Dropdown');
            setupSearch('#anggota5Search', '#anggota5Dropdown');
        });
    </script>
@endsection
