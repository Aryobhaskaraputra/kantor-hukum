@extends('layouts.app')

@section('title', 'List Pendaftar')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">List Pendaftar</h1>
    </div>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <form class="w-100 my-3" action="{{ route('admin.list-pendaftar') }}" method="GET">
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

    <div class="table-responsive">
        <table class="table table-striped table-bordered text-center">
            <thead>
                <tr>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Email</th>
                    <th>NIA</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->nama_depan }}</td>
                        <td>{{ $user->nama_belakang }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nomor_induk_anggota }}</td>
                        <td>{{ $user->status }}</td>
                        <td>
                            @if ($user->status == 'request')
                                <form action="{{ route('admin.store', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-light" role="alert">
                                Tidak ada pendaftaran baru.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{ $users->links() }}
        </ul>
    </nav>
@endsection
