<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard By Minhajul Islam</title>
    <!-- Core Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  

    <!-- CSS -->
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])

    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <!-- QuillJS CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        
    </style>
</head>

<body class="text-gray-900 font-inter">
    <!-- =========================================================Sider bar Start==================================== -->
    @include('admin.body.sidebar')

    
    <!-- =========================================================Sider bar End==================================== -->
    <!-- =========================================================Main Start==================================== -->
    <main class="main transition-all duration-300 ease-in-out lg:ml-64">
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
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
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
 <script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
</script>
</body>

</html>
