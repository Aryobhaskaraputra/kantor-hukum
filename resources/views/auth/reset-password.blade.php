<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('iconWeb.svg') }}" type="image/svg+xml">
    <title>@yield('title', 'Reset Password')</title>
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
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}" class="form container">
                    @csrf
                    <input type="hidden" name="token" value="{{ request()->route('token') }}">
                    <div class="row">
                        <div class="col">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="inputForm d-flex align-items-center">
                                <img src="{{ asset('storage/images/email-icon.svg') }}" alt="email-icon">
                                <input type="email" class="form-control input" id="email" name="email"
                                    placeholder="Masukan email anda..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="password" class="form-label fw-bold">Kata Sandi Baru</label>
                            <div class="inputForm d-flex align-items-center">
                                <img src="{{ asset('storage/images/password-icon.svg') }}" alt="password-icon">
                                <input type="password" class="form-control input" id="password" name="password"
                                    placeholder="Masukan kata sandi baru anda..." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Kata Sandi
                                Baru</label>
                            <div class="inputForm d-flex align-items-center">
                                <img src="{{ asset('storage/images/password-icon.svg') }}" alt="password-icon">
                                <input type="password" class="form-control input" id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Masukan konfirmasi kata sandi baru anda..." required>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <button type="submit" class="button-submit">Atur Ulang Kata Sandi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
</body>

</html>
