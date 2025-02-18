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

<body class="text-gray-900 font-inter bg-gradient-to-br from-orange-50 to-white">
    <!-- login section start -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-md">
            <!-- Logo/Brand Section -->
            <div class="text-center mb-8">
                <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-admin-line text-3xl text-orange-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Welcome back!</h2>
                <p class="text-gray-600 mt-2">Please sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Email/Username Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email or Username</label>
                    <div class="relative">
                        <i class="ri-user-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="email" name="email"
                            class="pl-10 w-full px-4 py-3 border @error('email') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            value="{{ old('email') }}" placeholder="Enter your email or username">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="#" class="text-sm text-orange-600 hover:text-orange-500">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <i class="ri-lock-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" id="password" name="password"
                            class="pl-10 w-full px-4 py-3 border @error('password') border-red-500 @else border-gray-200 @enderror rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            placeholder="Enter your password">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i id="passwordIcon" class="ri-eye-off-line"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 text-orange-600 rounded border-gray-300">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 px-4 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition duration-200 flex items-center justify-center">
                    Sign in
                    <i class="ri-login-box-line ml-2"></i>
                </button>
            </form>

            <!-- Sign Up Link -->
            <p class="mt-8 text-center text-sm text-gray-600">
                Don't have an account?
                <a href="signup.html" class="font-medium text-orange-600 hover:text-orange-500">Sign up</a>
            </p>
        </div>
    </div>
    <!-- login section end -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
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
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'ri-eye-line';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'ri-eye-off-line';
            }
        }
    </script>
</body>

</html>
