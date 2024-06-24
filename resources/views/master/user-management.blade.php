@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Pengguna</h1>
    </div>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <form class="w-100 my-3" action="{{ route('user.search') }}" method="GET">
                <div class="input-group shadow-sm">
                    <input type="search" name="search"
                        class="form-control form-control-dark text-bg-light border-0 rounded-start"
                        placeholder="Cari disini..." aria-label="Search" aria-describedby="basic-addon1"
                        style="border: none;" value="{{ request('search') }}">
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
            <form action="{{ route('User Management Page') }}" method="GET">
                <select class="form-select" id="filter" name="filter" onchange="this.form.submit()">
                    <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Semua</option>
                    <option value="master" {{ request('filter') == 'master' ? 'selected' : '' }}>Master</option>
                    <option value="admin" {{ request('filter') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pengacara" {{ request('filter') == 'pengacara' ? 'selected' : '' }}>Pengacara</option>
                </select>
            </form>
        </div>
    </div>

    <table class="table table-light table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($users->isEmpty())
                <tr>
                    <td colspan="5">
                        <div class="alert alert-light" role="alert">
                            Data tidak ditemukan.
                        </div>
                    </td>
                </tr>
            @else
                @foreach ($users as $user)
                    <tr>
                        <td>
                            @if ($user->profile_photo_url)
                                <img src="{{ asset('storage/' . $user->profile_photo_url) }}" alt="Profile Picture" width="50"
                                    height="50" class="rounded-circle me-2">
                            @else
                                <img src="{{ asset('storage/images/profile-icon.svg') }}" alt="Profile Picture"
                                    width="50" height="50" class="rounded-circle me-2">
                            @endif
                            {{ $user->nama_depan }} {{ $user->nama_belakang }}
                        </td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role_name }}</td>
                        <td>
                            <a href="{{ route('master.user.profile', ['id' => $user->id]) }}" class="action-icon">
                                <i class="fas fa-user">
                                    <img src="{{ asset('storage/images/user.svg') }}" alt="User Icon">
                                </i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{ $users->links() }}
        </ul>
    </nav>
@endsection
