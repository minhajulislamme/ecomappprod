@extends('frontend.frontend')
@section('content')
    <!-- login section start  -->
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
            <!-- Logo and Title -->
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <img src="https://placehold.co/32x32" class="w-10 h-10 rounded-md" alt="">
                    <h2 class="text-2xl text-orange-400 font-semibold">Shop Ever</h2>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Sign in to your account</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Or
                    <a href="#" class="font-medium text-orange-400 hover:text-orange-500">
                        create a new account
                    </a>
                </p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf
                <input type="hidden" name="remember" value="true">
                <div class="space-y-4">
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email address
                        </label>
                        <div class="mt-1 relative">
                            <input id="email" name="email" type="email" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                                placeholder="Enter your email">
                            <span class="absolute right-3 top-3 text-gray-400">
                                <i class="ri-mail-line text-xl"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent"
                                placeholder="Enter your password">
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i id="password-icon" class="ri-eye-off-line text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Remember Me and Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-orange-400 focus:ring-orange-400 border-gray-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>

                    <a href="#" class="text-sm font-medium text-orange-400 hover:text-orange-500">
                        Forgot your password?
                    </a>
                </div>

                <!-- Sign In Button -->
                <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-400 hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400">
                    Sign in
                </button>

                <!-- Social Login Divider -->
                {{-- <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or continue with</span>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-3 gap-3">
                <button type="button"
                    class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <i class="ri-google-fill text-xl"></i>
                </button>
                <button type="button"
                    class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <i class="ri-facebook-fill text-xl"></i>
                </button>
                <button type="button"
                    class="w-full inline-flex justify-center py-2.5 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    <i class="ri-github-fill text-xl"></i>
                </button>
            </div> --}}
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'ri-eye-line text-xl';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'ri-eye-off-line text-xl';
            }
        }
    </script>
@endsection
