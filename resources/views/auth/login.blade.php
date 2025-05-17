<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - GuruMurid App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold text-center text-blue-600">Login</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <div>
                <label class="block font-semibold text-gray-700">Password</label>
                <input type="password" name="password" required
                       class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-200">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register di sini</a>
        </p>
    </div>

</body>
</html>
