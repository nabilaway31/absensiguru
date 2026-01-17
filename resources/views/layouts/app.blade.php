<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Absensi Guru')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <nav style="background:#0f172a; padding:16px; color:white">
        <strong>ABSENSI GURU</strong>
    </nav>

    <div style="padding:20px">
        @yield('content')
    </div>

</body>
</html>
