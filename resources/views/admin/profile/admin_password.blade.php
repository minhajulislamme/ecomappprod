@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
                <div class="flex flex-col items-center">
                    <div class="flex justify-center w-full">
                        <img id="showImage"
                            src="{{ !empty($adminData->photo) ? url('upload/admin_images/' . $adminData->photo) : url('https://placehold.co/600x600') }}"
                            alt="Admin Photo" class="w-32 h-32 object-cover rounded mb-4">
                    </div>
                    <div class="">
                        <h3 class="text-xl font-semibold">Username: {{ $adminData->username ?? 'Admin Name' }}</h3>
                        <h3 class="text-xl font-semibold">Name: {{ $adminData->name ?? 'Admin Name' }}</h3>
                        <p class="text-gray-500">User Email: {{ $adminData->email ?? 'admin@example.com' }}</p>
                        <p class="text-gray-500">User Phone: {{ $adminData->phone ?? 'admin@example.com' }}</p>
                        <p class="text-gray-500"> User Address: {{ $adminData->address ?? 'admin@example.com' }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
                <div class="flex justify-between mb-6">
                    <div>
                        <div class="text-lg font-semibold">Change Password</div>
                        <div class="text-sm font-medium text-gray-400">Update your account password</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.password.update') }}" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="old_password"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500 focus:border-none
                                {{ $errors->has('old_password') ? 'border-red-500' : 'border-gray-100' }}">
                            @error('old_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500  focus:border-none
                                {{ $errors->has('password') ? 'border-red-500' : 'border-gray-100' }}">
                            @error('password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                class="border-gray-100 p-2.5 bg-gray-50 outline-none rounded-md w-full text-sm focus:ring-2 focus:ring-orange-500 focus:border-none
                                {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-100' }}">
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if (session('status'))
                        <div
                            class="p-4 rounded-md {{ session('status')['type'] === 'success' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                            {{ session('status')['message'] }}
                        </div>
                    @endif

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="bg-orange-500 text-white py-2 px-6 rounded hover:bg-orange-600 transition duration-200">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
