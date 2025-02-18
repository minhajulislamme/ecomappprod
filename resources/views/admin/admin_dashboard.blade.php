<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard By Minhajul Islam</title>
    <!-- Core Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS -->
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])

    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <!-- QuillJS CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-editor {
            min-height: 200px;
            background: white;
        }

        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.375rem;
            border-top-right-radius: 0.375rem;
            background: #f9fafb;
            border-color: #e5e7eb;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
            border-color: #e5e7eb;
        }

        .ql-toolbar .ql-stroke {
            stroke: #374151;
        }

        .ql-toolbar .ql-fill {
            fill: #374151;
        }

        .ql-toolbar .ql-picker {
            color: #374151;
        }

        .ql-snow.ql-toolbar button:hover,
        .ql-snow .ql-toolbar button:hover {
            color: #f97316;
        }
    </style>
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

        <!-- Replace old editor container with QuillJS -->
        
    </main>

    <!-- footer part -->

    <!-- =========================================================== script js==================================== -->
    <!-- Load QuillJS before other scripts -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
    </script>
    <script>
        @if (Session::has('message'))
            Swal.fire({
                text: "{{ Session::get('message') }}",
                icon: "{{ Session::get('alert-type', 'success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                }
            });
        @endif
    </script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    @yield('scripts')
</body>

</html>
