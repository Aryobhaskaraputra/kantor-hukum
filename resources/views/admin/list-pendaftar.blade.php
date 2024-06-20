@extends('layouts.app')

@section('title', 'List Pendaftar')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">List Pendaftar</h1>
    </div>

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

    <!-- Menampilkan navigasi paginasi Laravel dengan template Bootstrap -->
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            {{ $users->links() }}
        </ul>
    </nav>
@endsection
