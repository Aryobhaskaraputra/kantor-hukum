<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('iconWeb.svg') }}" type="image/svg+xml">
    <title>@yield('title', 'Daftar Akun')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center vh-100">
            <img src="{{ asset('storage/images/Logo.svg') }}" alt="logo" width="100" height="100">
            <div class="col-md-6">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form container" method="POST" action="{{ route('submit.register') }}">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="nama_depan" class="form-label fw-bold">Nama Depan</label>
                            <div class="inputForm">
                                <input type="text" class="form-control input" id="nama_depan" name="nama_depan"
                                    placeholder="Masukan nama depan anda..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="nama_belakang" class="form-label fw-bold">Nama Belakang</label>
                            <div class="inputForm">
                                <input type="text" class="form-control input" id="nama_belakang" name="nama_belakang"
                                    placeholder="Masukan nama belakang anda..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="inputForm">
                                <input type="email" class="form-control input" id="email" name="email"
                                    placeholder="Masukan email anda..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="nomor_induk_anggota" class="form-label fw-bold">Nomor Induk Anggota</label>
                            <div class="inputForm">
                                <input type="text" class="form-control input" id="nomor_induk_anggota"
                                    name="nomor_induk_anggota" placeholder="Masukan nomor induk anggota anda..."
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="button-submit">Daftar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
</body>

</html>
