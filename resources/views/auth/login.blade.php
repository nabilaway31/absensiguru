<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Guru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Card Container -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200">
            <!-- Header -->
            <div class="p-8 text-center border-b border-gray-200">
                <h1 class="text-xl font-semibold text-gray-800 mb-1">Sistem Absensi Guru</h1>
                <p class="text-gray-500 text-sm">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-2.5 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} rounded focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent"
                            placeholder="nama@example.com">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-2.5 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} rounded focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 text-gray-700 border-gray-300 rounded focus:ring-gray-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-gray-800 text-white py-2.5 rounded font-medium hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} Sistem Absensi Guru
                </p>
            </div>
        </div>
    </div>

</body>

</html>