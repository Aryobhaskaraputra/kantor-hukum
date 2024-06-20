<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('iconWeb.svg') }}" type="image/svg+xml">
    <title>@yield('title', 'Kantor Hukum')</title>
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
            <img src="{{ asset('storage/images/Logo.svg') }}" alt="logo" width="100" height="100" >
            <div class="col-md-6">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
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
                <form method="POST" action="{{ route('loginIndex') }}" class="form container">
                    @csrf
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
                            <label for="password" class="form-label fw-bold">Password</label>
                            <div class="inputForm d-flex align-items-center">
                                <img src="{{ asset('storage/images/password-icon.svg') }}" alt="password-icon">
                                <input type="password" class="form-control input" id="password" name="password"
                                    placeholder="Masukan password anda..." required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center ">
                            <a href="{{ route('password.request') }}" class="span fw-bold" style="text-decoration: none">Lupa Password?</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="button-submit">Masuk</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center">
                            <p class="p">Tidak memiliki akun? <a href="{{ route('register') }}" class="span fw-bold" style="text-decoration: none">Daftar</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('sweetalert::alert')
</body>

</html>
