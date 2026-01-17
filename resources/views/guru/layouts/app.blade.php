<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Guru')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        header,
        nav {
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        main {
            overflow-x: auto;
        }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex min-h-screen w-full">
        {{-- SIDEBAR --}}
        @include('guru.layouts.sidebar')

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col w-full">
            {{-- HEADER --}}
            <div class="sticky top-0 z-[1050]">
                @include('guru.layouts.header')
            </div>

            {{-- CONTENT --}}
            <main class="flex-1 p-3 lg:p-6 w-full">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- SWEETALERT SUCCESS --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-lg'
                }
            });
        </script>
    @endif

    {{-- SWEETALERT ERROR --}}
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                customClass: {
                    popup: 'rounded-lg'
                }
            });
        </script>
    @endif

</body>

</html>