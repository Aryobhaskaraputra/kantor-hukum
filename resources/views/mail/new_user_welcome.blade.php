<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: black;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #f4f4f9;
            padding-bottom: 10px;
        }

        p {
            font-size: 16px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            background: #f4f4f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
        }

        strong {
            color: #007BFF;
        }

        .footer {
            margin-top: 20px;
        }

        .footer h5 {
            margin: 0;
            color: #555;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Selamat Datang di KantorHukum!</h2>

        <p>Halo <strong>{{ $user->nama_depan }}</strong>,</p>

        <p>Selamat datang di KantorHukum! Berikut adalah detail akun Anda:</p>
        <ul>
            <li>Email: <strong>{{ $user->email }}</strong></li>
            <li>Kata Sandi: <strong>{{ $password }}</strong></li>
        </ul>

        <p>Silakan login dengan email dan kata sandi di atas.</p>

        <div class="footer">
            <h5>Terima Kasih,</h5>
            <h5>KantorHukum</h5>
        </div>
    </div>
</body>

</html>
