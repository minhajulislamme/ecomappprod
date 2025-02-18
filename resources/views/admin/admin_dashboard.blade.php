<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard By Minhajul Islam</title>
    <!-- --------------------rimix icon------------------- -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Excel cdn  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <!-- CSS -->
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
    {{-- <link rel="stylesheet" href="./dist/css/style.css"> --}}

</head>

<body class="text-gray-900 font-inter">
    <!-- =========================================================Sider bar Start==================================== -->
    @include('admin.body.sidebar')
    <div class="fixed top-0 left-0 w-full h-full  bg-black/50 z-40 md:hidden sidebar-overlay"></div>
    <!-- =========================================================Sider bar End==================================== -->
    <!-- =========================================================Main Start==================================== -->
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-gray-50 min-h-screen transition-all main">
        {{-- header part  --}}
        @include('admin.body.header')
        <!-- =========================================================Main Content Start==================================== -->
        @yield('admin_content')
        <!-- footer part -->
        @include('admin.body.footer')

    </main>

    <!-- footer part -->

    <!-- =========================================================== script js==================================== -->
    <!-- Load dependencies before vite -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- Load admin.js through vite last -->
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js']) <!-- Updated to match file changes -->
    <script src="{{ asset('js/admin/custom.js') }}"></script>

    <script>
        // Initialize Notyf
        const notyf = new Notyf({
            duration: 4000,
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                    type: 'success',
                    className: 'notyf__toast--success',
                    backgroundColor: '#10B981',
                    icon: false
                },
                {
                    type: 'error',
                    className: 'notyf__toast--error',
                    backgroundColor: '#EF4444',
                    icon: false
                }
            ]
        });

        @if (Session::has('message'))
            notyf.{{ Session::get('alert-type', 'success') }}("{{ Session::get('message') }}");
        @endif
    </script>

    @yield('scripts')
</body>

</html>
