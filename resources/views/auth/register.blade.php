<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Platform Edukasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            margin: 60px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #3498db;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Register</h1>

    @if ($errors->any())
        <div class="error">
            <ul style="padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <label for="name">Nama Lengkap</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <label for="role">Daftar Sebagai</label>
        <select name="role" id="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="murid" {{ old('role') == 'murid' ? 'selected' : '' }}>Murid</option>
            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
            {{-- <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option> --}}
        </select>

        <button type="submit">Daftar</button>
    </form>

    <div class="login-link">
        <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>
</div>
</body>
</html>
